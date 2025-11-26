# Quick Start: Inbox Email Management

## Access the Inbox

1. **Log into Admin Portal**
2. **Click "Inbox"** in the sidebar (next to "Email Tracking")
3. **View your inbox** with all incoming emails

## Folder Navigation

| Folder | Purpose | Badge |
|--------|---------|-------|
| 📬 **Inbox** | Unread emails | Red badge with count |
| 📭 **Read** | Already read emails | Green badge with count |
| ✈️ **Sent** | Emails you sent | Blue badge with count |
| 📝 **Drafts** | Unsent emails | Yellow badge with count |
| ⭐ **Starred** | Favorite emails | Gold badge with count |
| ⚠️ **Spam** | Unwanted emails | Red badge with count |
| 🗑️ **Trash** | Deleted emails | Gray badge with count |

## Email Status Indicators

### Visual Cues
- **Unread Email**: Blue background, bold text
- **Read Email**: Normal background, regular text
- **With Attachment**: Paperclip icon
- **Starred**: Yellow star icon

## Quick Actions

### Single Email Actions
| Action | How | Result |
|--------|-----|--------|
| **View** | Click email | Opens full details |
| **Mark as Read** | Click email \| dropdown | Toggle unread |
| **Star** | Click star icon | Add to favorites |
| **Move to Trash** | Dropdown menu | Soft delete |
| **Restore** | From trash, dropdown | Move back to inbox |
| **Spam** | Dropdown menu | Mark as unwanted |
| **Delete** | From trash dropdown | Permanent delete |

### Bulk Actions
| Action | How |
|--------|-----|
| **Select Multiple** | Check boxes on left |
| **Mark All as Read** | Check + Mark read button |
| **Move All to Trash** | Check + Move trash button |
| **Empty Trash** | In trash folder, empty button |

## Search & Filter

### Search
1. Enter search term in search box
2. Click search button
3. Results show in current folder
4. Search across: From, Subject, Content

### Filter
- Click folder name to filter
- Use status buttons in header
- Pagination: 15 emails per page

## Email Details View

When you click an email:

### Information Shown
- **From**: Sender name and email
- **To**: Your email
- **CC/BCC**: If included
- **Date**: When received
- **Priority**: Low / Normal / High
- **Status**: Current folder

### Body
- Full message display
- HTML formatting supported
- Plain text fallback

### Attachments
- Download link for each file
- File size display
- File type icon

### Action Buttons
- **Reply**: Send response
- **Reply All**: Reply to all
- **Forward**: Send to someone else
- **More Actions**: Star, Mark Read, Move, Spam, Delete

## Priority Levels

| Priority | Icon | Color | Meaning |
|----------|------|-------|---------|
| 🔴 **High** | ↑ Up arrow | Red | Urgent |
| 🟢 **Normal** | — Dash | Gray | Standard |
| 🔵 **Low** | ↓ Down arrow | Blue | Can wait |

## Keyboard Tips

| Shortcut | Action |
|----------|--------|
| Click star | Toggle favorite |
| Click checkbox | Select for bulk |
| Click subject | Open email |
| Esc | Close details |

## Search Examples

```
Search from sender:
  john@example.com

Search by subject:
  urgent
  meeting
  consultation

Search by content:
  pricing
  availability
  schedule
```

## Storage Information

- **Current**: Shows usage
- **Total**: 15 GB available
- **Meter**: Visual representation
- **Action**: Archive old emails

## Common Workflows

### Workflow 1: Triage Inbox
```
1. Open Inbox
2. Mark each unread as read
3. Star important ones
4. Archive or delete spam
5. Check Starred folder for important items
```

### Workflow 2: Find Old Email
```
1. Use Search box
2. Enter keyword (sender name, subject, content)
3. Click Search
4. Review results
5. Click to view details
```

### Workflow 3: Delete Unwanted
```
1. Select email or multiple emails
2. Move to Trash
3. Open Trash folder
4. Permanently delete or restore
```

### Workflow 4: Organize Important
```
1. Open email
2. Click Star icon
3. Go to Starred folder
4. View all important emails
```

## Folder Counts Explained

### Inbox Count
- **Shows**: Number of unread emails
- **Indicates**: Action needed
- **Action**: Read to reduce count

### Other Folder Counts
- **Read**: Total read emails
- **Sent**: Emails you've sent
- **Drafts**: Unsaved emails
- **Starred**: Favorites
- **Spam**: Blocked emails
- **Trash**: Deleted (recoverable)

## Tips & Tricks

### 📌 Pro Tips
1. **Star frequently needed emails** for quick access
2. **Search is powerful** - use it to find anything
3. **Bulk mark as read** to clean up inbox quickly
4. **Check Spam folder** regularly
5. **Don't forget Trash** - recover within 30 days (system dependent)
6. **Use preview text** - read without opening

### ⚠️ Important
- **Permanent delete** is irreversible
- **Soft deletes** go to trash first
- **Unread badge** only on Inbox
- **Storage limit** affects new emails
- **Spam marking** helps train system

## Common Issues

### Email not showing?
- Check correct folder
- Use search to find
- Check Spam folder
- Refresh page

### Can't mark as read?
- Click email first
- Try dropdown menu
- Page may need refresh

### Attachment won't download?
- Check file permissions
- Try different format if available
- Contact admin

## Next Steps

### Learn More
- Read full docs: `INBOX_EMAIL_SYSTEM.md`
- Compare systems: `INBOX_VS_TRACKING_COMPARISON.md`
- View implementation: `INBOX_IMPLEMENTATION_SUMMARY.md`

### Use Advanced Features
- Reply to emails
- Forward emails
- Manage attachments
- Create email drafts
- Track email status

## Contact & Support

For questions about the Inbox system:
1. Check documentation files
2. Contact admin portal support
3. Review model/controller code
4. Check browser console for errors

---

**Ready to use!** Start managing your inbox like Gmail! 📧

Last updated: November 26, 2025
