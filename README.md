#  Ticket Management System (Help Desk)

A full-stack **Ticket Management System** designed with a scalable, event-driven architecture.
Built to simulate a real-world support platform used in SaaS applications.

---

##  Overview

This project provides a **RESTful API backend** for managing support tickets, including authentication, role-based access control, notifications, and analytics.

It follows modern backend best practices:

* Clean architecture
* Separation of concerns
* Async processing

---

##  Tech Stack

### Backend

* **Laravel 13** (API-first architecture)
* **Laravel Sanctum** (Token-based authentication)
* **MySQL**
* **Queue (Database driver)**
* Event-driven system (Events & Listeners)

### Frontend (in progress)

* Vue 3 (SPA)
* Vite
* Tailwind CSS

---

##  Authentication & Authorization

* Token-based authentication via Sanctum
* Role-based system:

  * **Admin** → full access
  * **Agent** → manage assigned tickets
  * **User** → manage own tickets

Authorization handled using **Laravel Policies**

---

##  Core Features

### Ticket Management

* Create, update, delete tickets
* Assign tickets to agents
* Change status:

  * open
  * in_progress
  * resolved
  * closed
* Priority system:

  * low, medium, high

---

### Comments System

* Threaded comments per ticket
* Linked to users
* Real-time updates via events

---

##  Architecture

### ✔ Service Layer

Business logic is decoupled from controllers for maintainability and scalability.

### ✔ Form Request Validation

Reusable and clean validation logic.

### ✔ API Resources

Consistent and frontend-friendly JSON responses.

### ✔ Policy-Based Authorization

Fine-grained access control per role and ownership.

---

##  Event-Driven System

Events are triggered on:

* Ticket assignment
* Status changes
* New comments

---

##  Notifications

* Implemented using Laravel Notifications
* Triggered via events
* Delivered asynchronously

---

##  Queue System

* Database-driven queue
* Background worker processing
* Non-blocking API responses

---

##  Dashboard API

### Endpoint

```http
GET /api/v1/dashboard
```

### Example Response

```json
{
  "total": 3,
  "open": 2,
  "in_progress": 0,
  "resolved": 1,
  "closed": 0,
  "by_agent": [
    {
      "agent": "Gianni",
      "count": 1
    }
  ]
}
```

---

##  API Endpoints

### Authentication

* `POST /api/v1/register`
* `POST /api/v1/login`
* `POST /api/v1/logout`
* `GET /api/v1/me`

### Tickets

* `GET /api/v1/tickets`
* `POST /api/v1/tickets`
* `GET /api/v1/tickets/{id}`
* `PUT /api/v1/tickets/{id}`
* `DELETE /api/v1/tickets/{id}`

### Comments

* `POST /api/v1/tickets/{ticket}/comments`

### Dashboard

* `GET /api/v1/dashboard`

---

## Installation

### 1. Clone repository

```bash
git clone https://github.com/aitsu01/ticket-system.git
cd ticket-system
```

---

### 2. Backend Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env`:

```env
DB_DATABASE=ticket_system
DB_USERNAME=root
DB_PASSWORD=
```

---

### 3. Database

```bash
php artisan migrate
```

---

### 4. Run server

```bash
php artisan serve
```

---

### 5. Run Queue Worker

```bash
php artisan queue:work
```

---

##  Testing Example

```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
-H "Content-Type: application/json" \
-d '{"email":"test@test.com","password":"123456"}'
```

---

##  Design Choices

* **Laravel** for robust backend and rapid development
* **Vue 3** for reactive and dynamic UI
* **Tailwind CSS** for fast and clean styling
* **Event + Queue architecture** for scalability

---

##  Future Improvements

* Frontend dashboard (Vue 3)
* Real email integration (SMTP)
* File attachments
* Advanced filtering & search
* Pagination
* Queue monitoring (Laravel Horizon)
* Docker setup

---

##  Author

Developed as a full-stack portfolio project to demonstrate modern backend architecture and scalable system design.

