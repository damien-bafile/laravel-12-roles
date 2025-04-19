# Project Setup Guide

This guide will help you set up the project locally and serve the site.

## Prerequisites

Ensure you have the following installed on your system:

- **PHP** (version 8.1 or higher)
- **Composer** (latest version)
- **Node.js** (LTS version) and **npm**
- **MySQL** or any other database supported by Laravel
- **Git**

## Steps to Set Up Locally

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <repository-folder>
```

### 2. Install PHP Dependencies

Run the following command to install the required PHP dependencies:

```bash
composer install
```

### 3. Install JavaScript Dependencies

Run the following command to install the required JavaScript dependencies:

```bash
npm install
```

### 4. Set Up Environment Variables

1. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

2. Update the `.env` file with your local database credentials and other necessary configurations.

### 5. Generate Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 6. Run Database Migrations and Seeders

Run the following commands to set up the database schema and seed initial data:

```bash
php artisan migrate --seed
```

### 7. Build Frontend Assets

Compile the frontend assets using the following command:

```bash
npm run dev
```

### 8. Serve the Application

Run the following command to start the local development server:

```bash
php artisan serve
```

The application will be accessible at `http://localhost:8000`.

## Additional Notes

- To run tests, use the following command:

  ```bash
  php artisan test
  ```

- If you encounter permission issues, ensure the `storage` and `bootstrap/cache` directories are writable:

  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

- For advanced configurations, refer to the [Laravel Documentation](https://laravel.com/docs).

---

You are now ready to use the application locally!
