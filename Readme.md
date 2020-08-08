# Docker + PHP 7.4 + Nginx + Symfony 5 Joke App

## Description

This is a complete stack for running Symfony 5 into Docker containers using docker-compose tool.

It is composed by 3 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 7.4 PHPversion.
- `node`, the node container which holds the React Application to consume the API. (Not complete, example only)

## Installation

1. Clone this repo.

2. Run `docker-compose up -d`

3. Install Symfony composer dependencies
```
docker exec -it  joke-app_php_1 bash 
composer install
```

4. Migrate database
```
php bin/console doctrine:migrations:migrate
```

API will be at http://localhost/
React UI will be http://localhost:3000/

## References
Used https://medium.com/@ger86/how-to-integrate-docker-into-a-symfony-based-project-f06164dc7944 for direction in setting up docker container.

