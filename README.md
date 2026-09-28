# Certificate System — Backend (PHP + MySQL)

This is a standalone PHP + MySQL backend for the Certificate System. It is **not yet connected**
to the frontend HTML file — this just gets the server + database ready. You can connect the
frontend to it later (each button in the app would need to call these endpoints with `fetch()`
instead of using the browser's local storage).

## Folder contents

```
backend/
  config.php          <- database connection settings
  database.sql         <- run this once to create the database + tables
  api/
    auth.php            <- POST login (username + password)
    students.php         <- GET/POST/PUT/DELETE students
    reports.php           <- GET/POST/DELETE certificate issue log
    users.php              <- GET/POST/PUT/DELETE login accounts
    settings.php            <- GET/POST institution settings
```

## Where things live now

- **The app itself:** `http://localhost/cert-backend/` — this now opens the actual Certificate System page directly, already connected to MySQL. Bookmark this URL.
- **Status/diagnostics page:** `http://localhost/cert-backend/status.php` — shows if the database is connected and how many rows are in each table. Useful for troubleshooting, not for daily use.

## Setup in XAMPP (step by step)

1. **Start XAMPP.** Open the XAMPP Control Panel and click **Start** next to both **Apache** and **MySQL**.

2. **Copy this folder into htdocs.**
   Copy the whole `backend` folder into:
   `C:\xampp\htdocs\`
   You can rename it if you like, e.g. `C:\xampp\htdocs\cert-backend`.

3. **Create the database.**
   - Open your browser and go to: `http://localhost/phpmyadmin`
   - Click **Import** (top menu)
   - Click **Choose File**, select `database.sql` from this folder
   - Click **Go** at the bottom
   - This creates a database called `cert_system` with all 4 tables, and adds the default
     admin/staff logins and default college settings.

4. **Check the database connection.**
   `config.php` is already set up for a fresh XAMPP install (username `root`, no password).
   If your MySQL root user has a password, open `config.php` and change this line:
   ```php
   $db_pass = '';   // put your MySQL root password here if you have one
   ```

5. **Test it's working.**
   With Apache + MySQL running, open in your browser:
   ```
   http://localhost/cert-backend/
   ```
   This should open the Certificate System app itself. Log in with admin/admin123 (or staff/staff123)
   and check the green dot next to your name in the sidebar — that means it's connected to MySQL.

## API reference

| Endpoint | Method | What it does |
|---|---|---|
| `/api/auth.php` | POST | Login. Body: `{"username":"admin","password":"admin123"}` |
| `/api/students.php` | GET | List all students |
| `/api/students.php?id=xxx` | GET | Get one student |
| `/api/students.php` | POST | Create a student (JSON body) |
| `/api/students.php?id=xxx` | PUT | Update a student (JSON body) |
| `/api/students.php?id=xxx` | DELETE | Delete a student |
| `/api/reports.php` | GET | List all issued certificates |
| `/api/reports.php` | POST | Log a new certificate issue (JSON body) |
| `/api/reports.php?id=xxx` | DELETE | Delete a report entry |
| `/api/users.php` | GET | List all login accounts (no passwords shown) |
| `/api/users.php` | POST | Create a login account |
| `/api/users.php?username=x` | PUT | Update a login account |
| `/api/users.php?username=x` | DELETE | Delete a login account |
| `/api/settings.php` | GET | Get institution settings |
| `/api/settings.php` | POST | Update institution settings |

## Default logins (from database.sql)

| Username | Password | Role |
|---|---|---|
| admin | admin123 | admin |
| staff | staff123 | staff |

⚠ Change these before real use — passwords are stored as plain text in this starter version.
For production use, passwords should be hashed (e.g. with PHP's `password_hash()`), which can
be added when you're ready to connect this to the live app.

## Connecting the frontend later

Right now the HTML file stores everything in the browser (localStorage/IndexedDB). To switch it
to use this backend instead, each place that reads/writes `students`, `reports`, `users`, or
`settings` in the app's JavaScript would be changed to call these API endpoints with `fetch()`
instead. Just say the word when you're ready and this can be wired up.
