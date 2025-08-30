export function initProfil() {
    
    const form = document.getElementById('updateProfileForm');
    if (!form) return;

    const userId = window.currentUserId;
    if (!userId) {
        console.error("Aucun utilisateur connecté !");
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        console.log("FormData envoyé :");
        for (let [key, value] of formData.entries()) {
            console.log(key, ":", value);
        }

        // Validations front
        const email = formData.get("email");
        const pseudo = formData.get("pseudo");
        const password = formData.get("password");
        const confirmPassword = formData.get("confirmPassword");

        const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const validatePseudo = (pseudo) => /^[a-zA-Z0-9_]{3,20}$/.test(pseudo);
        const validatePassword = (password) =>
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password);

        if (!validateEmail(email)) return alert("Email invalide");
        if (!validatePseudo(pseudo)) return alert("Pseudo invalide (3-20 caractères, lettres, chiffres, underscore)");
        if (password && !validatePassword(password)) return alert("Mot de passe invalide.");
        if (password && password !== confirmPassword) return alert("Les mots de passe ne correspondent pas");

        try {
            // Envoi vers le back
            const res = await fetch(`http://localhost:8081/api/user/${userId}`, {
                method: "POST",
                body: formData
            });

            const result = await res.json();

            if (!res.ok || !result.success) {
                // Affiche les erreurs du back (email/pseudo déjà utilisé)
                return alert(result.message || `Erreur serveur : ${res.status}`);
            }

            // Si tout est ok
            alert("Profil mis à jour !");
            console.log("Utilisateur mis à jour :", result.user);

            // Mise à jour des champs du formulaire
            for (const key in result.user) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = result.user[key] || '';
            }

        } catch (err) {
            console.error("Erreur fetch :", err);
            alert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
