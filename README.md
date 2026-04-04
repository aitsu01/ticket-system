# 🎫 Ticket System (Laravel + Vue + Tailwind)

A modern full-stack ticket management system built with **Laravel 13**, **Vue 3**, and **TailwindCSS**.

This project simulates a real-world helpdesk / support system with authentication, ticket lifecycle management, and a clean dashboard UI.

---

##  Tech Stack

### Backend

* Laravel 13 (API-first architecture)
* Laravel Sanctum (authentication)
* MySQL
* Queues & Notifications
* RESTful API with Resources

### Frontend

* Vue 3 (Composition API)
* Vue Router
* Axios (API client)
* TailwindCSS

---

##  Authentication System

Complete authentication flow implemented:

*  Register
*  Login
*  Logout
*  Email Verification
*  Resend Verification Email
*  Forgot Password
*  Reset Password
*  Auth Guard (frontend + backend)

---

##  Ticket System Features

### Core Features

* Create tickets
* View tickets list
* Ticket detail page
* Add comments to tickets
* Assign tickets to agents
* Change ticket status

### Business Rules

*  Cannot comment on `resolved` or `closed` tickets
*  Protected API routes with Sanctum
*  User-based ticket ownership

---

##  Dashboard

* Total tickets
* Tickets by status
* Tickets per agent

---

##  Comments System

* Linked to users
* Shows author name
* Real-time refresh after adding comment

---

##  Ticket Enhancements

* Ticket number (e.g. `#12`)
* Creation date
* Status color indicators

---

##  UI / UX

* Global layout (Navbar + Sidebar)
* Responsive dashboard layout
* Clean card-based UI
* Status color coding
* Improved navigation flow

---

##  API Structure

Base URL:

```bash
/api/v1
```

### Example Endpoints

```bash
POST   /register
POST   /login
POST   /logout
GET    /me

GET    /tickets
POST   /tickets
GET    /tickets/{id}

POST   /tickets/{id}/comments

PATCH  /tickets/{id}/status
PATCH  /tickets/{id}/assign

GET    /dashboard
```

---

##  Installation

### 1. Clone repo

```bash
git clone https://github.com/aitsu01/ticket-system.git
cd ticket-system
```

---

### 2. Backend setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Configure `.env`:

* Database
* Mail (SMTP - Gmail recommended)

---

### 3. Run migrations

```bash
php artisan migrate
```

---

### 4. Start backend

```bash
php artisan serve
```

---

### 5. Frontend setup

```bash
cd ../frontend
npm install
npm run dev
```

---

##  Mail Configuration (Example Gmail)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

---

##  Testing API

Example with curl:

```bash
curl -X GET http://127.0.0.1:8000/api/v1/tickets \
-H "Authorization: Bearer YOUR_TOKEN"
```

---

##  Architecture Notes

* API-first backend (no Blade)
* Vue SPA frontend
* Separation of concerns:

  * Controllers
  * Services
  * Resources
* Scalable structure for real-world apps

---

##  Future Improvements

*  Ticket search & filters
*  Role system (admin / agent / user)
*  Advanced dashboard analytics
*  Real-time notifications
*  File attachments
*  Threaded comments

---



##  Why Laravel + Vue + Tailwind?

This stack was chosen to balance:

*  Rapid backend development (Laravel)
*  Reactive frontend (Vue)
*  Fast UI styling (Tailwind)

It reflects a modern full-stack approach used in real SaaS products.

---

