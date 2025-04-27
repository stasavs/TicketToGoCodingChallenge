# TicketGo Coding Challenge - Setup Guide

Welcome! 🚀 This project is a Laravel-based API for managing blog posts, authors, and comments.

This guide will walk you through setting up the project, installing dependencies, seeding the database with test data, and running the application.

---
## Installation

1. **Clone the repository**:

```bash
git clone https://github.com/stasavs/TicketToGoCodingChallenge.git
cd TicketToGoCodingChallenge
```

2. **Install PHP dependencies**:

```bash
composer install
```

3. **Set up environment variables**:

```bash
cp .env.example .env 
```

or in Windows Command Prompt

```bash
copy .env.example .env
```

4.  **OPTIONAL - Edit your .env file and set your database credentials:**:


```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

5. **Generate the application key**:

```bash
php artisan key:generate
```

6. **Run database migrations**:

```bash
php artisan migrate
```

7. **Seed the database with test data**:

```bash
php artisan db:seed
```
---
## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at:
http://127.0.0.1:8000 
---
## Running Tests

This project uses [PEST Testing Framework](https://pestphp.com) for testing.

To execute the full test suite, simply run:

```bash
php artisan test
```

This will automatically:

- Use an in-memory SQLite database (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`)
- Migrate tables
- Refresh the database before each test
- Run tests

