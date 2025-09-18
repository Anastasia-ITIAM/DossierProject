// tripReview.js
import { authFetch } from './signIn.js';

export function initTripReview() {
    const reviewsContainer = document.getElementById("trip-reviews");
    const reviewForm = document.getElementById("trip-review-form");

    if (!reviewsContainer) return;

    // Récupère automatiquement l’ID du trajet depuis body[data-trip-id]
    const tripId = document.body.dataset.tripId;
    if (!tripId) {
        console.error("Impossible de récupérer tripId depuis body[data-trip-id]");
        return;
    }

    // --- Charger et afficher les avis ---
    async function loadReviews() {
        try {
            // ⚡ Assurez-vous que le port correspond à votre backend Symfony
            const res = await authFetch(`http://localhost:8081/api/trip/${tripId}/reviews`, { method: 'GET' }, true);

            if (res.status === 404) {
                reviewsContainer.innerHTML = `<li class="list-group-item">Aucun avis disponible (endpoint non trouvé).</li>`;
                return;
            }

            if (!res.ok) throw new Error(`Erreur HTTP : ${res.status}`);

            const json = await res.json();

            if (!json.success || !json.reviews || json.reviews.length === 0) {
                reviewsContainer.innerHTML = `<li class="list-group-item">Aucun avis disponible.</li>`;
                return;
            }

            reviewsContainer.innerHTML = json.reviews.map(r => `
                <li class="list-group-item eco-box">
                    <strong>Utilisateur ${r.userId}</strong><br>
                    ${r.comment}<br>
                    ⭐ ${r.rating}/5<br>
                    <small>${r.createdAt}</small>
                </li>
            `).join("");
        } catch (err) {
            console.error("Erreur lors du chargement des avis :", err);
            reviewsContainer.innerHTML = `<li class="list-group-item text-danger">Erreur de chargement des avis.</li>`;
        }
    }

    // --- Ajouter un nouvel avis ---
    if (reviewForm) {
        reviewForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const comment = document.getElementById("review-comment").value.trim();
            const rating = parseInt(document.getElementById("review-rating").value, 10);

            if (!window.currentUserId) {
                alert("Vous devez être connecté pour laisser un avis.");
                return;
            }

            if (!comment || !rating || rating < 1 || rating > 5) {
                alert("Veuillez saisir un commentaire et une note valide (1-5).");
                return;
            }

            try {
                const res = await authFetch(`http://localhost:8081/api/trip/${tripId}/reviews`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        userId: window.currentUserId,
                        comment,
                        rating
                    })
                }, true);

                const json = await res.json();
                if (json.success) {
                    reviewForm.reset();
                    await loadReviews(); // Recharge les avis après ajout
                } else {
                    alert("Erreur : " + (json.message || "Impossible d'ajouter l'avis."));
                }
            } catch (err) {
                console.error("Erreur lors de l'ajout de l'avis :", err);
                alert("Une erreur est survenue lors de l'ajout de l'avis.");
            }
        });
    }

    // Charger les avis au démarrage
    loadReviews();
}
