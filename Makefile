docker.containers:
	# start docker containers
	docker-compose up -d --build --remove-orphans

shell:
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; bash"
setup:
	# start docker containers
	docker-compose up -d --build

	#copy env
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; cp .env.example .env"

	# install composer
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; composer install"

	# fix the permissions
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chown -R www-data:www-data ./vendor"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chown -R www-data:www-data ./storage"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chown -R :www-data storage"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chown -R :www-data bootstrap/cache"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chmod -R 775 storage"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chmod -R 775 bootstrap/cache"

	# migration
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; php artisan migrate"

	# clear the cache
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; php artisan cache:clear"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; chmod -R 775 storage"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; composer dump-autoload"
	docker exec -it php_coffe_shop bash -c "cd /var/www/html/website ; php artisan key:generate"