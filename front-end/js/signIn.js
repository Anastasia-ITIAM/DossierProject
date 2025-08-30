console.log('signIn.js chargé !');

const TOKEN_KEY = 'jwt';


// Supprime les caractères HTML pour éviter XSS
function sanitizeInput(input) {
    return input.replace(/[<>]/g, "");
}

// Alert sécurisée : ne permet pas d’exécuter du HTML ou du JS injecté
function safeAlert(message) {
    const div = document.createElement('div');
    div.textContent = Array.isArray(message) ? message.join('\n') : message;
    alert(div.textContent);
}

// Gestion du token JWT

export function setToken(token) {          
    localStorage.setItem(TOKEN_KEY, token);
}

export function getToken() {               
    return localStorage.getItem(TOKEN_KEY);
}

export function removeToken() {            
    localStorage.removeItem(TOKEN_KEY);
}

export function isTokenExpired(token) {   
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        return Date.now() >= payload.exp * 1000;
    } catch (err) {
        console.error('Erreur décodage token :', err);
        return true;
    }
}

export function logout() {               
    removeToken();
    window.location.href = '/pages/signIn.html';
}

// Fetch protégé avec JWT

export async function authFetch(url, options = {}) {
    const token = getToken();

    if (!token || isTokenExpired(token)) {
        console.warn("Token expiré ou absent");

        // Si on est sur une page protégée → redirection
        if (window.location.pathname.includes("profil.html")) {
            logout();
        }

        throw new Error('Token expiré ou non présent');
    }

    options.headers = {
        ...(options.headers || {}),
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    };

    const res = await fetch(url, options);

    if (res.status === 401) {
        if (window.location.pathname.includes("profil.html")) {
            logout();
        }
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
            body: JSON.stringify({
                email: sanitizeInput(email),
                password
            })
        });

        const data = await res.json();

        if (res.ok && data.token) {
            setToken(data.token);
            return { status: 'ok', token: data.token };
        }

        return { status: 'error', message: data.message || 'Identifiants invalides' };
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

        // Validation front
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return safeAlert('Email invalide');
        if (password.length < 8) return safeAlert('Mot de passe invalide (8 caractères minimum)');

        try {
            const result = await login(email, password);
            if (result.status === 'ok') {
                safeAlert('Connexion réussie !');
                window.location.href = '/pages/profil.html';
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

export async function getMe() {
    try {
        const res = await authFetch('http://localhost:8081/api/auth/me');
        return await res.json();
    } catch (err) {
        console.error(err.message);
        return null;
    }
}
