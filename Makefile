APP_NAME ?= cexpress
DOCKER_NETWORK ?= cexpress


build:
	docker-compose build

up:
	docker-compose up -d

fup:
	docker-compose up -d --force-recreate

db-reset:
	docker-compose exec -T -u `id -u` app mysql -u root -proot -h database courriers < database/sql/courriers.sql

down:
	docker-compose down

clear:
	docker-compose down -v

init:
	docker-compose run --rm cexpress composer install --no-interaction
