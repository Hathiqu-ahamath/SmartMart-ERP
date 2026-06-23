# Installation Guide

## Prerequisites
- PHP 8.2+
- Composer
- MySQL 8+
- Node.js (optional, for frontend assets)

## Steps

1. Clone the repository
```bash
git clone <repository-url> smartmart-erp
cd smartmart-erp
```

2. Install PHP dependencies
```bash
composer install
```

3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartmart_erp
DB_USERNAME=root
DB_PASSWORD=
```

5. Create database
```bash
mysql -u root -p -e "CREATE DATABASE smartmart_erp"
```

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

7. Storage link
```bash
php artisan storage:link
```

8. Start development server
```bash
php artisan serve
```

9. Login with default credentials
- Email: admin@smartmart.com
- Password: password

10. (Optional) Run tests
```bash
php artisan test
```
