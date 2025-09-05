console.log("initCar chargé !");

import { authFetch } from './signIn.js';

export function initCar() {
    const form = document.querySelector("#driverForm"); 
    if (!form) {
        console.warn("⚠️ Aucun formulaire trouvé avec id #driverForm");
        return;
    }
    
    console.log("✅ driverForm détecté");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        console.log("🚦 Submit détecté dans driverForm");

        // Récupérer les données du formulaire
        const formData = new FormData(form);

        // Transformer en objet JSON pour l'API (⚠️ clés en anglais comme en BDD)
        const data = {
            license_plate: formData.get("license_plate"),
            registration_date: formData.get("registration_date"),
            brand: formData.get("brand"),
            model: formData.get("model"),
            color: formData.get("color"),
            fuel_type: formData.get("fuel_type"),
            available_seats: parseInt(formData.get("available_seats"), 10) || 0,
            smoker: formData.get("smoker") === "on",
            pets_allowed: formData.get("pets_allowed") === "on",
            custom_preferences: formData.get("custom_preferences") || ""
        };

        console.log("📤 Données préparées pour envoi :", data);

        try {
            console.log("⏳ Envoi vers backend : http://localhost:8081/api/car");
            const response = await authFetch("http://localhost:8081/api/car", {
                method: "POST",
                body: JSON.stringify(data)
            });

            console.log("📥 Réponse brute :", response);

            const result = await response.json();
            console.log("✅ Réponse JSON du backend :", result);

            if (response.ok && result.success) {
                console.log("🎉 Voiture enregistrée en BDD :", result.car);
                alert("Voiture ajoutée avec succès ! Vous êtes maintenant chauffeur·euse.");

                // Stocker la voiture en sessionStorage
                sessionStorage.setItem("currentCar", JSON.stringify(result.car));

                // Redirection
                window.location.href = "/pages/profil.html";
            } else {
                console.error("❌ Erreur API :", result);
                alert("Erreur : " + (result.message || "Impossible d'ajouter la voiture."));
            }
        } catch (err) {
            console.error("💥 Exception JS lors de l'envoi :", err);
            alert("Erreur serveur ou token invalide. Réessayez plus tard.");
        }
    });
}
