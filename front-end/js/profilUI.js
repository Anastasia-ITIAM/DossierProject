export function initProfilUI() {
    const profileImage = document.getElementById("profileImage");
    const profilePseudo = document.getElementById("profilePseudo");
    const profileRole = document.getElementById("profileRole");
    const profileCredits = document.getElementById("profileCredits");

    // Récupérer l'ID utilisateur global
    const userId = window.currentUserId;
    if (!userId) {
        console.error("Aucun utilisateur connecté !");
        return;
    }

    // Utiliser une clé par utilisateur
    const storageKey = `userProfile_${userId}`;

    // Mapping rôle back → rôle affiché en français
    const roleLabels = {
        role_passenger: "passager",
        role_driver: "chauffeur",
        role_admin: "administrateur",
        role_employee: "employé"
    };

    function refreshUI() {
        const data = JSON.parse(sessionStorage.getItem(storageKey)) || {};

        console.log("Valeur du rôle récupérée :", data.role); // Vérification

        if (profileImage) {
            profileImage.src = data.photoUrl || ""; // vide si pas d'image
        }
        if (profilePseudo) {
            profilePseudo.textContent = data.pseudo || "";
        }
        if (profileRole) {
            if (data.role) {
                const roleKey = data.role.toLowerCase();
                const roleFr = roleLabels[roleKey] || data.role;
                profileRole.textContent = roleFr;
            } else {
                profileRole.textContent = "";
            }
        }
        if (profileCredits) {
            profileCredits.textContent =
                data.credits !== undefined ? data.credits : "";
        }
    }

    // Charger au démarrage
    refreshUI();

    // Écoute les changements du localStorage (si profil.js modifie)
    window.addEventListener("storage", (event) => {
        if (event.key === storageKey) {
            refreshUI();
        }
    });
}
