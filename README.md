# Nusantara Tech — Sistem Informasi Akademik (SIA)

> **Tugas Administrasi Sistem** — Development Environment in a Box
>
> A fully Dockerized academic information system built with Laravel, MySQL, MinIO,
> Nginx, and phpMyAdmin. Designed to mimic **SIAMUB** (Sistem Informasi Akademik
> Mahasiswa Universitas Brawijaya), a real Indonesian university student portal.

---

## 1. Tech Stack

| Service    | Technology            | Version       |
|------------|-----------------------|---------------|
| App        | PHP + Laravel         | 8.2 / 11.x    |
| Web Server | Nginx (reverse proxy) | 1.25-alpine   |
| Database   | MySQL                 | 8.0           |
| Storage    | MinIO (S3-compatible) | latest        |
| DB GUI     | phpMyAdmin            | latest        |
| Frontend   | Blade + Tailwind CSS CDN + Alpine.js | —  |

---

## 2. Prerequisites

| Software         | Minimum Version |
|------------------|-----------------|
| Docker Engine    | 20.10+          |
| Docker Compose   | 2.0+            |
| Git              | any             |

Verify installation:
```bash
docker --version
docker compose version
```

---

## 3. Quick Start — Zero to Running

### 3.1 Clone and enter project

```bash
git clone <repo-url> nusantara-tech
cd nusantara-tech
```

### 3.2 Create environment file

```bash
cp .env.example .env
```

The `.env.example` contains placeholder values that work out of the box for local
development. No editing required unless you want custom credentials.

### 3.3 Build and start all services

```bash
docker compose up -d --build
```

This builds the custom PHP-FPM image and starts all 5 services in detached mode.

> **What happens:** Docker builds the `app` image (PHP 8.2 + Composer + extensions),
> pulls `mysql:8.0`, `nginx:1.25-alpine`, `minio/minio:latest`, and
> `phpmyadmin:latest`, then starts everything on a shared bridge network.

### 3.4 Generate application key

```bash
docker compose exec app php artisan key:generate
```

### 3.5 Run database migrations

```bash
docker compose exec app php artisan migrate
```

### 3.6 Configure MinIO bucket

```bash
docker compose exec minio mc alias set local http://localhost:9000 minioadmin minioadmin123
docker compose exec minio mc mb local/nusantara-uploads
docker compose exec minio mc anonymous set public local/nusantara-uploads
```

### 3.7 Seed test user (optional)

```bash
docker compose exec app php artisan db:seed
```

Creates a demo account: `andi@student.ac.id` / `password123`

### 3.8 Open the application

Visit **http://localhost** in your browser. You will be redirected to the login page.

---

## 4. Access Points

| Service         | URL                          | Default Credentials       | Notes                        |
|-----------------|------------------------------|---------------------------|------------------------------|
| **Web App**     | http://localhost             | Register to create account | Login page → Dashboard       |
| **MinIO Console** | http://localhost:9001      | `minioadmin` / `minioadmin123` | S3-compatible object storage UI |
| **phpMyAdmin**  | http://localhost:8080        | `nusantara_user` / `nusantara_pass` | MySQL database management |

> All credentials above are the **placeholder defaults** from `.env.example`.
> Change them in `.env` before deploying anywhere other than localhost.

---

## 5. Progres 1 — Laporan Minggu Pertama

### A. Pemilihan Tech-Stack

* Bahasa pemrograman atau *framework* apa yang Anda pilih untuk aplikasi CRUD Anda (misal: Node.js, Python/Flask, PHP)? Apa *base image* yang Anda gunakan dalam Dockerfile?  
  \- Untuk Bahasa pemrogaman yang kami gunakan adalah PHP dengan framework Laravel dan base image yang kami gunakan adalah `php:8.2-fpm-alpine`
* Database apa yang Anda gunakan (MySQL/PostgreSQL)? Mengapa memilih versi tersebut?  
  \- Database yang kami gunakan adalah MySQL versi 8.0 karena versi ini menawarkan fleksibilitas pengembangan modern sekaligus efisiensi tinggi saat dijalankan dalam ekosistem kontainer. Dukungan tipe data JSON yang jauh lebih optimal pada MySQL 8.0 memberikan fleksibilitas bagi aplikasi CRUD untuk menyimpan data mahasiswa yang bersifat dinamis tanpa harus sering merombak skema tabel utama. Selain itu, untuk memenuhi ketentuan tambahan dimana kita perlu menggunakan GUI untuk Database yaitu phpMyAdmin, maka kita perlu menggunakan database yang memang ditujukan untuk phpMyAdmin, maka digunakanlah MySQL.
* Konfirmasikan bahwa Anda sudah menggunakan MinIO. Apa nama *bucket* yang rencananya akan Anda gunakan untuk menyimpan dokumen/foto mahasiswa?  
  \- Ya, kami sudah menggunakan MinIO dibuktikan dengan berjalannya *service* MinIO pada Docker Compose dan untuk nama bucket yang akan kami gunakan adalah `nusantara-uploads`.

### B. Desain Arsitektur Jaringan

Dalam arsitektur *container*, komunikasi antar-layanan adalah hal krusial. Mohon jelaskan:

* Apa nama *docker network* yang Anda definisikan dalam docker-compose.yml?  
  \- Nama docker network yang kami definisikan pada file docker-compose.yml adalah `nusantara_network` dengan driver bridge. Network ini digunakan sebagai jaringan internal Docker agar seluruh service seperti aplikasi Laravel, Nginx, MySQL, phpMyAdmin, dan MinIO dapat saling terhubung dan berkomunikasi dalam satu ekosistem container tanpa perlu menggunakan IP address secara manual.
* Bagaimana cara aplikasi web Anda memanggil Database dan MinIO? Jelaskan bagaimana Anda memanfaatkan *Service Name* Docker  
  \- Aplikasi web kami memanggil Database dan MinIO dengan memanfaatkan Service Name Docker Compose sebagai hostname internal antar-container. Untuk koneksi database, aplikasi menggunakan hostname `db` dengan port 3306, yang dikonfigurasi melalui environment variable `DB_HOST=db`. Sedangkan untuk layanan object storage MinIO, aplikasi menggunakan endpoint `http://minio:9000` yang berasal dari nama service `minio`. Dengan mekanisme ini, Docker secara otomatis menyediakan DNS internal sehingga setiap container dapat saling mengenali hanya melalui nama servicenya tanpa perlu konfigurasi IP address manual.
* Berapa nomor port *host* yang Anda buka untuk mengakses:
  * Dashboard Utama Aplikasi? **Port 80**
  * Dashboard GUI Database (jika ada)? **Port 8080**
  * Console MinIO? **Port 9001**

### C. Kendala Teknis

* Apa kendala terbesar yang dihadapi dalam menghubungkan antar *container* di minggu pertama ini?  
  \- Kendala terbesar ada dalam melakukan manajemen akses menggunakan MinIO. Dalam proyek ini, kami menciptakan fitur dimana pengguna dapat melakukan upload avatar dalam Sistem Informasi Akademik. Walaupun penyetoran berhasil dan berjalan dengan baik, saat foto tersebut perlu ditunjukkan dalam aplikasi web, malah tidak tertunjuk. Ini ada hal dengan memastikan bahwa link yang digunakan untuk menunjukkan avatar pada dashboard pengguna merupakan link internal yang tidak bisa diakses oleh browser. Oleh karena itu, perlu ada pergantian link dari link jaringan internal Docker menjadi link localhost yang dapat diakses oleh pengguna.
* Apakah ada layanan yang sering *exit* atau *error* saat dijalankan dengan docker-compose up?  
  \- Tidak ada

---

## 6. User Journey

| Step | Action | Description |
|------|--------|-------------|
| 1 | **Register** | Visit http://localhost, click "Daftar di sini", fill in Nama, NIM, Email, Jurusan, Angkatan, Password |
| 2 | **Login** | Enter Email and Password, click "Masuk" |
| 3 | **Dashboard** | View full student profile — NIM, name, major, angkatan, status AKTIF |
| 4 | **Edit Profile** | Click "EDIT PROFIL" in sidebar → update name, email, major, angkatan, or upload photo (JPG/PNG, max 2MB) |
| 5 | **Delete Account** | Click "HAPUS AKUN" in sidebar → confirm in modal dialog → account, photo, and data permanently deleted |

---

## 7. MinIO Object Storage

### Bucket Configuration

| Setting    | Value                |
|------------|----------------------|
| Bucket name | `nusantara-uploads` |
| Photo prefix | `avatars/`         |
| Access     | Public (anonymous read) |
| API endpoint | `http://minio:9000` (internal Docker network) |
| Public URL | `http://localhost:9000/nusantara-uploads/avatars/<filename>` |

### How profile photos work

1. User uploads a photo via Edit Profile page
2. File is stored in MinIO bucket `nusantara-uploads` under `avatars/` prefix
3. Old photo (if exists) is deleted from MinIO before new one is saved
4. Photo URL on dashboard: `http://localhost:9000/nusantara-uploads/avatars/<file>.jpg`
5. Bucket is publicly readable — images load directly in the browser

### Manual bucket operations

```bash
# List files in bucket
docker compose exec minio mc ls local/nusantara-uploads/avatars/

# Check bucket size
docker compose exec minio mc du local/nusantara-uploads

# Make bucket public (if needed)
docker compose exec minio mc anonymous set public local/nusantara-uploads
```

---

## 8. Data Persistence

Two **named Docker volumes** are declared at the top level of `docker-compose.yml`:

| Volume        | Mount Point         | Stores           | Survives `down`? | Survives `down -v`? |
|---------------|---------------------|------------------|:---:|:---:|
| `db_data`     | `/var/lib/mysql`    | MySQL database   | ✅  | ❌  |
| `minio_data`  | `/data`             | MinIO objects    | ✅  | ❌  |

```bash
# Stop all containers — volumes preserved, data safe
docker compose down

# WARNING: This deletes all database records and uploaded files!
docker compose down -v
```

**Always use `docker compose down` without `-v`** for normal workflow.
Only use `-v` if you want a completely fresh start.

---

## 9. Stopping & Tearing Down

```bash
# Stop all containers (data preserved)
docker compose down

# Stop all containers AND delete volumes (fresh start)
docker compose down -v

# Stop without removing containers
docker compose stop

# Restart all services
docker compose restart

# View logs
docker compose logs -f

# View logs for a specific service
docker compose logs -f app
docker compose logs -f db
```

---

## 10. Proof of Connectivity — Screenshots

All screenshots are stored in the `/screenshots` folder. These demonstrate that
every service is running and communicating correctly.

### 10.1 App ↔ Database (MySQL)

![phpMyAdmin users table](screenshots/phpmyadmin-users-table.png)

*phpMyAdmin showing the `users` table with registered student accounts.
Proves the Laravel app successfully connects to and writes to the MySQL database.*

### 10.2 App ↔ MinIO Object Storage

![MinIO bucket avatars](screenshots/minio-bucket-avatars.png)

*MinIO console showing the `nusantara-uploads` bucket with uploaded profile photos
under the `avatars/` prefix. Proves the app successfully stores and retrieves files
from MinIO S3-compatible storage.*

### 10.3 Web Application Pages

![Login page](screenshots/app-login.png)
*Login page (http://localhost) — SIAMUB-style design with centered white card on steel blue background.*

![Register page](screenshots/app-register.png)
*Registration page with all required fields: Nama Lengkap, NIM, Email, Jurusan, Angkatan, Password.*

![Dashboard without photo](screenshots/app-dashboard-no-photo.png)
*Student dashboard showing grey SVG silhouette placeholder when no profile photo has been uploaded.*

![Dashboard with photo](screenshots/app-dashboard-with-photo.png)
*Student dashboard with uploaded profile photo displayed in the photo box.*

![Edit profile page](screenshots/app-edit-profile.png)
*Edit profile form where users can update name, email, major, angkatan, upload a photo, or change password.*

---

## 11. Docker Architecture

```
┌─────────────────────────────────────────────────────────┐
│                  nusantara_network (bridge)              │
│                                                         │
│  ┌──────────────┐   ┌──────────────┐   ┌────────────┐  │
│  │    nginx     │   │     app      │   │     db     │  │
│  │   :80→host   │──→│   :9000      │──→│   :3306    │  │
│  │  nginx:1.25  │   │  php:8.2-fpm │   │  mysql:8.0 │  │
│  └──────────────┘   └──────┬───────┘   └─────┬──────┘  │
│                            │                 │         │
│                            │            ┌────┴───────┐  │
│                            │            │ phpmyadmin │  │
│                            │            │  :8080→host│  │
│                            │            └────────────┘  │
│                            │                            │
│                     ┌──────┴───────┐                    │
│                     │    minio     │                    │
│                     │ :9000→host   │                    │
│                     │ :9001→host   │                    │
│                     └──────────────┘                    │
│                                                         │
│  Volumes: db_data → /var/lib/mysql                      │
│           minio_data → /data                            │
└─────────────────────────────────────────────────────────┘
```

### Inter-Service Communication

| From   | To       | Address           | Protocol  |
|--------|----------|-------------------|-----------|
| nginx  | app      | `app:9000`        | FastCGI   |
| app    | db       | `db:3306`         | MySQL TCP |
| app    | minio    | `http://minio:9000` | S3 API  |
| phpmyadmin | db   | `db:3306`         | MySQL TCP |

All communication uses **Docker service names** on the `nusantara_network` bridge.
No `localhost` is used for inter-container communication.

---

## 12. UI Design Rationale

The interface deliberately mimics **SIAMUB (Sistem Informasi Akademik Mahasiswa
Universitas Brawijaya)** — the real student portal of Universitas Brawijaya.
This is not a generic admin dashboard or SaaS panel.

**SIAMUB design elements adopted:**
- **Page background:** `#1a6496` (SIAMUB steel blue)
- **Top navigation:** white bar with `#b3c6d3` bottom border, SIAM UB logo on left, icon menu (AKADEMIK, BIODATA, KELUAR) on right
- **Content panels:** white background, `1px solid #b3c6d3` border, square corners (institutional, not rounded)
- **Profile card:** photo on left (`2px solid #2980b9` border), student info on right
- **Sidebar menu:** right-aligned, ▶ triangle markers, uppercase labels, hover highlight
- **Announcement banners:** green (email info) and purple (welcome message) below profile card
- **Typography:** institutional font stack, NIM in monospace `#2980b9`

**Student perspective:** Each logged-in user sees only their own data — this is an
individual student portal, not an administrator management panel. No user lists,
data tables, or charts.

---

## 13. Important Notes

- **Manual Laravel auth** — NOT Breeze, Jetstream, or any starter kit
- **No Node.js build pipeline** — Tailwind CSS and Alpine.js loaded from CDN
- **Non-root container** — PHP-FPM runs as `appuser` (uid 1000)
- **AWS_ENDPOINT** inside container = `http://minio:9000` (Docker service name)
- **AWS_URL** for public access = `http://localhost:9000/nusantara-uploads`
- **AWS_USE_PATH_STYLE_ENDPOINT=true** is mandatory for MinIO (not virtual hosted-style)
- All credentials live in `.env` — nothing is hardcoded in committed files
- `docker compose down` preserves data; `docker compose down -v` destroys everything

---

## 14. Troubleshooting

| Problem | Solution |
|---------|----------|
| Port 80 already in use | Stop other web servers: `sudo systemctl stop apache2` or change nginx port in `docker-compose.yml` |
| "No application encryption key" | Run `docker compose exec app php artisan key:generate` |
| MinIO upload fails | Re-run bucket setup commands from Section 3.6 |
| Database connection refused | Wait for MySQL healthcheck (healthy status), then retry |
| Photo not showing on dashboard | Verify bucket is public: `docker compose exec minio mc anonymous get local/nusantara-uploads` |
| Permission denied on storage/ | Run `docker compose exec app chmod -R 755 storage bootstrap/cache` |
