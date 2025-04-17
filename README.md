# Affiliate Marketing Platform

A modern Affiliate Marketing Platform built with Laravel, Vite, Vue 3, and TailwindCSS. It allows users to sign up, generate affiliate links, track performance, and earn commissions from referrals. Businesses can create and manage affiliate programs to grow their customer base.

## 🚀 Features

- Landing page
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
git clone https://github.com/ConnectAffiliates/AffiliateMarket.git

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
```

## ⚙️ Configuration

- Configure your .env file with correct DB, MAIL, and other settings.
- Set up your Vite config if customizing the front end.

## 🧪 Running the Project

```bash
php artisan serve
```

## 📁 Folder Structure Highlights

- app/Http/Controllers – Core controllers for user and affiliate logic

- resources/js/ – Vue components and JavaScript logic

- resources/views/ – Blade templates and layout views

- public/ – Public assets and entry point

- tailwind.config.js – TailwindCSS configuration

- vite.config.js – Vite bundler setup

  ## 🤝 Contributing
  
  Feel free to fork this repository, raise issues, or submit PRs for improvements.

  ## 📄 License
  
  This project is open-sourced under the MIT license.

  Built with ❤️ by ByteForce

