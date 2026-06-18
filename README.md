# JAAN Network LMS - Backend Microservice 🚀

This repository contains the dedicated Laravel backend microservice for the JAAN Network Learning Management System (LMS). It is intentionally decoupled from the Flutter frontend to ensure scalability, security, and independent deployment.

## ✨ Core Features
* **Generic File Management:** Dynamically handles uploads for multiple file types (Profile Images, Course Videos, PDF Assignments) using a unified endpoint.
* **Storage Optimization:** Includes endpoints for secure file deletion to prevent orphaned files and server storage leaks.
* **REST API Architecture:** Lightweight, fast, and easy to integrate with any mobile or web frontend.

## 🛠 Tech Stack
* **Framework:** Laravel (PHP)
* **Storage:** Local VPS Public Storage (`/public/uploads`)
* **Routing:** API-centric routing (`routes/api.php`)

## 🚀 API Endpoints
* `POST /api/upload` - Uploads a file. Requires a `file` payload and a `folder_type` (e.g., 'profiles', 'videos'). Returns the generated `public_url`.
* `POST /api/delete` - Deletes a file from the server. Requires a JSON payload with `{"file_url": "..."}`.

## 💻 Local Development Setup
1. Clone the repository: `git clone https://github.com/subhashanasandakelum/JAAN-Network-LMS-Backend.git`
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure your local settings.
4. Generate app key: `php artisan key:generate`
5. Run the local development server:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000