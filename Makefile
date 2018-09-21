APP_NAME ?= cexpress
DOCKER_NETWORK ?= cexpress


build:
	docker-compose build

up:
	docker-compose up -d

fup:
	docker-compose up -d --force-recreate

db-reset:
	docker-compose run --entrypoint=docker-php-entrypoint  sh -c "mysql -u root -proot -h database dolibarr < database/sql/courriers.sql"

down:
	docker-compose down

clear:
	docker-compose down -v

init:
	docker-compose run --rm cexpress composer install --no-interaction
