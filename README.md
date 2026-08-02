# 🏪 Sari-Sari Store Management System

A web-based **Sari-Sari Store Management System** built with **Laravel** to help small businesses manage inventory, sales, suppliers, customer reservations ("Pabook"), and prepaid mobile load transactions.

The system digitizes traditional paper-based record keeping, making store operations more organized, efficient, and easier to monitor.

---

## ✨ Features

- 📦 Inventory Management
- 💰 Point of Sale (POS)
- 🛒 Sales Transaction Management
- 📱 Prepaid Mobile Load Transactions
- 📝 Customer Reservation (Pabook)
- 🚚 Supplier Management
- 📦 Stock Monitoring
- 📊 Sales Reports
- 👤 User Authentication
- 🔐 Role-Based Access Control

---

## 🛠️ Tech Stack

- Laravel
- Laravel Breeze
- PHP
- MySQL
- JavaScript
- HTML5
- CSS3
- Docker

---

## 📂 Project Structure

```
app/
database/
public/
resources/
routes/
storage/
```

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/sari-sari-store.git
```

### 2. Navigate to the project

```bash
cd sari-sari-store
```

### 3. Install dependencies

```bash
composer install
npm install
```

### 4. Create the environment file

```bash
cp .env.example .env
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Configure your database

Update your `.env` file:

```env
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations and seeders

```bash
php artisan migrate --seed
```

### 8. Create the storage link

```bash
php artisan storage:link
```

### 9. Start the application

```bash
php artisan serve
npm run dev
```

Visit:

```
http://127.0.0.1:8000
```

---

## 📊 Main Modules

- Dashboard
- Inventory
- Products
- Sales
- Suppliers
- Customer Reservations
- Mobile Load
- Reports
- User Management

---

## 🔐 Default Login

Administrator

```
Email:
admin@example.com

Password:
password
```

---

## 👨‍💻 Developer

Created by **Liz Zaragosa** | Second year IT6 Project
