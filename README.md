# News Aggregator Laravel Application


This is a backend service for aggregating news articles from multiple sources. The service supports filtering articles based on criteria such as title, author, category, date, and source. It also simulates user preferences for personalized results.

## Features
- Fetch articles from external news sources using strategies.
- Store articles in the database.
- Filter articles by title, author, category, date, and source.
- Simulate user preferences for personalized filtering.
- Supports pagination for article listings.
- Includes unit and feature tests for core functionalities.
- Dockerized environment with Laravel Sail.
- Clean and maintainable code following SOLID principles.


## Technology Stack
- PHP 8.2 (via Laravel Sail Docker containers)
- Laravel 11
- Mysql
- PHPUnit (for testing)


## Installation and Setup
### Prerequisites
Before starting, make sure you have the following installed on your machine:

- Docker (Required for Laravel Sail)
- Composer (For initial setup)

### 1- Clone the repository:

    git clone https://github.com/keyvanlotfi/news-aggregator.git
    cd news-aggregator

### 2- Install dependencies:

    composer install

### 3- Start Laravel Sail

Laravel Sail provides a Docker-powered environment for development. First, make sure Sail is installed:

    php artisan sail:install

Then, start the Docker containers:

    ./vendor/bin/sail up -d

### 4- Environment Setup

Copy the example .env file and generate the application key:

    cp .env.example .env
    ./vendor/bin/sail artisan key:generate

### 5- Run Migrations
To set up the database, run the migrations and seed the initial data:

    ./vendor/bin/sail artisan migrate --seed

### 6- Queue setup
Ensure Redis is installed and running, then start the queue worker:

    ./vendor/bin/sail artisan queue:work

### -7 Schedule command to fetch articles
To ensure that the scheduled tasks (such as fetching new articles) run automatically, you need to set up a cron job on your server. This will execute the Laravel scheduler every minute.

Add the following line to your server's crontab:

    * * * * * docker exec news-aggregator-laravel-app php /var/www/html/artisan schedule:run >> /dev/null 2>&1
#### Explanation:
- docker exec — Executes a command inside the running Docker container.
- news-aggregator-laravel-app — This is the name of the Laravel container. Adjust it to match your actual container name.
- php /var/www/html/artisan schedule:run — Runs the Laravel scheduler to execute any scheduled tasks.
- ">> /dev/null 2>&1 — Redirects output and errors to /dev/null to prevent log files from growing too large."

#### note
- Ensure that your Docker container is always running for the cron job to work.
- You can check the container name using the following command:


    docker ps



## Running Tests
To run all tests:

    ./vendor/bin/sail artisan test

The project contains unit tests for services and repositories, as well as feature tests for the API controller.

## API Endpoints
Retrieve a list of articles with optional filtering.
- title
- author
- source
- category
- date


    GET /api/v1/articles?title=Laravel&author=John

## Example Response:

    {
        "success": true,
        "data": [
            {
                "id": 1,
                "title": "Laravel Article",
                "description": "Introduction to Laravel...",
                "url": "http://example.com/article",
                "author": "John",
                "source": "Tech News",
                "category": "Education",
                "created_at": "2025-02-10 12:00:00",
                "updated_at": "2025-02-10 12:00:00"
            }
        ],
        "pagination": {
            "total": 10,
            "per_page": 8,
            "current_page": 1,
            "last_page": 2
        }
    }

show a single article using id:

    GET /api/v1/articles/{id}

## License
This project is licensed under the MIT License.
