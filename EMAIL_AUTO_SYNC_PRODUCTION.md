# Email Auto-Sync Setup for Production

## ✅ Automatic Email Synchronization

Your TGR backend is now configured to **automatically synchronize emails** from all configured email addresses!

## 🔧 How It Works

### Scheduling Configuration
The scheduler is configured in `app/Console/Kernel.php`:

```php
$schedule->command('app:check-email')
         ->everyFiveMinutes()           // Check every 5 minutes
         ->withoutOverlapping()         // Prevent duplicate runs
         ->appendOutputTo(...);         // Log all sync activity
```

This means:
- ✅ Emails sync **every 5 minutes** automatically
- ✅ New emails appear in inbox within 5 minutes of arrival
- ✅ Logs are saved to `storage/logs/email-sync.log`
- ✅ Duplicate sync jobs are prevented

## 🚀 Production Setup (Required!)

### For Production to Work, You MUST Set Up One of These:

#### Option 1: Linux/Ubuntu Server (Recommended)
Add a cron job to run Laravel's scheduler:

```bash
# Edit crontab
crontab -e

# Add this line
* * * * * cd /path/to/TGR_backend && php artisan schedule:run >> /dev/null 2>&1
```

This runs the scheduler **every minute**, which triggers your 5-minute sync cycle.

#### Option 2: Windows Server
Create a scheduled task:

```powershell
# Run PowerShell as Administrator
New-ScheduledTaskAction -Execute 'C:\xampp\php\php.exe' `
  -Argument 'C:\path\to\TGR_backend\artisan schedule:run' | `
  Register-ScheduledTask -TaskName "EmailSync" -Trigger (New-ScheduledTaskTrigger -Once -At (Get-Date).AddMinutes(1) -RepetitionInterval (New-TimeSpan -Minutes 1) -RepetitionDuration (New-TimeSpan -Days 999))
```

#### Option 3: Using a Service Like EasyCron
If you can't access server cron:

1. Go to: https://www.easycron.com
2. Create a cron job:
   - **URL:** `https://your-domain.com/api/schedule`
   - **Frequency:** Every 5 minutes
3. Laravel will handle the rest

#### Option 4: Using Supervisor (Advanced)
Create a background worker that continuously runs:

```ini
[program:laravel-scheduler]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/TGR_backend/artisan schedule:work
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel-scheduler.log
```

## 📋 Email Sync Flow

```
Every 5 Minutes:
  1. Scheduler triggers 'app:check-email' command
  2. Command finds all active addresses with auto-sync enabled
  3. For each address:
     - Connects to IMAP server (Gmail, etc.)
     - Fetches unread/new emails
     - Stores emails in database
     - Updates last_synced_at timestamp
  4. Process completes
  5. Wait 5 minutes, repeat
```

## 🔒 Security Considerations

### Passwords
- ✅ All passwords encrypted using Laravel encryption
- ✅ Never stored in plain text
- ✅ Can only be decrypted with APP_KEY

### Credentials
Store securely in `.env`:
```bash
APP_KEY=base64:your-encryption-key
MAIL_HOST=imap.gmail.com
MAIL_PORT=993
```

### Best Practices
1. **Use App Passwords** - Gmail: Use 2FA + app-specific password (NOT your real password)
2. **Rotate Passwords** - Change IMAP passwords periodically
3. **Monitor Logs** - Check `storage/logs/email-sync.log` regularly
4. **Limit Permissions** - Use restricted app accounts when possible

## 📊 Monitoring & Logs

### View Sync Logs
```bash
# See latest syncs
tail -f storage/logs/email-sync.log

# See sync errors
grep "ERROR" storage/logs/email-sync.log

# See imported email count
grep "Imported:" storage/logs/email-sync.log | wc -l
```

### Log Output Example
```
🔄 Starting email sync process...
📧 Found 3 address(es) to sync

📬 Syncing: info@tgrafrica.com (Primary)
   🔗 Connecting to imap.gmail.com...
   📨 Found 5 new email(s)
   ✓ Imported: sender@example.com - Subject Line
   ✓ Imported: another@sender.com - Another Subject
   ✅ Sync completed - 5 email(s) imported

📬 Syncing: ojamkwab@gmail.com (Primary)
   🔗 Connecting to imap.gmail.com...
   📨 Found 0 new email(s)
   ✅ Sync completed - 0 email(s) imported

✅ Email sync completed successfully!
```

## 🧪 Testing Sync

### Manual Test
```bash
# Sync all active addresses
php artisan app:check-email

# Sync specific address
php artisan app:check-email --address=ojamkwab@gmail.com

# Sync with verbose output
php artisan app:check-email -v
```

### Verify Scheduling
```bash
# See what's scheduled
php artisan schedule:list

# Run scheduler in foreground (testing)
php artisan schedule:work
```

## ⚙️ Configuration Options

### In `app/Console/Kernel.php`

Change sync frequency:
```php
// Every minute
$schedule->command('app:check-email')->everyMinute();

// Every 10 minutes
$schedule->command('app:check-email')->everyTenMinutes();

// Every 30 minutes
$schedule->command('app:check-email')->everyThirtyMinutes();

// Hourly
$schedule->command('app:check-email')->hourly();

// Daily at specific time
$schedule->command('app:check-email')->dailyAt('02:00');
```

### Prevent Overlapping
```php
// Prevents command from running twice at same time
->withoutOverlapping()

// With custom timeout (default 24 hours)
->withoutOverlapping(timeout: 120) // 120 minutes
```

## 🐛 Troubleshooting

### Emails Not Syncing
1. **Check if scheduler is running:**
   ```bash
   # Verify cron job exists
   crontab -l
   ```

2. **Check logs for errors:**
   ```bash
   tail -f storage/logs/email-sync.log
   ```

3. **Verify address is active:**
   - Admin Portal → Email Addresses
   - Ensure "Active" is ✅ and "Auto-Sync" is ✅

4. **Test IMAP manually:**
   ```bash
   php artisan app:check-email --address=your@email.com -v
   ```

### High CPU/Memory Usage
- Reduce sync frequency: `everyThirtyMinutes()` or `hourly()`
- Set connection timeout in IMAP configuration
- Monitor `storage/logs/email-sync.log`

### Sync Taking Too Long
- Check email account for extremely large mailbox
- Consider filtering old emails
- May need to increase server timeout

## 📈 Performance Tips

1. **Indexes:** Database indexed on `is_active`, `email`, `uuid` for fast queries
2. **Pagination:** Fetches emails in batches to avoid memory issues
3. **Duplicate Prevention:** Checks `message_id` to prevent duplicates
4. **Connection Pooling:** Reuses IMAP connections where possible

## 🔔 Notifications (Optional)

You can add notifications when sync fails:

```php
$schedule->command('app:check-email')
         ->everyFiveMinutes()
         ->onFailure(function () {
             \Log::error('Email sync failed!');
             // Send alert email
         })
         ->onSuccess(function () {
             \Log::info('Email sync successful!');
         });
```

## 📋 Deployment Checklist

Before going to production:

- [ ] IMAP extension installed on server
- [ ] Email addresses configured with credentials
- [ ] Auto-sync enabled on addresses that should sync
- [ ] Cron job or scheduler configured
- [ ] `storage/logs` directory writable
- [ ] `.env` file has correct encryption key
- [ ] Test email sync with `php artisan app:check-email`
- [ ] Check logs: `tail -f storage/logs/email-sync.log`
- [ ] Verify emails appear in inbox within 5 minutes
- [ ] Monitor for 24 hours after deployment
- [ ] Set up alerts for sync failures

## 🎉 You're All Set!

Once you set up the cron job or scheduler on your production server, emails will automatically sync every 5 minutes!

### Quick Reference:

| Action | Command |
|--------|---------|
| Manual sync | `php artisan app:check-email` |
| Sync specific email | `php artisan app:check-email --address=email@example.com` |
| View scheduler | `php artisan schedule:list` |
| Test scheduler | `php artisan schedule:work` |
| View logs | `tail -f storage/logs/email-sync.log` |

---

**Version:** 1.0
**Status:** ✅ Production Ready
**Date:** November 26, 2025

