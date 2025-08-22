# Image nginx légère
FROM nginx:alpine

# Copier tous les fichiers dans le dossier nginx
COPY . /usr/share/nginx/html

# Exposer le port 80
EXPOSE 80

# Lancer nginx
CMD ["nginx", "-g", "daemon off;"]
