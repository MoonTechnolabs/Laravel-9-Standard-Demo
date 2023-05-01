# Laravel-Code-Standard-Demo

This repository maintain standard structure and code best practices for Laravel.
It is always good to follow standard format to maintain quality code while developing webapp/apis.

## About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

<ul dir="auto">
<li><a href="https://laravel.com/docs/routing" rel="nofollow">Simple, fast routing engine</a>.</li>
<li><a href="https://laravel.com/docs/container" rel="nofollow">Powerful dependency injection container</a>.</li>
<li>Multiple back-ends for <a href="https://laravel.com/docs/session" rel="nofollow">session</a> and <a href="https://laravel.com/docs/cache" rel="nofollow">cache</a> storage.</li>
<li>Expressive, intuitive <a href="https://laravel.com/docs/eloquent" rel="nofollow">database ORM</a>.</li>
<li>Database agnostic <a href="https://laravel.com/docs/migrations" rel="nofollow">schema migrations</a>.</li>
<li><a href="https://laravel.com/docs/queues" rel="nofollow">Robust background job processing</a>.</li>
<li><a href="https://laravel.com/docs/broadcasting" rel="nofollow">Real-time event broadcasting</a>.</li>
</ul>


# Getting started
Please check the following steps for installation process.

## Installation
Clone the repository

    git clone https://github.com/MoonTechnolabs/Laravel-9-Standard-Demo.git

Switch to the repo folder

cd laravel-realworld-example-app
    
    Install all the dependencies using composer

composer install

    Copy the example env file and make the required configuration changes in the .env file

cp .env.example to  .env
In the .env for database connection set the following credentials

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    
Generate a new application key

    php artisan key:generate    
    
Run the database migrations

    php artisan migrate
    
Start the local development server
    
    php artisan serve
    
In the .env file set your project name using the below variable.

    APP_NAME=Laravel
    
In the .env file set app URL as epr your server
    
    APP_URL=http://localhost
    
For Request Logs we have added a telescope. Please make sure you can remove this in the production server OR make security for this URL.

    BASEURL/telescope
    
For development and error checking we have added log-viewer packages of Laravel. you can access this by the following URL.

    BASEURL/log-viewer

    
## Database seeding 

For Sample admin login we have added database seeder. Run the database seeder and you're done
    
        php artisan db:seed 
        
## API Specification
We have added sample apis. you can access this using postman api collection

    https://api.postman.com/collections/19849475-3118818f-fb8a-4e6d-bcf5-da04276967e7?access_key=PMAT-01GYYJGBC8R00NSD0BNHEYBJB9

For Swagger you can use the following URL. You have to change here your base URL 
 
    BASEURL/api/documentation
    
## Dependencies
We have used laravel passport for the REST APIs authentication.

You have to run below command for passport installation
    
        php artisan passport:install
        
# Code overview

## Folders Structure

- `app` - Contains all the models, controllers
- `app\Http\Controllers\Api` - Contains all the controllers related to apis
- `app\Http\Controllers\Admin` - Contains all the controllers related to admin panel.
- `app\Http\Middleware` - Contains the authentication middleware
- `app\Http\Requests` - Contains the files related to the add/edit form validations
- `app\Http\Services` - Contains the services. In this we have defined each functionality services.
- `app\Models` - Contains the all the modes files.
- `resources` - Contains the all the balde(view) files and email template fiels
- `config` - Contains all the application configuration files like database.
- `database\migrations` - Contains the database migrations
- `database\seeds` - Contains the database seeder files
- `routes` - It contains the apis and admin related routes file.

## Note:

In this example we are connecting to database when server runs.
In this we have covered laravel most usable standard features
1. Passport
2. Queue / Job  (Just we have set code but for server need to install superviser)
3. Middleware
4. Service Base functionality
5. Exception Handling using try catch
6. Accessor and Mutator
7. Role Permission Management


