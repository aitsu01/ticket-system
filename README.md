<h1 align="center"> Ticket System</h1>

<p align="center">
  Full-stack ticket management system built with Laravel, Vue 3 and Tailwind CSS
</p>

<p align="center">
  <strong> Portfolio Project • SaaS-ready Architecture • RBAC • Audit Logs • OAuth</strong>
</p>

<hr/>

<h2> Overview</h2>

<p>
A modern ticket management system that allows users to create, manage, and track support tickets.
The application includes authentication, role-based access control, audit logs, and Google OAuth login.
</p>

---

<h2> Features</h2>

<h3> Authentication</h3>
<ul>
  <li>Register / Login / Logout</li>
  <li>Password reset via email</li>
  <li>Email verification</li>
  <li>Google OAuth login</li>
  <li>Automatic logout on password change</li>
</ul>

<h3> Roles & Permissions (RBAC)</h3>
<ul>
  <li><strong>Admin</strong> → full system control</li>
  <li><strong>Agent</strong> → manage assigned tickets</li>
  <li><strong>User</strong> → create and track tickets</li>
</ul>

<h3> Ticket System</h3>
<ul>
  <li>Create, update, delete tickets</li>
  <li>Assign tickets to agents</li>
  <li>Change ticket status</li>
  <li>Search & filter tickets</li>
</ul>

<h3> Comments</h3>
<ul>
  <li>Add comments to tickets</li>
  <li>Auto-disable on closed tickets</li>
</ul>

<h3> Dashboard</h3>
<ul>
  <li>Ticket statistics</li>
  <li>Role-based data access</li>
</ul>

<h3>⚙️ Account Settings</h3>
<ul>
  <li>Change password (with validation)</li>
  <li>Change email (with re-verification)</li>
  <li>Password strength indicator</li>
</ul>

<h3> Audit Log System</h3>
<ul>
  <li>Track login (email & Google)</li>
  <li>Track logout</li>
  <li>Track failed login attempts</li>
  <li>Track admin actions</li>
  <li>Store IP, user agent and metadata</li>
</ul>

---

<h2> Tech Stack</h2>

<h3>Backend</h3>
<ul>
  <li>Laravel</li>
  <li>Laravel Sanctum</li>
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

---

<h2>📁 Project Structure</h2>

<pre>
ticket-system/
├── backend/     # Laravel API
└── frontend/    # Vue SPA
</pre>

---

<h2>⚙️ Installation</h2>

<h3>1. Clone repository</h3>

<pre>
git clone https://github.com/aitsu01/ticket-system.git
cd ticket-system
</pre>

---

<h3>2. Backend setup</h3>

<pre>
cd backend
composer install
cp .env.example .env
php artisan key:generate
</pre>

<p>Configure your <code>.env</code> (DB + MAIL + GOOGLE)</p>

<pre>
php artisan migrate
php artisan db:seed
php artisan serve
</pre>

<p><strong>Backend:</strong> http://127.0.0.1:8000</p>

---

<h3>3. Frontend setup</h3>

<pre>
cd frontend
npm install
npm run dev
</pre>

<p><strong>Frontend:</strong> http://localhost:5173</p>

---

<h2> Google OAuth Setup</h2>

<p>Configure in <code>.env</code>:</p>

<pre>
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/v1/auth/google/callback
</pre>

---

<h2> API Overview</h2>

<ul>
  <li>POST /register</li>
  <li>POST /login</li>
  <li>POST /logout</li>
  <li>GET /me</li>
  <li>GET /audit-logs</li>
  <li>GET /tickets</li>
  <li>PATCH /tickets/{id}/status</li>
  <li>PATCH /users/{id}/role</li>
</ul>

---

<h2> What I Practiced</h2>

<ul>
  <li>REST API design with Laravel</li>
  <li>Authentication with Sanctum & OAuth</li>
  <li>Role-based access control</li>
  <li>SPA architecture with Vue</li>
  <li>Advanced UI with Tailwind</li>
  <li>Security and audit logging</li>
</ul>

---

<h2> Current Limitations</h2>

<ul>
  <li>No automated tests</li>
  <li>Pagination improvements needed</li>
  <li>Notifications not implemented</li>
  <li>Some configs still hardcoded</li>
</ul>

---

<h2> Future Improvements</h2>

<ul>
  <li>Notifications system</li>
  <li>Audit log filters & analytics</li>
  <li>User avatars (Google integration)</li>
  <li>Dark mode</li>
  <li>Security alerts</li>
</ul>

---

<h2 align="center"> Author</h2>

<p align="center">
Portfolio project built to demonstrate full-stack development skills using Laravel and Vue.
</p>