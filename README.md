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
docker compose up -d --force-recreate  # pick up APP_KEY
```

---

## 4. Access Points

| Service         | URL                        | Credentials              |
|-----------------|----------------------------|--------------------------|
| Aplikasi        | http://localhost           | — (register to create)   |
| MinIO Dashboard | http://localhost:9001      | minioadmin / minioadmin123 |
| phpMyAdmin      | http://localhost:8080      | nusantara_user / nusantara_pass |


---

# Progres 1

##### A. Pemilihan Tech-Stack

* Bahasa pemrograman atau *framework* apa yang Anda pilih untuk aplikasi CRUD Anda (misal: Node.js, Python/Flask, PHP)? Apa *base image* yang Anda gunakan dalam Dockerfile ?  
* \-Untuk Bahasa pemrogaman yang kami gunakan adalah PHP dengan framework laravel dan base image yang kami gunakan adalah php:8.2-fpm-alpine  
* Database apa yang Anda gunakan (MySQL/PostgreSQL)? Mengapa memilih versi tersebut?  
  \- Database yang kami gunakan adalah MySQL versi 8.0 karena versi ini menawarkan fleksibilitas pengembangan modern sekaligus efisiensi tinggi saat dijalankan dalam ekosistem kontainer. Dukungan tipe data JSON yang jauh lebih optimal pada MySQL 8.0 memberikan fleksibilitas bagi aplikasi CRUD untuk menyimpan data mahasiswa yang bersifat dinamis tanpa harus sering merombak skema tabel utama. Selain itu, untuk memenuhi ketentuan tambahan dimana kita perlu menggunakan GUI untuk Database yaitu phpmyAdmin, maka kita perlu menggunakan database yang memang ditujukan untuk phpmyAdmin, maka digunakanlah MySQL.  
* Konfirmasikan bahwa Anda sudah menggunakan MinIO. Apa nama *bucket* yang rencananya akan Anda gunakan untuk menyimpan dokumen/foto mahasiswa?  
* \-ya, kami sudah menggunakan MinIO dibuktikan dengan berjalannya *service* MinIO pada Docker Compose dan untuk nama bucket yang akan kami gunakan adalah nusantara-uploads.

##### B. Desain Arsitektur Jaringan

Dalam arsitektur *container*, komunikasi antar-layanan adalah hal krusial. Mohon jelaskan:

*  Apa nama *docker network* yang Anda definisikan dalam docker-compose.yml?  
* \- Nama docker network yang kami definisikan pada file docker-compose.yml adalah nusantara\_network dengan driver bridge. Network ini digunakan sebagai jaringan internal Docker agar seluruh service seperti aplikasi Laravel, Nginx, MySQL, phpMyAdmin, dan MinIO dapat saling terhubung dan berkomunikasi dalam satu ekosistem container tanpa perlu menggunakan IP address secara manual.  
* Bagaimana cara aplikasi web Anda memanggil Database dan MinIO? Jelaskan  
* bagaimana Anda memanfaatkan *Service Name* Docker  
* \- Aplikasi web kami memanggil Database dan MinIO dengan memanfaatkan Service Name Docker Compose sebagai hostname internal antar-container. Untuk koneksi database, aplikasi menggunakan hostname db dengan port 3306, yang dikonfigurasi melalui environment variable DB\_HOST=db. Sedangkan untuk layanan object storage MinIO, aplikasi menggunakan endpoint http://minio:9000 yang berasal dari nama service minio. Dengan mekanisme ini, Docker secara otomatis menyediakan DNS internal sehingga setiap container dapat saling mengenali hanya melalui nama servicenya tanpa perlu konfigurasi IP address manual.  
*   
* Berapa nomor port *host* yang Anda buka untuk mengakses:  
  * Dashboard Utama Aplikasi? port 80  
  * Dashboard GUI Database (jika ada)? port 8080  
  * Console MinIO? port 9001

##### C. Kendala Teknis

*   
* Apa kendala terbesar yang dihadapi dalam menghubungkan antar *container* di minggu pertama ini?  
*   
* \- Kendala terbesar ada dalam melakukan manajemen akses menggunakan minio, dalam proyek ini, kami menciptakan fitur dimana pengguna dapat melakukan upload avatar dalam Sistem Informasi Akademik, walaupun penyetoran berhasil, dan berjalan dengan baik, tetapi saat foto tersebut perlu ditunjukan dalam aplikasi web, malah tidak tertunjuk, ini ada hal dengan memastikan bahwa link yang digunakan untuk menunjukkan avatar pada dashboard pengguna merupakan link internal yang tidak bisa diakses oleh browser, oleh karena itu, perlu ada pergantian link dari link jaringan internal docker, menjadi link localhost yang dapat diakses oleh pengguna.  
*   
* Apakah ada layanan yang sering *exit* atau *error* saat dijalankan dengan docker-compose up?  
*   
* \- Tidak ada

---
