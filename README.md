<div align="center">

# 🟣 Clary
### Multi-Tenant Agency Client Management Platform

![License](https://img.shields.io/github/license/n9rrrx/clary?style=for-the-badge&color=blue)
![PHP Version](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel Version](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

<br />

**Clary** is a robust, multi-tenant platform designed to help agencies, freelancers, and service teams manage the entire client lifecycle—from onboarding to invoicing—within a secure, isolated workspace.

[View Demo](#) · [Report Bug](https://github.com/n9rrrx/clary/issues) · [Request Feature](https://github.com/n9rrrx/clary/issues)

</div>

---

## ✨ Key Features

Clary is built with scalability and simplicity in mind, allowing organizations to operate in their own isolated environment (Multi-Tenancy) while sharing a centralized system.

### 🏢 Core Functionality
* **Multi-Tenancy Architecture:** Isolated workspaces and databases for each agency using `stancl/tenancy`.
* **Client Management:** comprehensive profiles, contact info, and status tracking (Lead vs Customer).
* **Project Workflows:** Budget tracking, timeline management, and status monitoring.
* **Task Management:** Priority-based task assignment and deadline tracking.
* **Billing & Invoicing:** Automated invoice generation with status tracking (Draft, Sent, Paid, Overdue).
* **Midnight UI:** A custom-designed dark mode interface for reduced eye strain.

### 🛠 Technical Highlights
* **RESTful API:** Full CRUD operations for all resources.
* **Secure Auth:** Laravel Sanctum implementation for API security.
* **Eloquent ORM:** Complex relationships managed seamlessly.
* **Robust Testing:** Full PHPUnit test coverage.

---

## 🏗️ Tech Stack

| Component | Technology | Description |
| :--- | :--- | :--- |
| **Framework** | **Laravel 11** | The PHP Framework for Web Artisans |
| **Language** | **PHP 8.3+** | Server-side scripting language |
| **Database** | **MySQL / PostgreSQL** | Relational database management |
| **Frontend** | **Blade & Tailwind** | Reactive UI components & styling |
| **Multi-Tenancy** | **Stancl/Tenancy** | Automatic tenant bootstrapping |
| **Testing** | **PHPUnit** | Unit and Feature testing |

---

## 🚀 Getting Started

Follow these steps to set up a local development environment.

### Prerequisites
* PHP >= 8.2
* Composer
* MySQL, PostgreSQL, or SQLite
* Node.js & NPM

### Installation

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/n9rrrx/clary.git](https://github.com/n9rrrx/clary.git)
    cd clary
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Configure Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Setup**
    Update your `.env` file with your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=clary
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

5.  **Migrate & Seed**
    This creates the tables and populates them with sample data.
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6.  **Serve Application**
    ```bash
    php artisan serve
    ```
    Visit `http://localhost:8000` to access Clary.

---

## 📚 API Documentation

Base URL: `http://localhost:8000/api`

### 👥 Clients
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/clients` | List all clients (paginated) |
| `POST` | `/clients` | Create a new client |
| `GET` | `/clients/{id}` | Show specific client details |
| `PUT` | `/clients/{id}` | Update client information |
| `DELETE` | `/clients/{id}` | Remove a client |

### 📂 Projects
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/projects` | List all projects |
| `POST` | `/projects` | Create a new project |
| `GET` | `/projects/{id}` | Show project details |
| `PUT` | `/projects/{id}` | Update project status/budget |
| `DELETE` | `/projects/{id}` | Delete a project |

### ⚡ Tasks & Invoices
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/tasks` | List all tasks |
| `POST` | `/invoices` | Generate a new invoice |
| `GET` | `/invoices/{id}` | Retrieve invoice details |

> **Note:** All API requests must include the `Accept: application/json` header. Protected routes require a Bearer Token via Sanctum.

---

## 🗂️ Database Schema Overview

The system uses a relational schema designed for data integrity.

* **Users:** System administrators and team members.
* **Clients:** `name`, `email`, `company`, `status`.
* **Projects:** Linked to Clients. Contains `budget`, `deadlines`, `status`.
* **Tasks:** Linked to Projects & Users. Contains `priority`, `due_date`.
* **Invoices:** Linked to Projects. Contains `subtotal`, `tax`, `total`, `status`.

---

## 🧪 Testing

Clary comes with a comprehensive test suite.

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter ClientApiTest

# Analyze coverage
php artisan test --coverage