# Resumist

A SaaS platform built with **Laravel 12**, **Tailwind CSS 4**, and **Vite**. Resumist provides resume-building tools with subscription plans, credit packs, an admin panel, and a RESTful API for the frontend client.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Manual Setup](#manual-setup)
- [Running the App](#running-the-app)
- [Default Accounts](#default-accounts)
- [Project Structure](#project-structure)
- [Running Tests](#running-tests)
- [Environment Variables](#environment-variables)
- [Useful Commands](#useful-commands)
- [License](#license)

---

## Prerequisites

Make sure the following are installed on your machine:

| Tool | Version | Check |
|------|---------|-------|
| PHP | ≥ 8.2 | `php -v` |
| Composer | latest | `composer -V` |
| Node.js | ≥ 18 | `node -v` |
| npm | ≥ 9 | `npm -v` |
| MySQL | ≥ 8.0 | `mysql --version` |

> **Note:** The project uses MySQL by default. You can swap to PostgreSQL or SQLite by updating the `DB_*` variables in your `.env` file.

---

## Quick Start

If you just want to get up and running fast, run the built-in setup script:

```bash
# 1. Clone the repository
git clone https://github.com/tah33/resumist.git
cd resumist

# 2. Run the all-in-one setup (installs deps, generates key, runs migrations, builds assets)
composer setup

# 3. Seed the database with demo data
php artisan db:seed

# 4. Create a storage symlink
php artisan storage:link

# 5. Start the development server
composer run dev
```

The app will be available at **http://localhost:8000**.

---

## Manual Setup

If you prefer to go step-by-step:

### 1. Clone the repository

```bash
git clone https://github.com/tah33/resumist.git
cd resumist
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure the environment

```bash
cp .env.example .env
```

Open `.env` and update the database credentials:

```bash
# Update .env with your credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resumist
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Create the database

Create a MySQL database matching the `DB_DATABASE` value in your `.env`:

```bash
# Create the database manually if not using the setup script
mysql -u root -p -e "CREATE DATABASE resumist;"
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Seed the database

```bash
php artisan db:seed
```

This seeds: roles, plans, settings, languages, currencies, payment methods, demo users, staff accounts, pages, tickets, and activity logs.

### 9. Create a storage symlink

```bash
php artisan storage:link
```

### 10. Build frontend assets

```bash
npm run build
```

---

## Running the App

### Development (recommended)

Start the Laravel server, queue worker, and Vite dev server all at once:

```bash
composer run dev
```

This runs concurrently:
- **Laravel server** → `http://localhost:8000`
- **Queue worker** → listens for background jobs
- **Vite dev server** → handles CSS/JS hot-reloading

### Production build

```bash
npm run build
php artisan serve
```

---

## Default Accounts

After running `db:seed`, the following demo accounts are available:

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@resumist.test` | `password` |
| Staff | `staff@resumist.test` | `password` |
| Editor | `editor@resumist.test` | `password` |
| Recruiter | `recruiter@resumist.test` | `password` |
| Candidate | `candidate@resumist.test` | `password` |

> **⚠️ Important:** Change these credentials before deploying to production.

---

## Project Structure

```
resumist/
├── app/
│   ├── Http/            # Controllers, Middleware, Requests
│   ├── Models/           # Eloquent models (User, Plan, Ticket, etc.)
│   ├── Providers/        # Service providers
│   ├── QueryFilters/     # Reusable query filter classes
│   ├── Repositories/     # Data-access repositories
│   ├── Services/         # Business logic services
│   └── helpers.php       # Global helper functions
├── config/               # Application configuration files
├── database/
│   ├── factories/        # Model factories for testing
│   ├── migrations/       # Database schema migrations
│   └── seeders/          # Database seed classes
├── lang/                 # Localization files
├── public/               # Public assets (entry point)
├── resources/
│   ├── css/              # Stylesheets (Tailwind CSS)
│   ├── js/               # JavaScript source files
│   └── views/            # Blade templates
├── routes/
│   ├── web.php           # Web routes (admin panel)
│   ├── admin.php         # Admin-specific routes
│   ├── api.php           # REST API routes (v1)
│   └── auth.php          # Authentication routes
├── storage/              # Logs, cache, uploaded files
├── tests/                # Unit & feature tests
├── .env.example          # Environment template
├── composer.json         # PHP dependencies
├── package.json          # Node dependencies
└── vite.config.js        # Vite + Tailwind configuration
```

---

## Running Tests

Tests use an in-memory SQLite database (configured in `phpunit.xml`):

```bash
# Run the full test suite
php artisan test

# Or via Pest directly
./vendor/bin/pest

# Run with coverage
./vendor/bin/pest --coverage
```

---

## Environment Variables

Key variables you may want to configure in `.env`:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | `Laravel` |
| `APP_URL` | Base URL for the backend | `http://localhost` |
| `FRONTEND_URL` | URL of the frontend client | `https://www.resumist.io/` |
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_DATABASE` | Database name | `example_app` |
| `QUEUE_CONNECTION` | Queue driver | `database` |
| `MAIL_MAILER` | Mail driver | `log` |
| `GOOGLE_CLIENT_ID` | Google OAuth client ID | *(empty)* |
| `LINKEDIN_CLIENT_ID` | LinkedIn OAuth client ID | *(empty)* |
| `AWS_ACCESS_KEY_ID` | AWS key for S3 storage | *(empty)* |
| `AWS_SECRET_ACCESS_KEY` | AWS secret for S3 storage | *(empty)* |
| `AWS_BUCKET` | S3 bucket name | *(empty)* |

---

## Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Re-run all migrations (⚠️ destroys data)
php artisan migrate:fresh --seed

# Create a storage symlink
php artisan storage:link

# List all routes
php artisan route:list

# Run the queue worker
php artisan queue:listen

# Format code with Laravel Pint
./vendor/bin/pint
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
