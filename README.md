## Prerequisites

- Laravel
- MySQL
- JWT Authentication
- PHP ^8.2
 
## Installation

```
https://github.com/Nobeul/apexdmit-api.git
cd your-repo-name
composer install
cp .env.example .env
```
Update the .env file with your database credentials and JWT secret key:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**Make sure your cache store is set to database like below**
```
CACHE_STORE=database
```

Generate application and JWT keys:
```
php artisan key:generate
php artisan jwt:secret
```
**Make sure your JWT_SECRET is set**
```
JWT_SECRET=your_jwt_secret
```
Run database migrations and seeders:
```
php artisan migrate --seed
```

Start the application:
```
php artisan serve
```
If you ran seeder, you will have an admin user with following credentials:
```
email: admin@gmail.com
password": 123456
```
__Registered users will be considered as regular user.__

Postman collection is in the root directory named as __ApexDmit.postman_collection.json__ You can download and import it on postman to test the endpoints.

Good Day :)


