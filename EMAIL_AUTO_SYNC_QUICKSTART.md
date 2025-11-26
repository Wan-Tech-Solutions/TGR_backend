# Email Auto-Sync - Production Deployment Quick Guide

## ✅ Current Status

Your application is **configured for automatic email sync**!

### Scheduler Configuration
- ✅ Every 5 minutes: Sync all active addresses
- ✅ Every hour: Full sync (backup cycle)
- ✅ Logs: `storage/logs/email-sync.log`
- ✅ No overlapping: Prevents duplicate syncs

## 🚀 Production Deployment - Choose ONE

### 1️⃣ Linux/Ubuntu/CentOS (Most Common)

**On your production server:**

```bash
# SSH into your server
ssh user@your-server.com

# Edit crontab
crontab -e

# Add this single line:
* * * * * cd /path/to/TGR_backend && php artisan schedule:run >> /dev/null 2>&1

# Save (Ctrl+X, then Y, then Enter)
```

**Verify it's working:**
```bash
# Check cron is set
crontab -l

# Check logs after 5-10 minutes
tail -f /path/to/TGR_backend/storage/logs/email-sync.log
```

---

### 2️⃣ Windows Server

**Create scheduled task (run PowerShell as Administrator):**

```powershell
# Navigate to your project
cd C:\path\to\TGR_backend

# Create task
schtasks /create /tn "EmailSync" /tr "C:\xampp\php\php.exe C:\path\to\TGR_backend\artisan schedule:run" /sc minute /mo 1 /ru SYSTEM

# Verify task
schtasks /query /tn "EmailSync"
```

**Or use GUI:**
- Open Task Scheduler
- Create Basic Task: "EmailSync"
- Trigger: Every 1 minute
- Action: Start a program
- Program: `C:\xampp\php\php.exe`
- Arguments: `C:\path\to\TGR_backend\artisan schedule:run`

---

### 3️⃣ Shared Hosting (If No Cron Access)

**Use EasyCron (Free):**

1. Go to: https://www.easycron.com
2. Sign up (free)
3. Create cron job:
   - **URL:** `https://your-domain.com/schedule`
   - **Frequency:** Every 5 minutes
4. Done! ✅

**Or contact your host:**
- Ask to add cron job: `php artisan schedule:run`
- Run every 1 minute

---

## 📊 What Happens Automatically

```
Every 5 minutes (On Production):
├─ Check all active email addresses
├─ For each address with auto-sync enabled:
│  ├─ Connect to IMAP (Gmail, Outlook, etc.)
│  ├─ Fetch new/unread emails
│  ├─ Store in database
│  └─ Update last_synced_at
└─ Log results to storage/logs/email-sync.log
```

## ✅ Verification Checklist

After setting up cron job:

```bash
# 1. Wait 5-10 minutes

# 2. Check logs
tail -f storage/logs/email-sync.log

# Expected output:
# 🔄 Starting email sync process...
# 📧 Found 3 address(es) to sync
# 📬 Syncing: ojamkwab@gmail.com (Primary)
# ✅ Email sync completed successfully!

# 3. Check if new emails appear in inbox
# Admin → Email → Inbox
```

## 🔧 Configuration Details

**Current Schedule (in `app/Console/Kernel.php`):**
```php
// Every 5 minutes
$schedule->command('app:check-email')
         ->everyFiveMinutes()
         ->withoutOverlapping()
         ->appendOutputTo(storage_path('logs/email-sync.log'));
```

**To Change Frequency:**
Edit `app/Console/Kernel.php`:
```php
// Every minute
->everyMinute()

// Every 10 minutes  
->everyTenMinutes()

// Every 30 minutes
->everyThirtyMinutes()

// Hourly
->hourly()

// Daily at 2 AM
->dailyAt('02:00')
```

## 🆘 Troubleshooting

### Emails Not Syncing?

**Check 1: Is cron running?**
```bash
# List cron jobs (Linux)
crontab -l

# List tasks (Windows)
schtasks /query /tn "EmailSync"
```

**Check 2: Are addresses configured?**
- Go to: Admin → Email Addresses
- Ensure addresses have:
  - ✅ Active: Yes
  - ✅ Auto-Sync: Yes
  - ✅ Host: imap.gmail.com (or your mail server)
  - ✅ Port: 993
  - ✅ Password: Set

**Check 3: View logs**
```bash
tail -f storage/logs/email-sync.log
```

**Check 4: Manual test**
```bash
php artisan app:check-email --address=your@email.com -v
```

### High CPU/Memory?
- Reduce frequency: Change `everyFiveMinutes()` to `everyThirtyMinutes()`
- Check for corrupted emails causing parse errors
- Monitor database query count

## 📈 Performance Notes

- **Database:** Optimized with indexes on `email`, `uuid`, `is_active`
- **Memory:** Processes emails in batches to avoid overflow
- **Time:** Typically completes in seconds (depends on email count)
- **Logging:** All activity logged to file for monitoring

## 🔒 Security

- ✅ Passwords encrypted with Laravel encryption
- ✅ All database queries use parameterized queries (no SQL injection)
- ✅ IMAP credentials never exposed in logs
- ✅ Only admins can view/edit email addresses
- ✅ Soft deletes enable email recovery

## 🎯 Summary

| Item | Status |
|------|--------|
| Command Created | ✅ `app:check-email` |
| Scheduler Configured | ✅ Every 5 minutes |
| IMAP Support | ✅ Enabled & tested |
| Email Addresses | ✅ Multiple supported |
| Auto-Sync | ✅ Ready to activate |
| Production Ready | ✅ Yes |

---

## 📋 Next Steps

1. **Choose your deployment option** (1, 2, or 3 above)
2. **Set up cron job or scheduled task**
3. **Wait 5-10 minutes**
4. **Check logs:** `tail -f storage/logs/email-sync.log`
5. **Verify emails appear in inbox**
6. **Monitor for 24 hours after going live**

---

**Questions?** See `EMAIL_AUTO_SYNC_PRODUCTION.md` for detailed information.

**Version:** 1.0 | **Date:** Nov 26, 2025 | **Status:** ✅ Production Ready

