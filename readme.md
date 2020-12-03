## Installation

**Create volume for database**

```
docker volume create db
```

**Build and up docker containers (It may take up to 10 minutes)**

```
docker-compose up -d --build
```

**Install composer dependencies:**

```
docker-compose exec php composer install
```

**Set Aliases:**

```
source aliases.sh
```

use short commands:

```
artisan migrate
```

**BASH:**

```
docker-compose exec php bash
```

*Copy environment file*

```
cp .env.example .env
```

Generate `APP_KEY` - http://localhost:8080/key

And setup as follow:

```
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=root
DB_PASSWORD=secret
```

## HOST

http://localhost:8080

http://localhost:8080/api/documentation - Swagger API DOCS

## TESTS

run `phpunit` or `vendor/bin/phpunit`

## Database

If you want to connect to database from an external tool, use the following parameters:

```
HOST: localhost
PORT: 3131
DB: db
USER: root
PASSWORD: secret
```
