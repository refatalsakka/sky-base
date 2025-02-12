##################
# DOCKER_COMPOSE #
##################

APACHE_CONTAINER=apache

.PHONY: build-dev	
build-dev:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build -d

.PHONY: stop-dev
stop-dev:
	docker compose stop

.PHONY: build-prod
build-prod:
	docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build

.PHONY: stop-prod
stop-prod:
	docker compose stop

.PHONY: clear-cache
clear-cache:
	docker compose exec $(APACHE_CONTAINER) php bin/console cache:clear

#################
# DATA FIXTURES #
#################

.PHONY: data-dev
data-dev:
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:database:drop --force && \
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:database:create && \
	docker compose exec $(APACHE_CONTAINER) sh -c "cd migrations && rm -rf *.php && cd .." && \
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:migrations:diff && \
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction && \
	docker compose exec $(APACHE_CONTAINER) php bin/console doctrine:fixtures:load --no-interaction
