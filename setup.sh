#!/bin/bash

echo "📄 Paso 1: Copiando archivo .env"
cp .env.example .env

echo "📦 Paso 2: Instalando dependencias con Composer"
docker compose exec app composer install

echo "🔁 Paso 3: Generando clave de aplicación"
docker compose exec app php artisan key:generate

echo "📦 Paso 4: Instalando dependencias de Node.js"
docker compose exec app npm install

echo "⚙️ Paso 5: Compilando assets"
docker compose exec app npm run dev

echo "🗃 Paso 6: Ejecutando migraciones"
docker compose exec app php artisan migrate

echo "🌱 Paso 7: Ejecutando seeders"
docker compose exec app php artisan db:seed

echo "✅ Proyecto Laravel listo en http://localhost:8000"