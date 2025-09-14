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

    // Définir quels boutons sont visibles pour chaque rôle
    const visibleByRole = {
        ROLE_PASSENGER: ["driver"],                   // passager normal ne peut pas publier ni avoir de véhicules
        ROLE_PASSENGER_DRIVER: ["publish", "myCars"], // chauffeur/passager peut publier et gérer ses véhicules
        ROLE_EMPLOYEE: ["employee"],
        ROLE_ADMIN: ["employee", "admin"]
    };

    const buttons = {
        employee: document.getElementById("btnEmployee"),
        admin: document.getElementById("btnAdmin"),
        driver: document.getElementById("btnDriver"),
        publish: document.getElementById("btnPublishTrip"), // bouton Publier un trajet
        myCars: document.getElementById("btnMyCars")       // bouton Mes véhicules
    };

    // Bloquer l'accès à devenir chauffeur si profil incomplet
    if (buttons.driver) {
        buttons.driver.addEventListener("click", (event) => {
            const requiredFields = [
                "email", "pseudo", "firstName", "lastName", 
                "birthDate", "postalAddress", "phone"
            ];

            const data = JSON.parse(sessionStorage.getItem(storageKey)) || {};
            const incomplete = requiredFields.some(field => !data[field] || data[field].trim() === "");

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
        const userRole = data.role || "ROLE_UNKNOWN"; // fallback si rôle absent
        console.log("Refresh UI avec ces données :", data);
        console.log("Rôle utilisateur :", userRole);

        // Mettre à jour infos du profil
        if (profileImage) profileImage.src = data.profilePhotoUrl ? `http://localhost:8081${data.profilePhotoUrl}` : "";
        if (profilePseudo) profilePseudo.textContent = data.pseudo || "";
        if (profileRole) profileRole.textContent = roleLabels[userRole] || userRole;
        if (profileCredits) profileCredits.textContent = data.credits !== undefined ? data.credits : "";

        // Masquer tous les boutons par défaut
        Object.values(buttons).forEach(btn => {
            if (btn) btn.style.setProperty("display", "none", "important");
        });

        // Afficher uniquement les boutons autorisés pour ce rôle
        if (visibleByRole[userRole]) {
            visibleByRole[userRole].forEach(key => {
                if (buttons[key]) buttons[key].style.setProperty("display", "inline-block", "important");
            });
        }
    }

    // Chargement initial
    refreshUI();

    // Mettre à jour si sessionStorage change dans un autre onglet
    window.addEventListener("storage", (event) => {
        if (event.key === storageKey) refreshUI();
    });

    // Écouter un éventuel fetch serveur
    window.addEventListener("profileDataReady", () => {
        refreshUI();
    });
}
