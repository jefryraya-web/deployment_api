# 📦 Panduan Lengkap Deployment - GitHub & Vercel

## 📋 Daftar Isi
1. [Persiapan Awal](#persiapan-awal)
2. [Setup Git Lokal](#setup-git-lokal)
3. [Create GitHub Repository](#create-github-repository)
4. [Push ke GitHub](#push-ke-github)
5. [Deploy ke Vercel](#deploy-ke-vercel)
6. [Update API URLs](#update-api-urls)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Persiapan Awal

### Yang Dibutuhkan:
- ✅ Akun GitHub (gratis di https://github.com)
- ✅ Git sudah terinstall (download dari https://git-scm.com)
- ✅ Akun Vercel (gratis di https://vercel.com)

### Verify Git Installation
Buka PowerShell dan jalankan:
```powershell
git --version
```

Output seharusnya menunjukkan versi Git, misal: `git version 2.41.0`

---

## 🔧 Setup Git Lokal

### Step 1: Configure Git (Jika belum pernah)
```powershell
git config --global user.name "Nama Lengkap Anda"
git config --global user.email "email@anda.com"
```

### Step 2: Initialize Repository Lokal
Buka PowerShell di folder `E:\laragon\www\deployment`:

```powershell
cd E:\laragon\www\deployment
git init
```

### Step 3: Add All Files
```powershell
git add .
```

Verify dengan:
```powershell
git status
```

### Step 4: Make First Commit
```powershell
git commit -m "Initial commit: Item Manager API with UI and documentation"
```

Expected output:
```
[main (root-commit) abc1234] Initial commit...
 10 files changed, 1500+ insertions(+)
 create mode 100644 api/index.php
 create mode 100644 public/index.html
 ...
```

---

## 🌐 Create GitHub Repository

### Step 1: Login ke GitHub
Buka https://github.com dan login dengan akun Anda

### Step 2: Create New Repository
- Klik tombol **"+"** di atas kanan → **"New repository"**
- Atau buka langsung: https://github.com/new

### Step 3: Fill Repository Details
```
Repository name: item-manager-api
Description: Item Manager - PHP CRUD API with UI and Postman collection
Visibility: Public
```

### Step 4: Don't Initialize
**JANGAN** pilih:
- Initialize with README ✗
- Add .gitignore ✗
- Choose a license ✗

(Sudah ada di local repository kita)

### Step 5: Create Repository
Klik tombol **"Create repository"**

Anda akan dibawa ke halaman baru dengan instruksi push.

---

## 🚀 Push ke GitHub

### Step 1: Copy Remote URL
Di halaman repository GitHub, copy URL:
```
https://github.com/USERNAME/item-manager-api.git
```

Ganti `USERNAME` dengan username GitHub Anda!

### Step 2: Add Remote & Push
Kembali ke PowerShell dan jalankan:

```powershell
# Set branch name ke 'main'
git branch -M main

# Add remote repository
git remote add origin https://github.com/USERNAME/item-manager-api.git

# Push ke GitHub
git push -u origin main
```

### Step 3: Verify
Buka https://github.com/USERNAME/item-manager-api

Anda seharusnya melihat:
- ✅ File sudah ter-upload
- ✅ README.md ditampilkan
- ✅ Semua folder ada (api/, public/)

---

## ⭐ Deploy ke Vercel

### Step 1: Go to Vercel
Buka https://vercel.com dan login/signup (bisa pakai GitHub account)

### Step 2: Import Project
- Klik **"Add New..."** → **"Project"**
- Atau buka: https://vercel.com/new

### Step 3: Select GitHub Repository
- Klik **"Import Git Repository"**
- Search untuk: `item-manager-api`
- Select repository Anda

### Step 4: Configure Project
Di halaman konfigurasi:

**Project Settings:**
- Framework Preset: **Other** (PHP)
- Root Directory: `.` (root)
- Build Command: (kosongkan/tidak perlu)
- Output Directory: `public`

**Environment Variables:**
Kosongkan (tidak perlu untuk project ini)

### Step 5: Deploy!
Klik tombol **"Deploy"**

Tunggu sampai proses selesai (biasanya 1-2 menit).

### Step 6: Get Your Domain
Setelah deploy selesai, Anda akan dapat:
```
https://item-manager-api-xxxx.vercel.app
```

---

## 🔗 Update API URLs

Setelah deploy, perlu update URL di frontend agar menunjuk ke Vercel domain:

### Edit file: `public/app.js`

**Find:**
```javascript
const API_BASE = "/api/items";
```

**Replace dengan:**
```javascript
const API_BASE = "https://item-manager-api-xxxx.vercel.app/api/items";
```

Ganti `xxxx` dengan domain Vercel Anda yang sebenarnya!

### Commit & Push Perubahan
```powershell
git add public/app.js
git commit -m "Update API URL for Vercel deployment"
git push
```

Vercel akan **auto-redeploy** ketika Anda push perubahan!

---

## 📝 Testing Deployment

### Test 1: Check UI
Buka: `https://your-domain.vercel.app`

Seharusnya melihat:
- ✅ Header "Item Manager"
- ✅ Form untuk tambah item
- ✅ List items (Daftar Item)
- ✅ Search box

### Test 2: Create Item via Web
1. Isi form dengan data test
2. Klik "Simpan"
3. Verify item muncul di list

### Test 3: Test API dengan Postman
Update Postman URLs:
```
Old:  http://deployment.test/api/items
New:  https://your-domain.vercel.app/api/items
```

Test semua endpoints (GET, POST, PUT, DELETE)

---

## 🔄 Continuous Deployment

Setelah ini, setiap kali Anda push ke GitHub:
```powershell
git add .
git commit -m "Your commit message"
git push
```

Vercel akan **otomatis redeploy** dalam hitungan menit!

---

## ❌ Troubleshooting

### Problem: "fatal: not a git repository"
**Solution:**
```powershell
cd E:\laragon\www\deployment
git init
```

### Problem: "error: remote origin already exists"
**Solution:**
```powershell
git remote remove origin
git remote add origin https://github.com/USERNAME/item-manager-api.git
```

### Problem: Vercel showing 404 or "Cannot GET /"
**Solution:**
- Verify `vercel.json` sudah di-push
- Check build logs di Vercel dashboard
- Vercel mungkin belum support routing PHP sepenuhnya
- Lihat bagian [PHP Runtime Support](#php-runtime-support) di bawah

### Problem: API returning 500 error di Vercel
**Solution:**
1. Check Vercel logs (di dashboard)
2. Verify `api/data.json` writeable
3. Pastikan environment variables configured
4. Coba test di lokal terlebih dahulu

### Problem: Data tidak tersimpan di Vercel
**Solution:**
Vercel tidak persistent file system. Perlu:
1. Gunakan database eksternal (MySQL, PostgreSQL)
2. Atau gunakan Vercel KV/Storage (beta)
3. Atau host di platform lain yang support persistent storage

Untuk sekarang, data akan hilang setelah 24 jam di Vercel.

---

## ⚡ PHP Runtime Support

Vercel support PHP via `@vercel/php`, tapi dengan beberapa keterbatasan:

**Supported:**
- ✅ PHP 8.1+
- ✅ JSON file operations (read/write - sementara saja)
- ✅ Basic routing
- ✅ API endpoints

**Limitations:**
- ❌ Persistent file storage (tidak persistent)
- ❌ Database connection (kecuali cloud database)
- ❌ Some PHP extensions

**Untuk production:**
Pertimbangkan:
1. Gunakan cloud database (e.g., Firebase, Supabase)
2. Deploy di platform PHP-friendly (Heroku, Render, Railway)
3. Convert ke Node.js/JavaScript backend

---

## 📚 Additional Resources

- Vercel Docs: https://vercel.com/docs
- GitHub Docs: https://docs.github.com
- Git Basics: https://git-scm.com/book/en/v2

---

## ✅ Deployment Checklist

- [ ] Git configured dengan user.name & user.email
- [ ] Local repository initialized (`git init`)
- [ ] GitHub repository created
- [ ] Code pushed ke GitHub (`git push`)
- [ ] Vercel project created
- [ ] Project deployed successfully
- [ ] Vercel domain diperoleh
- [ ] API URLs updated di app.js
- [ ] Changes pushed (auto-redeploy)
- [ ] Testing di production (web + API)

---

Generated: December 2025
