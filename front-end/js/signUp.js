export function initSignUp() {

    // Validation email
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Validation pseudo
    function validatePseudo(pseudo) {
        const regex = /^[a-zA-Z0-9_]{3,20}$/;
        return regex.test(pseudo);
    }

    // Validation mot de passe
    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return regex.test(password);
    }

    // Récupérer le formulaire par ID
    const form = document.getElementById('signUpForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = form.email.value.trim();
        const pseudo = form.pseudo.value.trim();
        const password = form.motdepasse.value;
        const confirmPassword = form.confirmer_motdepasse.value;
        const conditionsChecked = form.conditions.checked;

        // Alerts de validation
        if (!validateEmail(email)) return alert('Email invalide');
        if (!validatePseudo(pseudo)) return alert('Pseudo invalide (3-20 caractères)');
        if (!validatePassword(password)) return alert('Mot de passe invalide. Il doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.');
        if (password !== confirmPassword) return alert('Les mots de passe ne correspondent pas');
        if (!conditionsChecked) return alert('Vous devez accepter les conditions d’utilisation');

        
        // Envoi du formulaire via fetch POST
        
        // Préparer le JSON pour le back-end
        const data = {
            email: email,
            pseudo: pseudo,
            password: password
        };


        try {
                    console.log("📤 Data envoyée au backend :", data);

            const response = await fetch('http://localhost:8081/api/user', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                alert('Inscription réussie !');
                window.location.href = '/pages/signIn.html';
            } else {
                alert(result.message || 'Erreur serveur');
            }

        } catch (err) {
            console.error('Erreur fetch :', err);
            alert('Erreur réseau');
        }
    });
}
