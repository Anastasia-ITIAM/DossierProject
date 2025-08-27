import { login } from './auth.js'; // Assure-toi que login() est exporté dans auth.js

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

    const form = document.getElementById('signUpForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = form.email.value.trim();
        const pseudo = form.pseudo.value.trim();
        const password = form.motdepasse.value;
        const confirmPassword = form.confirmer_motdepasse.value;
        const conditionsChecked = form.conditions.checked;

        // Validation front
        if (!validateEmail(email)) return alert('Email invalide');
        if (!validatePseudo(pseudo)) return alert('Pseudo invalide (3-20 caractères)');
        if (!validatePassword(password)) return alert('Mot de passe invalide. Il doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.');
        if (password !== confirmPassword) return alert('Les mots de passe ne correspondent pas');
        if (!conditionsChecked) return alert('Vous devez accepter les conditions d’utilisation');

        const data = { email, pseudo, password };

        try {
            console.log("📤 Data envoyée au backend :", data);

            // 1️⃣ Inscription
            const response = await fetch('http://localhost:8081/api/user', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // 2️⃣ Login automatique après inscription
                const loginResult = await login(email, password);

                if (loginResult.status === 'ok') {
                    // Token est automatiquement stocké dans localStorage par login()
                    alert('Inscription et connexion réussies !');

                    // 3️⃣ Exemple : faire une requête protégée avec le token
                    const token = localStorage.getItem('jwt');
                    const meResponse = await fetch('http://localhost:8081/api/auth/me', {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}` // 🔑 indispensable
                        }
                    });
                    const meData = await meResponse.json();
                    console.log('Utilisateur connecté:', meData);

                    // Redirection vers le dashboard
                    window.location.href = '/pages/dashboard.html';
                } else {
                    alert('Inscription réussie, mais impossible de se connecter automatiquement. Veuillez vous connecter.');
                    window.location.href = '/pages/signIn.html';
                }

            } else {
                alert(result.message || 'Erreur serveur');
            }

        } catch (err) {
            console.error('Erreur fetch :', err);
            alert('Erreur réseau');
        }
    });
}
