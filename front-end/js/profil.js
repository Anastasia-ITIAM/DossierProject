export function initProfil() {

    // --- Utilitaires sécurité ---
    function sanitizeInput(input) {
        if (typeof input !== "string") return input; // ignore fichiers ou autres objets
        return input.replace(/[<>]/g, ""); // supprime balises HTML
    }

    function safeAlert(message) {
        const div = document.createElement('div');
        div.textContent = Array.isArray(message) ? message.join('\n') : message;
        alert(div.textContent);
    }

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

        // --- SANITIZE ALL INPUTS ---
        for (let [key, value] of formData.entries()) {
            formData.set(key, sanitizeInput(value));
        }

        console.log("FormData envoyé (sanitized) :");
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

        if (!validateEmail(email)) return safeAlert("Email invalide");
        if (!validatePseudo(pseudo)) return safeAlert("Pseudo invalide (3-20 caractères, lettres, chiffres, underscore)");
        if (password && !validatePassword(password)) return safeAlert("Mot de passe invalide.");
        if (password && password !== confirmPassword) return safeAlert("Les mots de passe ne correspondent pas");

        try {
            // Envoi vers le back
            const res = await fetch(`http://localhost:8081/api/user/${userId}`, {
                method: "POST",
                body: formData
            });

            const result = await res.json();

            if (!res.ok || !result.success) {
                return safeAlert(result.message || `Erreur serveur : ${res.status}`);
            }

            // Si tout est ok
            safeAlert("Profil mis à jour !");
            console.log("Utilisateur mis à jour :", result.user);

            // Mise à jour des champs du formulaire (sanitized)
            for (const key in result.user) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = sanitizeInput(result.user[key]) || '';
            }

        } catch (err) {
            console.error("Erreur fetch :", err);
            safeAlert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
