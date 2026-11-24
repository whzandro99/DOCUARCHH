# DOCUARCH — Laravel + MySQL

This is a Laravel application source package built from the DOCUARCH proposal. It contains the application files to copy into a fresh Laravel project.

## Included scope
- Three document types only: Letters, Clearance Forms, Reports
- Independent numbering series: LTR-YYYY-0001, CLR-YYYY-0001, RPT-YYYY-0001
- Role-based access: `admin`, `personnel`, `requester`
- Document archive, search/filter, optional file attachment, archive history
- Dashboard counts and date/type-filtered reports
- Admin user management

## 1. Requirements
- PHP 8.2+
- Composer
- MySQL / XAMPP
- Node.js and npm (optional; this package uses plain CSS/JS)
- VS Code

## 2. Create a fresh Laravel project
Open VS Code terminal in the folder where you want the project:

```bash
composer create-project laravel/laravel docuarch
cd docuarch
```

Copy the contents of this package's `app`, `bootstrap`, `database`, `public`, `resources`, and `routes` folders into the matching folders in the new `docuarch` project. Allow files to merge. Do not replace Laravel's `vendor` folder or `.env`.

## 3. Configure MySQL
Start Apache and MySQL in XAMPP. Create a database named `docuarch` in phpMyAdmin.

Edit `.env`:

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

## 4. Install and run
In the Laravel project terminal:

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

Open http://127.0.0.1:8000

## 5. Demo accounts
The seeder creates:
- Admin: `admin@docuarch.test` / `password`
- Office Personnel: `personnel@docuarch.test` / `password`
- Requesting User: `requester@docuarch.test` / `password`

Change these passwords before using real records. This starter uses demo credentials for classroom testing only.

## 6. Roles
- **Administrator:** dashboard, all documents, archive history, reports, and user management.
- **Office Personnel:** dashboard, create/edit/archive/search documents and view reports/history.
- **Requesting User:** read-only access to the document list and document details.

## 7. Notes
- Laravel's actual home page is `resources/views/dashboard.blade.php`; `public/index.html` is a static HTML reference page only.
- Document attachments are stored under `storage/app/public/documents`. Use `php artisan storage:link` so they can be accessed through `public/storage`.
- The system stores document information and optional digital copies. It does not physically store paper documents, automatically approve records, or connect to external school systems, matching the limitations in the proposal.
- The migration files create the MySQL tables. `database/docuarch_schema.sql` is also included as a reference schema; use migrations as the normal setup method, not both.
