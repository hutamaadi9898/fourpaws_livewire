# 🐾 FourPaws - Pet Memorial Platform

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel">
    <img src="https://img.shields.io/badge/Livewire-3.x-purple.svg" alt="Livewire">
    <img src="https://img.shields.io/badge/Filament-4.x-orange.svg" alt="Filament">
    <img src="https://img.shields.io/badge/Tailwind-4.x-blue.svg" alt="Tailwind">
    <img src="https://img.shields.io/badge/Status-Production%20Ready-green.svg" alt="Status">
</p>

A beautiful, modern platform for creating lasting tributes to beloved pets. Built with Laravel 12, Livewire 3, and Filament 4.

## ✨ Features

### 🎨 Memorial Management

-   **Create Memorials** - 4-step wizard with theme customization
-   **Edit Memorials** - Full editing capability for memorial owners
-   **Photo Uploads** - Profile photos and gallery images
-   **Privacy Controls** - Public or private visibility
-   **Theme Customization** - 7 color schemes, 3 layout styles

### 💬 Tribute System

-   **Submit Tributes** - Anyone can share memories
-   **Moderation UI** - Review and approve tributes
-   **Status Tracking** - Pending, Approved, Rejected states
-   **Email Notifications** - Automatic notifications

### 📧 Email Notifications

-   **Memorial Published** - Welcome email to owner
-   **Tribute Submitted** - Notification to memorial owner
-   **Tribute Approved** - Confirmation to submitter

### 🔐 Security & Authorization

-   **User Authentication** - Laravel Breeze integration
-   **Authorization Policies** - Memorial access control
-   **Protected Routes** - Edit and moderation require auth
-   **CSRF Protection** - Built-in security

### 🎯 User Experience

-   **Responsive Design** - Mobile-first approach
-   **Dark Mode** - Full dark mode support
-   **Dashboard** - Manage all memorials in one place
-   **Empty States** - Beautiful placeholder designs

## 🚀 Quick Start

### Prerequisites

-   PHP 8.4+
-   PostgreSQL 17
-   Node.js 18+
-   Composer
-   Laravel Herd (recommended)

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/fourpaws.git
cd fourpaws
```

2. **Install dependencies**

```bash
composer install
npm install
```

3. **Configure environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**
   Update `.env` with your database credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fourpaws
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations**

```bash
php artisan migrate
```

6. **Create storage link**

```bash
php artisan storage:link
```

7. **Build assets**

```bash
npm run build
# or for development
npm run dev
```

8. **Visit the application**

```
http://fourpaws.test
```

## 📖 Documentation

-   **[QUICK_START.md](QUICK_START.md)** - Quick reference guide
-   **[PHASE_5_COMPLETE.md](PHASE_5_COMPLETE.md)** - Detailed feature documentation
-   **[PHASE_5_SUMMARY.md](PHASE_5_SUMMARY.md)** - Implementation summary
-   **[plan.md](plan.md)** - Original project roadmap

## 🛠️ Tech Stack

-   **Backend:** Laravel 12.32.5
-   **Frontend:** Livewire 3.6.4, Alpine.js
-   **Styling:** Tailwind CSS 4.1.14
-   **Database:** PostgreSQL 17
-   **Admin:** Filament 4.1.1
-   **Testing:** Pest 4.1.1
-   **Code Quality:** Laravel Pint 1.19.4

## 🎯 Current Status

**Phase 5 Complete** ✅

-   Memorial CRUD operations
-   File upload system
-   Tribute moderation
-   Email notifications
-   Authorization policies

**Next Phase:**

-   Memorial deletion
-   Social media sharing
-   Analytics dashboard
-   Search functionality

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/MemorialTest.php

# Run with coverage
php artisan test --coverage
```

## 📝 Code Style

This project follows PSR-12 coding standards and uses Laravel Pint:

```bash
# Format all files
vendor/bin/pint

# Check without fixing
vendor/bin/pint --test
```

## 📧 Email Configuration

Update `.env` for email notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@fourpaws.test"
```

For production, run queue worker:

```bash
php artisan queue:work
```

## 🔒 Security

-   CSRF protection enabled
-   XSS prevention via Blade
-   SQL injection prevention via Eloquent
-   Authorization policies for all actions
-   File upload validation

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

Built with:

-   [Laravel](https://laravel.com) - The PHP framework
-   [Livewire](https://livewire.laravel.com) - Full-stack framework
-   [Filament](https://filamentphp.com) - Admin panel
-   [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS
-   [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript

---

<p align="center">Made with ❤️ for pet lovers everywhere</p>
