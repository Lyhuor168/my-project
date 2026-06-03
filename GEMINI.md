# Project Overview

This is a **School Management System / Learning Management System (LMS)** built with **Laravel 13** and **PHP 8.3**. It provides a comprehensive suite of tools for managing students, teachers, classes, attendance, courses, and schedules. It also includes an e-commerce module for a book shop and news/announcement management.

## Tech Stack

-   **Backend:** PHP 8.3, Laravel 13
-   **Frontend:** Tailwind CSS 4.0 (Vite), Alpine.js, Axios
-   **Database:** MySQL (standard Laravel configuration)
-   **Key Libraries:**
    -   `barryvdh/laravel-dompdf`: For PDF generation (e.g., invoices).
    -   `mcamara/laravel-localization`: For multi-language support (English and Khmer).
    -   `laravel/breeze`: Likely used for authentication scaffolding.

## Main Features

-   **User Management:** Roles include `user` and `admin`.
-   **Student & Teacher Management:** Full CRUD operations for student and teacher profiles.
-   **Academics:** Management of Courses, School Classes, and Schedules.
-   **Attendance:**
    -   Daily attendance tracking for classes.
    -   Attendance reporting and summaries.
    -   Attendance Requests (leave requests) with review workflows.
-   **Book Shop:**
    -   Inventory management for books.
    -   Order processing and status updates.
    -   PDF Invoice generation.
-   **CMS Features:** News/announcements and homepage slides.
-   **Localization:** Built-in support for English (`en`) and Khmer (`kh`/`km`).

## Building and Running

### Prerequisites
-   PHP 8.3+
-   Composer
-   Node.js & NPM
-   MySQL

### Key Commands

-   **Setup Project:**
    ```bash
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    npm run build
    ```

-   **Development:**
    ```bash
    # Run server, vite, and workers concurrently
    composer dev
    # OR individually
    php artisan serve
    npm run dev
    ```

-   **Testing:**
    ```bash
    composer test
    # OR
    php artisan test
    ```

-   **Database:**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

## Development Conventions

-   **Architecture:** Follows standard Laravel MVC patterns.
-   **Routing:** Routes are organized in `routes/web.php`. Public routes are accessible to all, while management features are protected by `auth` middleware.
-   **Models:** Standard Eloquent models in `app/Models/`.
-   **Controllers:** Business logic and view orchestration in `app/Http/Controllers/`.
-   **Views:** Blade templates located in `resources/views/`. Uses Tailwind CSS for styling and Alpine.js for lightweight interactivity.
-   **Localization:** Translation strings are found in `lang/en/messages.php` and `lang/kh/messages.php`.
-   **Static Assets:** Managed via Vite. Sources in `resources/css/` and `resources/js/`.

## Directory Structure Highlights

-   `app/Http/Controllers/`: Core business logic.
-   `app/Models/`: Database entities.
-   `database/migrations/`: Database schema definitions.
-   `database/seeders/`: Initial data for development/testing.
-   `lang/`: Localization files for EN and KH.
-   `resources/views/`: UI templates (Blade).
-   `routes/`: Application routing.
