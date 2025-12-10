# 🚀 QUICK START CARD - DEPLOYMENT

Cetak/save file ini untuk referensi cepat!

---

## 📋 PRE-DEPLOYMENT CHECKLIST

Sebelum mulai, pastikan:
- [ ] GitHub account (https://github.com/signup)
- [ ] Git installed (https://git-scm.com)
- [ ] Vercel account (https://vercel.com/signup)
- [ ] Folder: E:\laragon\www\deployment
- [ ] Files ada: api/, public/, router.php
- [ ] Local test works: http://deployment.test

---

## 🎯 5 SIMPLE STEPS

### STEP 1: Git Configuration
```powershell
git config --global user.name "Your Name"
git config --global user.email "your@email.com"
cd E:\laragon\www\deployment
git init
git add .
git commit -m "Initial commit"
```
⏱️ Time: 1 minute

---

### STEP 2: GitHub Setup
1. Go to: https://github.com/new
2. Name: item-manager-api
3. Create (uncheck README/gitignore)
4. Copy the URL shown
⏱️ Time: 1 minute

---

### STEP 3: Push to GitHub
```powershell
git branch -M main
git remote add origin https://github.com/USERNAME/item-manager-api.git
git push -u origin main
```
Replace: USERNAME = your GitHub username
⏱️ Time: 1 minute

---

### STEP 4: Deploy to Vercel
1. Go to: https://vercel.com
2. Click: Add New → Project
3. Select: item-manager-api repo
4. Click: Deploy
5. Wait 1-2 minutes
6. Copy domain (like: https://item-manager-api-xxx.vercel.app)
⏱️ Time: 2 minutes

---

### STEP 5: Update URLs
Edit: `E:\laragon\www\deployment\public\app.js`

Find line 1:
```javascript
const API_BASE = "/api/items";
```

Replace with:
```javascript
const API_BASE = "https://item-manager-api-xxx.vercel.app/api/items";
```
(Use YOUR domain from Step 4)

Then:
```powershell
git add public/app.js
git commit -m "Update API URL"
git push
```
⏱️ Time: 2 minutes

---

## ✅ TOTAL TIME: ~5-10 minutes for first deployment

---

## 🔗 Important URLs

Keep these bookmarked:

| Service | URL |
|---------|-----|
| GitHub | https://github.com/USERNAME/item-manager-api |
| Vercel | https://vercel.com/dashboard |
| Your App | https://item-manager-api-xxx.vercel.app |
| API Docs | https://item-manager-api-xxx.vercel.app (README.md) |

---

## 🆘 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| Git not found | Install from https://git-scm.com |
| Remote already exists | `git remote remove origin` then retry |
| Push rejected | Check URL correct, use HTTPS not SSH |
| Build failed | Check Vercel dashboard → Logs |
| 404 Not Found | Wait 2 min, hard refresh (Ctrl+F5) |
| Data lost | Normal! Vercel doesn't persist files - use database for production |

More help: See TROUBLESHOOTING.md

---

## 📚 Documentation Files

Need more details?

- **DEPLOYMENT.md** - Full explanation
- **DEPLOYMENT_CHECKLIST.md** - Detailed step-by-step
- **TROUBLESHOOTING.md** - 15 problem solutions
- **DEPLOYMENT_ARCHITECTURE.md** - How it works (diagrams)

---

## 🔄 Future Updates

After deployment, to make changes:

```powershell
# Make changes locally
# Edit files...
# Then:
git add .
git commit -m "Your changes"
git push
# Vercel auto-deploys in 1-2 min
```

---

## ⚡ Tips

1. **Browser Cache:** After push, do Ctrl+F5 to see latest version
2. **Logs:** Check Vercel dashboard for build/deployment logs
3. **Data Loss:** Expected - files reset every 24h on Vercel
4. **Testing:** Use POSTMAN_QUICK_REFERENCE.md to test API
5. **Support:** See TROUBLESHOOTING.md for 15+ common issues

---

## 📱 Testing After Deployment

### Test 1: Web UI
```
Open: https://your-domain.vercel.app
Should see: Form + Item list
```

### Test 2: Create Item
```
1. Fill form
2. Click "Simpan"
3. Item should appear in list
```

### Test 3: API (Postman)
```
Update URL from:
http://deployment.test/api/items
To:
https://your-domain.vercel.app/api/items

Test GET, POST, PUT, DELETE
```

---

## 📞 Get Help

If stuck:
1. Check TROUBLESHOOTING.md
2. View Vercel build logs
3. Search error on Google
4. Ask on Stack Overflow

---

**Print this card & keep it handy! 📌**

---

Generated: December 2025
Item Manager API - PHP CRUD with UI
GitHub + Vercel Deployment
