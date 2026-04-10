# Ticket System

A full-stack ticket management system built with **Laravel**, **Vue 3**, and **Tailwind CSS**.

This project was created as a portfolio piece to showcase my ability to build a modern web application with authentication, role-based access, REST APIs, and a responsive frontend interface.

## Overview

The application allows users to create and manage support tickets through a clean and intuitive interface.  
It includes authentication, email verification, role-based access control, ticket assignment, comments, dashboards, and account settings.

## Main Features

- User registration, login, logout, and password reset
- Email verification
- Role-based access (`admin`, `agent`, `user`)
- Create, update, view, and delete tickets
- Assign tickets to agents
- Change ticket status
- Add comments to tickets
- Dashboard with ticket statistics
- Search and filter tickets
- User account settings
- Responsive UI built with Tailwind CSS

## Tech Stack

### Backend
- Laravel
- Laravel Sanctum
- MySQL

### Frontend
- Vue 3
- Vue Router
- Axios
- Tailwind CSS

## Project Structure

```text
ticket-system/
├── backend/     # Laravel API
└── frontend/    # Vue SPA

How It Works
The backend exposes a REST API built with Laravel.
The frontend is a Vue single-page application that consumes the API through Axios.
Authentication is handled with Laravel Sanctum.
Access to features is restricted based on the user role.
Installation
1. Clone the repository

git clone https://github.com/aitsu01/ticket-system.git
cd ticket-system

2. Backend setup

cd backend
composer install
cp .env.example .env
php artisan key:generate

Configure your .env file with your database and mail settings.

Then run:

php artisan migrate
php artisan db:seed
php artisan serve


The backend will usually run on:

http://127.0.0.1:8000


3. Frontend setup

Open a new terminal:

cd frontend
npm install
npm run dev


The frontend will usually run on:

http://localhost:5173

Environment Notes

Make sure the frontend and backend URLs match your local configuration.

Example:

Frontend: http://localhost:5173
Backend API: http://127.0.0.1:8000/api/v1

If needed, update your environment variables and frontend API configuration.

API Overview

Main API routes include:

POST /register
POST /login
POST /forgot-password
POST /reset-password
GET /email/verify/{id}/{hash}
GET /user
POST /logout
Tickets
GET /tickets
POST /tickets
GET /tickets/{id}
PUT /tickets/{id}
DELETE /tickets/{id}
PATCH /tickets/{id}/status
PATCH /tickets/{id}/assign
Comments
GET /tickets/{id}/comments
POST /tickets/{id}/comments
Dashboard
GET /dashboard
Users
GET /users
Demo Roles

The project supports three roles:

admin: manages users and tickets
agent: handles assigned tickets
user: creates and tracks personal tickets


What I Practiced In This Project

With this project I focused on improving my skills in:

Building REST APIs with Laravel
Managing authentication with Sanctum
Structuring a Vue frontend application
Handling role-based authorization
Creating reusable frontend services and components
Working with form validation and API resources
Designing responsive interfaces with Tailwind CSS
Current Limitations

This project is functional, but there are still some areas I would improve:

make authorization more consistent across all endpoints using policies
add more automated tests
improve pagination and filtering
connect notifications/events more fully
move all hardcoded local URLs to environment configuration
improve seed data for demo usage