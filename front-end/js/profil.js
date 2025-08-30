export function initProfil() {

    // --- Utilitaires sécurité ---
    function sanitizeInput(input) {
        if (typeof input !== "string") return input;
        return input.replace(/[<>]/g, "");
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

    // --- Charger les données utilisateur ---
    async function loadUserData() {
        try {
            // On tente de récupérer les données locales
            const localData = JSON.parse(localStorage.getItem('userProfile')) || {};

            if (Object.keys(localData).length > 0) {
                // Pré-remplir le formulaire avec les données locales
                for (const key in localData) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) input.value = sanitizeInput(localData[key]) || '';
                }
            }

            // Ensuite, on synchronise avec le serveur pour récupérer les dernières données
            const res = await fetch(`http://localhost:8081/api/user/${userId}`);
            const result = await res.json();
            if (!res.ok || !result.success) {
                console.error("Impossible de récupérer les données serveur");
                return;
            }

            const serverData = result.user;

            // Fusionner serveur + local (local prend le dessus si différent)
            const finalData = { ...serverData, ...localData };

            // Remplir le formulaire
            for (const key in finalData) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = sanitizeInput(finalData[key]) || '';
            }

            // Stocker la version finale dans localStorage
            localStorage.setItem('userProfile', JSON.stringify(finalData));

        } catch (err) {
            console.error("Erreur fetch :", err);
        }
    }

    loadUserData();

    // --- Soumission du formulaire ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        // Sanitize tous les inputs
        for (let [key, value] of formData.entries()) {
            formData.set(key, sanitizeInput(value));
        }

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
            const res = await fetch(`http://localhost:8081/api/user/${userId}`, {
                method: "POST",
                body: formData
            });

            const result = await res.json();

            if (!res.ok || !result.success) {
                return safeAlert(result.message || `Erreur serveur : ${res.status}`);
            }

            safeAlert("Profil mis à jour !");
            console.log("Utilisateur mis à jour :", result.user);

            // Mettre à jour le formulaire et le localStorage
            const currentData = JSON.parse(localStorage.getItem('userProfile')) || {};

            for (const key in result.user) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    const newValue = sanitizeInput(result.user[key]) || '';
                    input.value = newValue;
                    currentData[key] = newValue;
                }
            }

            localStorage.setItem('userProfile', JSON.stringify(currentData));

        } catch (err) {
            console.error("Erreur fetch :", err);
            safeAlert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
