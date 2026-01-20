# Volunteer Event Management API

REST API sederhana untuk sistem Volunteer Event Management menggunakan Laravel dan Laravel Sanctum.

---

## Tech Stack
- Laravel 12
- Laravel Sanctum (Token Authentication)
- MySQL / SQLite
- REST API (JSON)

---

## ⚙️ Cara Install

1. Clone repository
```bash
git clone <repository-url>
cd restApi
```
2. Install dependency
```bash
composer install
```
3. Copy file environment
```bash
cp .env.example .env
```
4. Generate application key
```bash
php artisan key:generate
```
5. Konfigurasi database di file
```bash
DB_DATABASE=rest_api
DB_USERNAME=root
DB_PASSWORD=
```
6. Konfigurasi database di file .env
```bash
php artisan migrate
```
## 🔐 Authentication
### API menggunakan Laravel Sanctum (Token Based Authentication).
Setelah login berhasil, token harus dikirim pada header:
```bash
Authorization: Bearer {token}
Accept: application/json
```
---

## 📌 Daftar Endpoint API
### 🔑 Authentication
| Method | Endpoint      | Deskripsi          |
| ------ | ------------- | ------------------ |
| POST   | /api/register | Register user      |
| POST   | /api/login    | Login user         |
| POST   | /api/logout   | Logout user (auth) |

### 📅 Event (Public)
| Method | Endpoint         | Deskripsi               |
| ------ | ---------------- | ----------------------- |
| GET    | /api/events      | List event (pagination) |
| GET    | /api/events/{id} | Detail event            |

### 📅 Event (Protected – Auth Required)
| Method | Endpoint              | Deskripsi    |
| ------ | --------------------- | ------------ |
| POST   | /api/events           | Create event |
| POST   | /api/events/{id}/join | Join event   |

## 📦 Contoh Request & Response
Login
```bash
{
  "email": "admin@gmail.com",
  "password": "password"
}
```
Response
```bash
{
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxx"
}
```
Create Event
```bash
{
  "title": "Beach Cleanup",
  "description": "Kegiatan bersih pantai",
  "event_date": "2026-02-01"
}
```
## Format Error Response
Validation Error
```bash
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "title": ["The title field is required."]
  }
}
```
Server Error
```bash
{
  "success": false,
  "message": "Internal server error"
}
```
---
## 🧠 Catatan Asumsi & Desain

- Endpoint **GET /api/events** dibuat **public** karena hanya digunakan untuk membaca data event dan tidak mengubah state sistem.

- Endpoint **create event** dan **join event** dilindungi menggunakan **Laravel Sanctum** untuk memastikan hanya user terautentikasi yang dapat melakukan aksi tersebut.

- Relasi antara **User** dan **Event** menggunakan **many-to-many relationship** dengan tabel pivot `event_user`.
- Sistem mencegah user untuk **join event yang sama lebih dari satu kali** dengan melakukan pengecekan data pada tabel pivot sebelum proses attach.

- API menggunakan **Laravel API Resource** dan **pagination** untuk menjaga konsistensi struktur response dan efisiensi pengambilan data.

- Seluruh error API diformat secara **konsisten** menggunakan **global exception handling** pada Laravel 12.
## 🧠 Jawaban Pertanyaan Wajib
### 1. Bagian tersulit dari assignment ini?

Menjaga konsistensi error response dan memastikan user tidak bisa join event yang sama lebih dari satu kali.

### 2. Jika diberi waktu 1 minggu, apa yang akan diperbaiki?

Menambahkan role management, policy authorization, dan unit testing.

### 3. Kenapa memilih pendekatan teknis ini?

Karena Sanctum ringan, cocok untuk SPA/mobile, dan desain API dipisahkan antara public dan protected agar mudah diintegrasikan dengan frontend.
