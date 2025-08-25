export function initSignIn() {

    // Validation email
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Récupérer le formulaire par ID
    const form = document.getElementById('signInForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {  
        e.preventDefault();

        const email = form.email.value.trim();
        const password = form.motdepasse.value;

        // Alerts de validation
        if (!validateEmail(email)) return alert('Email invalide');
        if (password.length < 8) return alert('Mot de passe invalide (au moins 8 caractères)');

       
        // Envoi du formulaire via fetch POST
       
        // Préparer le JSON pour le back-end
        const data = {
            email: email,
            password: password
        };

        try {
            const response = await fetch('http://localhost:8081/api/login', {  
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                alert('Connexion réussie !');
                window.location.href = '/pages/profil.html';
            } else {
                alert(result.message || 'Identifiants invalides');
            }

        } catch (err) {
            console.error('Erreur fetch :', err);
            alert('Erreur réseau');
        }
    });
}
