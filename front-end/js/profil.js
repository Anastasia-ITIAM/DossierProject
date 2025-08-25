export function initProfil() {

    const form = document.getElementById('updateProfileForm');
    if (!form) return;

    // Récupérer l'ID utilisateur depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userId');
    if (!userId) return console.error("userId non défini dans l'URL");

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Créer FormData à partir du formulaire
        const formData = new FormData(form);

        // Pour que Symfony traite comme PUT
        formData.append("_method", "PUT");

        // Récupération des valeurs pour validation côté JS
        const email = formData.get("email");
        const pseudo = formData.get("pseudo");
        const password = formData.get("password");
        const confirmPassword = formData.get("confirmPassword");

        // --- VALIDATIONS ---
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
                method: "POST", // Symfony traitera PUT via _method
                body: formData
            });

            const result = await res.json();

            if (result.success) {
                alert("Profil mis à jour !");
                console.log("Utilisateur mis à jour :", result.user);
            } else {
                alert(result.message || "Erreur serveur");
            }
        } catch (err) {
            console.error("Erreur fetch :", err);
            alert("Erreur réseau");
        }
    });
}
