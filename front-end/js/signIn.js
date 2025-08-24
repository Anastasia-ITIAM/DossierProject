export function initSignIn() {

    // Validation Pseudo (3-20 caractères, lettres, chiffres, underscore)
    function validatePseudo(pseudo) {
        const regex = /^[a-zA-Z0-9_]{3,20}$/;
        return regex.test(pseudo);
    }

    // Récupérer le formulaire par ID
    const form = document.getElementById('signInForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {  
        e.preventDefault();

        const pseudo = form.pseudo.value.trim();
        const password = form.motdepasse.value;

        // Alerts de validation
        if (!validatePseudo(pseudo)) return alert('Pseudo invalide (3-20 caractères)');
        if (password.length < 8) return alert('Mot de passe invalide (au moins 8 caractères)');

       
        // Envoi du formulaire via fetch POST
       
        // Préparer le JSON pour le back-end
        const data = {
            pseudo: pseudo,
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
