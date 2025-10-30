# Laravel E-commerce API

A backend e-commerce application built using Laravel, providing core functionality such as authentication, product catalog, cart system, and order handling.

It supports multilingual content (EN/AR) using Spatie Translatable and product image management via Spatie Media Library.

---

## ✅ API Requirements

1. Authentication (Sanctum): Implement signup, signin, and logout endpoints.
2. Product Management: Generate 10,000 products using a seeder. Each product includes title, description, price, quantity, and one image. Supports Arabic & English via Spatie Translatable.
3. Cart Management: Users can add multiple products to their cart, view their cart, and remove items.
4. Orders: Users can create orders from their cart; checkout clears cart. Orders include total price and item details.

---

## 🚀 Installation

```bash
git clone https://github.com/emanemad-dev/laravel-ecommerce-api.git
cd laravel-ecommerce-api
composer install
cp .env.example .env
php artisan key:generate
```

### ✅ DB Setup

* Configure database in `.env`

Run migrations

```bash
php artisan migrate
```

---

## 🌱 Seeder

Generates **10,000 products** with:

* Title (EN/AR)
* Description (EN/AR)
* Price
* Quantity
* One image (Spatie Media Library)

Run seeder:

```bash
php artisan db:seed --class=ProductSeeder
```

---

## ▶️ Run App

```bash
php artisan serve
```

---

## 📦 API Endpoints

### ✅ Auth

| Method | Endpoint    | Description             |
| ------ | ----------- | ----------------------- |
| POST   | /api/signup | User signup             |
| POST   | /api/signin | User login              |
| POST   | /api/logout | Logout (requires token) |

### ✅ Products

| Method | Endpoint           | Description               |
| ------ | ------------------ | ------------------------- |
| GET    | /api/products      | List products (paginated) |
| GET    | /api/products/{id} | Show product              |

### ✅ Cart

| Method | Endpoint               | Description              |
| ------ | ---------------------- | ------------------------ |
| POST   | /api/cart/add          | Add product(s) to cart   |
| GET    | /api/cart              | View cart                |
| DELETE | /api/cart/{product_id} | Remove product from cart |

### ✅ Orders

| Method | Endpoint         | Description            |
| ------ | ---------------- | ---------------------- |
| POST   | /api/orders      | Create order from cart |
| GET    | /api/orders      | List user orders       |
| GET    | /api/orders/{id} | Show order details     |

---

## 🧪 Testing Flow (Manual)

1. Create a new user (Signup)
2. Login using the same credentials
3. Copy the issued token
4. View list of products
5. Add product(s) to the cart
6. View cart to confirm items
7. Remove an item from the cart (optional)
8. Create an order (Checkout)
9. Confirm the order exists in order history
10. View details of a specific order

---

## 🖼️ Media Library

Each product has **one image** stored using Spatie Media Library.

---

## 🎁 Dashboard

* Filament admin panel installed and configured
* Manage products (CRUD + translations + image upload)
* View orders

Dashboard URL:

```
{url}/admin
```

## ✅ Tech Stack

* Laravel 11
* Sanctum
* Spatie Media Library
* Spatie Translatable
* Filament (optional)

---

## ✅ License

This project is open-source.
