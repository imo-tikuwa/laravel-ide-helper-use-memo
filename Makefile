init:
	docker-compose up -d --build
	docker-compose exec app composer install
	docker-compose exec app php artisan migrate

app:
	docker-compose exec app bash
app-pint-fix:
	docker-compose exec app ./vendor/bin/pint

db:
	docker-compose exec db bash
db-postgres:
	docker-compose exec db psql -U postgres -d sample

down:
	docker-compose down
down-all:
	docker-compose down --rmi all --volumes --remove-orphans