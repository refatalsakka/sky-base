APACHE_CONTAINER=apache

.PHONY: build-dev	
build-dev:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build -d

.PHONY: build-prod
build-prod:
	docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d

.PHONY: stop
stop:
	docker compose stop

.PHONY: start
start:
	docker compose start

.PHONY: bash
bash:
	docker compose exec -it $(APACHE_CONTAINER) bash

.PHONY: logs
logs:
	docker compose logs -f $(APACHE_CONTAINER)

.PHONY: clear-cache
clear-cache:
	docker compose exec $(APACHE_CONTAINER) php bin/console cache:clear && \
	docker compose exec $(APACHE_CONTAINER) php bin/console cache:warmup

.PHONY: create-db
create-db:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:database:create

.PHONY: drop-db
drop-db:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:database:drop --force

.PHONY: rm-migrations
rm-migrations:
	docker compose exec $(APACHE_CONTAINER) sh -c "cd migrations && rm -rf *.php"

.PHONY: diff
diff:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:migrations:diff

.PHONY: migrate
migrate:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:migrations:migrate

.PHONY: load-fixtures-prod
load-fixtures-prod:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:fixtures:load --group=prod

.PHONY: load-fixtures-dev
load-fixtures-dev:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:fixtures:load --group=dev

.PHONY: reset-dev
reset-dev:
	make rm-migrations
	make drop-db || true
	make create-db
	make diff
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:fixtures:load --group=dev --no-interaction
