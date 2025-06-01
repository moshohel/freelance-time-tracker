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

🔐 Authentication
Register: POST /api/register

Login: POST /api/login

Logout: POST /api/logout (with bearer token)

Use the bearer token from login for all protected routes:

    Authorization: Bearer YOUR_TOKEN

📚 API Endpoints Overview

Clients
| Method | Endpoint | Description |
| ------ | ----------------- | -------------------- |
| GET | /api/clients | List all clients |
| POST | /api/clients | Create new client |
| GET | /api/clients/{id} | View a single client |
| PUT | /api/clients/{id} | Update client |
| DELETE | /api/clients/{id} | Delete client |

Projects
| Method | Endpoint | Description |
| ------ | ------------------ | --------------------- |
| GET | /api/projects | List all projects |
| POST | /api/projects | Create a new project |
| GET | /api/projects/{id} | View a single project |
| PUT | /api/projects/{id} | Update project |
| DELETE | /api/projects/{id} | Delete project |

Time Logs

| Method | Endpoint                 | Description                  |
| ------ | ------------------------ | ---------------------------- |
| GET    | /api/time-logs           | List logs (optional filters) |
| GET    | /api/time-logs/{id}      | View a single time log       |
| POST   | /api/time-logs           | Create manual time log       |
| PUT    | /api/time-logs/{id}      | Update a time log            |
| POST   | /api/time-logs/start     | Start a time log             |
| POST   | //api/time-logs/{id}/end | End current active log       |
| DELETE | /api/time-logs/{id}      | Delete a time log            |

📊 Reports

| Method | Endpoint    | Description                         |
| ------ | ----------- | ----------------------------------- |
| GET    | /api/report | Get total time summary with filters |

| Parameter    | Type   | Description                       |
| ------------ | ------ | --------------------------------- |
| `from`       | `date` | Start date (format: `YYYY-MM-DD`) |
| `to`         | `date` | End date (format: `YYYY-MM-DD`)   |
| `project_id` | `int`  | Filter by specific project        |
| `client_id`  | `int`  | Filter by specific client         |

Example:

    GET /api/report?from=2020-05-20&to=2026-05-24&project_id=6&client_id=6

## Author

-   Mohammad Shohel
    https://github.com/moshohel
    mohammadshohel866@gmail.com
