GROUP = auth
MODEL = User

test:
	php artisan migrate:reset --env=testing
	php artisan migrate --seed --env=testing
	vendor/bin/phpunit --testsuite Feature --testdox --group=${GROUP}

test-all:
	php artisan migrate:reset --env=testing
	php artisan migrate --seed --env=testing
	vendor/bin/phpunit --testsuite Feature --testdox
