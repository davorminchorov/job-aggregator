# JobNexus.tech

JobNexus.tech is a modern job board platform built with Laravel, Livewire, and Filament Admin. It provides a clean and intuitive interface for browsing job positions across different categories and companies.

## Features

### For Job Seekers
- 🔍 Advanced job search with filters for title, location, and salary
- 🏷️ Category-based job browsing with sorting options
- 🏢 Detailed company profiles with information about size, industry, and open positions
- 📱 Mobile-friendly responsive design
- 🌓 Dark mode support for comfortable viewing
- 💼 Easy application process (coming soon)

### For Companies
- ✨ Beautiful company profiles with logos and detailed information
- 📊 Track job posting performance
- 📝 Easy job posting management
- 🎯 Targeted candidate reach
- 🔄 Automated job imports from various sources

### For Administrators
- 🔐 Secure admin panel powered by Filament
- 📊 Dashboard with key metrics
- 👥 User management with roles and permissions
- 🏷️ Category and tag management
- 🔍 Advanced filtering and search capabilities
- 🔄 Job source management and synchronization

## Tech Stack

- **Backend**
  - PHP 8.4+
  - Laravel 11
  - MySQL 8.0+
  - Redis 7.0+

- **Frontend**
  - Livewire 3 for dynamic interfaces
  - TailwindCSS 3 for styling
  - Alpine.js 3 for JavaScript interactions
  - Heroicons for beautiful icons

- **Admin Panel**
  - Filament 3
  - Spatie Permissions for access control

## Requirements

- PHP >= 8.4
- Composer >= 2.0
- Node.js >= 18
- MySQL >= 8.0
- Redis >= 7.0

## Installation

### Using Docker (Laravel Sail)

1. Clone the repository:
```bash
git clone https://github.com/davorminchorov/jobnexus.git
cd jobnexus
```

2. Install PHP dependencies:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Configure environment variables:
```bash
# Update these variables in your .env file
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=jobnexus
DB_USERNAME=sail
DB_PASSWORD=password

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

5. Start Docker containers:
```bash
./vendor/bin/sail up -d
```

6. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

7. Run migrations and seeders:
```bash
./vendor/bin/sail artisan migrate --seed
```

8. Install and build frontend assets:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### Using Laravel Herd

1. Clone the repository:
```bash
git clone https://github.com/davorminchorov/jobnexus.git
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

4. Configure environment variables:
```bash
# Update these variables in your .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobnexus
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Install and build frontend assets:
```bash
npm install
npm run build
```

## Development

### Development Data

For local development, you can use the development seeder to populate your database with test data:

```bash
# Using Sail
./vendor/bin/sail artisan app:seed-dev

# Using Herd
php artisan app:seed-dev
```

This will create:
- Admin user (admin@example.com / password)
- 10 regular users
- 20 companies with 3-8 job positions each
- Random filled/unfilled positions

### Job Sources

JobNexus supports importing job positions from various sources:

#### Supported Sources
- **Airtable**: Import jobs from Airtable bases
  - Required fields: API Key, Base ID, Table ID
- **Telegram**: Import jobs from Telegram channels/groups
  - Required fields: Bot Token, Chat ID

#### Managing Sources
1. Configure source types in the admin panel
2. Add source credentials
3. Run sync manually or wait for scheduled sync

To manually sync job sources:
```bash
# Using Sail
./vendor/bin/sail artisan app:sync-job-positions

# Using Herd
php artisan app:sync-job-positions
```

### Starting Development Server

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

## Project Structure

### Models
- `JobPosition`: Job listings with details like title, description, salary, and requirements
- `Company`: Company profiles with information like name, description, size, and industry
- `Category`: Job categories for better organization
- `User`: User accounts with role-based permissions
- `JobPositionSource`: Configuration for job import sources
- `JobPositionSourceType`: Supported job source types and their required fields

### Key Components
- **Livewire Components**
  - `JobPositions`: Handles job listing display and filtering
  - `Companies`: Manages company listing and search
  - `Categories`: Displays job categories
  - `JobPositionDetails`: Shows detailed job information
  - `CompanyDetails`: Displays company profile and open positions

- **Admin Resources**
  - Job position management
  - Company profile management
  - Category organization
  - User administration
  - Role and permission control
  - Job source configuration

### Frontend Design
- Modern and clean UI using TailwindCSS
- Responsive design for all screen sizes
- Dark mode support
- Consistent styling across all pages
- Smooth transitions and interactions

## Admin Panel

The admin panel is accessible at `/admin`. To access it, create a user with an email ending in `@jobnexus.tech`.

Features available in the admin panel:
- Dashboard with key metrics
- Job position management
- Company profile management
- Category organization
- User administration
- Role and permission control
- Job source configuration and sync management

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
