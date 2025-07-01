SafeSpace Laravel Project

This project uses Laravel Breeze for authentication. Breeze is already installed, so you do not need to install or run it separately.

Use XAMPP PHPMyAdmin for the database.

Create a new database named "safespace" or import the provided "safespace.sql" file into your XAMPP PHPMyAdmin.

Open the Laravel project folder in your terminal or command prompt.

Run the command:
php artisan migrate

To access the admin login page, add "/login" to your project URL. For example:
http://127.0.0.0.0/login

Use the following admin credentials to log in:
Email: admin@example.com
Password: 12345678

To create a new admin account, add "/register" to your project URL. For example:
http://127.0.0.0.0/loginregister

After registering a new user, open your database in XAMPP PHPMyAdmin.

Go to the "users" table and find the new user record.

Manually change the "role" field of that user from "user" to "admin" to give admin access.

