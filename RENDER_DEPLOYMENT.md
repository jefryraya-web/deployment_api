# 🚀 Deploy PHP API ke Render.com

Karena Vercel tidak support PHP runtime, kita deploy API ke Render (gratis, support PHP, persistent storage).

## Step 1: Create Render Account & Web Service

1. Buka https://render.com
2. Signup (pilih GitHub account untuk faster setup)
3. Setelah login, klik **"New +"** → **"Web Service"**
4. Connect GitHub → Select repository: `jefryraya-web/deployment_api`
5. Di halaman config:
   - **Name:** `deployment-api` (atau nama lain)
   - **Environment:** `Docker` (atau PHP jika tersedia)
   - **Region:** `Frankfurt` atau `Singapore` (pilih yang dekat)
   - **Branch:** `main`

### Jika Render menanyakan "Runtime" atau "Build Command":
- **Build Command:** (kosongkan atau `mkdir -p /tmp`)
- **Start Command:** `php -S 0.0.0.0:$PORT router.php`

6. Klik **"Create Web Service"**
7. Tunggu deployment selesai (~2-3 menit)
8. Copy URL yang diberikan, contoh: `https://deployment-api-xxxxx.onrender.com`

## Step 2: Update API URL di `public/app.js`

Setelah API live di Render, update file lokal:

File: `public/app.js`

**Find (Line 1):**
```javascript
const API_BASE = "/api/items";
```

**Replace dengan:**
```javascript
const API_BASE = "https://deployment-api-xxxxx.onrender.com/api/items";
```

(Ganti `xxxxx` dengan subdomain Render Anda)

## Step 3: Commit, Push, dan Vercel Auto-Redeploy

```powershell
git add public/app.js
git commit -m "Update API URL to Render endpoint"
git push
```

Vercel akan auto-redeploy dalam 1-2 menit.

## Step 4: Test

1. Buka: https://deployment-api-vercel.vercel.app (atau domain Vercel Anda)
2. Coba tambah item
3. Cek apakah data muncul di list

## Troubleshooting Render

### Build gagal / logs error
- Buka project Render → tab "Logs" → cek error
- Pastikan `router.php` ada di root
- Pastikan Start Command: `php -S 0.0.0.0:$PORT router.php`

### API returns 404 atau error
- Test direct API:
  ```
  https://deployment-api-xxxxx.onrender.com/api/items
  ```
  Seharusnya return JSON array (mungkin kosong)
- Jika 404, berarti routing tidak bekerja — buka logs Render

### Timeout
- Render free tier mungkin sleep setelah 15 menit inactivity
- API akan respond lambat di request pertama (startup)

---

**Setelah API live di Render + frontend di Vercel, Anda punya full stack:**
- Frontend (UI): Vercel
- Backend (API): Render
- Data: `api/data.json` di Render (persistent selama file tidak dihapus)

Untuk production, gunakan cloud database (Firebase, Supabase, atau MySQL cloud).

---

Generated: December 2025
