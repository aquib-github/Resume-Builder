# Resume Builder

A PHP-based web application that allows users to create, manage, and export professional resumes. Users can register, log in, build multiple resumes with personal details, education, experience, and skills, then preview, print, or download them as PDF.

---

## ✨ Features

- **User Authentication** — Register, login, logout, and password reset via email OTP
- **Resume CRUD** — Create, read, update, and delete resumes
- **Resume Sections** — Personal info, objective, experience, education, skills, and declaration
- **Clone Resume** — Duplicate an existing resume with one click
- **PDF Export** — Download resume as a PDF file
- **Print Support** — Print-optimized A4 layout
- **Customization** — Change resume background tiles and fonts
- **WhatsApp Sharing** — Share resume link directly via WhatsApp
- **Responsive Design** — Mobile-friendly with Bootstrap 5

---

## 🛠️ Tech Stack

| Layer      | Technology                          |
|------------|-------------------------------------|
| Frontend   | HTML5, CSS3, Bootstrap 5, jQuery    |
| Backend    | PHP 8.x                            |
| Database   | MySQL / MariaDB                     |
| Email      | PHPMailer (SMTP via Gmail)          |
| PDF        | jsPDF + html2canvas                |
| Server     | Apache (XAMPP)                      |

---

## 📁 Folder Structure

```
resumebuilder/
├── actions/                    # Backend action handlers (form processing)
│   ├── addeducation.action.php
│   ├── addexperience.action.php
│   ├── addskills.action.php
│   ├── changebackground.action.php
│   ├── changefont.action.php
│   ├── changepassword.action.php
│   ├── clonecv.action.php
│   ├── createresume.action.php
│   ├── deleteeducation.action.php
│   ├── deleteexperince.action.php
│   ├── deleteresume.action.php
│   ├── deleteskill.action.php
│   ├── login.action.php
│   ├── logout.action.php
│   ├── register.action.php
│   ├── sendcode.action.php
│   ├── updateprofile.action.php
│   ├── updateresume.action.php
│   └── verifyotp.action.php
├── assets/
│   ├── class/                  # Core PHP classes
│   │   ├── database.class.php  # Database connection (MySQLi)
│   │   └── function.class.php  # Helper functions (auth, session, etc.)
│   ├── images/                 # Static images
│   │   ├── logo.png
│   │   └── tiles/              # Background tile patterns
│   ├── includes/               # Shared page components
│   │   ├── header.php
│   │   ├── navbar.php
│   │   └── footer.php
│   └── packages/
│       └── phpmailer/          # PHPMailer library
├── account.php                 # User profile/account page
├── change-password.php         # Change password page
├── createresume.php            # Create new resume form
├── forgot-password.php         # Forgot password page
├── login.php                   # Login page
├── myresumes.php               # Dashboard — list all resumes
├── register.php                # Registration page
├── resume.php                  # Resume preview/print/download
├── resumebuilder.sql           # Database schema (clean, no data)
├── updateresume.php            # Edit resume with sections
├── verification.php            # OTP verification page
└── README.md
```

---

## 🚀 Installation (XAMPP)

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) with PHP 8.x and MySQL/MariaDB
- A Gmail account with [App Password](https://support.google.com/accounts/answer/185833) for SMTP (for password reset emails)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/resumebuilder.git
   ```

2. **Move to XAMPP htdocs**
   ```bash
   # Copy or move the project folder to:
   C:\xampp\htdocs\resumebuilder
   ```

3. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

4. **Create the database**
   - Open [phpMyAdmin](http://localhost/phpmyadmin)
   - Import the `resumebuilder.sql` file:
     - Click **Import** tab → Choose `resumebuilder.sql` → Click **Go**
   - This creates the `resumebuilder` database with all required tables

5. **Configure database connection** (if needed)
   - Edit `assets/class/database.class.php`
   - Update host, username, password, and database name if different from defaults

6. **Configure email (for password reset)**
   - Edit `actions/sendcode.action.php`
   - Update the SMTP username and app password with your own Gmail credentials

7. **Open in browser**
   ```
   http://localhost/resumebuilder/login.php
   ```

---

## 📸 Screenshots

| Page | Screenshot |
|------|-----------|
| Login | ![Login Page](screenshots/login.png) |
| Dashboard | ![Dashboard](screenshots/dashboard.png) |
| Create Resume | ![Create Resume](screenshots/create.png) |
| Resume Preview | ![Resume Preview](screenshots/preview.png) |

> **Note:** Add your own screenshots to a `screenshots/` folder in the project root.

---

## 🔐 Security Features

- **Prepared Statements** — All database queries use parameterized queries to prevent SQL injection
- **XSS Protection** — All user-generated output is escaped with `htmlspecialchars()`
- **Session Security** — Session regeneration on login, proper session cleanup on logout
- **Ownership Verification** — All CRUD operations verify the logged-in user owns the resource
- **Input Validation** — Server-side validation on all form submissions
- **Whitelisted Values** — Font and background changes are validated against allowed lists

---

## 🔮 Future Improvements

- [ ] Replace MD5 password hashing with `password_hash()` / `password_verify()` (bcrypt)
- [ ] Add CSRF token protection on all forms
- [ ] Support multiple resume templates/themes
- [ ] Add profile photo upload
- [ ] Implement rate limiting on login and OTP endpoints
- [ ] Add admin panel for user management
- [ ] Support multi-language resumes
- [ ] Move SMTP credentials to a `.env` configuration file
- [ ] Add resume sharing via public URL with privacy controls

---

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to open an issue or submit a pull request.
