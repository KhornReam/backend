# 🎓 StudentHub — Student Management System

A modern, full-stack Student Management System designed to help schools and training centers manage student information, classes, attendance, grades, and academic performance efficiently.

Built with **Vue 3, Laravel, and MySQL**, this project demonstrates practical full-stack development, REST API integration, database design, and software engineering principles.

## 📌 Project Overview

StudentHub provides a centralized platform for managing academic information through a clean, responsive, and user-friendly interface.

### 🎯 Objectives

- Simplify student information management.
- Manage classes, subjects, and teacher assignments.
- Track student attendance and academic performance.
- Provide dashboards and academic reports.
- Implement secure authentication and role-based access control.
- Apply clean architecture and maintainable coding practices.

## ✨ Features

### 📊 Dashboard
- Total student statistics
- Class and subject summaries
- Attendance overview
- Academic performance charts
- Recent activity

### 👨‍🎓 Student Management
- Create, view, update, and delete student records
- Generate unique student IDs
- Search, filter, sort, and paginate students
- Manage student profiles and enrollment information

### 🏫 Academic Management
- Class management
- Subject management
- Teacher assignments
- Student enrollment

### 📅 Attendance Management
- Record daily attendance
- Track Present, Absent, Late, and Excused statuses
- Calculate attendance percentages
- Filter attendance by student, class, and date

### 📝 Grade Management
- Manage assessments and scores
- Calculate weighted averages
- Track student performance
- Generate academic reports

### 🔐 Authentication and Authorization
- Secure login and logout
- Role-based access control
- Admin, Teacher, and Student roles
- Protected routes and API endpoints

> **Note:** Features are planned for implementation in phases. Update this section as each feature is completed and tested.

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| Vue 3 | Frontend framework |
| Vite | Frontend development and build tool |
| JavaScript | Frontend programming |
| Vue Router | Client-side routing |
| Pinia | State management |
| Axios | HTTP requests to the API |
| Laravel | Backend framework |
| PHP | Backend programming |
| MySQL | Relational database |
| Laravel Sanctum | API authentication, where appropriate |
| Bootstrap 5 / CSS | Responsive user interface |
| Chart.js | Dashboard charts |
| Git & GitHub | Version control |

## 🏗️ System Architecture

```text
┌──────────────────────────────────┐
│         Vue 3 Frontend           │
│                                  │
│ Pages · Components · Router      │
│ Pinia · Axios · UI               │
└────────────────┬─────────────────┘
                 │
          HTTP / JSON API
                 │
┌────────────────▼─────────────────┐
│        Laravel Backend           │
│                                  │
│ Routes · Controllers             │
│ Validation · Services · Models   │
│ Authentication · Authorization   │
└────────────────┬─────────────────┘
                 │
             Eloquent ORM
                 │
┌────────────────▼─────────────────┐
│           MySQL                  │
│                                  │
│ Users · Students · Classes       │
│ Subjects · Attendance · Grades   │
└──────────────────────────────────┘
```

## 📁 Project Structure

```text
studenthub/
├── frontend/
│   └── src/
│       ├── assets/
│       ├── components/
│       ├── composables/
│       ├── layouts/
│       ├── pages/
│       ├── router/
│       ├── services/
│       ├── stores/
│       ├── utils/
│       ├── App.vue
│       └── main.js
│
├── backend/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Requests/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   ├── Policies/
│   │   └── Services/
│   ├── database/
│   │   ├── migrations/
│   │   ├── factories/
│   │   └── seeders/
│   ├── routes/
│   ├── tests/
│   └── composer.json
│
├── docs/
│   ├── architecture.md
│   └── api-documentation.md
│
├── .gitignore
└── README.md
```

## ⚙️ Installation and Setup

### Prerequisites

Install the following tools before starting:

- [Node.js](https://nodejs.org/)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/downloads/)
- [Git](https://git-scm.com/)
- [Postman](https://www.postman.com/) for API testing

### 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/studenthub.git
cd studenthub
```

Replace `YOUR_USERNAME` with your GitHub username and adjust the repository URL to match your actual repository.

### 2. Configure the Backend

```bash
cd backend
composer install
```

Create the environment file:

**Windows Command Prompt:**
```cmd
copy .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Update the database settings in `backend/.env`:

```env
APP_NAME=StudentHub
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studenthub
DB_USERNAME=root
DB_PASSWORD=
```

Use your actual MySQL username and password. Do not commit `.env` to GitHub.

Create the `studenthub` database in MySQL, then run:

```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Run the seeder command after creating the required seeders. If seeders are not ready yet, skip `php artisan db:seed`.

The Laravel API will normally be available at:

`http://127.0.0.1:8000`

### 3. Configure the Frontend

Open a second terminal:

```bash
cd frontend
npm install
npm run dev
```

Configure the frontend API base URL in your Axios configuration, for example:

```javascript
// frontend/src/services/api.js

import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

export default api;
```

Adjust the base URL to match the API routes and authentication setup you implement.

The frontend development server will display its local URL in the terminal, usually:

`http://localhost:5173`

## 🔌 API Endpoints

The following endpoints are planned examples for the versioned REST API.

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/students` | Retrieve students |
| POST | `/api/v1/students` | Create a student |
| GET | `/api/v1/students/{id}` | Retrieve a student |
| PUT | `/api/v1/students/{id}` | Update a student |
| DELETE | `/api/v1/students/{id}` | Delete a student |
| GET | `/api/v1/classes` | Retrieve classes |
| GET | `/api/v1/subjects` | Retrieve subjects |
| GET | `/api/v1/attendance` | Retrieve attendance records |
| GET | `/api/v1/grades` | Retrieve grade records |

These endpoints must be implemented in Laravel before they can be used.

## 🗄️ Database Design

The planned database includes the following entities:

- `users` — authentication and user roles
- `students` — student profile information
- `teachers` — teacher profiles
- `classes` — class information
- `subjects` — subject information
- `enrollments` — student enrollment records
- `class_subjects` — class, subject, and teacher assignments
- `attendance_sessions` — attendance sessions
- `attendances` — individual attendance records
- `assessments` — assessment definitions
- `grades` — student assessment scores
- `activity_logs` — important system activities

Use foreign keys, unique constraints, indexes, and appropriate relationships to maintain data integrity.

## 🧪 Testing

Use the following commands from the backend directory:

```bash
php artisan test
```

Build the frontend for production:

```bash
cd frontend
npm run build
```

Test API requests using Postman and verify that validation, authentication, permissions, and database operations behave correctly.

## 🔒 Security

- Store secrets and credentials in environment variables.
- Validate all incoming data on the backend.
- Enforce role-based authorization for protected operations.
- Use secure password hashing.
- Restrict access to private student information.
- Validate uploaded files and limit their allowed types and sizes.
- Never expose production credentials or sensitive student data in source control.

## 🚀 Development Roadmap

- [ ] Phase 1 — Requirements and system architecture
- [ ] Phase 2 — Database schema and migrations
- [ ] Phase 3 — Authentication and authorization
- [ ] Phase 4 — Student CRUD and API integration
- [ ] Phase 5 — Classes, subjects, and enrollments
- [ ] Phase 6 — Attendance management
- [ ] Phase