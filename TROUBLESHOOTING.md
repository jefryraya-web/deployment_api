# 🔧 DEPLOYMENT TROUBLESHOOTING GUIDE

## Problem 1: Git Command Not Found

### Error Message:
```
'git' is not recognized as an internal or external command
```

### Cause:
Git tidak terinstall atau tidak di-add ke PATH

### Solutions:

**Option A: Install Git**
1. Download: https://git-scm.com/download/win
2. Run installer
3. Default settings okay
4. Restart PowerShell

**Option B: Check PATH**
```powershell
git --version
```

Should output: `git version 2.41.0` (atau versi lainnya)

If still error:
1. Restart komputer
2. Try again

---

## Problem 2: fatal: not a git repository

### Error Message:
```
fatal: not a git repository (or any of the parent directories): .git
```

### Cause:
Belum menjalankan `git init` di folder yang benar

### Solutions:

**Check current directory:**
```powershell
pwd
```

Should output: `E:\laragon\www\deployment`

**If wrong directory:**
```powershell
cd E:\laragon\www\deployment
```

**Initialize git:**
```powershell
git init
git add .
git commit -m "Initial commit"
```

---

## Problem 3: error: remote origin already exists

### Error Message:
```
fatal: remote origin already exists.
```

### Cause:
Remote sudah ditambahkan sebelumnya

### Solutions:

**Check existing remotes:**
```powershell
git remote -v
```

**Remove existing remote:**
```powershell
git remote remove origin
```

**Add new remote:**
```powershell
git remote add origin https://github.com/USERNAME/item-manager-api.git
```

**Try push again:**
```powershell
git push -u origin main
```

---

## Problem 4: Permission Denied (SSH)

### Error Message:
```
fatal: Could not read from remote repository.
Please make sure you have the correct access rights
and the repository exists.
```

### Cause:
SSH key not configured (jika menggunakan SSH URL)

### Solutions:

**Use HTTPS instead of SSH:**
```powershell
git remote set-url origin https://github.com/USERNAME/item-manager-api.git
```

Instead of:
```
git@github.com:USERNAME/item-manager-api.git
```

**Or configure SSH key:**
1. Generate SSH key: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-gpg-key
2. Add to GitHub: https://github.com/settings/keys
3. Use SSH URL

---

## Problem 5: Authentication Failed

### Error Message:
```
fatal: Authentication failed for 'https://github.com/...'
```

Or prompt asking for username/password repeatedly

### Cause:
Password tidak benar atau GitHub token expired

### Solutions:

**Option A: Generate GitHub Token**
1. Go to: https://github.com/settings/tokens
2. Click "Generate new token"
3. Select scopes: `repo`, `workflow`
4. Copy token
5. Use as password when prompted

**Option B: Save Credentials**
```powershell
git config --global credential.helper wincred
```

Then next push will ask for credentials once, then save them.

**Option C: SSH Key**
Follow SSH key setup from Problem 4

---

## Problem 6: Vercel Build Failed

### Error Message (in Vercel Dashboard):
```
Build failed: Error ...
```

### Common Causes & Solutions:

**Cause A: vercel.json format error**
1. Check file: `vercel.json`
2. Verify JSON syntax (valid brackets, quotes)
3. Use JSON validator: https://jsonlint.com/

**Fix:**
```powershell
git add vercel.json
git commit -m "Fix vercel.json"
git push
```

---

**Cause B: PHP file has syntax error**
1. Check `api/index.php` for PHP errors
2. Verify `.php` files valid

**Local test:**
```powershell
php -l api/index.php
```

Output should be: `No syntax errors detected`

---

**Cause C: Missing file or wrong path**
1. Check all files exist in repository
2. Paths in vercel.json must be correct
3. No hardcoded absolute paths (E:\laragon\...)

---

## Problem 7: 404 Not Found in Vercel

### Error Message:
```
404 Not Found
The requested URL was not found on this server.
```

When visiting: `https://item-manager-api.vercel.app`

### Cause:
Routing not configured correctly

### Solutions:

**Check vercel.json routing:**
```json
"routes": [
  {
    "src": "/api/(.*)",
    "dest": "/api/index.php"
  },
  {
    "src": "/(?!api).*",
    "dest": "/public/index.html",
    "check": true
  },
  {
    "src": "/(.*)",
    "dest": "/router.php"
  }
]
```

**Push update:**
```powershell
git add vercel.json
git commit -m "Fix routing in vercel.json"
git push
```

---

## Problem 8: API Returning 500 Error

### Error Message:
```
HTTP 500 Internal Server Error
```

In browser console or Postman response

### Cause:
PHP error atau API code issue

### Solutions:

**Check Vercel Logs:**
1. Go to Vercel dashboard
2. Select project
3. Go to "Deployments"
4. Select latest deployment
5. View "Logs" tab

**Common issues:**
- Syntax error in PHP
- File not found
- Permission denied
- Missing extension

**Check locally first:**
```powershell
php api/index.php
```

If error, fix locally:
```powershell
php -l api/index.php
```

---

## Problem 9: CORS Error in Browser

### Error Message:
```
Access to XMLHttpRequest at 'https://...' from origin 'https://...'
has been blocked by CORS policy
```

### Cause:
CORS headers tidak dikirim dari API

### Solutions:

**Check api/index.php has CORS headers:**
```php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
```

**If missing, add:**
```powershell
# Edit file locally
# Add headers to api/index.php
# Save
git add api/index.php
git commit -m "Add CORS headers to API"
git push
```

---

## Problem 10: Data Not Persisting in Vercel

### Issue:
Data created via web/API doesn't persist. After 24h it's gone.

### Cause:
Vercel doesn't have persistent file system. `data.json` gets deleted/reset.

### Solutions:

**Short Term (Testing):**
Nothing to do - this is expected behavior in Vercel free tier

**Long Term (Production):**
Need to use real database:

**Option 1: Cloud Database**
- Firebase Realtime Database
- MongoDB Atlas (cloud)
- MySQL/PostgreSQL cloud
- Supabase

**Option 2: Alternative Hosting**
- Railway.app
- Render.com
- Heroku (paid)
- DigitalOcean
- Linode

**Option 3: Vercel KV (Paid)**
- Vercel KV Storage (Redis)
- ~$0.20 per day
- More info: https://vercel.com/kv

### Recommendation:
For production app, use Firebase or Supabase (free tier available)

---

## Problem 11: Changes Not Showing After Push

### Issue:
After `git push`, website still shows old version

### Cause:
Vercel cache or browser cache not cleared

### Solutions:

**Clear Browser Cache:**
- Press: `Ctrl + Shift + Delete`
- Select: "All time"
- Clear

**Or Hard Refresh:**
- Press: `Ctrl + F5` (or `Cmd + Shift + R` on Mac)

**Force Redeploy in Vercel:**
1. Go to Vercel dashboard
2. Select project
3. Go to "Deployments"
4. Find latest deployment
5. Click "..." → "Redeploy"

---

## Problem 12: Can't Edit vercel.json

### Error:
File doesn't exist or can't save

### Solutions:

**Create vercel.json:**
1. Open VSCode
2. File → New File
3. Name: `vercel.json`
4. Save in: `E:\laragon\www\deployment\`

**Content:**
```json
{
  "version": 2,
  "builds": [
    {
      "src": "router.php",
      "use": "@vercel/php"
    }
  ],
  "routes": [
    {
      "src": "/api/(.*)",
      "dest": "/api/index.php"
    },
    {
      "src": "/(.*)",
      "dest": "/router.php"
    }
  ]
}
```

**Push to GitHub:**
```powershell
git add vercel.json
git commit -m "Add vercel.json configuration"
git push
```

---

## Problem 13: Repository URL Wrong

### Error:
After `git remote add origin`, realize URL is wrong

### Solutions:

**Check current URL:**
```powershell
git remote -v
```

**Update URL:**
```powershell
git remote set-url origin https://github.com/USERNAME/item-manager-api.git
```

**Verify:**
```powershell
git remote -v
```

---

## Problem 14: PowerShell Execution Policy

### Error:
```
cannot be loaded because running scripts is disabled on this system
```

### Solutions:

**Option A: Use Command Prompt instead**
- Press `Win + R`
- Type: `cmd`
- Run commands there

**Option B: Change Execution Policy**
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

---

## Problem 15: GitHub Authentication (First Time)

### Issue:
When pushing, browser opens for authentication

### Cause:
First time pushing to GitHub from this computer

### Solutions:

**Authenticate:**
1. Browser will open github.com login
2. Login with your account
3. Authorize Git
4. Return to PowerShell
5. Push will continue

**Future pushes:**
Won't need authentication (credentials saved)

---

## 🆘 Still Having Issues?

### Debug Checklist:

- [ ] Verify folder: `E:\laragon\www\deployment`
- [ ] Check files exist: `api/`, `public/`, `router.php`
- [ ] Git initialized: `git init` done
- [ ] GitHub account created: https://github.com
- [ ] GitHub repo created: github.com/USERNAME/item-manager-api
- [ ] Vercel account created: https://vercel.com
- [ ] Local testing working: http://deployment.test works
- [ ] All files committed locally: `git status` shows nothing
- [ ] vercel.json valid: https://jsonlint.com/

### Get Help:

1. **Vercel Logs:** Check deployment logs in dashboard
2. **GitHub Issues:** Create issue in repo
3. **Stack Overflow:** Search & ask PHP/Vercel questions
4. **Vercel Discord:** https://discord.gg/vercel

---

Generated: December 2025
