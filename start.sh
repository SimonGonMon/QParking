# Esta es la mayor payasada vista nunca. Carga las variables de entorno del contenedor externo de Azure en el contenedor interno de Docker
eval $(printenv | sed -n "s/^\([^=]\+\)=\(.*\)$/export \1=\2/p" | sed 's/"/\\\"/g' | sed '/=/s//="/' | sed 's/$/"/' >> /etc/profile)

# Optimizamos el framework
php artisan optimize

# Corremos el servidor de Laravel
php artisan serve --host=0.0.0.0 --port=80