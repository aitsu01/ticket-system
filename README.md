<h1 align="center">Ticket System</h1>

<p align="center">
  A full-stack ticket management system built with <strong>Laravel</strong>, <strong>Vue 3</strong>, and <strong>Tailwind CSS</strong>.
</p>

<p align="center">
  This project showcases a modern SaaS-style application with authentication, role-based access control, Google OAuth login, and a clean user interface.
</p>

<hr>

<h2>Overview</h2>

<p>
  The application allows users to create, manage, and track support tickets through a modern single-page interface.
</p>

<p>It includes:</p>

<ul>
  <li>Secure authentication (classic + Google OAuth)</li>
  <li>Role-based access control (RBAC)</li>
  <li>Ticket lifecycle management</li>
  <li>Dashboard analytics</li>
  <li>Account management</li>
</ul>

<hr>

<h2>Main Features</h2>

<h3>Authentication</h3>
<ul>
  <li>Register / Login / Logout</li>
  <li>Password reset via email</li>
  <li>Email verification</li>
  <li>Google OAuth login with Socialite</li>
  <li>Automatic logout on password change</li>
</ul>

<h3>Roles &amp; Permissions</h3>
<ul>
  <li><code>admin</code> — full access to users and tickets</li>
  <li><code>agent</code> — manage assigned tickets</li>
  <li><code>user</code> — create and track personal tickets</li>
</ul>

<h3>Tickets</h3>
<ul>
  <li>Create, view, update, and delete tickets</li>
  <li>Assign tickets to agents</li>
  <li>Change ticket status</li>
  <li>Filter tickets by status, assignment, and ownership</li>
  <li>Search functionality</li>
</ul>

<h3>Comments</h3>
<ul>
  <li>Add comments to tickets</li>
  <li>Comments disabled for closed or resolved tickets</li>
</ul>

<h3>Dashboard</h3>
<ul>
  <li>Ticket statistics overview</li>
  <li>Role-based data access</li>
</ul>

<h3>Account Settings</h3>
<ul>
  <li>Change password with validation and email notification</li>
  <li>Change email with re-verification flow</li>
  <li>Password strength indicator</li>
</ul>

<h3>OAuth</h3>
<ul>
  <li>Login and registration with Google</li>
  <li>Seamless SPA authentication flow</li>
</ul>

<h3>UI / UX</h3>
<ul>
  <li>Responsive design with Tailwind CSS</li>
  <li>Clean SPA navigation</li>
  <li>Modern SaaS-style interface</li>
</ul>

<hr>

<h2>Tech Stack</h2>

<h3>Backend</h3>
<ul>
  <li>Laravel</li>
  <li>Laravel Sanctum (API Authentication)</li>
  <li>Laravel Socialite (Google OAuth)</li>
  <li>MySQL</li>
</ul>

<h3>Frontend</h3>
<ul>
  <li>Vue 3 (Composition API)</li>
  <li>Vue Router</li>
  <li>Axios</li>
  <li>Tailwind CSS</li>
</ul>

<hr>

<h2>Project Structure</h2>

<pre><code>ticket-system/
├── backend/     # Laravel API
└── frontend/    # Vue SPA
</code></pre>

<hr>

<h2>Installation</h2>

<h3>1. Clone the repository</h3>

<pre><code>git clone https://github.com/aitsu01/ticket-system.git
cd ticket-system
</code></pre>

<h3>2. Backend setup</h3>

<pre><code>cd backend
composer install
cp .env.example .env
php artisan key:generate
</code></pre>

<p>Configure your <code>.env</code> file with:</p>

<ul>
  <li>Database credentials</li>
  <li>Mail configuration</li>
  <li>Google OAuth credentials</li>
</ul>

<h3>Google OAuth Setup</h3>

<p>Add the following variables to your <code>.env</code> file:</p>

<pre><code>GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/v1/auth/google/callback
</code></pre>

<p>Run the backend:</p>

<pre><code>php artisan migrate
php artisan db:seed
php artisan serve
</code></pre>

<p>Backend runs on:</p>

<pre><code>http://127.0.0.1:8000
</code></pre>

<h3>3. Frontend setup</h3>

<pre><code>cd frontend
npm install
npm run dev
</code></pre>

<p>Frontend runs on:</p>

<pre><code>http://localhost:5173
</code></pre>

<hr>

- Audit log system (user activity tracking)
- Google OAuth login (Socialite)

##  Audit Log System

The application includes a full audit logging system that tracks user activity:

- Login (email and Google OAuth)
- Logout
- Failed login attempts
- Account registration
- Admin actions (role updates, user management)

Each log stores:
- User info (name + email)
- IP address
- User agent
- Metadata (login method, etc.)

This feature improves security, debugging, and system monitoring.

<h2>API Overview</h2>

<h3>Auth</h3>
<ul>
  <li><code>POST /register</code></li>
  <li><code>POST /login</code></li>
  <li><code>POST /logout</code></li>
  <li><code>GET /me</code></li>
</ul>

<h3>OAuth</h3>
<ul>
  <li><code>GET /auth/google/redirect</code></li>
  <li><code>GET /auth/google/callback</code></li>
</ul>

<h3>Password</h3>
<ul>
  <li><code>POST /forgot-password</code></li>
  <li><code>POST /reset-password</code></li>
</ul>

<h3>Tickets</h3>
<ul>
  <li><code>GET /tickets</code></li>
  <li><code>POST /tickets</code></li>
  <li><code>GET /tickets/{id}</code></li>
  <li><code>DELETE /tickets/{id}</code></li>
  <li><code>PATCH /tickets/{id}/status</code></li>
  <li><code>PATCH /tickets/{id}/assign</code></li>
</ul>

<h3>Comments</h3>
<ul>
  <li><code>POST /tickets/{id}/comments</code></li>
</ul>

<h3>Dashboard</h3>
<ul>
  <li><code>GET /dashboard</code></li>
</ul>

<h3>Users (Admin)</h3>
<ul>
  <li><code>GET /users</code></li>
  <li><code>PATCH /users/{id}/role</code></li>
  <li><code>PATCH /users/{id}/toggle-active</code></li>
</ul>

<hr>

<h2>What I Practiced</h2>

<ul>
  <li>Building REST APIs with Laravel</li>
  <li>Authentication with Sanctum and OAuth</li>
  <li>Role-based access control (RBAC)</li>
  <li>SPA architecture with Vue 3</li>
  <li>State management and API handling</li>
  <li>Form validation and UX improvements</li>
  <li>Secure account management flows</li>
</ul>