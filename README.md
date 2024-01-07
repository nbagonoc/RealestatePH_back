## Laravel10 JWT Auth

A simple Laravel10 RESTful Backend Auth using JWT's

## How to run locally:

- Download dependencies:
```
composer install
cp .env.example .env
php artisan key:generate
setup your database in the .env file
php artisan migrate
php artisan jwt:secret
php artisan db:seed
```

- Serve by running:
```
php artisan serve
```

- PS:
    - Default role is user when you register
    - Create DB seeder
    