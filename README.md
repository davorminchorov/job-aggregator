# JobNexus

JobNexus is a modern job board platform built with Laravel, Livewire, and Filament Admin. It provides a clean and intuitive interface for browsing job positions across different categories.

## Features

- 🔍 Advanced job search with filters
- 🏷️ Category-based job browsing
- 🏢 Company profiles with logos
- 🌓 Dark mode support
- 📱 Responsive design
- 🔐 Admin panel for content management

## Tech Stack

- PHP 8.2+
- Laravel 10
- MySQL 8.0+
- Livewire 3
- Filament 3
- TailwindCSS 3
- Alpine.js 3

## Requirements

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18
- MySQL >= 8.0

## Installation

### Using Docker (Laravel Sail)

1. Clone the repository:
```bash
git clone https://github.com/yourusername/jobnexus.git
cd jobnexus
```

2. Install PHP dependencies:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Start Docker containers:
```bash
./vendor/bin/sail up -d
```

5. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

6. Run migrations and seeders:
```bash
./vendor/bin/sail artisan migrate --seed
```

7. Install and build frontend assets:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### Using Laravel Herd

1. Clone the repository:
```bash
git clone https://github.com/yourusername/jobnexus.git
cd jobnexus
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

6. Install and build frontend assets:
```bash
npm install
npm run build
```

## Database Structure

The application uses the following main models:

- `JobPosition`: Represents a job listing with title, description, requirements, benefits, etc.
- `Company`: Contains company information including name, description, website, and logo
- `Category`: Represents job categories for better organization
- `User`: Admin users for managing the platform

## Admin Panel

The admin panel is accessible at `/admin`. To access it, create a user with an email ending in `@jobnexus.tech`.

Features available in the admin panel:
- Manage job positions
- Manage companies
- Manage categories
- View and manage users

## Development

To start the development server:

```bash
# Using Sail
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev

# Using Herd
php artisan serve
npm run dev
```

## Testing

To run the test suite:

```bash
# Using Sail
./vendor/bin/sail artisan test

# Using Herd
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
