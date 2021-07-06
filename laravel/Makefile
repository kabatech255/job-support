GROUP = auth
test:
	php artisan migrate:reset --env=testing
	php artisan migrate --seed --env=testing
	vendor/bin/phpunit --testsuite Feature --testdox --group=${GROUP}
