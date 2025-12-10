#  Item Manager - PHP CRUD API + UI

Aplikasi web modern untuk mengelola data dengan fitur **Create, Read, Update, Delete (CRUD)** menggunakan **PHP + SQLite + HTML/CSS/JavaScript**.

##  Fitur Utama

-  **CRUD Lengkap**: Tambah, lihat, ubah, dan hapus data
-  **API REST**: Endpoint JSON untuk integrasi dengan aplikasi lain
-  **UI Modern**: Interface responsif dan menarik
-  **Search**: Fitur pencarian real-time data
-  **SQLite Database**: Database lokal yang portable
-  **Validation**: Validasi data pada backend dan frontend
-  **Error Handling**: Penanganan error yang baik
-  **CORS Enabled**: Siap untuk cross-origin requests

##  Struktur Folder

```
deployment/
 router.php              # Router untuk PHP server
 api/
    index.php          # REST API (PHP)
    db.sqlite          # Database SQLite (dibuat otomatis)
 public/
     index.html         # UI HTML
     app.js             # JavaScript untuk CRUD
     style.css          # Styling
```

##  Instalasi & Setup

### Persyaratan
- **PHP 7.3+**
- **Browser modern** (Chrome, Firefox, Safari, Edge)
- **Postman** (opsional, untuk testing API)
- Tidak perlu instalasi database terpisah!

### Cara Menjalankan (Lokal via Laragon)

Aplikasi sudah berjalan di:
```
http://deployment.test
```

### Cara Menjalankan (Lokal via PHP Built-in)

1. **Buka PowerShell** di folder `E:\laragon\www\deployment`

2. **Jalankan server PHP built-in:**
   ```powershell
   php -S localhost:8000 router.php
   ```

3. **Buka browser** dan akses:
   ```
   http://localhost:8000
   ```

---

##  API Documentation

### Base URL
```
http://deployment.test/api
```
atau (jika menggunakan PHP built-in):
```
http://localhost:8000/api
```

### Endpoints

#### 1️⃣  GET - List Semua Item
```
GET /api/items
```

**Request:**
```
Method: GET
URL: http://deployment.test/api/items
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "title": "Judul Item",
    "content": "Deskripsi item",
    "created_at": "2025-12-10 10:30:00",
    "updated_at": "2025-12-10 10:30:00"
  },
  ...
]
```

---

#### 2️⃣  POST - Tambah Item Baru
```
POST /api/items
```

**Request:**
```
Method: POST
URL: http://deployment.test/api/items
Headers: Content-Type: application/json

Body (JSON):
{
  "title": "Judul Item Baru",
  "content": "Deskripsi item yang lengkap"
}
```

**Response (201 Created):**
```json
{
  "id": 6,
  "title": "Judul Item Baru",
  "content": "Deskripsi item yang lengkap",
  "created_at": "2025-12-10 11:30:00",
  "updated_at": "2025-12-10 11:30:00"
}
```

**Error Response (400 Bad Request):**
```json
{
  "error": "Title is required"
}
```

---

#### 3️⃣  GET - Lihat Detail Item
```
GET /api/items/{id}
```

**Request:**
```
Method: GET
URL: http://deployment.test/api/items/1
```

**Response (200 OK):**
```json
{
  "id": 1,
  "title": "Judul Item",
  "content": "Deskripsi",
  "created_at": "2025-12-10 10:30:00",
  "updated_at": "2025-12-10 10:30:00"
}
```

**Error Response (404 Not Found):**
```json
{
  "error": "Not found"
}
```

---

#### 4️⃣  PUT - Update Item
```
PUT /api/items/{id}
```

**Request:**
```
Method: PUT
URL: http://deployment.test/api/items/1
Headers: Content-Type: application/json

Body (JSON):
{
  "title": "Judul Diubah",
  "content": "Konten yang sudah diubah"
}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "title": "Judul Diubah",
  "content": "Konten yang sudah diubah",
  "updated_at": "2025-12-10 11:45:00"
}
```

---

#### 5️⃣  DELETE - Hapus Item
```
DELETE /api/items/{id}
```

**Request:**
```
Method: DELETE
URL: http://deployment.test/api/items/1
```

**Response (200 OK):**
```json
{
  "message": "Item deleted"
}
```

**Error Response (404 Not Found):**
```json
{
  "error": "Not found"
}
```

---

##  Testing dengan Postman

### Setup Postman

1. **Download Postman**: https://www.postman.com/downloads/
2. **Install dan buka aplikasi**
3. **Buat folder baru**: Klik "New" → "Folder" → Beri nama "Item Manager API"

### Test Cases

#### Test 1: GET Semua Item
```
Method: GET
URL: http://deployment.test/api/items
```
**Expected:** Status 200, Array JSON items

#### Test 2: POST Tambah Item
```
Method: POST
URL: http://deployment.test/api/items
Headers:
  - Content-Type: application/json
Body (raw):
{
  "title": "Belajar PHP",
  "content": "PHP adalah bahasa server-side yang powerful"
}
```
**Expected:** Status 201, Object item baru dengan ID

#### Test 3: PUT Update Item
```
Method: PUT
URL: http://deployment.test/api/items/1
Headers:
  - Content-Type: application/json
Body (raw):
{
  "title": "PHP untuk Pemula",
  "content": "Belajar PHP dari dasar"
}
```
**Expected:** Status 200, Object item yang sudah diupdate

#### Test 4: DELETE Hapus Item
```
Method: DELETE
URL: http://deployment.test/api/items/1
```
**Expected:** Status 200, Success message

---

##  Testing Skenario Lengkap

Ikuti urutan ini untuk test API secara lengkap:

1. **GET** `/api/items` → lihat data awal
2. **POST** `/api/items` → tambah item pertama
3. **GET** `/api/items` → verify item baru ada
4. **POST** `/api/items` → tambah item kedua
5. **PUT** `/api/items/1` → update item
6. **GET** `/api/items` → verify perubahan
7. **DELETE** `/api/items/1` → hapus item
8. **GET** `/api/items` → verify item sudah hilang

4. **Selesai!** Aplikasi siap digunakan.

## 📡 Endpoint API

### 1. Daftar Semua Item
```http
GET /api/items
```
**Response:**
```json
[
  {
    "id": 1,
    "title": "Judul Item",
    "content": "Konten item",
    "created_at": "2025-12-10 10:30:00",
    "updated_at": "2025-12-10 10:30:00"
  }
]
```

### 2. Ambil Item Berdasarkan ID
```http
GET /api/items/1
```
**Response:**
```json
{
  "id": 1,
  "title": "Judul Item",
  "content": "Konten item",
  "created_at": "2025-12-10 10:30:00",
  "updated_at": "2025-12-10 10:30:00"
}
```

### 3. Tambah Item Baru
```http
POST /api/items
Content-Type: application/json

{
  "title": "Judul Baru",
  "content": "Konten baru"
}
```
**Response (201 Created):**
```json
{
  "id": 2,
  "title": "Judul Baru",
  "content": "Konten baru"
}
```

### 4. Ubah Item
```http
PUT /api/items/1
Content-Type: application/json

{
  "title": "Judul Diubah",
  "content": "Konten diubah"
}
```
**Response (200 OK):**
```json
{
  "id": 1,
  "title": "Judul Diubah",
  "content": "Konten diubah"
}
```

### 5. Hapus Item
```http
DELETE /api/items/1
```
**Response (200 OK):**
```json
{
  "deleted": true
}
```

##  Contoh Testing di Postman

### 1. GET - Daftar Item
- **Method**: GET
- **URL**: `http://localhost:8000/api/items`
- **Response**: Array data items

### 2. POST - Tambah Item
- **Method**: POST
- **URL**: `http://localhost:8000/api/items`
- **Headers**: `Content-Type: application/json`
- **Body (raw JSON)**:
  ```json
  {
    "title": "Belajar PHP",
    "content": "Saya belajar membuat API dengan PHP"
  }
  ```

### 3. PUT - Ubah Item
- **Method**: PUT
- **URL**: `http://localhost:8000/api/items/1`
- **Headers**: `Content-Type: application/json`
- **Body (raw JSON)**:
  ```json
  {
    "title": "Belajar PHP & SQLite",
    "content": "Saya belajar membuat API dengan PHP dan SQLite"
  }
  ```

### 4. DELETE - Hapus Item
- **Method**: DELETE
- **URL**: `http://localhost:8000/api/items/1`

##  Fitur UI

- **Form Sticky**: Form tetap terlihat saat scroll
- **Item Cards**: Kartu item yang indah dengan hover effect
- **Search Real-time**: Cari item saat mengetik
- **Responsive Design**: Bekerja sempurna di desktop, tablet, mobile
- **Alerts**: Notifikasi success/error otomatis
- **Loading States**: Indikator loading saat fetch data

##  Deploy ke Vercel (Catatan Penting)

### Opsi A: Deploy UI ke Vercel + API ke Platform Lain  REKOMENDASI

Vercel tidak mendukung PHP runtime native, tapi Anda bisa:

1. **Deploy UI (folder `public`) ke Vercel** sebagai static site
2. **Deploy API PHP ke platform yang mendukung PHP**:
   - **Render.com** (free tier tersedia)
   - **Railway.app** (free tier tersedia)
   - **Heroku** (berbayar sekarang)
   - **DigitalOcean App Platform** (berbayar)
   - **VPS** (Contosbox, IDCloudhost, dll)

3. **Ubah `apiBase` di `public/app.js`** ke URL API yang dideploy:
   ```javascript
   const API_BASE = "https://your-api-domain.com/api/items";
   ```

### Opsi B: Konversi ke Node.js (Full Vercel)

Saya bisa mengkonversi API ke Node.js + Express sehingga bisa dideploy langsung ke Vercel.

##  Catatan Pengembangan

- Database SQLite otomatis dibuat di `api/db.sqlite`
- CORS diaktifkan untuk semua origin (bisa disesuaikan di `api/index.php`)
- Input user di-escape untuk keamanan XSS
- Validasi judul wajib di client dan server
- Prepared statements untuk mencegah SQL Injection

##  Troubleshooting

### Port 8000 sudah digunakan?
Ganti port:
```powershell
php -S localhost:9000 router.php
```
Lalu akses: `http://localhost:9000`

### Database tidak bisa ditulis?
Pastikan folder `api/` punya permission write. Di Windows, folder biasanya sudah accessible.

### API tidak merespons?
- Buka DevTools (F12)  Network tab  cek request/response
- Pastikan PHP extension SQLite3 aktif: `php -m | grep -i sqlite`

##  Support

Jika ada pertanyaan atau masalah, silakan buat issue atau hubungi saya.

---

**Dibuat dengan  menggunakan PHP + SQLite + HTML/CSS/JavaScript**
