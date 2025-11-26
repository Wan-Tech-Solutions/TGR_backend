# Multiple Email Addresses - Quick Reference Card

## 🚀 Quick Access

| Action | Location |
|--------|----------|
| View all addresses | Sidebar → Email → Email Addresses |
| Add new | Click **+ Add Email Address** button |
| Edit | Click **Edit** button in list |
| View emails | Click on address in inbox (coming soon) |

## 📋 Routes

```
GET  /admin-email-addresses                    → List
GET  /admin-email-addresses/create             → Create Form
POST /admin-email-addresses                    → Store
GET  /admin-email-addresses/{id}/edit          → Edit Form
PUT  /admin-email-addresses/{id}               → Update
POST /admin-email-addresses/{id}/toggle-active → Toggle Active
POST /admin-email-addresses/{id}/toggle-auto-sync → Toggle Sync
DEL  /admin-email-addresses/{id}               → Delete
```

## 🔍 Search by

- Email address
- Label/Category
- Description

## ⚙️ Configuration Fields

### Basic
- **Email** (unique, required)
- **Label** (category name, required)
- **Description** (optional notes)

### IMAP/POP3 (Optional)
- **Host** (e.g., imap.gmail.com)
- **Port** (993 for IMAP SSL, 110 for POP3)
- **Encryption** (SSL, TLS, or None)
- **Password** (encrypted, optional)

### Options
- **Active** (checkbox) - Enable/disable email receiving
- **Auto-Sync** (checkbox) - Automatic email import

## 🎯 Common Tasks

### Add Email Address
```
1. Admin Portal → Email Addresses
2. Click + Add Email Address
3. Fill Email, Label
4. Click Add Email Address
```

### Setup IMAP Auto-Sync
```
1. Edit the address
2. Enter Mail Server Host
3. Enter Port (993 for Gmail)
4. Select Encryption (SSL for Gmail)
5. Enter Password
6. Enable Auto-Sync
7. Save
```

### Deactivate Address
```
1. Find address in list
2. Click red/green status button
3. Address toggled to inactive
```

### Delete Address
```
1. Find address in list
2. Click trash icon
3. Confirm in modal
```

## 📊 Statistics Dashboard

Shows on list page:
- **Total**: All addresses
- **Active**: Enabled addresses
- **Inactive**: Disabled addresses
- **Auto-Sync**: Addresses with sync enabled

## 🔒 Security

- ✅ Passwords encrypted
- ✅ All inputs validated
- ✅ Authentication required
- ✅ Soft deletes available

## 💾 Database

| Table | Purpose |
|-------|---------|
| email_addresses | Store address configurations |
| incoming_emails | Updated with email_address_id |

## 📱 Mobile Friendly

- ✅ Responsive design
- ✅ Touch-friendly buttons
- ✅ Mobile pagination
- ✅ Mobile search

## 🆘 Quick Troubleshooting

| Issue | Solution |
|-------|----------|
| Can't see feature | Clear cache, log out/in |
| Can't add address | Check email is unique |
| Port validation error | Use 1-65535 range |
| Can't access URL | Verify auth middleware |
| Can't enable sync | Configure IMAP/POP3 first |

## 📞 Support Info

- **Feature:** Multiple Email Addresses
- **Version:** 1.0
- **Status:** Production Ready
- **Last Updated:** Nov 26, 2025

## 🔗 Related Features

- Inbox System (receives emails)
- Email Tracking
- Email Management
- Audit Trail

## 💡 Pro Tips

1. **Use descriptive labels** for easy identification
2. **Enable auto-sync** for important addresses
3. **Deactivate** instead of delete to preserve data
4. **Use strong passwords** for IMAP/POP3
5. **Monitor sync status** to ensure emails are imported

## 📖 Documentation

| Doc | Purpose |
|-----|---------|
| MULTIPLE_EMAIL_ADDRESSES.md | Full technical docs |
| MULTIPLE_EMAIL_ADDRESSES_QUICKSTART.md | Testing & setup |
| This file | Quick reference |

---

**Version:** 1.0 | **Date:** Nov 26, 2025 | **Status:** ✅ Ready

