init:
	docker-compose up -d --build
	docker-compose exec app composer install

app:
	docker-compose exec app bash

db:
	docker-compose exec db bash
db-postgres:
	docker-compose exec db psql -U postgres sample
db-dbuser:
	docker-compose exec -e PGPASSWORD=dbpass db psql -U dbuser sample