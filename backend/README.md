# Laravel Web Application for Brewery List

## Introduction
This Laravel web application allows users to log in using a predefined username and password, generate a token, and use this token to access an API that serves as a proxy to the OpenBreweryDB. The application provides a paginated list of breweries retrieved from the OpenBreweryDB API. The project includes Docker for containerization and basic testing to ensure code quality.

## Features
- User authentication with username and password
- Token generation after login
- Proxy API to interact with OpenBreweryDB
- Paginated list of breweries
- Docker support for easy setup and deployment
- Basic testing for functionality

## Prerequisites
- Docker and Docker Compose
- PHP 8.2 or higher
- Composer

## Installation

### Clone the Repository

```bash
git clone https://github.com/MoroAlberto/laravel_openbrewery
cd laravel_openbrewery
```

### Environment Setup
Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

### Install Dependencies
Install PHP dependencies using Composer:
```bash
composer install
```

### Generate Application Key
```bash
php artisan key:generate
```

### Set Up JWT Secret
Generate a JWT secret key:
```bash
php artisan jwt:secret
```

### Generate SSL Certificates (Optional)
If you need to generate certificates for secure connections, run:
```bash
php artisan jwt:generate-certs
```

### Database Setup
Ensure your database settings in the `.env` file are correct, then run the migrations:
```bash
php artisan migrate
```

### Seed the Database
Seed the database with the predefined user:
```bash
php artisan db:seed
```

### Docker Setup
Build and start the Docker containers:
```bash
docker-compose up -d
```

### Run the Application
If not using Docker, you can start the development server with:
```bash
php artisan serve
```

### Access the Application
Open your web browser and go to `http://localhost:8000` to access the application.

## Usage

### User Login
Log in using the predefined credentials:
- Username: `root`
- Password: `password`

### Retrieve Breweries
After logging in, a token will be generated. Use this token to access the API that fetches data from OpenBreweryDB and displays a paginated list of breweries.

## Testing
Run the tests to ensure the application is working as expected:
```bash
php artisan test
```
