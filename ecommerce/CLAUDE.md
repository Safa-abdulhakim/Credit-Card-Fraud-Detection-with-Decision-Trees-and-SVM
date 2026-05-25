# Laravel E-Commerce Platform — CLAUDE.md

## Project Overview

Enterprise-Level Multi-Vendor E-Commerce System built with Laravel 11, PHP 8.4, and SQLite (development). Supports 4 roles: Admin, Vendor, Customer, and Delivery Agent.

## Tech Stack

- **Framework**: Laravel 11 (PHP 8.4)
- **Database**: SQLite (dev) / MySQL 8 (prod)
- **Frontend**: Blade + Bootstrap 5 + Font Awesome + Chart.js
- **Auth**: Laravel Breeze (email/password) + Sanctum (API tokens)
- **PDF**: barryvdh/laravel-dompdf
- **Queue**: Database driver (configurable to Redis in prod)

## Project Structure

```
ecommerce/
├── app/
│   ├── DTOs/               # ProductDTO, CheckoutDTO
│   ├── Events/             # OrderPlaced, OrderCancelled, OrderStatusChanged
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/      # Admin panel controllers (15 files)
│   │   │   ├── Api/V1/     # REST API controllers (10 files)
│   │   │   ├── Auth/       # Breeze auth controllers
│   │   │   ├── Customer/   # Customer portal controllers
│   │   │   ├── Delivery/   # Delivery agent controllers
│   │   │   ├── Store/      # Public store controllers
│   │   │   └── Vendor/     # Vendor panel controllers
│   │   ├── Middleware/     # AdminMiddleware, VendorMiddleware, etc.
│   │   └── Resources/V1/  # API resources (ProductResource)
│   ├── Listeners/          # Queued event listeners
│   ├── Models/             # Eloquent models
│   ├── Notifications/      # Mail+database notifications
│   ├── Policies/           # Authorization policies
│   └── Services/           # Business logic layer
├── database/
│   ├── migrations/         # 19 migration files
│   └── seeders/            # 8 seeders (roles, users, vendors, products, etc.)
├── resources/views/
│   ├── admin/              # Admin panel views
│   ├── customer/           # Customer portal views
│   ├── delivery/           # Delivery agent views
│   ├── layouts/            # app.blade.php, admin.blade.php, vendor.blade.php
│   ├── store/              # Public storefront views
│   └── vendor/             # Vendor panel views
└── routes/
    ├── api.php             # API v1 routes (Sanctum-guarded)
    └── web.php             # All web routes (178 total)
```

## Common Commands

```bash
cd ecommerce

# Development
php artisan serve                    # Start dev server
php artisan migrate:fresh --seed     # Reset and re-seed database
php artisan queue:work               # Process queued jobs
php artisan storage:link             # Link storage for file uploads

# Testing
php artisan test                     # Run all tests
php artisan test --filter=CartTest   # Run specific test

# Artisan helpers
php artisan route:list               # List all routes
php artisan make:model Foo -mcr      # Model + migration + controller
```

## Role-Based Access

| Role | Login Redirects To | Middleware |
|------|-------------------|------------|
| Admin | `/admin/dashboard` | `admin` |
| Vendor (approved) | `/vendor/dashboard` | `vendor` |
| Vendor (pending) | `/vendor/pending` | — |
| Customer | `/customer/dashboard` | `customer` |
| Delivery Agent | `/delivery/dashboard` | `delivery` |

## Seeded Test Accounts

| Email | Password | Role |
|-------|----------|------|
| admin@example.com | password | Admin |
| vendor1@example.com | password | Vendor (approved) |
| vendor2@example.com | password | Vendor (approved) |
| customer1@example.com | password | Customer |
| delivery@example.com | password | Delivery Agent |

## Architecture

- **Service Layer**: Thin controllers delegate to Services (ProductService, OrderService, CartService, CouponService, ReportService)
- **Repository Pattern**: Services use Eloquent directly (no extra repository layer needed at this scale)
- **DTOs**: `ProductDTO` and `CheckoutDTO` carry validated data from controllers to services
- **RBAC**: Custom `roles` table + `role_id` on users. Helper methods: `isAdmin()`, `isVendor()`, `isCustomer()`, `isDeliveryAgent()`
- **Events/Listeners**: `OrderPlaced` fires on checkout → sends confirmation email + notifies vendor + reserves stock
- **Policies**: `ProductPolicy`, `OrderPolicy`, `VendorPolicy`, `ReviewPolicy` with admin `before()` bypass

## API Endpoints

Base URL: `/api/v1/`

**Public:**
- `GET /store/products` — Product listing with filters
- `GET /store/products/{slug}` — Product detail
- `GET /store/categories` — Category tree
- `GET /store/brands` — Brand list

**Auth:**
- `POST /auth/login` — Get Sanctum token
- `POST /auth/register` — Register + get token
- `POST /auth/logout` — Revoke token

**Protected (Bearer token):**
- `GET/POST /cart` — Cart management
- `GET/POST /orders` — Order list + checkout
- `GET/POST /wishlist/{product}` — Toggle wishlist
- `GET/POST /reviews` — Submit reviews
- `GET /notifications` — Notification list
- `GET/PATCH /profile` — Profile management

## Key Models & Relationships

```php
User → hasOne Vendor, hasMany Orders, hasMany Reviews
Product → belongsTo Vendor, Category, Brand; hasMany Images, Variants, Reviews
Order → belongsTo User; hasMany OrderItems; hasOne Shipment
Cart → belongsTo User (or guest via session); hasMany CartItems
Coupon → hasMany CouponUsages
```

## Environment Notes

- SQLite database at `database/database.sqlite`
- File uploads stored in `storage/app/public/` (symlinked to `public/storage/`)
- Queue driver: `database` (table: `jobs`)
- Mail: `log` driver in development (check `storage/logs/laravel.log`)

## Git Branch

Development branch: `claude/laravel-ecommerce-platform-txp93`
