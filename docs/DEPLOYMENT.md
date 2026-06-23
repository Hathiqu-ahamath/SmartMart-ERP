# Deployment Guide

## Production Server Requirements
- PHP 8.2+ with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, MySQL
- Composer
- MySQL 8+
- Web server (Apache/Nginx)

## Deployment Steps

1. Upload files to production server
2. Set proper permissions:
```bash
chmod -R 775 storage bootstrap/cache
chmod -R 775 public
```

3. Production environment:
```bash
cp .env.example .env
php artisan key:generate
# Set APP_ENV=production, APP_DEBUG=false
```

4. Database setup:
```bash
php artisan migrate --seed --force
```

5. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Set up cron job for scheduler:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

7. Configure web server to point to `/public` directory

## Security Checklist
- [ ] HTTPS enabled
- [ ] APP_DEBUG=false
- [ ] Strong database credentials
- [ ] Regular backups configured
- [ ] File permissions locked down
- [ ] Failed login throttling active
