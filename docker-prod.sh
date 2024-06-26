docker compose --env-file production.env down
docker compose --env-file production.env up -d --build
docker image prune -f