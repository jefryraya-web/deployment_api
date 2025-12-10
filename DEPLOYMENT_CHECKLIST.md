# 🚀 DEPLOYMENT STEP-BY-STEP CHECKLIST

## 📦 STEP 1: SETUP GIT LOKAL
**Lokasi:** PowerShell di `E:\laragon\www\deployment`

### ✅ Sub-step 1.1: Configure Git
```powershell
git config --global user.name "Nama Lengkap Anda"
git config --global user.email "email@anda.com"
```
**Expected:** Tidak ada output (konfigurasi tersimpan)

---

### ✅ Sub-step 1.2: Navigasi ke folder
```powershell
cd E:\laragon\www\deployment
```

---

### ✅ Sub-step 1.3: Initialize Repository
```powershell
git init
```
**Expected Output:**
```
Initialized empty Git repository in E:\laragon\www\deployment\.git
```

---

### ✅ Sub-step 1.4: Check Status
```powershell
git status
```
**Expected Output:**
```
On branch master
No commits yet
Untracked files:
  (use "git add <file>..." to include in what will be committed)
        .gitignore
        .htaccess
        README.md
        ...
```

---

### ✅ Sub-step 1.5: Add All Files
```powershell
git add .
```

---

### ✅ Sub-step 1.6: Create First Commit
```powershell
git commit -m "Initial commit: Item Manager API with UI"
```
**Expected Output:**
```
[master (root-commit) abcd123] Initial commit...
 12 files changed, 2000+ insertions(+)
```

---

## 🌐 STEP 2: CREATE REPOSITORY DI GITHUB
**Lokasi:** Browser (https://github.com)

### ✅ Sub-step 2.1: Login ke GitHub
- Buka https://github.com
- Login dengan akun Anda

---

### ✅ Sub-step 2.2: Buat Repository Baru
- Klik **+** icon (atas kanan)
- Pilih **New repository**
- Atau langsung: https://github.com/new

---

### ✅ Sub-step 2.3: Isi Form
```
Repository name:       item-manager-api
Description:           Item Manager - PHP CRUD API with UI
Visibility:            ✓ Public
Initialize with README: ✗ (unchecked)
Add .gitignore:        ✗ (unchecked)
Choose a license:      ✗ (None)
```

---

### ✅ Sub-step 2.4: Create Repository
Klik tombol **"Create repository"** (hijau)

---

### ✅ Sub-step 2.5: Copy Repository URL
Anda akan lihat halaman dengan instruksi.

Cari dan copy URL ini:
```
https://github.com/USERNAME/item-manager-api.git
```

**Ganti USERNAME dengan username GitHub Anda!**

---

## 📤 STEP 3: PUSH KE GITHUB
**Lokasi:** PowerShell di `E:\laragon\www\deployment`

### ✅ Sub-step 3.1: Add Remote Repository
```powershell
git remote add origin https://github.com/USERNAME/item-manager-api.git
```
Ganti USERNAME dengan username GitHub Anda!

---

### ✅ Sub-step 3.2: Verify Remote Added
```powershell
git remote -v
```
**Expected Output:**
```
origin  https://github.com/USERNAME/item-manager-api.git (fetch)
origin  https://github.com/USERNAME/item-manager-api.git (push)
```

---

### ✅ Sub-step 3.3: Set Main Branch
```powershell
git branch -M main
```

---

### ✅ Sub-step 3.4: Push ke GitHub
```powershell
git push -u origin main
```

**First time?** Mungkin akan minta authentication:
- Bisa pakai GitHub Personal Access Token
- Atau gunakan credential manager

---

### ✅ Sub-step 3.5: Verify di GitHub
- Buka: https://github.com/USERNAME/item-manager-api
- Verify semua file sudah ada:
  - ✅ api/ folder
  - ✅ public/ folder
  - ✅ README.md
  - ✅ DEPLOYMENT.md
  - ✅ vercel.json
  - ✅ .gitignore
  - dll

---

## ⭐ STEP 4: DEPLOY KE VERCEL
**Lokasi:** Browser (https://vercel.com)

### ✅ Sub-step 4.1: Login ke Vercel
- Buka https://vercel.com
- Login atau signup (bisa pakai GitHub)

---

### ✅ Sub-step 4.2: Import Project
- Klik **"Add New..."** (atas)
- Pilih **"Project"**
- Atau langsung: https://vercel.com/new

---

### ✅ Sub-step 4.3: Connect Git
- Pilih **"Import Git Repository"**
- Authorize Vercel mengakses GitHub
- Search: `item-manager-api`
- Select repository Anda

---

### ✅ Sub-step 4.4: Configure Build
Di halaman "Configure Project":

**Framework:** Other
**Root Directory:** . (dot)
**Build Command:** (kosongkan)
**Output Directory:** (kosongkan)

---

### ✅ Sub-step 4.5: Deploy!
Klik **"Deploy"**

**Tunggu 1-2 menit sampai proses selesai.**

Status akan berubah dari:
1. ⏳ Building...
2. ✅ Ready

---

### ✅ Sub-step 4.6: Get Domain
Setelah selesai, Anda akan lihat:
```
🎉 Congratulations! Your project has been successfully deployed.
```

Dan domain URL seperti:
```
https://item-manager-api-abc123.vercel.app
```

**Copy domain ini! Butuh di step berikutnya.**

---

## 🔗 STEP 5: UPDATE API URLS
**Lokasi:** Text editor (VS Code)

### ✅ Sub-step 5.1: Buka File
File: `E:\laragon\www\deployment\public\app.js`

---

### ✅ Sub-step 5.2: Find & Replace
**Line ~1:**
```javascript
const API_BASE = "/api/items";
```

**Replace dengan:**
```javascript
const API_BASE = "https://item-manager-api-abc123.vercel.app/api/items";
```

**Ganti domain dengan domain Vercel Anda dari step 4.6!**

---

### ✅ Sub-step 5.3: Save File
Ctrl + S (atau File → Save)

---

## 📤 STEP 6: PUSH PERUBAHAN
**Lokasi:** PowerShell

### ✅ Sub-step 6.1: Check Changes
```powershell
git status
```
**Expected:** Akan terlihat `public/app.js` modified

---

### ✅ Sub-step 6.2: Stage Changes
```powershell
git add public/app.js
```

---

### ✅ Sub-step 6.3: Commit
```powershell
git commit -m "Update API URL for Vercel deployment"
```

---

### ✅ Sub-step 6.4: Push
```powershell
git push
```

---

### ✅ Sub-step 6.5: Wait for Auto-Deploy
Vercel akan otomatis detect push dan redeploy dalam 1-2 menit.

Bisa monitor di: https://vercel.com/dashboard

---

## ✅ STEP 7: TESTING DEPLOYMENT
**Lokasi:** Browser

### ✅ Sub-step 7.1: Test Web UI
- Buka: `https://your-domain.vercel.app`
- Verify:
  - ✅ Halaman load
  - ✅ Form ada
  - ✅ List items ada
  - ✅ CSS loaded (styling bagus)

---

### ✅ Sub-step 7.2: Test Create Item
1. Isi form:
   - Judul: "Test Item"
   - Konten: "Testing deployment"
2. Klik "Simpan"
3. Verify item muncul di list

---

### ✅ Sub-step 7.3: Test API dengan Postman
1. Buka Postman
2. Change URL dari `http://deployment.test/api/items`
3. Ke: `https://your-domain.vercel.app/api/items`
4. Test GET, POST, PUT, DELETE

---

## 🎉 DEPLOYMENT COMPLETE!

Selamat! Project Anda sudah live di Vercel!

**Akses:**
- Web UI: `https://your-domain.vercel.app`
- API: `https://your-domain.vercel.app/api/items`
- GitHub: `https://github.com/USERNAME/item-manager-api`

**Future Changes:**
```powershell
git add .
git commit -m "Your changes"
git push
# Otomatis redeploy!
```

---

## ⚠️ IMPORTANT NOTES

### Data Persistence
Vercel tidak memiliki persistent file system. Data di `api/data.json` akan hilang setelah 24 jam.

**Untuk production:**
- Gunakan cloud database (Firebase, MySQL, PostgreSQL)
- Atau gunakan managed storage service

### Custom Domain (Opsional)
Ingin domain sendiri seperti `mysite.com`?
1. Beli domain (Namecheap, GoDaddy, etc)
2. Di Vercel dashboard → Settings → Domains
3. Add custom domain
4. Follow instruksi DNS configuration

---

Generated: December 2025
