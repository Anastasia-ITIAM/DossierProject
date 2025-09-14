console.log('signIn.js chargé !');

const TOKEN_KEY = 'jwt';
const USERID_KEY = 'userId';
let isLoggingOut = false; // Évite plusieurs redirections simultanées

// Supprime les caractères HTML pour éviter XSS
function sanitizeInput(input) {
    return input.replace(/[<>]/g, "");
}

// Alert sécurisée (non bloquante pour debug, ici simple alert)
function safeAlert(message) {
    const div = document.createElement('div');
    div.textContent = Array.isArray(message) ? message.join('\n') : message;
    alert(div.textContent);
}

// Gestion du token JWT
export function setToken(token) { localStorage.setItem(TOKEN_KEY, token); }
export function getToken() { return localStorage.getItem(TOKEN_KEY); }
export function removeToken() { localStorage.removeItem(TOKEN_KEY); }

export function setUserId(userId) { localStorage.setItem(USERID_KEY, userId); }
export function getUserId() { return parseInt(localStorage.getItem(USERID_KEY), 10) || 0; }

// Vérifie si le token est expiré
export function isTokenExpired(token) {
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        return Date.now() >= payload.exp * 1000;
    } catch (err) {
        console.error('Erreur décodage token :', err);
        return true;
    }
}

// Déconnexion sécurisée
export function logout(redirect = true) {
    if (isLoggingOut) return;
    isLoggingOut = true;

    removeToken();
    localStorage.removeItem(USERID_KEY);

    if (redirect) {
        setTimeout(() => {
            window.location.href = '/pages/signIn.html';
        }, 50);
    }
}

// Fetch protégé avec JWT
// forceAuth = false → pas de redirection automatique (utile pour pages publiques / debug)
export async function authFetch(url, options = {}, forceAuth = true) {
    const token = getToken();

    if (forceAuth && (!token || isTokenExpired(token))) {
        console.warn("Token expiré ou absent (redirection désactivée si forceAuth=false)");
        // Commenter la ligne suivante pendant debug pour éviter redirection
        // if (forceAuth) logout();
        throw new Error('Token expiré ou non présent');
    }

    options.headers = options.headers || {};
    if (token && forceAuth) {
        options.headers['Authorization'] = `Bearer ${token}`;
    }
    options.headers['Content-Type'] = 'application/json';

    const res = await fetch(url, options);

    if (res.status === 401 && forceAuth) {
        console.warn("Token invalide ou expiré");
        // Commenter pendant debug
        // logout();
        throw new Error('Token invalide ou expiré');
    }

    return res;
}

// Connexion utilisateur
export async function login(email, password) {
    try {
        const res = await fetch('http://localhost:8081/api/auth/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: sanitizeInput(email), password })
        });

        const data = await res.json();

        if (res.ok && data.token) {
            setToken(data.token);

            // Décodage du JWT pour récupérer l'ID utilisateur
            try {
                const payload = JSON.parse(atob(data.token.split('.')[1]));
                if (payload.userId) {
                    setUserId(payload.userId);
                    console.log('User ID stocké:', payload.userId);
                }
            } catch (err) {
                console.error('Erreur décodage JWT pour userId :', err);
            }

            return { status: 'ok', token: data.token };
        }

        return { status: 'error', message: 'Email ou mot de passe incorrect. Veuillez réessayer.' };
    } catch (err) {
        console.error('Erreur fetch login :', err);
        return { status: 'error', message: 'Erreur réseau ou serveur' };
    }
}

// Initialisation formulaire login
export function initSignIn() {
    const form = document.getElementById('signInForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = sanitizeInput(form.email.value.trim());
        const password = form.password.value;

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return safeAlert('Email invalide');
        if (password.length < 8) return safeAlert('Mot de passe invalide (8 caractères minimum)');

        try {
            const result = await login(email, password);
            if (result.status === 'ok') {
                safeAlert('Connexion réussie !');
                setTimeout(() => {
                    window.location.href = '/pages/profil.html';
                }, 50);
            } else {
                safeAlert(result.message);
            }
        } catch (err) {
            console.error('Erreur fetch submit :', err);
            safeAlert('Erreur réseau ou serveur');
        }
    });
}

// Récupération infos utilisateur
// forceAuth = false → pas de redirection sur pages publiques (utile pour debug)
export async function getMe(forceAuth = true) {
    try {
        const res = await authFetch('http://localhost:8081/api/auth/me', {}, forceAuth);
        const data = await res.json();
        if (data && data.id) setUserId(data.id);
        return data;
    } catch (err) {
        console.warn("Impossible de récupérer l'utilisateur :", err.message);
        return null;
    }
}
