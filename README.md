# Library Management System

A robust, production-ready Library Management System built with Procedural PHP and MySQL. This application demonstrates core web development concepts including authentication, CRUD operations, database management, security best practices, and mixed storage strategies (MySQL + JSON).

##  Features

### Core Features
*   **Authentication**: Secure Login and Registration system using MySQL.
*   **Role-Based Access**: 
    *   **Admin**: Full access to manage books and users, view system statistics.
    *   **User**: Borrow books, manage profile, view loan history, and use wishlist.
*   **Dynamic Routing**: Custom procedural router handling clean URLs.
*   **User Feedback**: Session-based Flash Messages for immediate success/error notifications.

### Book Management (MySQL)
*   **CRUD Operations**: Admins can Add, Edit, Delete (securely), and View books.
*   **Pagination**: Server-side pagination for the book catalog to handle large datasets.
*   **Search & Filter**: Filter books by Category or Search by Title/Author.
*   **Stock Management**: Real-time tracking of available quantities with transaction safety.

### Borrowing System (MySQL)
*   **Loan Lifecycle**: Borrow books -> Stock decreases -> Return books -> Stock increases.
*   **Transaction Safety**: Database transactions ensure data integrity during borrow/return operations.
*   **History**: Users can view their borrowing history and active loans with due dates.
*   **Overdue Tracking**: Visual indicators for overdue books.

### Wishlist (JSON Storage)
*   **Hybrid Storage**: Demonstrates working with JSON files for non-relational data.
*   **Functionality**: Add/Remove books to personal wishlist.

##  Tech Stack
*   **Backend**: PHP (Procedural Style)
*   **Database**: MySQL (Users, Books, Loans)
*   **File Storage**: JSON (Wishlist data)
*   **Frontend**: HTML5, CSS3, JavaScript
*   **Server**: Apache/Nginx (via PHP built-in server or XAMPP/MAMP)

##  Project Structure
```
/app
    /controllers    # Procedural logic files (auth.php, book.php, etc.)
    /views          # HTML Templates
    config.php      # Database connection, Security helpers (CSRF, Prepared Statements), Flash messages
/data               # JSON storage (wishlist.json)
/public
    /css            # Stylesheets
    /js             # JavaScript files
index.php           # Entry point and Router
database.sql        # MySQL Database Schema
```

##  How to Run

### Prerequisites
1.  **PHP**: Version 7.4 or higher.
2.  **MySQL**: Local server (XAMPP, MAMP, or standalone).

### Setup Steps
1.  **Database Setup**:
    *   Open your MySQL tool (phpMyAdmin, TablePlus, CLI).
    *   Create a database named `library_db` (or import the script directly).
    *   Import the `database.sql` file provided in the root directory.
    
2.  **Configuration**:
    *   Open `app/config.php`.
    *   Update the `DB_USER` and `DB_PASS` constants to match your MySQL credentials.
    *   Default is set to `root` / `""` (empty password).

3.  **Start Server**:
    *   Open terminal in project root.
    *   Run: `php -S localhost:8000`

4.  **Access**:
    *   Open browser: `http://localhost:8000`

##  Test Accounts
The `database.sql` file includes these default users:

| Role  | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@library.com` | `password` | `L!bR@ry#2026`
| **User** | `john@example.com` | `password` |

##  Security Highlights
This project implements "Real Life Workable" security standards:

*   **SQL Injection Prevention**: All database queries use **Prepared Statements** via custom helper functions (`db_query`, `db_fetch_one`).
*   **CSRF Protection**: Comprehensive Cross-Site Request Forgery protection on all forms and state-changing actions using unique session tokens.
*   **Secure State Changes**: Sensitive actions (Delete, Borrow, Return) are strictly enforced via `POST` requests.
*   **Password Hashing**: Uses `password_hash()` and `password_verify()` for secure credential storage.
*   **XSS Protection**: Output escaping via `htmlspecialchars` in all views.
*   **Session Management**: Secure session handling for authentication and flash messages.

---
 2026 Library Management System
