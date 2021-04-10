#!/usr/bin/make

user_id := $(shell id -u)
docker_compose_bin := $(shell command -v docker-compose 2> /dev/null) --file "docker/docker-compose.yml"
php_container_bin := $(docker_compose_bin) run --rm -u "$(user_id)" "php"

.PHONY : help build install shell fixer test coverage entities
.DEFAULT_GOAL := build

# --- [ Development tasks ] -------------------------------------------------------------------------------------------

build: ## Build container and install composer libs
	$(docker_compose_bin) build --force-rm

install: ## Install all data
	$(php_container_bin) composer update

shell: ## Runs shell in container
	$(php_container_bin) bash

fixer: ## Run fixer to fix code style
	$(php_container_bin) composer run-script fixer

linter: ## Run linter to check project
	$(php_container_bin) composer run-script linter

test: ## Run tests
	$(php_container_bin) composer run-script test

coverage: ## Run tests with coverage
	$(php_container_bin) composer run-script coverage

entities: ## Build entities from yaml file with description
	$(php_container_bin) composer run-script entities
