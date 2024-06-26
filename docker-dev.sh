docker-compose --env-file development.env down
docker-compose --env-file development.env up -d --build
docker image prune -f