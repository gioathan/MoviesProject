# Run all containers in detached mode
up:
	docker-compose -f deploy/docker-compose.yml up -d

# Stop and remove containers
down:
	docker-compose -f deploy/docker-compose.yml down

# Rebuild everything (clean)
rebuild:
	docker-compose -f deploy/docker-compose.yml down --volumes --remove-orphans
	docker-compose -f deploy/docker-compose.yml build --no-cache
	docker-compose -f deploy/docker-compose.yml up -d

# Restart containers
restart:
	docker-compose -f deploy/docker-compose.yml down
	docker-compose -f deploy/docker-compose.yml up -d

# Run DB migrations inside the app container
db:
	docker exec ci4_app php spark migrate

# Check container logs
logs:
	docker-compose -f deploy/docker-compose.yml logs -f

writable-permissions:
	docker exec ci4_app chmod -R 0777 /var/www/html/writable
