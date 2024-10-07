docker-up:
	docker compose up -d

docker-down:
	docker compose down -v

ls:
	docker compose exec php /bin/bash

composer-install:
	docker compose exec php composer install --no-interaction

test-all:
	docker compose exec php php ./bin/phpunit --testdox

run-migrations:
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction

php-load-fixtures:
	docker compose exec php php bin/console doctrine:fixtures:load --no-interaction

php-schema-update-force:
	docker compose exec php php bin/console doctrine:schema:update --force

cache-clear:
	docker compose exec php php bin/console cache:clear

debug-router:
	docker compose exec php php bin/console debug:router

enter-php:
	docker compose exec -it php bash

database-create:
	docker compose exec php  php bin/console d:d:c --if-not-exists --no-interaction

schema-create:
	docker compose exec php  php bin/console d:s:c --no-interaction

database-test-create:
	docker compose exec php  php bin/console d:d:c -e test --if-not-exists --no-interaction