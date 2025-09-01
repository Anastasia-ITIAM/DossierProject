export function initProfilUI() {
    const profileImage = document.getElementById("profileImage");
    const profilePseudo = document.getElementById("profilePseudo");
    const profileRole = document.getElementById("profileRole");
    const profileCredits = document.getElementById("profileCredits");

    const userId = window.currentUserId;
    if (!userId) {
        console.error("Aucun utilisateur connecté !");
        return;
    }

    const storageKey = `userProfile_${userId}`;

    const roleLabels = {
        role_passenger: "passager",
        role_driver: "chauffeur",
        role_admin: "administrateur",
        role_employee: "employé"
    };

    function refreshUI() {
        const data = JSON.parse(sessionStorage.getItem(storageKey)) || {};
        console.log("Refresh UI avec ces données :", data);

        if (!profileImage) console.warn("Élément #profileImage non trouvé !");
        if (!profilePseudo) console.warn("Élément #profilePseudo non trouvé !");
        if (!profileRole) console.warn("Élément #profileRole non trouvé !");
        if (!profileCredits) console.warn("Élément #profileCredits non trouvé !");

        if (profileImage) {
            console.log("Profile image DOM avant :", profileImage.src);
            profileImage.src = data.profilePhotoUrl
                ? `http://localhost:8081${data.profilePhotoUrl}`
                : "";
            console.log("Profile image DOM après :", profileImage.src);
        }

        if (profilePseudo) profilePseudo.textContent = data.pseudo || "";
        if (profileRole) {
            profileRole.textContent = data.role
                ? roleLabels[data.role.toLowerCase()] || data.role
                : "";
        }
        if (profileCredits) {
            profileCredits.textContent =
                data.credits !== undefined ? data.credits : "";
        }
    }

    // Charger au démarrage
    refreshUI();

    // Mettre à jour si sessionStorage change (par un autre onglet)
    window.addEventListener("storage", (event) => {
        if (event.key === storageKey) {
            console.log("Storage event détecté :", event);
            refreshUI();
        }
    });
}
