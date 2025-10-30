

# 🛍️ E-Commerce API — Laravel

A simplified e-commerce REST API built with Laravel including authentication, product management, cart, and order handling.
Supports multilingual products and image uploads.

---

## 🚀 Features

✅ Authentication — Signup, login, logout
✅ Product management — 10,000 generated products
✅ Spatie Translatable — EN/AR titles & descriptions
✅ Spatie Media Library — 1 image per product
✅ Cart system — Add/remove/view
✅ Orders — Checkout, total price, order items
✅ Filament Admin Dashboard (optional / available)

---

## 📦 Tech Stack

* **Laravel**
* **Laravel Sanctum**
* **Spatie Translatable**
* **Spatie Media Library**
* **Filament (Dashboard)**
* MySQL / PostgreSQL / SQLite

---

## ⚙️ Installation

```bash
git clone https://github.com/emanemad-dev/laravel-ecommerce-task.git
cd project-laravel-ecommerce-task
composer install
cp .env.example .env
```

Set your database credentials in `.env`

```bash
php artisan key:generate
php artisan migrate
```

---

## 📂 Database Seeding

10,000 products are automatically generated using:

```bash
php artisan db:seed
```

Each product includes:

* Title (EN + AR)
* Description (EN + AR)
* Price
* Quantity
* One image

---

## 🔐 Authentication (Sanctum)

| Method | Endpoint    | Description             |
| ------ | ----------- | ----------------------- |
| POST   | /api/signup | Register                |
| POST   | /api/signin | Login                   |
| POST   | /api/logout | Logout (requires token) |

### Example — Signup

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password"
}
```

### Example — Login

```json
{
  "email": "john@example.com",
  "password": "password"
}
```

---

## 🛒 Products

| Method | Endpoint           | Description     |
| ------ | ------------------ | --------------- |
| GET    | /api/products      | Paginated list  |
| GET    | /api/products/{id} | Product details |

---

## 🛍️ Cart

| Method | Endpoint            | Description          |
| ------ | ------------------- | -------------------- |
| POST   | /api/cart/add       | Add products to cart |
| GET    | /api/cart           | View cart            |
| DELETE | /api/cart/{product} | Remove product       |

Example:

```json
{
  "products": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 55, "quantity": 1 }
  ]
}
```

---

## 📦 Orders

| Method | Endpoint         | Description   |
| ------ | ---------------- | ------------- |
| POST   | /api/orders      | Checkout      |
| GET    | /api/orders      | List orders   |
| GET    | /api/orders/{id} | Order details |

✔ Checkout clears the cart
✔ Order contains total price + items

---

## 🖥️ Admin Dashboard (Filament)

A full Admin Panel is available using **Filament**.

### ✅ Features

* Product CRUD
* Upload product image
* Manage EN/AR translations
* View orders & order details

### ▶️ How to access

Start server:

```bash
php artisan serve
```

Then open in browser:

```
http://localhost:8000/admin
```

Login with credentials you inserted (e.g. via seeder).


## ✅ Example Usage Flow

1. Signup → Login → Get Token
2. View Products
3. Add Products to Cart
4. View Cart
5. Create Order (Checkout)
6. View Order History

---


## 🛠️ Additional Notes

* All protected routes require Bearer Token
* Products support EN/AR localization
* Each product has only one image
* Cart clears after checkout

---

## ✅ Requirements

* PHP ≥ 8.1
* Composer
* MySQL / PostgreSQL / SQLite

---

## 📄 License

Open-source. Free to use.

---
