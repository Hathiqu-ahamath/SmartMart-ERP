# Troubleshooting

## Common Issues & Solutions

### 1. Blank Page / 500 Error After Changes

```bash
# Clear all caches
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Check the error log
cat storage/logs/laravel.log
```

### 2. Route Not Found (404)

```bash
# List all registered routes
php artisan route:list
```

### 3. Database Connection Error

```
.env file has incorrect DB credentials
```

**Fix:** Update `.env` with correct database settings and clear config:

```bash
php artisan config:clear
```

### 4. Migration Error: Table Already Exists

```bash
# Rollback and re-migrate (WARNING: destroys data)
php artisan migrate:fresh --seed

# Or reset specific tables
php artisan migrate:reset
php artisan migrate --seed
```

### 5. Composer Out of Memory

```bash
# Increase memory limit
php -d memory_limit=4G composer install
```

### 6. Login Redirects Back to Login

- Ensure database has the `users` table and a user exists
- Check `APP_URL` in `.env` matches your server URL
- Clear session: delete `storage/framework/sessions/*`

### 7. CSRF Token Mismatch

- Ensure `app.debug` is `true` in `.env` during development to see the error
- Run `php artisan key:generate` if missing
- Make sure all forms include `@csrf`

### 8. Storage: Images Not Showing

```bash
php artisan storage:link
```

### 9. "Class 'App\Models\X' not found"

```bash
# Dump autoload
composer dump-autoload
```

### 10. Port 8000 Already in Use

```bash
# Use a different port
php artisan serve --port=8080
```

## Logs

```bash
# View the latest error log entries
tail -f storage/logs/laravel.log

# On Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50
```

## Maintenance Mode

```bash
# Enable
php artisan down

# Disable
php artisan up
```
