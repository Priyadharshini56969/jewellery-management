# 💎 Jewellery Management System

A web-based jewellery product management system using CodeIgniter 4.

## 🚀 Features

- User login/logout
- Add/edit/delete jewellery products
- Image upload and resizing
- Product list with DataTables (server-side)
- Column visibility toggle

## 🛠️ Setup Instructions

### Requirements:
- PHP 7.4+
- MySQL
- Apache (XAMPP recommended)
- Composer

### Steps:

1. Clone or download the repository into your XAMPP `htdocs` folder:

    git clone https://github.com/Priyadharshini56969/jewellery-management
    or download and extract the ZIP file.

2. Import the SQL database dump (if provided) using phpMyAdmin or MySQL CLI.

3. Configure your database connection in the .env file (or app/Config/Database.php):


database.default.hostname = localhost
database.default.database = jewellery_db
database.default.username = root
database.default.password = 
Start Apache and MySQL from the XAMPP control panel.

4. Open your browser and visit:


http://localhost/jewellery-management/public/


## Test Login

- **Username:** admin  
- **Password:** admin123
