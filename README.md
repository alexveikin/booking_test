## How to install

Install dependencies:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Create `.env` file from `.env.example` file:
```shell
cp .env.example .env
```

Set desired docker environment in `.env` file:
```dotenv
# DOCKER
APP_PORT=8080
FORWARD_DB_PORT=33061
```

Run docker infrastructure:
```shell
./vendor/bin/sail up -d
```

Run next command to install dependencies:
```shell
./vendor/bin/sail composer install
```

Run next command to generate APP_KEY in .env file. You should do it only once.
```shell
./vendor/bin/sail artisan key:generate
```

Build front-end:
```shell
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

To run database migrations and set up the data use:
```shell
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# or use 
./vendor/bin/sail artisan migrate --seed
```

To refresh database with the data use:
```shell
./vendor/bin/sail artisan migrate:refresh --seed
```

Follow the link [localhost:8080](http://localhost:8080/)
