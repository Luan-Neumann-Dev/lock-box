# LOCK BOX

> A web app for storing personal notes with end-to-end double-layer encryption — your notes are never exposed without your password.

[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![DaisyUI](https://img.shields.io/badge/DaisyUI-FF9903?style=for-the-badge&logo=daisyui&logoColor=white)](https://daisyui.com/)

![Project Preview](https://github.com/user-attachments/assets/8a3f1a9d-7618-419f-b3e6-6cd1ea2bde8f)
![Project Preview](https://github.com/user-attachments/assets/8620a383-ecf9-4024-a424-2a2a6184fa7c)
![Project Preview](https://github.com/user-attachments/assets/d66730b2-775f-4f69-9867-42d50ef8c945)
![Project Preview](https://github.com/user-attachments/assets/c6b808d2-0f83-488f-9b9d-2187999b7557)

---

## 🎯 About

**LockBox** is a secure notes web application built with pure PHP, following the MVC pattern without relying on any framework. The project's core focus is **privacy**: every note is encrypted with a double layer (AES-256-CBC + HMAC SHA3-512) before being saved to the database.

Note contents can only be viewed after the user re-confirms their account password, and remain masked with asterisks at all other times — even if someone gains direct access to the database, the data is unreadable without the encryption keys.

The project was built from scratch to solidify concepts around routing, middlewares, session management, and security in PHP without the help of frameworks like Laravel or Symfony.

## ✨ Key Features

- 🔐 **Double-layer encryption** — Notes ciphered with AES-256-CBC and authenticated via HMAC SHA3-512
- 👁️ **Password-gated viewing** — Content is only revealed after re-authentication at read time
- 📝 **Full notes CRUD** — Create, list, search, edit and delete notes
- 🔑 **User authentication** — Registration and login with secure password hashing
- 🛡️ **Route middlewares** — Clean separation between public (guest) and protected (auth) routes
- 🔍 **Title search** — Filter notes directly from the listing view

## 🛠️ Tech Stack

**Backend:**
- PHP 8.1+ — Application logic with MVC implemented from scratch
- SQLite — Lightweight database via PDO with prepared statements
- OpenSSL — AES-256-CBC note encryption
- Composer — PSR-4 autoloading

**Frontend:**
- TailwindCSS + DaisyUI — Styling and UI components
- PHP Views — Server-side rendering

**Tools:**
- Laravel Pint — Code style (dev)
- PHP Built-in Server — Local development

## 🚀 Quick Start

```bash
# Clone the repository
git clone https://github.com/yourusername/lock-box.git
cd lock-box

# Install dependencies
composer install

# Set up environment variables
cp .env.example .env
# Edit .env with your encryption keys

# Start the development server
php -S localhost:8000 -t public public/server.php
```

Open `http://localhost:8000`

## 📁 Project Structure

```
lock-box/
├── Core/                    # Custom mini-framework core
│   ├── Database.php        # PDO abstraction
│   ├── Route.php           # HTTP router
│   ├── Validacao.php       # Validation engine
│   ├── Session.php         # Session management
│   ├── Flash.php           # Flash messages
│   └── functions.php       # Global helpers (encrypt, decrypt, auth...)
│
├── app/
│   ├── Controllers/        # Controllers (Index, Login, Register, Notes/)
│   ├── Middlewares/        # AuthMiddleware and GuestMiddleware
│   └── Models/             # Note.php and User.php
│
├── config/
│   ├── config.php          # Database and security config
│   └── routes.php          # All route definitions
│
├── views/                  # PHP templates
│   ├── template/           # Base layouts (app and guest)
│   ├── partials/           # Reusable components (navbar, search)
│   └── notas/              # Notes CRUD views
│
├── database/
│   └── database.sqlite     # SQLite database
│
└── public/
    └── index.php           # Application entry point
```

## 💡 Technical Highlights

### Double-Layer Encryption

Notes are encrypted before any database write. The process uses AES-256-CBC for the primary cipher and HMAC SHA3-512 to guarantee data integrity — if a note is tampered with in the database, decryption fails silently.

```php
function encrypt($data) {
    $method = 'aes-256-cbc';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);
    $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, true);
    return base64_encode($iv . $second_encrypted . $first_encrypted);
}
```

### Framework-Free MVC Router

The routing system supports GET, POST, PUT and DELETE with fluent chaining and per-route middleware injection:

```php
(new Route)
    ->get('/notes', Notes\IndexController::class, AuthMiddleware::class)
    ->post('/notes/create', [Notes\CreateController::class, 'store'], AuthMiddleware::class)
    ->put('/note', Notes\UpdateController::class, AuthMiddleware::class)
    ->run();
```

### Re-authentication-Gated Viewing

Note content is masked by default — displayed as `***` preserving the actual text length. To reveal it, the user must confirm their password, which is verified via `password_verify()` and stored in a scoped session flag.

## 📚 What I Learned

**Technical Skills:**
- Building a mini MVC framework in pure PHP with routing, middlewares, and PSR-4 autoloading
- Symmetric encryption with AES-256-CBC and message authentication with HMAC
- Session management and route-level access control via middlewares
- PDO with prepared statements for SQL Injection prevention

**Best Practices:**
- Clean separation of concerns between Controllers, Models, and Views
- Environment variables to keep sensitive configuration out of source code
- Centralized, reusable validation engine with support for multiple rules per field

## 🗺️ Roadmap

- [ ] Support for additional databases (MySQL / PostgreSQL)
- [ ] Two-factor authentication (2FA)
- [ ] Encrypted note export
- [ ] REST API for mobile access
- [ ] Automated tests with PHPUnit

## 📝 Notes

- This is an **educational** project focused on PHP security and architecture
- Encryption keys must be securely generated and never committed — always use `.env`
- The included SQLite database is for demonstration purposes only

## 📄 License

MIT License — see [LICENSE](LICENSE) for details.

## 👤 Author
 
**Luan Neumann**

- LinkedIn: [luan-neumann-dev](https://www.linkedin.com/in/luan-neumann-dev/)
- GitHub: [@Luan-Neumann-Dev](https://github.com/Luan-Neumann-Dev)
 
---
 
⭐ Found this helpful? Give it a star!
