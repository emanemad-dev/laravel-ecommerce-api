# Laravel E-commerce API

This repository contains a simplified e-commerce backend built with Laravel.

## ✅ Features

* Laravel Sanctum Authentication
* Products CRUD
* Categories CRUD
* Media Handling (Spatie Media Library)
* Multi‑language Support (Spatie Translatable)
* Filament Dashboard

## 🚀 Installation

```bash
git clone https://github.com/emanemad-dev/laravel-ecommerce-api.git
cd laravel-ecommerce-api
composer install
cp .env.example .env
php artisan key:generate
```

## ⚙️ Environment Setup

* Configure database inside **.env** file
* Run migrations

```bash
php artisan migrate
```

## ▶️ Run Project

```bash
php artisan serve
```

## 📁 Filament Dashboard

Filament dashboard is available at:

```
/ admin
```

Login credentials can be created using a seeder or through registration.

## ⚡ API Authentication

Uses **Laravel Sanctum** for API token authentication.

## 📦 Media Uploads

Uses **Spatie Media Library** to upload product images.

## 🌍 Localization

Uses **Spatie Translatable** to store product titles and descriptions in multiple languages.

## ✅ Example Product Payload

```json
{
  "title": {
    "en": "Shoes",
    "ar": "حذاء"
  }
}
```

## ✅ License

This project is open‑source.
