console.log('signIn.js chargé !');

// --- Gestion du token JWT ---
const TOKEN_KEY = 'jwt';

function setToken(token) {
    localStorage.setItem(TOKEN_KEY, token);
}

function getToken() {
    return localStorage.getItem(TOKEN_KEY);
}

function logout() {
    localStorage.removeItem(TOKEN_KEY);
}

// --- Fetch protégé automatique ---
async function authFetch(url, options = {}) {
    const token = getToken();
    if (!token) throw new Error('Utilisateur non connecté');

    options.headers = {
        ...(options.headers || {}),
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    };

    const res = await fetch(url, options);

    if (res.status === 401) {
        logout();
        throw new Error('Token expiré ou non valide');
    }

    return res;
}

// --- Connexion ---
async function login(email, password) {
    const res = await fetch('http://localhost:8081/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });

    let data;
    try {
        data = await res.json();
    } catch (err) {
        throw new Error('Réponse serveur non JSON : ' + err.message);
    }

    if (res.ok && data.token) {
        setToken(data.token);
        return { status: 'ok', token: data.token };
    }

    return { status: 'error', message: data.message || 'Erreur de connexion' };
}

// --- Initialisation formulaire sign-in ---
export function initSignIn() {
    const form = document.getElementById('signInForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = form.email.value.trim();
        const password = form.password.value;

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            return alert('Email invalide');
        }
        if (password.length < 8) {
            return alert('Mot de passe invalide (8 caractères minimum)');
        }

        try {
            const result = await login(email, password);
            if (result.status === 'ok') {
                alert('Connexion réussie !');
                window.location.href = '/pages/dashboard.html';
            } else {
                alert(result.message);
            }
        } catch (err) {
            console.error('Erreur fetch :', err.message);
            alert('Erreur réseau ou serveur');
        }
    });
}

// --- Exemple pour récupérer les infos utilisateur ---
export async function getMe() {
    try {
        const res = await authFetch('http://localhost:8081/api/auth/me');
        return await res.json();
    } catch (err) {
        console.error(err.message);
        return null;
    }
}
