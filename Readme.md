# Docker + PHP 7.4 + Nginx + Symfony 5 Joke App

## Description

This is a complete stack for running Symfony 5 into Docker containers using docker-compose tool.

It is composed by 3 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 7.4 PHPversion.

## Installation

1. Clone this repo.

2. Run `docker-compose up -d`

3. The 2 containers are deployed: 

```
Creating symfony-docker_php_1   ... done
Creating symfony-docker_nginx_1 ... done
```

4. Install Symfony composer dependencies
```
docker exec -it  joke-app_php_1 bash 
composer install
```

## References
Used https://medium.com/@ger86/how-to-integrate-docker-into-a-symfony-based-project-f06164dc7944 for direction in setting up docker container.

