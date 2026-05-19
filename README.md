# Nusantara Tech — Sistem Informasi Akademik (SIA)

> **Tugas Administrasi Sistem** — Development Environment in a Box

---

## 1. Tech Stack

| Service    | Technology       | Version       |
|------------|------------------|---------------|
| App        | PHP / Laravel    | 8.2 / 13.x    |
| Web Server | Nginx            | 1.25-alpine   |
| Database   | MySQL            | 8.0           |
| Storage    | MinIO (S3)       | latest        |
| DB GUI     | phpMyAdmin       | latest        |
| Frontend   | Blade + Tailwind CSS CDN + Alpine.js | — |

---

## 2. Prerequisites

- Docker Engine 20.10+
- Docker Compose 2.0+
- Git

---

## 3. Quick Start

```bash
# 1. Copy environment file
cp .env.example .env

# 2. Build and start all services
docker-compose up -d --build

# 3. Generate application key
docker-compose exec app php artisan key:generate

# 4. Run database migrations
docker-compose exec app php artisan migrate

# 5. Configure MinIO bucket
docker-compose exec minio mc alias set local http://localhost:9000 minioadmin minioadmin123
docker-compose exec minio mc mb local/nusantara-uploads
docker-compose exec minio mc anonymous set public local/nusantara-uploads
```

---

## 4. Access Points

| Service         | URL                        | Credentials              |
|-----------------|----------------------------|--------------------------|
| Aplikasi        | http://localhost           | — (register to create)   |
| MinIO Dashboard | http://localhost:9001      | minioadmin / minioadmin123 |
| phpMyAdmin      | http://localhost:8080      | nusantara_user / nusantara_pass |

---

## 5. User Journey

1. **Register** — Buka http://localhost, isi form pendaftaran (Nama, NIM, Email, Jurusan, Angkatan, Password)
2. **Login** — Masuk dengan Email dan Password yang telah didaftarkan
3. **Dashboard** — Lihat profil lengkap termasuk NIM, nama, jurusan, angkatan, dan status AKTIF
4. **Upload Foto** — Klik "Ganti Foto" di bawah kotak foto, pilih file JPG/PNG (max 2MB), upload
5. **Hapus Akun** (opsional) — Klik "HAPUS AKUN" di sidebar kanan, konfirmasi di modal dialog

---

## 6. MinIO Storage

- **Bucket:** `nusantara-uploads`
- **Prefix foto profil:** `avatars/`
- **Akses publik:** anonymous read enabled
- **URL foto publik:** `http://localhost:9000/nusantara-uploads/avatars/<filename>`

---

## 7. Data Persistence

Dua named volume dideklarasikan di `docker-compose.yml`:

| Volume       | Mount Point            | Data              |
|--------------|------------------------|-------------------|
| `db_data`    | `/var/lib/mysql`       | MySQL database    |
| `minio_data` | `/data`                | MinIO objects     |

- `docker-compose down` → container berhenti, **volume tetap ada** (data aman)
- `docker-compose down -v` → container berhenti + **volume dihapus** (data hilang)

Jangan gunakan `-v` kecuali Anda ingin menghapus semua data.

---

## 8. UI Design Rationale

Tampilan antarmuka sengaja dirancang menyerupai **SIAMUB (Sistem Informasi Akademik Mahasiswa Universitas Brawijaya)** — portal mahasiswa Universitas Brawijaya yang sebenarnya. Ini bukan dashboard admin generik atau panel SaaS.

**Elemen desain SIAMUB yang diadopsi:**
- **Warna latar belakang halaman:** `#1a6496` (biru baja khas SIAMUB)
- **Navigasi atas:** latar putih dengan border bawah `#b3c6d3`, logo SIAM UB di kiri, ikon menu (AKADEMIK, BIODATA, KELUAR) di kanan
- **Panel konten putih** dengan border `1px solid #b3c6d3`, sudut persegi (tidak rounded) untuk kesan institusional
- **Kartu profil** dengan foto di kiri (border `2px solid #2980b9`) dan info mahasiswa di kanan
- **Sidebar menu** di kanan dengan item bertanda segitiga dan label uppercase
- **Banner pengumuman** hijau dan ungu di bawah kartu profil
- **Tipografi dan layout** yang mengikuti standar portal akademik Indonesia

**Perspektif mahasiswa:** Setiap pengguna yang login hanya melihat datanya sendiri — ini adalah portal mahasiswa individu, bukan panel manajemen administrator. Tidak ada daftar pengguna, tidak ada tabel data, tidak ada grafik.

---

## 9. Screenshot Evidence

> *Tambahkan screenshot berikut setelah menjalankan aplikasi:*

| # | Halaman                 | Screenshot |
|---|-------------------------|------------|
| 1 | Halaman Login           | *(insert)* |
| 2 | Halaman Register        | *(insert)* |
| 3 | Dashboard (tanpa foto)  | *(insert)* |
| 4 | Dashboard (dengan foto) | *(insert)* |
| 5 | Bucket MinIO — avatars  | *(insert)* |
| 6 | phpMyAdmin — tabel users| *(insert)* |

---

## Arsitektur Docker

```
┌───────────────────────────────────────────────────┐
│                  nusantara_network                │
│                                                   │
│  ┌─────────┐  ┌─────────┐  ┌──────────────────┐  │
│  │  nginx  │  │   app   │  │       db         │  │
│  │  :80    │──│  :9000  │──│     :3306        │  │
│  └─────────┘  └─────────┘  └──────────────────┘  │
│                     │              │              │
│                     │         ┌──────────────┐    │
│                     │         │  phpmyadmin  │    │
│                     │         │    :8080     │    │
│                     │         └──────────────┘    │
│                     │                             │
│               ┌──────────┐                        │
│               │  minio   │                        │
│               │ :9000/01 │                        │
│               └──────────┘                        │
│                                                   │
│  Volumes: db_data, minio_data                     │
└───────────────────────────────────────────────────┘
```

---

## First-Time Setup (Bahasa Indonesia)

```bash
cp .env.example .env
docker-compose up -d --build
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec minio mc alias set local http://localhost:9000 minioadmin minioadmin123
docker-compose exec minio mc mb local/nusantara-uploads
docker-compose exec minio mc anonymous set public local/nusantara-uploads
```

---

## Catatan Penting

- Aplikasi ini menggunakan **Laravel manual auth** — BUKAN Breeze/Jetstream
- **Tidak ada Node.js build pipeline** — Tailwind CSS dan Alpine.js di-load dari CDN
- `AWS_ENDPOINT` di dalam container = `http://minio:9000` (bukan localhost)
- `AWS_USE_PATH_STYLE_ENDPOINT=true` wajib untuk MinIO
- PHP-FPM berjalan sebagai **non-root user** (`appuser`, uid 1000)
- Semua kredensial ada di `.env` — tidak ada yang di-hardcode
