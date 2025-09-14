import { injectCommon } from './injectCommon.js';
import { initHeader } from './header.js';
import { initFormsAnimation } from './formsAnimation.js';
import { initTogglePassword } from './togglePassword.js';
import { initSwapAddress } from './swapAddress.js';
import { initSignUp } from './signUp.js'; 
import { initSignIn, getMe } from './signIn.js'; 
import { initProfil } from './profil.js';
import { initProfilUI } from './profilUI.js';
import { initCarPage } from './car.js';
import { initPublishTrip } from './publishTrip.js';
import { initMyTrips } from './myTrips.js';
import { initTripDetails } from './tripDetails.js';
import { initSearchTrip } from './searchTrip.js';




// Mapping page class -> init function
const pageInits = {
    'signup-page': initSignUp,
    'signin-page': initSignIn,
    'driver-page': initCarPage, 
    'publishTrip-page': initPublishTrip,
    'trips-page': initMyTrips,
    'trip-details-page': initTripDetails,
    'trip-search-page': initSearchTrip,
    'profil-page': () => {
        initProfil();
        initProfilUI();
    },
};

// Initialisation de l'utilisateur connecté
async function initUser() {
    const user = await getMe();
    if (user) {
        console.log("Utilisateur connecté :", user);
        window.currentUserId = user.id;   
    } else {
        // Redirection uniquement pour les pages protégées
        if (document.body.classList.contains('profil-page')) {
            window.location.href = '/pages/signIn.html';
        }
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    try {
        console.log("Début de l'initialisation principale");

        await injectCommon();       // Injecte header/footer/modals
        await initUser();           // Initialise window.currentUserId
        await initHeader();         // Initialise le header avec l'utilisateur

        // Initialisations globales (animations, toggle, swap)
        initFormsAnimation();
        initTogglePassword('password', 'togglePassword');
        initTogglePassword('confirmPassword', 'toggleConfirmPassword');
        initSwapAddress('depart', 'arrivee', 'swapBtn');

        // Initialisation spécifique à la page
        const bodyClass = document.body.className.split(' ');
        bodyClass.forEach(cls => {
            if (pageInits[cls]) {
                console.log(`Initialisation de la page : ${cls}`);
                pageInits[cls]();
            }
        });

        console.log("Initialisation JS terminée !");
    } catch (err) {
        console.error("Erreur lors de l'initialisation principale :", err);
    }
});
