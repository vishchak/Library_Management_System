# Library Management System

The **Library Management System (LMS)** is a web application designed to manage library resources, user accounts, and
book loans. It allows library administrators to efficiently manage their collection, and users to borrow and return
books.

## Features

- **User Registration and Login:** Users can register for an account and log in.
- **User Roles:** Supports both Admin and Member roles.
- **Search and Browse Books:** Users can search and browse the library's book collection.
- **Borrow and Return Books:** Members can borrow and return books.
- **Admin Panel:** Admins have access to an admin panel for managing books and users.

## Getting Started

### Prerequisites

Before you begin, make sure you have the following prerequisites:

- PHP 7.0 or higher
- MySQL database
- Web server (e.g., Apache, Nginx)
- Basic knowledge of HTML, CSS, and PHP

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/library-management-system.git
   cd library-management-system

2. Create a MySQL database and import the SQL schema from the database.sql file.

3. Configure the database connection in ../sheared/connection.php: $servername = "localhost";
   $username = "yourusername";
   $password = "yourpassword";
   $dbname = "library_db";

4. Start your web server and navigate to the project's root directory in your web browser.

## Usage

- Visit the homepage to browse and search for books.
- Register for an account to borrow and return books.
- Admins can access the admin panel to manage books and users.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project.
2. Create your feature branch: git checkout -b feature/your-feature.
3. Commit your changes: git commit -m 'Add some feature'.
4. Push to the branch: git push origin feature/your-feature.
5. Create a pull request.

## Acknowledgments
- Bootstrap - Front-end framework
- Font Awesome - Icons
- PHP - Server-side scripting language
- MySQL - Relational database management system