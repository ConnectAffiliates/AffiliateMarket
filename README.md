# Affiliate Marketing Platform

A modern Affiliate Marketing Platform built with Laravel, Vite, Vue 3, and TailwindCSS. It allows users to sign up, generate affiliate links, track performance, and earn commissions from referrals. Businesses can create and manage affiliate programs to grow their customer base.

## 🚀 Features

-Landing page
- User registration and login system
- Affiliate dashboard with referral tracking
- Campaign & link management
- Commission calculation and payouts
- Admin panel to manage users and programs
- Notification & email support
- Mobile responsive UI built with TailwindCSS
- Integrated Font Awesome & Vuetify for UI components

## 🛠 Tech Stack

- Laravel 12
- PHP 8.1+
- MySQL
- Vue 3
- Vite
- TailwindCSS
- Font Awesome & Material Design Icons

## 📦 Installation

```bash
# Clone the repo
git clone https://github.com/your-username/affiliate-marketing-platform.git

cd affiliate-marketing-platform

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy .env and generate app key
cp .env.example .env
php artisan key:generate

# Set up the database
php artisan migrate

# Compile assets
npm run dev
