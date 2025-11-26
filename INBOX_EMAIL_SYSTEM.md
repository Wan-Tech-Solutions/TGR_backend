# Inbox Email Management System Documentation

## Overview
The Inbox Email Management System is a comprehensive incoming email management solution similar to Gmail, featuring read/unread status tracking, multiple email folders, and advanced filtering capabilities.

## Features

### 1. **Multi-Folder Organization**
- **Inbox**: Receives all incoming emails (displays unread count badge)
- **Read**: Shows all read emails
- **Sent**: Displays sent emails from admin compose
- **Drafts**: Manages draft emails
- **Starred**: Favorites for important emails
- **Spam**: Quarantined suspicious emails
- **Trash**: Deleted emails (can be restored or permanently deleted)

### 2. **Read/Unread Functionality**
- Visual distinction between read (normal) and unread (blue highlight, bold text) emails
- Quick action to mark emails as read/unread
- Auto-mark as read when opening email details
- Unread count badges on folder list

### 3. **Email Management**
- **Star/Unstar**: Mark important emails for quick reference
- **Move to Trash**: Soft delete emails
- **Restore from Trash**: Recover deleted emails
- **Mark as Spam**: Filter unwanted emails
- **Delete Permanently**: Hard delete emails from trash
- **Bulk Actions**: Mark multiple emails as read or move to trash

### 4. **Email Details View**
- Full sender information (name and email)
- Subject line and complete message body
- HTML and plain text message support
- Recipient, CC, BCC information
- Attachment display with download links
- Priority level indication (Low, Normal, High)
- Email status badges

### 5. **Search & Filter**
- Search by sender name, email, subject, or content
- Filter by email status
- Status-based pagination

### 6. **Advanced Features**
- **Attachments**: Track and manage email attachments
- **Priority Levels**: Distinguish high-priority emails
- **Email Tags**: Organize emails with custom tags (structure ready)
- **Thread Support**: Track email conversations
- **Storage Info**: Display storage usage metrics
- **Audit Trail**: All email actions are logged

## Database Schema

### incoming_emails table
```sql
- id (Primary Key)
- uuid (Unique identifier)
- user_id (FK to users)
- from_email (sender's email)
- from_name (sender's name)
- to_email (recipient email)
- subject (email subject)
- message (plain text body)
- html_message (HTML body)
- status (inbox|sent|draft|trash|spam) - indexed
- is_read (boolean) - indexed
- is_starred (boolean) - indexed
- message_id (unique for threading)
- thread_id (for grouping conversations)
- cc (CC recipients)
- bcc (BCC recipients)
- priority (low|normal|high)
- attachment_count (number of attachments)
- received_at (when email arrived) - indexed
- read_at (when marked as read)
- created_at, updated_at
- deleted_at (for soft deletes)
```

### email_attachments table
```sql
- id (Primary Key)
- uuid (Unique identifier)
- incoming_email_id (FK to incoming_emails)
- filename (original filename)
- mime_type (file type)
- size (file size in bytes)
- path (storage path)
- created_at, updated_at
```

### email_tags table
```sql
- id (Primary Key)
- uuid (Unique identifier)
- user_id (FK to users)
- name (tag name)
- color (display color)
- description (tag description)
- created_at, updated_at
```

### email_tag_mappings table (Pivot)
```sql
- id (Primary Key)
- incoming_email_id (FK)
- email_tag_id (FK)
- created_at, updated_at
```

## Models

### IncomingEmail Model
**Location**: `app/Models/IncomingEmail.php`

**Key Methods**:
```php
// Relationships
$email->user();           // Get email owner
$email->attachments();    // Get all attachments
$email->tags();          // Get associated tags

// Mark as read/unread
$email->markAsRead();
$email->markAsUnread();

// Starred functionality
$email->toggleStarred();

// Move between folders
$email->moveToTrash();
$email->restoreFromTrash();
$email->markAsSpam();

// Utilities
$email->getPreviewText(100);  // Get text preview
```

**Scopes**:
```php
IncomingEmail::inbox();      // Unread inbox emails
IncomingEmail::read();       // Read emails
IncomingEmail::sent();       // Sent emails
IncomingEmail::draft();      // Draft emails
IncomingEmail::trash();      // Trashed emails
IncomingEmail::spam();       // Spam emails
IncomingEmail::starred();    // Starred emails
IncomingEmail::unread();     // All unread emails
IncomingEmail::byStatus($status);  // Filter by status
IncomingEmail::recent();     // Ordered by date
```

### EmailAttachment Model
**Location**: `app/Models/EmailAttachment.php`

**Features**:
- UUID support
- File size calculation with units (B, KB, MB, GB)
- Relationship to IncomingEmail

### EmailTag Model
**Location**: `app/Models/EmailTag.php`

**Features**:
- User-scoped tags
- Color coding for visual organization
- Many-to-many relationship with emails

## Controller

### AdminIncomingEmailController
**Location**: `app/Http/Controllers/Admin/AdminIncomingEmailController.php`

**Methods**:
- `index()` - Display inbox with filtering
- `show($uuid)` - Show email details
- `markAsRead($uuid)` - Mark single email as read
- `markAsUnread($uuid)` - Mark single email as unread
- `toggleStarred($uuid)` - Toggle star status
- `moveToTrash($uuid)` - Move to trash
- `restoreFromTrash($uuid)` - Restore from trash
- `markAsSpam($uuid)` - Mark as spam
- `bulkMarkAsRead()` - Bulk read action
- `bulkMoveToTrash()` - Bulk trash action
- `destroy($uuid)` - Permanently delete
- `emptyTrash()` - Clear all trash

## Routes

```php
// Inbox display and management
GET    /admin-email-inbox                    -> index
GET    /admin-email-inbox/{uuid}             -> show
POST   /admin-email-inbox/{uuid}/mark-read   -> markAsRead
POST   /admin-email-inbox/{uuid}/mark-unread -> markAsUnread
POST   /admin-email-inbox/{uuid}/toggle-starred -> toggleStarred
POST   /admin-email-inbox/{uuid}/move-trash  -> moveToTrash
POST   /admin-email-inbox/{uuid}/restore-trash -> restoreFromTrash
POST   /admin-email-inbox/{uuid}/mark-spam   -> markAsSpam
DELETE /admin-email-inbox/{uuid}             -> destroy
POST   /admin-email-inbox/bulk/mark-read     -> bulkMarkAsRead
POST   /admin-email-inbox/bulk/move-trash    -> bulkMoveToTrash
POST   /admin-email-inbox/empty-trash        -> emptyTrash
```

## Views

### inbox.blade.php
**Location**: `resources/views/adminPortal/email/inbox.blade.php`

**Features**:
- Sidebar with folder navigation
- Unread count badges on each folder
- Search functionality
- Email list with quick actions
- Storage usage indicator
- Responsive design

**Folder Buttons**:
- Inbox (shows unread count)
- Read (shows read count)
- Sent
- Drafts
- Starred
- Spam
- Trash

**Email List Display**:
- Sender name/email
- Email subject
- Preview text (first 50 chars)
- Date received
- Attachment indicator
- Read/unread visual styling

### inbox-details.blade.php
**Location**: `resources/views/adminPortal/email/inbox-details.blade.php`

**Features**:
- Full email header information
- Sender details
- Recipient, CC, BCC display
- Priority badge
- Status badge
- Complete HTML/plain text rendering
- Attachments section with download links
- Action buttons (Reply, Reply All, Forward)
- Dropdown menu with additional actions

## Usage Examples

### Creating an Incoming Email (Manual)
```php
IncomingEmail::create([
    'from_email' => 'sender@example.com',
    'from_name' => 'John Doe',
    'to_email' => 'admin@tgrafrica.com',
    'subject' => 'Important Message',
    'message' => 'Message content...',
    'html_message' => '<p>Message content...</p>',
    'status' => 'inbox',
    'priority' => 'high',
    'received_at' => now(),
]);
```

### Fetching Unread Emails
```php
$unreadEmails = IncomingEmail::inbox()->get();
$count = IncomingEmail::unread()->count();
```

### Managing Email Status
```php
// Mark as read
$email->markAsRead();

// Toggle starred
$email->toggleStarred();

// Move to trash (soft delete)
$email->moveToTrash();

// Restore from trash
$email->restoreFromTrash();

// Mark as spam
$email->markAsSpam();
```

### Search and Filter
```php
// Search across multiple fields
$results = IncomingEmail::where('from_email', 'like', '%@example.com%')
    ->orWhere('subject', 'like', '%urgent%')
    ->recent()
    ->paginate(15);

// Filter by status
$sent = IncomingEmail::byStatus('sent')->recent()->paginate(15);
```

## Frontend Integration

### Sidebar Navigation
The sidebar shows:
- Compose button
- Folder list with counts
- Quick access to Inbox, Read, Sent, Drafts, Starred, Spam, Trash
- Storage usage meter

### Email List
Each email shows:
- Star button (toggle)
- Checkbox (for bulk actions)
- Sender info
- Subject and preview
- Date and attachment indicator
- Read/unread styling

### Quick Actions
- Click email to view details
- Star icon to favorite
- Checkbox for bulk selection
- Status dropdown for quick actions

## Statistics & Counts

The system tracks:
- Total emails count
- Unread emails in Inbox
- Read emails in Inbox
- Sent emails
- Draft emails
- Trash count
- Spam count
- Starred emails

These counts appear as badges next to each folder.

## Security & Permissions

- User authentication required (middleware)
- Audit trail for all actions
- Soft deletes for recovery
- UUIDs for secure email references
- CSRF protection on all forms

## Performance Optimizations

- Indexed columns: `status`, `is_read`, `is_starred`, `received_at`, `thread_id`
- Pagination (15 emails per page)
- Eager loading of relationships
- Soft deletes instead of hard deletes

## Future Enhancements

1. **Email Threading**: Group related emails in conversations
2. **Advanced Tagging**: Organize emails with custom tags
3. **Email Rules**: Auto-filter and organize incoming emails
4. **Email Scheduling**: Schedule email sending
5. **Calendar Integration**: Link emails to calendar events
6. **Backup & Export**: Export emails to various formats
7. **Mobile App**: Native mobile access
8. **Real-time Notifications**: Live updates for new emails
9. **Email Signatures**: Custom signatures for replies
10. **Templates**: Pre-written email response templates

## Testing

Sample data is provided via IncomingEmailSeeder:
- 2 unread inbox emails (1 with attachment)
- 1 read email
- 1 spam email

Run seeder with:
```bash
php artisan db:seed --class=IncomingEmailSeeder
```

## Troubleshooting

### Emails not showing
- Check `incoming_emails` table for data
- Verify user authentication
- Clear application cache: `php artisan cache:clear`

### Counts not updating
- Run `php artisan migrate` to ensure tables created
- Check `is_read` and `status` values in database

### Attachment issues
- Verify file path in `email_attachments.path`
- Check storage permissions
- Ensure file exists on disk

## Support

For issues or questions about the Inbox Email Management System, refer to:
- Controller: `AdminIncomingEmailController`
- Views: `resources/views/adminPortal/email/`
- Models: `app/Models/IncomingEmail*`
- Database: `incoming_emails`, `email_attachments`, `email_tags`
