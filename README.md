Project is created in laravel and contenerization is achived by sail
https://laravel.com/docs/11.x/sail

To run this project you have to have docker and make installed:
https://docs.docker.com/get-docker/ <br />
`sudo apt-get update` <br />
`sudo apt-get -y install make` <br />

To build this project you firstly have to run command that will install all composer dependencies:<br />
    `make dependencies`

then:<br />
    `make build`<br />
    `make up`<br />

You can also used commands assigned to make commands in Makefile.

dependencies: <br />
`    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs`

build:<br />
	`./vendor/bin/sail build`

up: <br />
	`./vendor/bin/sail up -d`

down: <br />
	`./vendor/bin/sail down`

migrate: <br />
	`./vendor/bin/sail artisan migrate`