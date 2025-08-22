export function initSignIn() {
    
    // Validation Pseudo (3-20 caractères, lettres, chiffres, underscore)
    function validatePseudo(pseudo) {
        const regex = /^[a-zA-Z0-9_]{3,20}$/;
        return regex.test(pseudo);
    }

     // Validation Mot de passe (minimum 8 caractères, au moins 1 maj, 1 min, 1 chiffre, 1 spécial)
    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return regex.test(password);
    }


     // Initialisation du formulaire 
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const pseudo = form.pseudo.value.trim();
        const password = form.motdepasse.value;

        // Alerts
        if (!validatePseudo(pseudo)) {
            alert("Pseudo invalide (3-20 caractères)");
            return;
        }

        if (!validatePassword(password)) {
            alert("Mot de passe invalide. Il doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.");
            return;
        }

           // Envoi du formulaire
        form.submit();
    });

}