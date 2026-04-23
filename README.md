<h1 align="center">OrbitErp</h1>

<p align="center">
  A modern, multi-tenant ERP platform for growing businesses — built with Laravel, Alpine.js, and Gemini AI.
</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2-8892BF?logo=php&logoColor=white">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?logo=tailwindcss&logoColor=white">
  <img alt="Alpine.js" src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpine.js&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/license-MIT-green">
</p>

---

## 📖 What is OrbitErp?

**OrbitErp** is a full-featured, Software-as-a-Service (SaaS) Enterprise Resource Planning (ERP) platform designed for small and medium-sized businesses (SMBs). It provides a centralized workspace to manage every aspect of a company's operations — from customer relations and sales orders to team collaboration and AI-powered assistance.

The platform is **multi-tenant by design**: each organization gets its own isolated workspace (a "Company") with its own data, members, roles, and configurations — all sharing the same infrastructure. This makes OrbitErp both scalable and cost-efficient.

---

## ✨ Key Features

### 🏢 Multi-Tenant Architecture
- Each user can belong to **multiple companies** with different roles.
- Complete data isolation: every entity (orders, products, clients) is scoped to its `company_id`.
- Company-scoped URL routing via unique slugs (`/c/{company-slug}/...`).

### 🔐 Role-Based Access Control (RBAC)
- Granular permission system (e.g., `view_orders`, `manage_members`).
- Custom roles per company — an "Accountant" role in Company A can have completely different permissions than the same role in Company B.
- Enforced at three levels: **Blade views** (`@can`), **Route middleware**, and **Laravel Policies**.

### 👥 Team Management & Invitations
- Invite team members via email with a secure, signed invitation link.
- Assign roles at the moment of invitation.
- Full membership management (promote, demote, remove).

### 🛒 Sales & Order Management
- Create and track orders linked to specific clients and suppliers.
- Line-item management with dynamic pricing.
- Order statuses: Pending, In Progress, Shipped, Delivered, Cancelled.
- Automatic invoice generation from an order.

### 📦 Inventory & Product Catalog
- Full product catalog with SKU tracking, pricing, and stock levels.
- Category management with hierarchical organization.
- Link products to one or more suppliers.

### 👤 CRM — Clients & Suppliers
- Detailed client and supplier profiles with contact information, addresses, and notes.
- Order history linked directly to each client/supplier.

### 🤖 OrbitBot — AI Assistant
- Integrated AI assistant powered by **Google Gemini**.
- Natural language interface for managing company data.
- **Tool Calling** capability: OrbitBot can query the database, list clients, summarize orders, and even create records — all through conversation.
- 31 specialized administrative tools (CRUD for Clients, Products, Orders, Tasks, Calendar, etc.).

### 💬 Team Collaboration
- **Real-time messaging** through company-scoped conversations.
- **Task management** board with due dates and statuses.
- **Calendar** for scheduling and tracking company events.

### 🎨 Premium UI/UX
- Premium custom design system built with Tailwind CSS.
- Full **Dark Mode** support.
- Responsive design for desktop, tablet, and mobile.
- Smooth animations, micro-interactions, and skeleton loaders.
- Persistent sidebar state via LocalStorage.

---

## 🗂️ Project Architecture

OrbitErp follows a clean **MVC architecture** with a **Service Layer** pattern for complex business logic.

```
app/
├── Ai/
│   ├── Agents/          # OrbitBot AI agent definition
│   └── Tools/           # 31 AI tools (CRUD per module)
├── Http/
│   ├── Controllers/     # Thin controllers, route handling
│   ├── Middleware/      # Membership & auth middleware
│   └── Requests/        # Form validation (one per action)
├── Policies/        # Laravel Policies for authorization
├── Models/              # Eloquent models
└── Services/            # Business logic layer (e.g., OrderService)

resources/
└── views/
    ├── components/      # Reusable Blade components (inputs, buttons)
    ├── layouts/         # Admin and guest layouts
    └── {module}/        # Views per module (orders, clients, etc.)
```

---

## 🧩 Core Data Model

```
User ─── Membership ─── Company
              │
            Role ─── Permission

Company ◆─── Product ─── Category
        ◆─── Order   ◆─── OrderItem ──── Product
        ◆─── Client
        ◇─── Supplier
```

- **Composition** (`◆`): Entities are owned by and destroyed with the Company.
- **Aggregation** (`◇`): Entities can be shared or exist independently.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 11 (PHP 8.2) |
| **Frontend** | Blade, Alpine.js 3.x |
| **Styling** | Tailwind CSS 3.x |
| **Database** | MySQL 8+ / PostgreSQL |
| **AI** | Google Gemini API (`laravel/ai`) |
| **Auth** | Laravel Breeze + Sanctum |
| **Build** | Vite |
| **Version Control** | Git |

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL or PostgreSQL

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/OrbitErp.git
cd OrbitErp

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env
DB_CONNECTION=mysql
DB_DATABASE=orbit_erp
DB_USERNAME=root
DB_PASSWORD=

# 6. Add your Gemini API key in .env
GEMINI_API_KEY=your_api_key_here

# 7. Run migrations and seed the database
php artisan migrate --seed

# 8. Start the development servers
php artisan serve
npm run dev
```

Visit `http://localhost:8000` to access the application.

---

## 📁 Module Overview

| Module | Description |
|---|---|
| **Companies** | Create and manage isolated company workspaces |
| **Members** | Invite users and assign roles |
| **Roles & Permissions** | Define granular access policies |
| **Clients** | CRM for customer management |
| **Suppliers** | Supplier directory and product links |
| **Products** | Catalog, SKU, stock, pricing |
| **Categories** | Product categorization |
| **Orders** | Full sales order lifecycle |
| **Invoices** | Invoice generation from orders |
| **Payments** | Payment tracking per invoice |
| **Tasks** | Team task board |
| **Calendar** | Event scheduling |
| **Conversations** | Internal team messaging |
| **OrbitBot** | AI-powered business assistant |

---

## 🔒 Security

- All routes are protected by **Laravel's authentication guard**.
- Multi-tenant isolation is enforced via the `membership` middleware.
- All database queries use **Eloquent's prepared statements** (SQL injection safe).
- Forms are protected by **CSRF tokens**.
- Passwords are **hashed** using Bcrypt.

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 🙏 Acknowledgements

- [Laravel](https://laravel.com) — The PHP framework for web artisans.
- [Alpine.js](https://alpinejs.dev) — A rugged, minimal JavaScript framework.
- [Google Gemini](https://deepmind.google/technologies/gemini/) — Powering OrbitBot's intelligence.
