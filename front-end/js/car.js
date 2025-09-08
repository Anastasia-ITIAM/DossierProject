// car.js (version simplifiée sans smoker et pets_allowed)
console.log("initCar chargé !");

import { authFetch } from './signIn.js';

/* ---------- Utils ---------- */
function deepGet(obj, path) {
    if (!obj || !path) return undefined;
    const parts = path.split('.');
    let cur = obj;
    for (const p of parts) {
        if (cur == null) return undefined;
        cur = cur[p];
    }
    return cur;
}

function coalesce(obj, ...keys) {
    for (const k of keys) {
        const v = deepGet(obj, k);
        if (v !== undefined && v !== null && v !== '') return v;
    }
    return undefined;
}

function toYMD(value) {
    if (!value && value !== 0) return '';
    if (typeof value === 'string') {
        const s = value.trim();
        if (/^\d{4}-\d{2}-\d{2}$/.test(s)) return s;
        if (/^\d{4}-\d{2}-\d{2}T/.test(s)) return s.split('T')[0];
        if (/^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}/.test(s)) return s.split(' ')[0];
        const d = new Date(s);
        if (!isNaN(d)) return toYMD(d);
        return '';
    }
    if (value instanceof Date) {
        if (isNaN(value)) return '';
        const yyyy = value.getFullYear();
        const mm = String(value.getMonth() + 1).padStart(2, '0');
        const dd = String(value.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }
    if (typeof value === 'number') {
        const d = new Date(value);
        if (!isNaN(d)) return toYMD(d);
    }
    return '';
}

/* ---------- API ---------- */
export async function fetchMyCars() {
    console.log("📡 fetchMyCars appelé");
    try {
        const response = await authFetch('http://localhost:8081/api/car/list', { method: 'GET' });
        const data = await response.json();
        console.log("📄 Réponse fetchMyCars :", data);
        if (response.ok && data.success) {
            return Array.isArray(data.cars) ? data.cars : (data.cars ? [data.cars] : []);
        } else {
            console.error("❌ Erreur récupération voitures :", data.message);
            return [];
        }
    } catch (err) {
        console.error("⚠️ Exception fetchMyCars :", err);
        return [];
    }
}

/* ---------- Rendu ---------- */
function createInput({ type='text', name, value='', min, required=false, classes='form-control' }) {
    const input = document.createElement('input');
    input.type = type;
    input.name = name;
    input.className = classes;
    if (min !== undefined) input.min = min;
    if (required) input.required = true;
    if (value !== undefined && value !== null) input.value = value;
    return input;
}

export function renderCars(cars) {
    const carsList = document.getElementById('cars-list');
    if (!carsList) return;
    carsList.innerHTML = '';

    if (!Array.isArray(cars) || cars.length === 0) {
        const empty = document.createElement('div');
        empty.className = 'text-muted';
        empty.textContent = 'Aucun véhicule enregistré.';
        carsList.appendChild(empty);
        return;
    }

    cars.forEach(car => {
        const licensePlate = coalesce(car, 'license_plate', 'licensePlate', 'plate', 'plaque') || '';
        const registrationRaw = coalesce(car,
            'registration_date', 'registrationDate', 'registered_at', 'registration', 'immatriculation_date'
        );
        const brand = coalesce(car, 'brand', 'marque', 'make') || '';
        const model = coalesce(car, 'model', 'modele', 'type') || '';
        const color = coalesce(car, 'color', 'couleur') || '';
        const fuel = coalesce(car, 'fuel_type', 'fuelType', 'energy', 'energie') || '';
        const seats = Number(coalesce(car, 'available_seats', 'availableSeats', 'seats', 'places')) || 0;
        const customPref = coalesce(car, 'custom_preferences', 'customPreferences', 'preferences') || '';

        const form = document.createElement('form');
        form.className = 'card p-3 mb-2 shadow-sm eco-box';
        if (car.id !== undefined) form.dataset.carId = car.id;

        // row1: plaque + date
        const row1 = document.createElement('div'); row1.className = 'row';
        const col11 = document.createElement('div'); col11.className = 'col-md-6 mb-2';
        col11.appendChild(Object.assign(document.createElement('label'), { textContent: 'Plaque *' }));
        col11.appendChild(createInput({ type:'text', name:'license_plate', value: licensePlate }));
        const col12 = document.createElement('div'); col12.className = 'col-md-6 mb-2';
        col12.appendChild(Object.assign(document.createElement('label'), { textContent: 'Date immatriculation *' }));
        const dateInput = createInput({ type:'date', name:'registration_date' });
        dateInput.value = toYMD(registrationRaw);
        col12.appendChild(dateInput);
        row1.appendChild(col11); row1.appendChild(col12);

        // row2: marque model color
        const row2 = document.createElement('div'); row2.className = 'row';
        [['Marque *', 'brand', brand], ['Modèle *', 'model', model], ['Couleur *', 'color', color]].forEach(([labelText, name, value]) => {
            const col = document.createElement('div'); col.className = 'col-md-4 mb-2';
            col.appendChild(Object.assign(document.createElement('label'), { textContent: labelText }));
            col.appendChild(createInput({ name, value }));
            row2.appendChild(col);
        });

        // row3: fuel / seats
        const row3 = document.createElement('div'); row3.className = 'row';
        const colFuel = document.createElement('div'); colFuel.className = 'col-md-6 mb-2';
        colFuel.appendChild(Object.assign(document.createElement('label'), { textContent: 'Énergie *' }));
        colFuel.appendChild(createInput({ name:'fuel_type', value: fuel }));
        const colSeats = document.createElement('div'); colSeats.className = 'col-md-6 mb-2';
        colSeats.appendChild(Object.assign(document.createElement('label'), { textContent: 'Places disponibles *' }));
        colSeats.appendChild(createInput({ type:'number', name:'available_seats', min:1, value: seats }));
        row3.appendChild(colFuel); row3.appendChild(colSeats);

        // prefs textarea avec label
const prefsDiv = document.createElement('div');
prefsDiv.className = 'mb-3';

const prefsLabel = document.createElement('label');
prefsLabel.className = 'form-label';
prefsLabel.textContent = 'Préférences personnalisées';
prefsLabel.htmlFor = `prefs_${car.id || Math.random()}`; // id unique

const prefs = document.createElement('textarea');
prefs.className = 'form-control';
prefs.name = 'custom_preferences';
prefs.rows = 3;
prefs.value = customPref;
prefs.id = prefsLabel.htmlFor; // associe label à textarea

prefsDiv.appendChild(prefsLabel);
prefsDiv.appendChild(prefs);
form.appendChild(prefsDiv);


        // delete button
        const delDiv = document.createElement('div'); delDiv.className='text-center mb-4 mt-3';
        const delBtn = document.createElement('button');
        delBtn.type='button';
        delBtn.className='btn btn-danger';
        delBtn.textContent='Supprimer';
        delBtn.addEventListener('click', async () => {
            if (!confirm('Voulez-vous vraiment supprimer ce véhicule ?')) return;
            try {
                if (!car.id) return alert('ID absent');
                const resp = await authFetch(`http://localhost:8081/api/car/delete/${car.id}`, { method: 'DELETE' });
                const result = await resp.json();
                if (resp.ok && result.success) {
                    renderCars(await fetchMyCars());
                } else alert('Erreur suppression: ' + (result.message || JSON.stringify(result)));
            } catch(err) { alert('Erreur réseau'); console.error(err); }
        });
        delDiv.appendChild(delBtn);

        // assemble
form.appendChild(row1);
form.appendChild(row2);
form.appendChild(row3);
form.appendChild(prefsDiv);   // d’abord préférences personnalisées
form.appendChild(delDiv);     // puis bouton supprimer
carsList.appendChild(form);

    });
}

/* ---------- Formulaire d’ajout ---------- */
export function initCar() {
    const form = document.querySelector("#driverForm");
    if (!form) return;
    const userId = window.currentUserId;
    if (!userId) return;
    const storageKey = `userProfile_${userId}`;

    form.addEventListener('submit', async (e)=>{
        e.preventDefault();
        const formData = new FormData(form);
        const data = {
            license_plate: formData.get('license_plate'),
            registration_date: formData.get('registration_date'),
            brand: formData.get('brand'),
            model: formData.get('model'),
            color: formData.get('color'),
            fuel_type: formData.get('fuel_type'),
            available_seats: parseInt(formData.get('available_seats'),10) || 0,
            custom_preferences: formData.get('custom_preferences') || ''
        };
        try {
            const resp = await authFetch('http://localhost:8081/api/car/add', { method:'POST', body: JSON.stringify(data) });
            const result = await resp.json();
            if(resp.ok && result.success){
                const currentUserData = JSON.parse(sessionStorage.getItem(storageKey)) || {};
                currentUserData.role='ROLE_PASSENGER_DRIVER';
                sessionStorage.setItem(storageKey, JSON.stringify(currentUserData));
                window.dispatchEvent(new Event('profileDataReady'));
                renderCars(await fetchMyCars());
                form.reset();
            } else alert('Erreur : ' + (result.message || JSON.stringify(result)));
        } catch(err){ alert('Erreur réseau'); console.error(err);}
    });
}

/* ---------- Init page ---------- */
export async function initCarPage(){
    renderCars(await fetchMyCars());
    initCar();
}
