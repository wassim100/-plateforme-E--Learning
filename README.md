## -plateforme-E--Learning

Laravel-based E‑Learning platform (front + admin) with PostgreSQL.

### What’s inside
- Front and Admin themes under `public/desgin/`
- Admin: Categories CRUD with search, pagination, KPIs
- Mock dashboard APIs for charts/tables

### Setup
1) Copy `.env.example` to `.env`, then set PostgreSQL values:
- DB_CONNECTION=pgsql
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=educa_laravel
- DB_USERNAME=postgres
- DB_PASSWORD=your_password

2) Install and boot
- composer install
- php artisan key:generate
- php artisan migrate --seed
- php artisan serve

App: http://127.0.0.1:8000

### Notes
- `_ide_helper.php`, `_ide_helper_models.php`, `.phpstorm.meta.php` are ignored.
- For large demo videos under `public/desgin/images/*.mp4`, prefer Git LFS or external hosting.
