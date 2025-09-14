export async function initSearchTrip() {
    const params = new URLSearchParams(window.location.search);
    const depart = params.get('depart')?.trim();
    const arrivee = params.get('arrivee')?.trim();
    const datetime = params.get('datetime')?.trim();

    const resultsContainer = document.querySelector('#resultsContainer');
    if (!resultsContainer) return;

    resultsContainer.innerHTML = '<p class="text-center">Chargement des trajets...</p>';

    try {
        let url;

        // Construire l'URL de l'API selon les filtres
        if (depart || arrivee || datetime) {
            const queryParams = {};
            if (depart) queryParams.depart = depart;
            if (arrivee) queryParams.arrivee = arrivee;
            if (datetime) queryParams.datetime = datetime;
            url = `http://localhost:8081/api/trip/search?${new URLSearchParams(queryParams).toString()}`;
        } else {
            url = 'http://localhost:8081/api/trip/all';
        }

        console.log('URL fetch:', url);

        const resp = await fetch(url);
        if (!resp.ok) throw new Error(`Erreur serveur : ${resp.status}`);

        const result = await resp.json();
        console.log('RESULT FRONTEND:', result);

        if (!result.success || !Array.isArray(result.trips) || result.trips.length === 0) {
            resultsContainer.innerHTML = '<p class="text-center text-danger">Aucun trajet trouvé.</p>';
            return;
        }

        // Mélanger les trajets pour affichage aléatoire
        const trips = result.trips.sort(() => Math.random() - 0.5);

        resultsContainer.innerHTML = '';
        trips.forEach(trip => {
            // Définir la photo du conducteur avec fallback
            let photoUrl = trip.driver_photo_url || '/uploads/profiles/profile_default.png';

            // S'assurer que l'URL commence par '/'
            if (!photoUrl.startsWith('/')) {
                photoUrl = '/' + photoUrl;
            }

            const card = document.createElement('div');
            card.className = 'col-md-4 mb-4';
            card.innerHTML = `
                <div class="card h-100" style="background-color: #e8f5e9;">
                    <div class="card-body">
                        <div style="display: flex; align-items: center; gap: 15px; margin: 15px 0;">
                            <img src="http://localhost:8081${photoUrl}" 
                                 alt="Conducteur" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='/uploads/profiles/profile_default.png';">
                            <div>
                                <strong>${trip.departure_address || 'N/A'}</strong> → <strong>${trip.arrival_address || 'N/A'}</strong><br>
                                <u>Conducteur·rice</u> : ${trip.driver_name || 'Inconnu'}<br>
                                <u>Places restantes</u> : ${trip.available_seats ?? 0}<br>
                                <u>Prix</u> : ${trip.price ?? 0} crédits<br>
                                <u>Départ</u> : ${trip.departure_date || ''} à ${trip.departure_time || ''}<br>
                                <u>Arrivée prévue</u> : ${trip.arrival_time || ''}<br>
                                ${trip.eco_friendly ? '<span class="eco-label">🌱 EcoRide</span>' : ''}
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn custom-btn btn-sm mt-2" href="details.html?id=${trip.id}">Voir détails</a>
                        </div>
                    </div>
                </div>
            `;
            resultsContainer.appendChild(card);
        });

    } catch (err) {
        console.error('Erreur recherche trajets:', err);
        resultsContainer.innerHTML = '<p class="text-center text-danger">Impossible de charger les trajets.</p>';
    }
}
