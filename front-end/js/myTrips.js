import { authFetch } from './signIn.js'; // fonction fetch avec token ou session

export async function initMyTrips() {
    const avenirTab = document.getElementById('avenir');
    const aValiderTab = document.getElementById('a-valider');
    const passesTab = document.getElementById('passes');

    if (!avenirTab || !aValiderTab || !passesTab) return;

    try {
        const resp = await authFetch('http://localhost:8081/api/trip/list');
        const result = await resp.json();

        if (!result.success) {
            console.error('Erreur récupération trajets:', result.message);
            return;
        }

        const now = new Date();

        // Vider les onglets
        avenirTab.innerHTML = '';
        aValiderTab.innerHTML = '';
        passesTab.innerHTML = '';

        result.trips.forEach(trip => {
            const depDateTime = new Date(`${trip.departure_date}T${trip.departure_time || '00:00'}`);
            const isPast = depDateTime < now;
            const isDriver = trip.user_id === window.currentUserId;

            /// Créer la carte
const cardDiv = document.createElement('div');
cardDiv.className = 'col-md-6 mb-4';
cardDiv.innerHTML = `
    <div class="card eco-box shadow-sm p-3">
        <h5 class="card-title">
            Trajet vers ${trip.arrival_address}
        </h5>
        <p class="card-text">
            <strong>Départ :</strong> ${trip.departure_address}<br>
            <strong>Arrivée :</strong> ${trip.arrival_address}<br>
            <strong>Date :</strong> ${trip.departure_date} à ${trip.departure_time}<br>
            <strong>Places :</strong> ${trip.available_seats}<br>
            <strong style="color:red;">Rôle :</strong> ${isDriver ? 'Chauffeur' : 'Passager'}
            ${trip.eco_friendly ? '<div class="eco-label text-center">🌱 EcoRide</div>' : ''}
        </p>
        <div class="text-center">
            <a href="#" class="btn custom-btn">Voir les détails</a>
        </div>
    </div>
`;


            // Classer dans les onglets
            if (isPast) passesTab.appendChild(cardDiv);
            else avenirTab.appendChild(cardDiv); // pour simplifier, on met tout le futur dans "À venir"
        });

        // Tu peux ajouter la logique "À valider" selon ton statut participant_validation
    } catch (err) {
        console.error('Erreur fetch trajets:', err);
    }
}
