# Laravel Application Setup

Welcome! This guide will help you clone this repository and get your Laravel application up and running.

## Prerequisites

Before you begin, make sure you have the following installed:

- [PHP](https://www.php.net/) (version 8.1 or higher)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [Node.js & npm](https://nodejs.org/) (for frontend assets, if needed)
- A database (e.g., MySQL, PostgreSQL)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
```

### 2. Install Dependencies

```bash
composer install
```

If your project uses frontend assets:

```bash
npm install
```

### 3. Environment Setup

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file to set your database and other environment variables.

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. (Optional) Seed the Database

```bash
php artisan db:seed
```

### 6. Serve the Application

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Email Verification Setup

To enable email verification, you need to modify the `vendor/laravel/framework/src/Illuminate/Auth/Notifications/VerifyEmail.php` file.  
Inside the `buildMailMessage` method, add the following lines before email verification can work:

```php
$app = env('FRONTEND_URL', 'https://owenahub.com');
$frontendUrl = "$app/verify-email?url=" . urlencode($url);
```

This ensures the verification link points to your frontend application.

## Additional Commands

- Compile frontend assets: `npm run dev`
- Run tests: `php artisan test`

## Troubleshooting

If you encounter issues, check:

- PHP version compatibility
- Database connection settings in `.env`
- Permissions for storage and bootstrap/cache directories

## Contributing

Pull requests are welcome! Please open an issue first to discuss changes.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
