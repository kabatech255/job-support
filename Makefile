GROUP = auth
GROUP = User

start:
	docker compose start

exec:
	docker compose exec laravel ash

stop:
	docker compose stop

phpstan:
	docker compose exec laravel ash -c "composer phpstan"

test:
	cp ./openapi/openapi.yml ./laravel/
	docker compose exec laravel ash -c "make test GROUP=${GROUP}"

test-all:
	cp ./openapi/openapi.yml ./laravel/
	docker compose exec laravel ash -c "make test-all"

crud:
	docker compose exec laravel ash -c "php artisan initial:api ${MODEL}"
