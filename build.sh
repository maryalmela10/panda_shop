#!/bin/bash

echo "🛑 Deteniendo contenedores anteriores..."
docker compose down

echo "🧹 Limpiando contenedores, imágenes y volúmenes no utilizados..."
docker system prune -af --volumes

echo "🚀 Construyendo e iniciando contenedores..."
docker compose up --build -d

sleep 5

chmod +x setup.sh
./setup.sh
