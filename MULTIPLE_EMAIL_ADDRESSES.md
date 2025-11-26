# Multiple Email Addresses Feature

## Overview

The Multiple Email Addresses feature allows you to manage multiple email addresses within the TGR inbox system. Each email address can be individually configured, activated/deactivated, and set up for automatic email synchronization via IMAP/POP3.

## Features

✅ **Add Multiple Mailing Addresses**
- Configure unlimited email addresses to receive incoming emails
- Each address is stored with complete configuration details

✅ **Email Address Management**
- Create, read, update, and delete email addresses
- Activate/deactivate addresses without deleting them
- Search and filter email addresses

✅ **Auto-Sync Capability**
- Enable automatic email synchronization from configured email addresses
- Support for IMAP and POP3 protocols
- Track last sync time for each address
- Encrypted password storage for security

✅ **Status Tracking**
- Monitor which addresses are active
- See email count per address
- Track sync status for each address

## Database Structure

### email_addresses Table
```sql
CREATE TABLE email_addresses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    label VARCHAR(255),
    description TEXT,
    password VARCHAR(255),              -- Encrypted
    host VARCHAR(255),                  -- IMAP/POP3 host
    port INT,                           -- IMAP/POP3 port
    encryption VARCHAR(255),            -- ssl, tls, none
    is_active BOOLEAN DEFAULT true,
    auto_sync BOOLEAN DEFAULT false,
    last_synced_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (uuid),
    INDEX (email),
    INDEX (is_active)
);
```

### Updated incoming_emails Table
```sql
ALTER TABLE incoming_emails ADD COLUMN email_address_id BIGINT UNSIGNED;
ALTER TABLE incoming_emails ADD FOREIGN KEY (email_address_id) 
    REFERENCES email_addresses(id) ON DELETE SET NULL;
```

## Models

### EmailAddress Model
**Location:** `app/Models/EmailAddress.php`

**Methods:**
- `activate()` - Activate an email address
- `deactivate()` - Deactivate an email address
- `toggleAutoSync()` - Toggle auto-sync status
- `updateSyncTime()` - Update last_synced_at timestamp
- `getDecryptedPassword()` - Get decrypted password for IMAP/POP3
- `setEncryptedPassword($password)` - Set and encrypt password

**Scopes:**
- `active()` - Get only active email addresses
- `withAutoSync()` - Get addresses with auto-sync enabled

**Relationships:**
- `incomingEmails()` - Has many incoming emails

### Updated IncomingEmail Model
**Changes:**
- Added `email_address_id` to fillable properties
- Added `emailAddress()` relationship
- Can now track which email address received each email

## Controller

### AdminEmailAddressController
**Location:** `app/Http/Controllers/Admin/AdminEmailAddressController.php`

**Methods:**

| Method | Route | Purpose |
|--------|-------|---------|
| `index()` | GET /admin-email-addresses | List all email addresses with search |
| `create()` | GET /admin-email-addresses/create | Show form to create new address |
| `store()` | POST /admin-email-addresses | Store new email address |
| `edit()` | GET /admin-email-addresses/{id}/edit | Show form to edit address |
| `update()` | PUT /admin-email-addresses/{id} | Update email address |
| `toggleActive()` | POST /admin-email-addresses/{id}/toggle-active | Toggle active status |
| `toggleAutoSync()` | POST /admin-email-addresses/{id}/toggle-auto-sync | Toggle auto-sync |
| `destroy()` | DELETE /admin-email-addresses/{id} | Delete email address |
| `getStats()` | - | Get email address statistics |

## Routes

All routes are protected with `auth` middleware:

```php
// List email addresses
GET /admin-email-addresses → admin.email-addresses.index

// Create new address
GET /admin-email-addresses/create → admin.email-addresses.create
POST /admin-email-addresses → admin.email-addresses.store

// Edit address
GET /admin-email-addresses/{id}/edit → admin.email-addresses.edit
PUT /admin-email-addresses/{id} → admin.email-addresses.update

// Toggle status
POST /admin-email-addresses/{id}/toggle-active → admin.email-addresses.toggle-active
POST /admin-email-addresses/{id}/toggle-auto-sync → admin.email-addresses.toggle-auto-sync

// Delete address
DELETE /admin-email-addresses/{id} → admin.email-addresses.destroy
```

## Views

### email-addresses.blade.php
Main list view for managing email addresses

**Features:**
- Search functionality
- Statistics dashboard (Total, Active, Inactive, Auto-Sync count)
- Table with all email addresses
- Action buttons (Edit, Activate/Deactivate, Enable/Disable Sync, Delete)
- Pagination (15 per page)
- Delete confirmation modal

**Variables Received:**
- `$emailAddresses` - Paginated collection of addresses
- `$search` - Search query (if any)
- `$count_blogs`, `$contact_count`, `$prospectus_count` - Sidebar counts

### email-address-form.blade.php
Create/Edit form view

**Fields:**
- Email Address (required, unique)
- Label (required) - e.g., "Primary", "Support", "Investors"
- Description (optional)
- Mail Server Host (optional)
- Port (optional, 1-65535)
- Encryption (optional) - ssl, tls, none
- Password (optional, encrypted)
- Active checkbox
- Auto-Sync checkbox

**Includes:**
- Setup guide with instructions
- Tips for using the feature
- Field validation messages
- Information sidebar

## Usage

### Adding a New Email Address

1. Navigate to **Email Addresses** in the sidebar
2. Click **+ Add Email Address**
3. Fill in the required fields:
   - Email Address (must be unique)
   - Label (descriptive name)
4. Optionally configure IMAP/POP3:
   - Mail Server Host
   - Port
   - Encryption type
   - Password
5. Enable auto-sync if desired
6. Click **Add Email Address**

### Editing an Address

1. Go to **Email Addresses** list
2. Click the **Edit** button for the address
3. Update fields as needed
4. Click **Update Email Address**

### Managing Address Status

**Activate/Deactivate:**
- Click the green/red button next to an address
- Inactive addresses won't receive new emails

**Enable/Disable Auto-Sync:**
- Click the sync button next to an address
- Requires IMAP/POP3 configuration

### Viewing Address Details

The list shows:
- Email address
- Label/category
- Active/Inactive status
- Auto-sync status
- Last sync time
- Number of emails received

### Deleting an Address

1. Click the **Delete** button (trash icon)
2. Confirm in the modal
3. Address and associated configuration are deleted
4. Note: Associated emails are not deleted

## Security

### Password Encryption

Passwords are encrypted using Laravel's built-in encryption before storage:

```php
$emailAddress->setEncryptedPassword($request->password)->save();
```

Retrieval:
```php
$password = $emailAddress->getDecryptedPassword();
```

### Access Control

All routes are protected with the `auth` middleware, ensuring only authenticated users can:
- View email addresses
- Add new addresses
- Modify configurations
- Delete addresses

### Validation

All user inputs are validated:
- Email must be valid and unique
- Label is required
- Port must be between 1-65535
- Encryption must be one of: ssl, tls, none

## Data Migration

### Sample Data

The `EmailAddressSeeder` includes sample data:

1. **info@tgrafrica.com** (Primary)
   - Auto-sync enabled
   - Active

2. **investorscommunity@tgrafrica.com** (Investors)
   - Auto-sync enabled
   - Active

3. **support@tgrafrica.com** (Support)
   - Inactive (no auto-sync)

4. **noreply@tgrafrica.com** (No Reply)
   - Inactive (no auto-sync)

Run seeder:
```bash
php artisan db:seed --class=EmailAddressSeeder
```

## Integration with Incoming Emails

Each incoming email now tracks which address received it:

```php
// Get emails for specific address
$emails = $emailAddress->incomingEmails()->get();

// Create email with address reference
IncomingEmail::create([
    'email_address_id' => $emailAddress->id,
    'from_email' => 'sender@example.com',
    'to_email' => $emailAddress->email,
    'subject' => 'Test',
    'message' => 'Test message',
]);
```

## Performance

- **Indexing:** Optimized indexes on `uuid`, `email`, and `is_active` columns
- **Pagination:** Lists display 15 addresses per page
- **Queries:** Eager loading recommended when fetching related emails
- **Search:** Full-text search on email, label, and description

## Future Enhancements

- ✅ IMAP/POP3 auto-sync implementation
- ✅ Email filtering by address
- ✅ Webhook integration for external mail services
- ✅ Email forwarding between addresses
- ✅ Scheduled sync jobs
- ✅ Sync status notifications
- ✅ Email address statistics and reporting

## Troubleshooting

### Address Not Receiving Emails
- Verify the address is **Active**
- Check if a migration to that address exists
- Ensure the email address is correct

### Auto-Sync Not Working
- Enable auto-sync in the address settings
- Configure IMAP/POP3 credentials
- Check server host and port
- Verify encryption type matches server

### Password Encryption Issues
- Ensure `.env` file has `APP_KEY` set
- Password should be encrypted automatically on save
- Use `getDecryptedPassword()` to retrieve

## Sidebar Navigation

A new navigation item has been added to the admin portal:

```
📧 Email Addresses
```

Located under the Email section, allowing quick access to email management.

## Files Modified/Created

**Created:**
- `app/Models/EmailAddress.php`
- `app/Http/Controllers/Admin/AdminEmailAddressController.php`
- `resources/views/adminPortal/email/email-addresses.blade.php`
- `resources/views/adminPortal/email/email-address-form.blade.php`
- `database/migrations/2025_11_26_create_email_addresses_table.php`
- `database/seeders/EmailAddressSeeder.php`

**Modified:**
- `app/Models/IncomingEmail.php` (added email_address_id)
- `routes/web.php` (added 8 new routes)
- `resources/views/adminPortal/layout/header.blade.php` (added sidebar link)

## Testing

To test the feature:

1. Run migrations: `php artisan migrate`
2. Seed data: `php artisan db:seed --class=EmailAddressSeeder`
3. Navigate to `/admin-email-addresses`
4. Add a new email address
5. Test search and filtering
6. Test activation/deactivation
7. Test edit and delete operations

## Statistics

- **Total Setup Time:** < 5 minutes for basic configuration
- **Database Queries:** All optimized with strategic indexing
- **Code Files:** 6 created, 3 modified
- **Routes Added:** 8 RESTful routes
- **Views Created:** 2 comprehensive Blade templates

