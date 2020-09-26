.PHONY: up down install bash cacl

# Start server
up:
	docker-compose up -d

# Stop server
down:
	docker-compose down

# Install project
install:
	docker-compose build \
	&& docker-compose up -d \
	&& docker-compose exec php chown -R 1000:1000 ../symfony \
	&& docker-compose exec -u www-data php composer install \
	&& docker-compose exec -u www-data php bin/console assets:install \
	&& docker-compose run --rm node yarn install \
	&& docker-compose run --rm node yarn build

# Run bash in php container
bash:
	docker-compose exec -u www-data php bash

# Clear server cache
cacl:
	docker-compose exec -u www-data php php -d memory_limit=-1 bin/console ca:cl

# Run yarn in watch mode
yarn-watch:
	docker-compose run --rm node yarn dev --watch