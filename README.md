# DOCUARCH — Document Archiving System

**Technology:** Laravel, PHP, MySQL, HTML, CSS, and JavaScript

DOCUARCH is a web-based Document Archiving System designed to help offices organize, store, search, retrieve, and manage archived documents digitally.

## Main Features

- Document archiving for Letters, Clearance Forms, and Reports
- Automatic document numbering
- Document search and filtering
- Document information management
- Optional digital file attachments
- Archive history and activity logs
- Dashboard statistics
- Reports generation
- User management
- Role-based access control

## Technology Requirements

- PHP 8.2 or higher
- Composer
- MySQL
- XAMPP
- Visual Studio Code
- Git

## Installation Guide

### 1. Clone the repository

```bash
git clone https://github.com/whzandro99/DOCUARCHH.git
cd DOCUARCHH
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

Copy `.env.example` and rename the copy to `.env`.

Configure your database settings:

```env
APP_NAME=DOCUARCH
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=docuarch
DB_USERNAME=root
DB_PASSWORD=
```

Create a MySQL database named `docuarch` using phpMyAdmin.

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Run migrations and seed the database

```bash
php artisan migrate --seed
```

### 6. Start the development server

```bash
php artisan serve
```

Open http://127.0.0.1:8000 in your browser.

## Demo Accounts

| Role | Email | Password |
|---|---|---|
| Administrator | admin@docuarch.test | password |
| Office Personnel | personnel@docuarch.test | password |
| Requesting User | requester@docuarch.test | password |

These are demonstration credentials for classroom testing. Change them before using real records.

## Document Numbering

- Letters: `LTR-YYYY-0001`
- Clearance Forms: `CLR-YYYY-0001`
- Reports: `RPT-YYYY-0001`

Each document type has an independent numbering series.

## Project Scope

DOCUARCH focuses on digital document archiving, organization, retrieval, and archive management. It is not a document routing or approval workflow system.

---

**DOCUARCH — Making Document Archiving More Organized and Accessible.**