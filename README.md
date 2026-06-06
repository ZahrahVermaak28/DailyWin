# Taskie AZU

A Laravel 12 task management system built with Laravel Breeze, Blade, MySQL, and Tailwind CSS. The app supports admin, team member, and guest roles with task CRUD, assignment, categories, dashboard statistics, and email reminders for tasks due in 24 hours.

## Technologies

- Laravel 12
- Laravel Breeze Blade stack
- MySQL
- Tailwind CSS
- Blade components

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create a MySQL database named `taskie`, then confirm these `.env` values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskie
DB_USERNAME=root
DB_PASSWORD=
```

Run the database and frontend setup:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

## Admin Login

- Email: `admin@example.com`
- Password: `password`

## Roles And Permissions

- Admin: full task access, can assign tasks to other users, can manage categories, and can open the admin area.
- Team Member: can create tasks for themselves, view assigned tasks, and update/delete tasks they created or were assigned.
- Guest: authenticated read/no-management role. Guests cannot access task management routes.

## Main Features

- Registration and login with role selection
- Task CRUD with `status`, `priority`, and `due_date`
- Admin-only task assignment to users
- Many-to-many categories through `category_task`
- Dashboard statistics by status, priority, and due date
- Admin area with tasks, users, and category management
- Scheduled reminder command: `php artisan tasks:send-reminders-azu`

## Database Schema

- users: `id`, `name`, `email`, `password`, `role`, timestamps
- tasks: `id`, `title`, `description`, `status`, `priority`, `due_date`, `created_by`, `assigned_to`, timestamps
- categories: `id`, `name`, `slug`, timestamps
- category_task: `id`, `category_id`, `task_id`, timestamps

Relationships:

- A user has many created tasks through `created_by`.
- A user has many assigned tasks through `assigned_to`.
- A task belongs to a creator and optionally an assignee.
- Tasks and categories are many-to-many through `category_task`.

## Template Source

The interface uses the Laravel Breeze Blade/Tailwind starter views as the base template. No external admin template was copied.

## Mail Reminders

For local development, set Mailtrap or log mail values in `.env`. The scheduled command finds incomplete tasks due tomorrow and sends the assigned user a reminder. Add this cron entry on a deployed server:

```bash
* * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```

## Known Issues

- The current XAMPP PHP CLI in this environment is PHP 8.2.12. The installed Pest/PHPUnit dependency uses PHP 8.3 typed class constants, so `php artisan test` requires PHP 8.3+ or compatible dev dependency versions.
