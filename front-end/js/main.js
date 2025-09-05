import { injectCommon } from './injectCommon.js';
import { initHeader } from './header.js';
import { initFormsAnimation } from './formsAnimation.js';
import { initTogglePassword } from './togglePassword.js';
import { initSwapAddress } from './swapAddress.js';
import { initSignUp } from './signUp.js'; 
import { initSignIn, getMe } from './signIn.js'; 
import { initProfil } from './profil.js';
import { initProfilUI } from './profilUI.js';
import { initCar } from './car.js';


// Mapping page class -> init function
const pageInits = {
    'signup-page': initSignUp,
    'signin-page': initSignIn,
    'driver-page': initCar,
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
        await injectCommon();
        await initUser();
        await initHeader();

        // Initialisations globales (animations, toggle, swap)
        initFormsAnimation();
        initTogglePassword('password', 'togglePassword');
        initTogglePassword('confirmPassword', 'toggleConfirmPassword');
        initSwapAddress('depart', 'arrivee', 'swapBtn');

        // Initialisation spécifique à la page
        const bodyClass = document.body.classList.value.split(' ');
        bodyClass.forEach(cls => {
            if (pageInits[cls]) pageInits[cls]();
        });

        console.log("Initialisation JS terminée !");
    } catch (err) {
        console.error("Erreur lors de l'initialisation principale :", err);
    }
});