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
    if (!form) {
        console.error("Formulaire #updateProfileForm non trouvé");
        return;
    }

    const userId = window.currentUserId;
    if (!userId) {
        console.error("Aucun utilisateur connecté !");
        return;
    }

    const storageKey = `userProfile_${userId}`;

    // --- Charger les données utilisateur ---
    async function loadUserData() {
        try {
            const storedData = JSON.parse(sessionStorage.getItem(storageKey)) || {};
            console.log("Données stockées existantes :", storedData);

            const profileImage = document.getElementById("profileImage");

            if (profileImage && storedData.profilePhotoUrl) {
                console.log("Affichage photo depuis sessionStorage :", storedData.profilePhotoUrl);
                profileImage.src = `http://localhost:8081${storedData.profilePhotoUrl}`;
            }

            // Récupérer les données serveur
            const res = await fetch(`http://localhost:8081/api/user/${userId}`);
            const result = await res.json();
            console.log("Réponse serveur :", result);

            if (!res.ok || !result.success) {
                console.error("Impossible de récupérer les données serveur");
                return;
            }

            const serverData = result.user;
            console.log("Données serveur :", serverData);

            // Fusion serveur + local
            const userData = { ...serverData, ...storedData };

            // Remplir le formulaire
            for (const key in userData) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = sanitizeInput(userData[key]) || '';
            }

            if (profileImage && userData.profilePhotoUrl) {
                console.log("Affichage photo depuis serveur :", userData.profilePhotoUrl);
                profileImage.src = `http://localhost:8081${userData.profilePhotoUrl}`;
            } else if (!userData.profilePhotoUrl) {
                console.warn("Pas de profilePhotoUrl dans userData");
            } else if (!profileImage) {
                console.warn("Élément #profileImage non trouvé dans le DOM");
            }

            // Stocker dans sessionStorage
            sessionStorage.setItem(storageKey, JSON.stringify(userData));
            console.log("SessionStorage mis à jour :", JSON.parse(sessionStorage.getItem(storageKey)));

        } catch (err) {
            console.error("Erreur fetch :", err);
        }
    }

    loadUserData();

    // --- Soumission du formulaire ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        for (let [key, value] of formData.entries()) {
            if (typeof value === "string") formData.set(key, sanitizeInput(value));
        }

        try {
            const res = await fetch(`http://localhost:8081/api/user/${userId}`, {
                method: "POST",
                body: formData
            });

            const result = await res.json();
            console.log("Réponse mise à jour :", result);

            if (!res.ok || !result.success) {
                return safeAlert(result.message || `Erreur serveur : ${res.status}`);
            }

            safeAlert("Profil mis à jour !");
            console.log("Utilisateur mis à jour :", result.user);

            const profileImage = document.getElementById("profileImage");
            const updatedData = JSON.parse(sessionStorage.getItem(storageKey)) || {};

            for (const key in result.user) {
                updatedData[key] = result.user[key];
                const input = form.querySelector(`[name="${key}"]`);
                if (input && typeof result.user[key] === "string") {
                    input.value = sanitizeInput(result.user[key]);
                }
            }

            if (profileImage && result.user.profilePhotoUrl) {
                console.log("Mise à jour photo après submit :", result.user.profilePhotoUrl);
                profileImage.src = `http://localhost:8081${result.user.profilePhotoUrl}`;
                updatedData.profilePhotoUrl = result.user.profilePhotoUrl;
            }

            sessionStorage.setItem(storageKey, JSON.stringify(updatedData));
            console.log("SessionStorage après submit :", JSON.parse(sessionStorage.getItem(storageKey)));

        } catch (err) {
            console.error("Erreur fetch :", err);
            safeAlert("Erreur réseau ou serveur : " + err.message);
        }
    });
}
