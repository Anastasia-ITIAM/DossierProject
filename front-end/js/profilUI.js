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
        ROLE_PASSENGER: "passager",
        ROLE_PASSENGER_DRIVER: "chauffeur et passager",
        ROLE_ADMIN: "administrateur",
        ROLE_EMPLOYEE: "employé"
    };

    const visibleByRole = {
        ROLE_PASSENGER: ["driver"],
        ROLE_PASSENGER_DRIVER: [],
        ROLE_EMPLOYEE: ["employee"],
        ROLE_ADMIN: ["employee", "admin"]
    };

    const buttons = {
        employee: document.getElementById("btnEmployee"),
        admin: document.getElementById("btnAdmin"),
        driver: document.getElementById("btnDriver")
    };

    // Bloquer l'accès à devenir chauffeur si profil incomplet
    if (buttons.driver) {
        buttons.driver.addEventListener("click", (event) => {
            const requiredFields = [
                "email",
                "pseudo",
                "firstName",
                "lastName",
                "birthDate",
                "postalAddress",
                "phone"
            ];

            const data = JSON.parse(sessionStorage.getItem(storageKey)) || {};

            const incomplete = requiredFields.some(
                field => !data[field] || data[field].trim() === ""
            );

            if (incomplete) {
                event.preventDefault();
                alert("Vous devez compléter tous les champs de votre profil avant de devenir chauffeur·euse!");
                window.location.href = "profil.html"; 
                return false;
            }
        });
    }

    function refreshUI() {
        const data = JSON.parse(sessionStorage.getItem(storageKey)) || {};
        console.log("Refresh UI avec ces données :", data);
        console.log("Rôle actuel (data.role) :", data.role);

        if (profileImage) profileImage.src = data.profilePhotoUrl ? `http://localhost:8081${data.profilePhotoUrl}` : "";
        if (profilePseudo) profilePseudo.textContent = data.pseudo || "";
        if (profileRole) profileRole.textContent = data.role ? roleLabels[data.role] || data.role : "";
        if (profileCredits) profileCredits.textContent = data.credits !== undefined ? data.credits : "";

        // Masquer tous les boutons d'abord
        Object.values(buttons).forEach(btn => {
            if (btn) btn.style.setProperty("display", "none", "important");
        });

        // Afficher uniquement ceux autorisés pour le rôle actuel
        const allowed = visibleByRole[data.role] || [];
        allowed.forEach(key => {
            if (buttons[key]) buttons[key].style.setProperty("display", "inline-block", "important");
        });
    }

    // Chargement initial
    refreshUI();

    // Mettre à jour si sessionStorage change dans un autre onglet
    window.addEventListener("storage", (event) => {
        if (event.key === storageKey) refreshUI();
    });

    // Écouter le nouvel événement déclenché après fetch serveur
    window.addEventListener("profileDataReady", () => {
        refreshUI();
    });
}
