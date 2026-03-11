# 🎣 Fishing Diary App

A personal fishing logbook built with Laravel.  
Track your catches, analyze your results and improve your technique.

![Fishing Diary App](screenshots/my-catches.png)

## ✨ Features

- 📋 **Catch log** – add, edit and delete fishing entries
- 📊 **Stats** – analyze catches by species, weight and location  
- 🔃 **Sorting** – by date, weight or species
- 🌍 **Multilingual** – English and German (DE/EN)
- 🔐 **Authentication** – personal diary per user

## 🛠️ Tech Stack

- **Backend:** Laravel (MVC, Eloquent ORM)
- **Frontend:** Blade Templates, CSS
- **Database:** MySQL
- **Tools:** Composer, Git

## 🚀 Installation
```bash
git clone https://github.com/Dmytro-Popov/fishing-app
cd fishing-app
composer install
cp .env.example .env
php artisan key:generate
# Configure database in .env
php artisan migrate
php artisan serve
```

## 📸 Screenshots

> My Catches – overview with sort options

![My Catches](screenshots/my-catches.png)
