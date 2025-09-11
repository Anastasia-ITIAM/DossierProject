import { authFetch } from './signIn.js';

/* ---------- Utils ---------- */
function toDateInputValue(date) {
    if (!date) return '';
    const d = new Date(date);
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function toTimeInputValue(date) {
    if (!date) return '';
    const d = new Date(date);
    const hh = String(d.getHours()).padStart(2, '0');
    const mm = String(d.getMinutes()).padStart(2, '0');
    return `${hh}:${mm}`;
}

/* ---------- Populate voitures ---------- */
async function populateUserCars() {
    const select = document.getElementById('vehicule_id');
    if (!select) return;

    try {
        const resp = await authFetch('http://localhost:8081/api/car/list', { method: 'GET' });
        const data = await resp.json();

        if (resp.ok && data.success && Array.isArray(data.cars)) {
            select.innerHTML = '<option value="">-- Sélectionner --</option>';
            data.cars.forEach(car => {
                const opt = document.createElement('option');
                opt.value = car.id;
                opt.textContent = `${car.brand} ${car.model} (${car.license_plate})`;
                select.appendChild(opt);
            });
        }
    } catch (err) {
        console.error('Erreur récupération voitures :', err);
    }
}

/* ---------- Formulaire publication trajet ---------- */
function initPublishTripForm() {
    const form = document.getElementById('publish_trip');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const payload = {
            car_id: parseInt(formData.get('vehicule_id'), 10),
            user_id: window.currentUserId, // Vérifie que currentUserId est bien défini
            departure_address: formData.get('adresse_depart'),
            arrival_address: formData.get('adresse_arrivee'),
            departure_date: formData.get('date_depart'),
            departure_time: formData.get('heure_depart'),
            arrival_time: formData.get('heure_arrivee'),
            available_seats: parseInt(formData.get('places_disponibles'), 10),
            eco_friendly: formData.get('voyage_ecologique') === '1',
            price: parseInt(formData.get('prix'), 10), // <-- AJOUT du prix en crédits
            status: 'open'
        };

        try {
            const resp = await authFetch('http://localhost:8081/api/trip/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }, // <-- important
                body: JSON.stringify(payload)
            });
            const result = await resp.json();

            if (resp.ok && result.success) {
                alert('Trajet publié avec succès !');
                window.location.href = '/pages/myTrips.html';
            } else {
                alert('Erreur publication : ' + (result.message || JSON.stringify(result)));
            }
        } catch (err) {
            alert('Erreur réseau');
            console.error(err);
        }
    });
}

/* ---------- Init page ---------- */
export async function initPublishTrip() {
    await populateUserCars();
    initPublishTripForm();
}
