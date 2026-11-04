## Running the Application

1-run terminal
2-run composer install
3-copy .env.example .env
4-php artisan key:generate

5-Open the `.env` file and set your local database credentials:

env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_password

6- Run Database Migrations & Seeders
Execute migrations to set up the database schema along with sample user data:
php artisan migrate --seed

7- Run bash : php artisan ser then
Access the application in your browser at: `http://127.0.0.1:8000`
