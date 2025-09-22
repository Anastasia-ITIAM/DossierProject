import { login } from './signIn.js';

function sanitizeInput(input) {
    return input.replace(/[<>]/g, "");
}

function safeAlert(message) {
    alert(Array.isArray(message) ? message.join('\n') : message);
}

export function initSignUp() {
    const validateEmail = email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const validatePseudo = pseudo => /^[a-zA-Z0-9_]{3,20}$/.test(pseudo);
    const validatePassword = password => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password);

    const form = document.getElementById('signUpForm');
    if (!form) return;

    form.addEventListener('submit', async e => {
        e.preventDefault();

        const email = sanitizeInput(form.email.value.trim());
        const pseudo = sanitizeInput(form.pseudo.value.trim());
        const password = form.password.value;
        const confirmPassword = form.confirmPassword.value;
        const conditionsChecked = form.conditions.checked;

        if (!validateEmail(email)) return safeAlert('Email invalide');
        if (!validatePseudo(pseudo)) return safeAlert('Pseudo invalide (3-20 caractères)');
        if (!validatePassword(password)) return safeAlert('Mot de passe invalide.');
        if (password !== confirmPassword) return safeAlert('Les mots de passe ne correspondent pas');
        if (!conditionsChecked) return safeAlert('Vous devez accepter les conditions d’utilisation');

        const data = { email, pseudo, password };

        try {
            console.log("📤 Data envoyée :", data);

            const response = await fetch('http://localhost:8000/api/user', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                const loginResult = await login(email, password);
                if (loginResult.status === 'ok') {
                    safeAlert('Inscription et connexion réussies ! 🎉\nVous avez 20 crédits !');
                    window.location.href = '/pages/profil.html';
                } else {
                    safeAlert('Inscription réussie, mais impossible de se connecter automatiquement.');
                    window.location.href = '/pages/signIn.html';
                }
            } else {
                safeAlert(Array.isArray(result.message) ? result.message.join('\n') : result.message);
            }

        } catch (err) {
            console.error('Erreur fetch :', err);
            safeAlert('Erreur réseau');
        }
    });
}
