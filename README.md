# 07 Printers - Professional Website

Complete website for **07 Printers** (Nazimabad, Karachi) built with HTML, CSS, PHP & MySQL.

## Features

- Modern, professional, responsive design
- Smooth animations (AOS library)
- Session-based Shopping Cart
- Add to Cart functionality
- Checkout with payment options:
  - WhatsApp Order (recommended)
  - EasyPaisa
  - JazzCash
  - Bank Transfer
- Direct WhatsApp ordering with pre-filled cart details
- Full services list (10 categories, 100+ items)
- Rate list with prices
- About page with machines & software
- Contact form (sends via WhatsApp)
- Floating WhatsApp button
- Mobile-friendly navigation

## Installation

### 1. Requirements
- PHP 7.4+ (or 8.x)
- MySQL / MariaDB
- Apache / Nginx (or XAMPP / Localhost)

### 2. Setup Database
1. Create database or import `database.sql` via phpMyAdmin
2. Update credentials in `includes/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'printers07');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

> Note: Website works even without database (products are hardcoded as fallback).

### 3. Update Shop Info
Edit `includes/config.php` for:
- Phone numbers
- WhatsApp numbers (without +)
- EasyPaisa / JazzCash numbers
- Bank details
- Address

### 4. Deploy
Upload entire `07printers` folder to your hosting `public_html` or subdomain.

## File Structure

```
07printers/
├── index.php              # Homepage
├── services.php           # All services
├── products.php           # Rate list + Add to Cart
├── cart.php               # Shopping cart
├── checkout.php           # Payment & Order
├── about.php              # About + Machines
├── contact.php            # Contact form
├── cart-action.php        # Cart operations
├── database.sql           # Database schema + sample data
├── includes/
│   ├── config.php         # Settings & helpers
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/style.css
│   └── js/main.js
└── README.md
```

## Payment Notes

Full EasyPaisa / JazzCash API integration requires merchant accounts from JazzCash & EasyPaisa.  
Current implementation shows payment instructions and sends order to WhatsApp for manual confirmation — perfect for small shops.

## Owners
- M. Anas Mughal — 0312-1223711
- Hussain Faisal — 0347-0777597

**Address:** Block 3-D, No. 39, Nazimabad No. 03, Near Abbasi Shaheed Hospital, Karachi.

---

Built with care for 07 Printers.