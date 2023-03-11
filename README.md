
# Requirements
    1. PHP >= 8.0
    2. Composer
    3. MySQL 8
    4. Apache2
    5. Git

# Task Directive:
    Develop a complete server/client example showcasing the use of RESTful APIs.

# Download project 
    1. open your terminal
    2. cd /var/www/html (or your default apache2 public directory)
    3. git clone https://github.com/amrfoley/ryalize.git
    4. cd ryalize
    5. cp .env.example .env
    6. import database/ryalize.sql to your DB.
    7. run "composer install"
    8. run "php database/seeder.php"
    9. open "http://localhost/ryalize/transactions" in your browser

# APIs
    GET /api/v1/users >> fetch all users
    POST /api/v1/users >> store new user
    GET /api/v1/users/{id} >> fetch user by id
    PATCH /api/v1/users/{id} >> update user data
    DELETE /api/v1/users/{id} >> delete user by id

    GET /api/v1/transaction >> fetch paginated transactions ordered by date desc
        PARAMS: location_id, ?year, ?month, ?day