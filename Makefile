GROUP = auth

start:
	docker compose start

phpstan:
	docker compose exec laravel ash -c "composer phpstan"

test:
	cp ./swagger/swagger.yml ./laravel/
	docker compose exec laravel ash -c "make test GROUP=${GROUP}"

test-all:
	cp ./swagger/swagger.yml ./laravel/
	docker compose exec laravel ash -c "make test-all"

exec:
	docker compose exec laravel ash

stop:
	docker compose stop
