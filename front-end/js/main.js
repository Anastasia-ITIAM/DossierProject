import { injectCommon } from './injectCommon.js';
import { initFormsAnimation } from './formsAnimation.js';
import { initTogglePassword } from './togglePassword.js';
import { initSwapAddress } from './swapAddress.js';
import { initSignUp } from './signUp.js'; 
import { initSignIn } from './signIn.js'; 
import { initProfil } from './profil.js';

// Mapping page class -> init function
const pageInits = {
    'signup-page': initSignUp,
    'signin-page': initSignIn,
    'profil-page': initProfil,
};

document.addEventListener("DOMContentLoaded", async () => {
    try {
        // 1️⃣ Injection des éléments communs (header, footer, modals)
        await injectCommon();

        // 2️⃣ Initialisations globales (animations, toggle, swap)
        initFormsAnimation();
        initTogglePassword('password', 'togglePassword');
        initTogglePassword('confirmPassword', 'toggleConfirmPassword');
        initSwapAddress('depart', 'arrivee', 'swapBtn');

        // 3️⃣ Initialisation spécifique à la page
        const bodyClass = document.body.classList.value.split(' ');
        bodyClass.forEach(cls => {
            if (pageInits[cls]) pageInits[cls]();
        });

        console.log("Initialisation JS terminée !");
    } catch (err) {
        console.error("Erreur lors de l'initialisation principale :", err);
    }
});
