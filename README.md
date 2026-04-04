# 🎫 Ticket Management System

A modern full-stack helpdesk application built with **Laravel 13 + Vue 3**.

This project allows users to create, manage and track support tickets with a clean and intuitive UI.

---

##  Features

###  Authentication
- User registration with email verification
- Login with protected routes
- Password reset flow
- Resend verification email with cooldown (anti-spam)

###  User Experience
- Password strength meter
- Real-time validation
- Clean and responsive UI (Tailwind CSS)

###  Ticket Management
- Create, view and manage tickets
- Ticket number system (e.g. #123)
- Status management (open, in progress, resolved, closed)
- Assign tickets to agents
- Comment system with user tracking

###  Search & Filters
- Search by title, description or ticket number
- Filter by status
- "My tickets" and "Assigned to me" filters

###  Dashboard
- Ticket statistics
- Tickets grouped by status
- Tickets per agent

###  Landing Page
- Public home page
- Product description
- Login / Register CTA

---

##  Tech Stack

### Backend
- :contentReference[oaicite:0]{index=0} 13
- Sanctum (API authentication)
- MySQL

### Frontend
- :contentReference[oaicite:1]{index=1} 3 (Composition API)
- Vue Router
- Axios
- Tailwind CSS

---

## Installation

### 1. Clone repository

```bash
git clone https://github.com/your-username/ticket-system.git
cd ticket-system

2. Backend setup
cd backend
composer install
cp .env.example .env
php artisan key:generate

Configure your .env:

DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

Run migrations:

php artisan migrate

Start server:

php artisan serve
3. Frontend setup
cd frontend
npm install
npm run dev
 API Endpoints (Main)
Method	Endpoint	Description
POST	/api/v1/register	Register user
POST	/api/v1/login	Login
POST	/api/v1/resend-verification	Resend email
POST	/api/v1/forgot-password	Send reset link
POST	/api/v1/reset-password	Reset password
GET	/api/v1/tickets	List tickets
POST	/api/v1/tickets	Create ticket
 Project Structure
backend/
  app/
  routes/api.php

frontend/
  src/
    views/
    components/
    services/
 Future Improvements
Role & permission system (admin / agent / user)
Global layout (navbar/sidebar)
Real-time updates (WebSockets)
Charts in dashboard
Notifications system
 Author



License

This project is open-source and available under the MIT license.