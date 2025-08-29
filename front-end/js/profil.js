export function initProfil() {
    const form = document.getElementById('updateProfileForm');
    if (!form) return;

    // Récupérer l'ID utilisateur depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userId');
    if (!userId) {
        console.error("userId non défini dans l'URL");
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Créer FormData à partir du formulaire
        const formData = new FormData(form);

        // --- DEBUG: afficher tout le FormData pour vérifier ce qui est envoyé ---
        console.log("FormData envoyé :");
        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]);
        }

        // --- VALIDATIONS ---
        const email = formData.get("email");
        const pseudo = formData.get("pseudo");
        const password = formData.get("password");
        const confirmPassword = formData.get("confirmPassword");

        const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        if (!validateEmail(email)) return alert("Email invalide");

        const validatePseudo = (pseudo) => /^[a-zA-Z0-9_]{3,20}$/.test(pseudo);
        if (!validatePseudo(pseudo)) return alert("Pseudo invalide (3-20 caractères, lettres, chiffres, underscore)");

        if (password) {
            const validatePassword = (password) =>
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password);
            if (!validatePassword(password)) return alert("Mot de passe invalide. Il doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.");
            if (password !== confirmPassword) return alert("Les mots de passe ne correspondent pas");
        }

        // --- ENVOI ---
        try {
            const res = await fetch(`http://localhost:8081/api/user/${userId}`, {
                method: "POST", // Utilisation directe de PUT
                body: formData
            });

            if (!res.ok) {
                const errorText = await res.text();
                throw new Error(`Erreur HTTP ${res.status}: ${errorText}`);
            }

            const result = await res.json();

            if (result.success) {
                alert("Profil mis à jour !");
                console.log("Utilisateur mis à jour :", result.user);
                // Optionnel : mettre à jour les champs du formulaire avec la réponse du serveur
                for (const key in result.user) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = result.user[key] || '';
                    }
                }
            } else {
                alert(result.message || "Erreur serveur");
            }
        } catch (err) {
            console.error("Erreur fetch :", err);
            alert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
