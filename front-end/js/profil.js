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

    const storageKey = `userProfile_${userId}`;

    // --- Charger les données utilisateur ---
    async function loadUserData() {
        try {
            // Récupérer les données du sessionStorage si elles existent
            const storedData = JSON.parse(sessionStorage.getItem(storageKey)) || {};

            // Afficher la photo immédiatement si disponible
            const profileImage = document.getElementById("profileImage");
            if (profileImage && storedData.photoUrl) {
                profileImage.src = storedData.photoUrl;
            }

            // Récupérer les données serveur
            const res = await fetch(`http://localhost:8081/api/user/${userId}`);
            const result = await res.json();

            if (!res.ok || !result.success) {
                console.error("Impossible de récupérer les données serveur");
                return;
            }

            const serverData = result.user;

            // Fusion serveur + local (local prend le dessus)
            const userData = { ...serverData, ...storedData };

            // Remplir le formulaire et la photo
            for (const key in userData) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = sanitizeInput(userData[key]) || '';
            }
            if (profileImage && userData.photoUrl) {
                profileImage.src = userData.photoUrl;
            }

            // Stocker dans sessionStorage
            sessionStorage.setItem(storageKey, JSON.stringify(userData));

        } catch (err) {
            console.error("Erreur fetch :", err);
        }
    }

    loadUserData();

    // --- Soumission du formulaire ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        // Sanitize tous les inputs sauf les fichiers
        for (let [key, value] of formData.entries()) {
            if (typeof value === "string") formData.set(key, sanitizeInput(value));
        }

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

            // Mettre à jour sessionStorage et formulaire
            const profileImage = document.getElementById("profileImage");
            const updatedData = JSON.parse(sessionStorage.getItem(storageKey)) || {};

            for (const key in result.user) {
                updatedData[key] = result.user[key];
                const input = form.querySelector(`[name="${key}"]`);
                if (input && typeof result.user[key] === "string") {
                    input.value = sanitizeInput(result.user[key]);
                }
            }

            if (profileImage && result.user.photoUrl) {
                profileImage.src = result.user.photoUrl;
                updatedData.photoUrl = result.user.photoUrl;
            }

            sessionStorage.setItem(storageKey, JSON.stringify(updatedData));

        } catch (err) {
            console.error("Erreur fetch :", err);
            safeAlert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
