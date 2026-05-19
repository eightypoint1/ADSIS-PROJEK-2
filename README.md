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