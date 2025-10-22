# 📚 Timedoor Backend Programming Test

This project is a **Laravel-based backend web application** developed as part of the **Timedoor Backend Developer Technical Test**.  
It implements complete backend logic with **Books**, **Authors**, and **Ratings** modules — featuring relationship handling, clean controller structures, and dynamic front-end rendering using **Bootstrap 5** and **jQuery AJAX**.

---

## 🚀 Features

-   ✅ API for **Books**, **Authors**, and **Ratings**
-   📊 Display **Top 10 Books** (sorted by average rating)
-   🧑‍💼 Display **Top 10 Authors** (sorted by total votes)
-   ⭐ Rating submission form (Select Author → Book → Score)
-   🔁 AJAX-based dynamic dropdowns (jQuery)
-   📑 Modular Blade components:
    -   `<x-base-title>` — page header with title & subtitle
    -   `<x-base-table>` — reusable table layout
    -   `<x-base-form>` — reusable form component
-   💾 Database seeder for dummy data generation
-   🎨 Simple and responsive layout using **Bootstrap 5**

---

## ⚙️ System Requirements

Before installation, ensure you have the following tools installed:

| Requirement  | Version | Description                |
| ------------ | ------- | -------------------------- |
| **PHP**      | ≥ 8.2   | Required for Laravel 12    |
| **Composer** | ≥ 2.5   | PHP dependency manager     |
| **MySQL**    | ≥ 8.0   | Database system            |
| **Git**      | ≥ 2.0   | For cloning the repository |

---

## 🛠️ Installation Guide

Follow these steps to install and run the project on your local environment.

---

### 1️⃣ Clone the Repository

Use Git to download the project to your local machine:

```bash
git clone https://github.com/divta-suryawan/timedoor-tectnical-test.git
```

### 2️⃣ Install PHP Dependencies

Use Composer to install all Laravel dependencies:

```bash
composer install
```

### 3️⃣ Set Up Environment Configuration

Copy the default environment file:

```bash
cp .env.example .env
```

Edit the `.env` file to configure your database connection details.

### 4️⃣ Generate Application Key

Generate a unique application key:

```bash
php artisan key:generate
```

### 5️⃣ Migrate Database

Run database migrations to create the necessary tables:

```bash
php artisan migrate
```

### 6️⃣ Seed Database

Seed the database with dummy data:

```bash
php artisan db:seed
```

### 7️⃣ Start the Development Server

Start the Laravel development server:

```bash
php artisan serve
```

### 8️⃣ Access the Application

Open your web browser and navigate to `http://localhost:8000` to access the application.
