export function initSignUp() {

    // Validation Email
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

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

    // Récupérer le formulaire par ID
    const form = document.getElementById('signUpForm');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const email = form.email.value.trim();
        const pseudo = form.pseudo.value.trim();
        const password = form.motdepasse.value;
        const confirmPassword = form.confirmer_motdepasse.value;
        const conditionsChecked = form.conditions.checked;

        // Alerts
        if (!validateEmail(email)) {
            alert("Email invalide");
            return;
        }

        if (!validatePseudo(pseudo)) {
            alert("Pseudo invalide (3-20 caractères)");
            return;
        }

        if (!validatePassword(password)) {
            alert("Mot de passe invalide. Il doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.");
            return;
        }

        if (password !== confirmPassword) {
            alert("Les mots de passe ne correspondent pas");
            return;
        }

        if (!conditionsChecked) {
            alert("Vous devez accepter les conditions d’utilisation");
            return;
        }

        // Envoi du formulaire via fetch POST vers Symfony
        fetch('http://localhost:8081/api/signup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                pseudo: pseudo,
                motdepasse: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Inscription réussie !');
                window.location.href = '/signIn.html'; // redirection vers login
            } else {
                alert('Erreur : ' + data.error);
            }
        })
        .catch(err => {
            console.error('Erreur JS fetch :', err);
            alert('Erreur serveur');
        });
    });
}
