import { injectCommon } from './injectCommon.js';
import { initFormsAnimation } from './formsAnimation.js';
import { initTogglePassword } from './togglePassword.js';
import { initSwapAddress } from './swapAddress.js';
import { initSignUp } from './signUp.js'; 
import { initSignIn, getMe } from './signIn.js'; 
import { initProfil } from './profil.js';
import { initHeader } from './header.js';

// Mapping page class -> init function
const pageInits = {
    'signup-page': initSignUp,
    'signin-page': initSignIn,
    'profil-page': initProfil,
};

// Initialisation de l'utilisateur connecté
async function initUser() {
    const user = await getMe();
    if (user) {
        console.log("Utilisateur connecté :", user);
        window.currentUserId = user.id;   // ID accessible globalement
        window.currentUser = user;        // Autres infos disponibles
    } else {
        // Redirige vers login si non connecté
        if (!document.body.classList.contains('signin-page')) {
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