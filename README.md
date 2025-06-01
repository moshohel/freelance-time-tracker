# Freelance Time Tracker API

A RESTful API built with Laravel 12 for tracking time spent on freelance projects. Includes client and project management, time logging, and reporting.

## 📦 Features

-   🔐 User Authentication with Laravel Sanctum
-   👥 Client Management (CRUD)
-   📁 Project Management (CRUD, linked to clients)
-   ⏳ Time Logging (start, end, manual logs)
-   📊 Reports for total tracked time
-   🛡️ Secure API with auth middleware & validation
-   🧪 Feature Tests (PHPUnit)

# 🛠️ Installation Guide

### ⚙️ Requirements

-   PHP >= 8.2
-   Composer
-   MySQL
-   Laravel 12
-   Git

---

### 📥 Clone the Repository

Clone the repository

    git clone https://github.com/moshohel/freelance-time-tracker.git

Switch to the repo folder

    cd freelance-time-tracker

📦 Install Dependencies

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Edit your .env and update

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_user
    DB_PASSWORD=your_db_password

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

## Database seeding

Run the database seeder for test Data

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Author

-   [Mohammad Shohel](https://github.com/moshohel)
