# University Student Information and Academic Management System

A web-based application developed to manage student information and academic records efficiently.

## Project Overview

The University Student Information and Academic Management System helps manage student records through a user-friendly web interface. It provides authentication and student record management features.

## Features

- User Registration and Login
- Session-based Authentication
- Admin Dashboard
- Add New Student Records
- View Student Records
- Edit Student Information
- Delete Student Records
- JavaScript Form Validation
- XML Export of Student Records
- XML Record Display

## Technologies Used

| Technology | Purpose |
|---|---|
| HTML | Webpage Structure |
| CSS | User Interface Design |
| JavaScript | Form Validation |
| PHP | Backend Development |
| MySQL | Database Management |
| XML | Student Data Representation |
| XAMPP | Local Development Server |

## Project Structure

```text
university-student-management-system/
│
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── register.php
│
├── config/
│   └── database.php
│
├── css/
│   └── style.css
│
├── js/
│   └── validation.js
│
├── students/
│   ├── add.php
│   ├── delete.php
│   ├── edit.php
│   └── index.php
│
├── xml/
│   ├── display.php
│   ├── export.php
│   └── students.xml
│
├── dashboard.php
└── index.php
```

## Installation and Setup

1. Install XAMPP on your computer.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Copy the project folder into the XAMPP `htdocs` directory.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Create a database named `university_db`.
6. Import the project's SQL database backup when available.
7. Configure the database connection in `config/database.php`.
8. Open the project in your browser:

```text
http://localhost/university-student-management-system/
```

## Database Configuration

Update the database credentials in `config/database.php` according to your local MySQL setup.

## Project Purpose

The main objective of this project is to simplify student record management, reduce manual work, and provide an organized way to store and manage academic information.

## Future Enhancements

- Search and filter student records
- Generate student reports
- Role-based access control
- Improved security and data backup

## Author

**2024bca-arch**

## License

This project is developed for academic and educational purposes.
