##################
# DOCKER_COMPOSE #
##################

.PHONY: build-dev	
build-dev:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build

.PHONY: up-dev
up-dev:
	docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build -d

.PHONY: stop-dev
stop-dev:
	docker compose stop

.PHONY: build-prod
build-prod:
	docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build

.PHONY: up-prod
up-prod:
	docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d

.PHONY: stop-prod
stop-prod:
	docker compose stop

#################
# DATA FIXTURES #
#################

.PHONY: data-dev
data-dev:
	yes | php bin/console doctrine:database:drop --force && \
	php bin/console doctrine:database:create && \
	cd migrations && rm -rf *.php && cd .. && \
	php bin/console doctrine:migrations:diff && \
	yes | php bin/console doctrine:migrations:migrate && \
	yes | php bin/console doctrine:fixtures:load

.PHONY: data-prod
data-prod:
	yes | php bin/console doctrine:database:drop --force && \
	php bin/console doctrine:database:create && \
	yes | php bin/console doctrine:migrations:migrate && \
	yes | php bin/console doctrine:fixtures:load --group=prod