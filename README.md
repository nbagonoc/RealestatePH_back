## RealestatePH

RESTful backend API for RealestatePH using Laravel

## How to run locally:

- Download dependencies:
```
composer install
cp .env.example .env
php artisan key:generate
setup database and AWS S3 configs in the .env file
php artisan migrate
php artisan jwt:secret
php artisan db:seed
```

- Serve by running:
```
php artisan serve
```

- Features:
    - Guest
        - Auth
            - Sign-up
        - Listings
            - view listing
        - Users
            - view agent
    - User
        - Auth
            - Sign-in
        - Listings
            - view listing
            - like/unline listing
            - view liked listing
        - Users
            - manage(view, update) profile
            - view agent
        - Reviews
            - manage(create, view, update, delete) review agents
    - Agent(realestate agent/broker)
        - Auth
            - Sign-in
        - Listings
            - manage(create, view, update, delete) listing
        - Users
            - manage(view, update) profile
            - view users(all)
        - Reviews
            - manage(create, view, update, delete) review users(all)
    

- Backlog:
    - MVP(Minimum viable product):
        - DONE!
    - Feat to be added in the future(if I have the time, that is...):
        - Manage(create available booking timeslots, book timeslot, cancel booking timeslot) viewing (none MVP)

- Todo:
    - Upload photos and include it here in MD file
    - Upload default photos(listing and profile) for the seeder file
