import { injectCommon } from './injectCommon.js';
import { initFormsAnimation } from './formsAnimation.js';
import { initTogglePassword } from './togglePassword.js';
import { initSwapAddress } from './swapAddress.js';
import { initSignUp } from './signUp.js'; 
import { initSignIn } from './signIn.js'; 

document.addEventListener("DOMContentLoaded", async () => {
    try {
        // Injection des éléments communs(header,footer,modals)
        await injectCommon();

        // Animations des formulaires, affichage/masquage des mots de passe, échange des adresses départ/arrivée
        initFormsAnimation();
        initTogglePassword('motdepasse', 'togglePassword');
        initTogglePassword('confirmer_motdepasse', 'toggleConfirmPassword');
        initSwapAddress('depart', 'arrivee', 'swapBtn');

        // Configuration spécifique à la page d'inscription (signUp.html)
        if (document.body.classList.contains('signup-page')) {
            initSignUp();
        }

        // Configuration spécifique à la page de connexion (signIn.html)
        if (document.body.classList.contains('signin-page')) {
            initSignIn();
        }

        console.log("Initialisation JS terminée !");
    } catch (err) {
        console.error("Erreur lors de l'initialisation principale :", err);
    }
});
