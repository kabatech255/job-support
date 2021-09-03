GROUP = auth
GROUP = User

start:
	docker compose start

exec:
	docker compose exec app ash

stop:
	docker compose stop

phpstan:
	docker compose exec app ash -c "composer phpstan"

test:
	cp ./openapi/openapi.yml ./laravel/
	docker compose exec app ash -c "make test GROUP=${GROUP}"

test-all:
	cp ./openapi/openapi.yml ./laravel/
	docker compose exec app ash -c "make test-all"

crud:
	docker compose exec app ash -c "php artisan initial:api ${MODEL}"
