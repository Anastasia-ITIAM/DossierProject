# --------------------------
# Image Nginx légère pour production
# --------------------------
FROM nginx:alpine

# Supprimer la configuration par défaut si nécessaire
RUN rm /etc/nginx/conf.d/default.conf

# Copier la configuration Nginx personnalisée (optionnel)
# COPY nginx.conf /etc/nginx/conf.d/

# Copier uniquement les fichiers buildés du front (ex: dist ou build)
# Remplace 'build/' par le dossier généré par ton front-end (React, Vue, Angular, etc.)
COPY build/ /usr/share/nginx/html

# Exposer le port 80
EXPOSE 80

# Lancer nginx en foreground
CMD ["nginx", "-g", "daemon off;"]
