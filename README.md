# Job Aggregator

A modern job board application built with Laravel, Livewire, and Filament, featuring job positions, categories, and applications management.

## Features

- 🔍 Job search and filtering
- 📑 Job categories management
- 💼 Company profiles
- 📝 Job applications tracking
- 🎨 Modern UI with Tailwind CSS
- 🔐 User authentication and authorization
- 🛠 Admin panel powered by Filament

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

## Setup Instructions

### Using Docker (Laravel Sail)

1. Clone the repository:
```bash
git clone https://github.com/yourusername/job-aggregator.git
cd job-aggregator
```

2. Install PHP dependencies using a temporary container:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Start the Docker containers:
```bash
./vendor/bin/sail up -d
```

5. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

6. Run migrations and seeders:
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

7. Install and build frontend assets:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

The application will be available at `http://localhost`.

### Using Laravel Herd

1. Clone the repository:
```bash
git clone https://github.com/yourusername/job-aggregator.git
cd job-aggregator
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Configure your `.env` file with your Herd database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_aggregator
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seeders:
```bash
php artisan migrate:fresh --seed
```

7. Install and build frontend assets:
```bash
npm install
npm run build
```

The application will be available at `http://job-aggregator.test` (assuming you've configured the domain in Herd).

## Database Structure

The application uses the following main models:
- `User` - Manages user accounts
- `JobPosition` - Stores job listings
- `Category` - Organizes job positions
- `Company` - Manages company information
- `JobApplication` - Tracks job applications

## Admin Panel

Access the admin panel at `/admin` with the following credentials:
- Email: admin@example.com
- Password: password

## Testing

Run the test suite:

```bash
# Using Docker
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

This project is open-sourced software licensed under the [MIT license](LICENSE.md).
