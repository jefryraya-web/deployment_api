# 📊 DEPLOYMENT ARCHITECTURE DIAGRAM

## Alur Lengkap Deployment

```
┌─────────────────────────────────────────────────────────────┐
│          LOKAL DEVELOPMENT ENVIRONMENT                      │
│          (E:\laragon\www\deployment)                        │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────────┐                                       │
│  │  Source Code     │                                       │
│  │  ├─ api/         │                                       │
│  │  ├─ public/      │                                       │
│  │  ├─ router.php   │                                       │
│  │  └─ ...          │                                       │
│  └────────┬─────────┘                                       │
│           │                                                 │
│           ├─→ git init                                      │
│           ├─→ git add .                                     │
│           ├─→ git commit                                    │
│           │                                                 │
│           ▼                                                 │
│  ┌──────────────────┐                                       │
│  │  .git directory  │                                       │
│  │  (version control)                                       │
│  └────────┬─────────┘                                       │
│           │                                                 │
└───────────┼─────────────────────────────────────────────────┘
            │
            │ git push
            │
            ▼
┌─────────────────────────────────────────────────────────────┐
│              GITHUB REPOSITORY                              │
│    (github.com/USERNAME/item-manager-api)                   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Remote Repository Storage                           │  │
│  │  ├─ All commits history                              │  │
│  │  ├─ All branches                                     │  │
│  │  ├─ Source code backup                              │  │
│  │  └─ Version tracking                                │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
└───────────┬─────────────────────────────────────────────────┘
            │
            │ Connect & Deploy
            │
            ▼
┌─────────────────────────────────────────────────────────────┐
│              VERCEL PLATFORM                                │
│          (vercel.com - Hosting)                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Build Process                                       │  │
│  │  1. Clone repository                                │  │
│  │  2. Read vercel.json config                         │  │
│  │  3. Setup PHP environment                           │  │
│  │  4. Create production build                         │  │
│  │  5. Deploy to edge servers                          │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Live Application                                    │  │
│  │  📱 Frontend: public/index.html                      │  │
│  │  🔌 Backend API: api/index.php                       │  │
│  │  🌐 Domain: item-manager-api-xxxx.vercel.app       │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
            ▲
            │
            │ Browser Request
            │
    ┌───────┴────────┐
    │                │
┌───▼────────┐  ┌────▼────────┐
│   User 1   │  │   User 2    │
│  Browser   │  │   Browser   │
└────────────┘  └─────────────┘
```

---

## File Flow Diagram

```
GitHub Repository Structure:
(Apa yang ada di https://github.com/USERNAME/item-manager-api)

root/
├── api/
│   ├── index.php .................. REST API (CRUD)
│   └── data.json .................. Database (JSON)
├── public/
│   ├── index.html ................. UI Template
│   ├── app.js ..................... Frontend Logic
│   └── style.css .................. Styling
├── router.php ..................... HTTP Router
├── index.php ...................... Entry Point
├── vercel.json .................... Vercel Config (NEW)
├── .gitignore ..................... Git Ignore (NEW)
├── README.md ...................... Documentation
├── DEPLOYMENT.md .................. Deployment Guide (NEW)
├── DEPLOYMENT_CHECKLIST.md ........ Checklist (NEW)
└── POSTMAN_QUICK_REFERENCE.md .... API Guide
```

---

## Deployment Timeline

```
Timeline Deployment Process:

1. LOCAL DEVELOPMENT (saat ini)
   │
   ├─ git init
   ├─ git add .
   ├─ git commit
   │
2. CREATE GITHUB REPO
   │
   ├─ Create empty repo
   ├─ Get remote URL
   │
3. PUSH TO GITHUB
   │
   ├─ git remote add origin <url>
   ├─ git push -u origin main
   ├─ Wait: 30 seconds
   ├─ Files uploaded ✓
   │
4. DEPLOY TO VERCEL
   │
   ├─ Login to vercel.com
   ├─ Import GitHub repo
   ├─ Configure settings
   ├─ Click Deploy
   ├─ Wait: 1-2 minutes
   ├─ Get domain ✓
   │
5. UPDATE & REDEPLOY
   │
   ├─ Edit app.js (API URL)
   ├─ git add .
   ├─ git commit
   ├─ git push
   ├─ Vercel auto-deploys
   ├─ Wait: 1-2 minutes
   ├─ Live ✓

Total time: ~5-10 minutes for first deployment
Future updates: 1-2 minutes auto-deploy
```

---

## Component Interaction

```
User's Browser
      │
      ├─→ GET https://item-manager-api.vercel.app
      │   └─→ Vercel Edge Network
      │       └─→ Serve public/index.html
      │           └─→ Browser renders UI
      │
      ├─→ User fills form & clicks "Simpan"
      │   └─→ JavaScript (app.js)
      │       └─→ fetch() POST /api/items
      │           └─→ API Gateway (Vercel Routing)
      │               └─→ api/index.php (PHP Runtime)
      │                   └─→ Process POST
      │                   └─→ Save to data.json
      │                   └─→ Return JSON response
      │       └─→ app.js receives response
      │       └─→ showAlert("Item ditambahkan")
      │       └─→ loadItems() (fetch GET)
      │           └─→ api/index.php (GET /api/items)
      │               └─→ Read data.json
      │               └─→ Return array JSON
      │       └─→ renderItems() displays list
      │
      └─→ User sees item in list ✓
```

---

## After Deployment - What Happens

```
GitHub Repository (Remote)
         │
         │ Polling every 1 minute
         │
         ▼
   Vercel Platform
         │
         ├─→ Detect new push?
         │   └─→ YES: Start build
         │   └─→ NO: Skip
         │
         ├─→ Build Process
         │   ├─ Clone code
         │   ├─ Install dependencies
         │   ├─ Build/compile
         │   ├─ Run tests (if configured)
         │   └─ Generate optimized build
         │
         ├─→ Deploy Build
         │   ├─ Copy to edge servers
         │   ├─ Update DNS
         │   ├─ Invalidate cache
         │   └─ Health checks
         │
         └─→ Live!
             └─→ New version accessible via domain
                 └─→ All users get latest code
                 └─→ Old version removed
```

---

## Environment Comparison

```
┌──────────────────────────────────────────────────────────┐
│              LOCAL vs PRODUCTION                         │
├──────────────────────────────────────────────────────────┤
│                                                          │
│ LOCAL (Laragon)          │    PRODUCTION (Vercel)        │
│ ─────────────────────────┼────────────────────────────   │
│ http://deployment.test   │ https://item-manager...app    │
│ Your computer            │ Cloud servers (worldwide)     │
│ No SSL                   │ SSL/HTTPS included           │
│ File system persistence  │ Temporary file system (24h)  │
│ Direct file access       │ Managed environment          │
│ Visible logs             │ Logs in Vercel dashboard     │
│ Manual restart needed    │ Auto-restart/redeploy        │
│ Single user/testing      │ Multiple users/production    │
│                          │                              │
└──────────────────────────────────────────────────────────┘
```

---

## Summary

**Before Deployment:**
- Code di komputer lokal Anda
- Only accessible via `http://localhost:8000` atau `http://deployment.test`
- Cannot be accessed by others

**After Deployment:**
- Code di GitHub (backup & version control)
- Application live di Vercel (publicly accessible)
- Anyone dengan URL bisa akses
- Auto-deploy saat Anda push changes

---

Generated: December 2025
