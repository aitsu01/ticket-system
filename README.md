#  Ticket System (Laravel + Vue + Tailwind)

A full-stack helpdesk ticketing system built with **Laravel (API)** and **Vue 3 (SPA)**.

---

##  Features

###  Authentication

* Register / Login (Laravel Sanctum)
* Email verification
* Password reset (email flow)

---

###  Ticket Management

* Create, view, update tickets
* Unique ticket number (#ID)
* Status workflow:

  * Open
  * In Progress
  * Resolved
  * Closed
* Priority levels

---

###  Comments

* Add comments to tickets
* Author displayed for each comment
* Disabled when ticket is closed/resolved

---

###  Agent Assignment

* Assign tickets via dropdown (real users)
* Display assigned agent
* Assignment locked for closed/resolved tickets

---

###  Authorization

* Admin-only ticket deletion
* Role-based access control
* Backend protected routes

---

###  Dashboard API

* Total tickets
* Status breakdown
* Tickets per agent

---

###  Advanced Search & Filters

* Search by:

  * Title
  * Description
  * Ticket number (#ID)
* Filters:

  * Status
  * My tickets
  * Assigned to me
* Backend-powered filtering (scalable)

---

##  Tech Stack

### Backend

* Laravel 13
* Sanctum (API Auth)
* Eloquent ORM
* API Resources

### Frontend

* Vue 3 (Composition API)
* Vue Router
* Axios
* TailwindCSS

---

##  Architecture

* REST API (Laravel)
* SPA Frontend (Vue)
* Clean separation of concerns
* Scalable backend filtering

---

##  UI Highlights

* Dashboard with stats
* Ticket list with filters
* Ticket detail view (comments, status, assignment)
* Clean and responsive design

---

##  Installation

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

### Frontend

```bash
cd frontend
npm install
npm run dev
```

---

##  Environment

Configure `.env`:

```env
DB_DATABASE=ticket_system
MAIL_MAILER=smtp
QUEUE_CONNECTION=database
```

---

##  Roadmap

* Pagination
* Debounced search
* Notifications UI
* Roles & permissions system
* File attachments

---

##  Author

Gianni

---

##  Notes

This project simulates a real-world helpdesk system with production-like architecture and scalable backend logic.


