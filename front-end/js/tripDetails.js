import { authFetch } from './signIn.js';

export async function initTripDetails() {
  const params = new URLSearchParams(window.location.search);
  const tripId = params.get('id');
  if (!tripId) return;

  try {
    const resp = await authFetch(`http://localhost:8081/api/trip/${tripId}`);

    // Vérifier le statut HTTP
    if (!resp.ok) {
      if (resp.status === 401) {
        alert('Vous devez vous connecter pour voir ce trajet.');
        window.location.href = 'signIn.html';
        return;
      }
      throw new Error(`Erreur serveur : ${resp.status}`);
    }

    // Vérifier que la réponse est bien du JSON
    const contentType = resp.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
      throw new Error('Réponse invalide : ce n’est pas du JSON');
    }

    const result = await resp.json();

    if (result.success) {
      const trip = result.trip;

      // Remplir les infos
      const setText = (selector, value) => {
        const el = document.querySelector(selector);
        if (el) el.textContent = value ?? '';
      };

      setText('#trip-departure', trip.departure_address);
      setText('#trip-arrival', trip.arrival_address);
      setText('#trip-date', trip.departure_date);
      setText('#trip-time', `${trip.departure_time} - ${trip.arrival_time}`);
      setText('#trip-price', `${trip.price} crédits`);
      setText('#trip-seats', trip.available_seats);
      setText('#trip-driver', trip.driver_name);

      // ✅ Nouveaux champs
      setText('#trip-eco', trip.eco_friendly ? 'Oui ♻️' : 'Non 🚗');
      setText('#trip-vehicle', trip.vehicle ?? 'Non renseigné');

      // Liste des passagers
      const passengersList = document.querySelector('#trip-passengers');
      if (passengersList && Array.isArray(trip.passengers)) {
        passengersList.innerHTML = '';
        trip.passengers.forEach(p => {
          const li = document.createElement('li');
          li.className = 'list-group-item eco-box';
          li.textContent = `${p.name} (${p.email})`;
          passengersList.appendChild(li);
        });
      }

      // ✅ Cacher les boutons "Se connecter / Créer un compte" si user est connecté
      checkAuthUI();
    } else {
      console.error('Erreur récupération trajet:', result.message);
    }
  } catch (err) {
    console.error('Erreur réseau ou parsing JSON:', err);
    alert('Impossible de charger le trajet. Vérifiez votre connexion ou reconnectez-vous.');
  }
}

/**
 * Masque le bloc d'authentification si l'utilisateur est déjà connecté
 */
function checkAuthUI() {
  const token = localStorage.getItem('jwt'); // ou le nom de ta clé
  const authBox = document.querySelector('#auth-box');

  if (token && authBox) {
    authBox.style.display = 'none';
  }
}
