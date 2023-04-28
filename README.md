1. git clone GITURL
2. got to your project root directory and run below 2 commands 

composer install
php artisan key:generate

3. copy .env.example file and make it .env
3. in the .env for database connection set following credentials

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

4. For email SMTP setting change the following credentials in .env file  (based on your SMTP server)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

5. In the .env file set you project name using below variable.
APP_NAME=Laravel


6. In the .env file set app URL as epr your server
APP_URL=http://localhost

7. Once Database connection are done you have to run below command for migration generate and seeder add.
php artisan migrate
php artisan db:seed 

8. For Swagger you can use following url. You have to change here your base URL
BASEURL/api/documentation


9. For Request Logs we have added telescope. Please make sure you can remove this in prod server OR make security for this URL.
BASEURL/telescope

10. For development and error checking we have added log-viewer packages of laravel. you can access this by following url.
BASEURL/log-viewer


11. Credentials For Super Admin Login
laraveladmin@yopmail.com
Moon@123$$!!

12. Postman Collection: https://api.postman.com/collections/19849475-3118818f-fb8a-4e6d-bcf5-da04276967e7?access_key=PMAT-01GYYJGBC8R00NSD0BNHEYBJB9
