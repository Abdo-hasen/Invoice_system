# Laravel Invoice Management System

A web-based invoice management system built with Laravel, designed for managing invoices and related business operations.

# demo : 
https://drive.google.com/drive/folders/1nyYVZQtXSNO6OpMcJYT5TefVMdowKWnX?usp=sharing

## Features

- Invoice creation and management
- PDF invoice generation and export
- Excel export functionality 
- User role-based permissions using Spatie
- Email notifications
- Chart visualization using ChartJS
- Real-time event broadcasting
- Secure authentication and authorization

## Requirements

- PHP ^8.1
- Laravel ^10.8
- Composer
- Node.js & NPM

## Installation

1. Clone the repository:
```sh
git clone <repository-url>
cd invoices
```

2. Install PHP dependencies:
```sh
composer install
```

3. Install NPM packages:
```sh
npm install
```

4. Configure environment variables:
```sh
cp .env.example .env
```

5. Generate application key:
```sh
php artisan key:generate
```

6. Set up your database credentials in `.env` file

7. Run database migrations:
```sh
php artisan migrate
```

8. Start the development server:
```sh
php artisan serve
```

## Dependencies

### PHP Packages
- [Laravel Framework ^10.8](https://laravel.com)
- [Laravel Sanctum ^3.2](https://laravel.com/docs/sanctum)
- [Laravel Permission ^5.10](https://spatie.be/docs/laravel-permission)
- [Laravel Excel 3.1.48](https://laravel-excel.com)
- [Laravel ChartJS ^3.0](https://github.com/fx3costa/laravelchartjs)
- [Sweet Alert ^7.0](https://realrashid.github.io/sweet-alert)

### Frontend Assets
- AdminLTE Template
- jQuery UI
- Select2
- ChartJS
- PDF Make

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Security

If you discover any security vulnerabilities, please email [taylor@laravel.com](mailto:taylor@laravel.com).
