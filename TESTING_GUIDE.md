# System Testing Quick Reference Guide

## 🧪 How to Test Each Functionality

### 1. CONSULTATION BOOKING FLOW

**Test Steps:**
1. Go to website: `/features/consultation`
2. Fill in test data:
   - Name: "Test Client"
   - Email: "test@example.com"
   - Phone: Any valid number
   - Nationality: Any country
   - Country: Any country
3. Select consultation date (future date)
4. Answer all 34 assessment questions
5. Click "Proceed to Payment"

**Expected Results:**
- ✅ Consultation created in database
- ✅ Assessment scores calculated (0-340)
- ✅ Payment pending in dashboard
- ✅ Confirmation email received
- ✅ Admin sees consultation in list

**What to Check in Admin:**
- Go to Admin → Consultations
- Verify new booking appears
- Check status is "pending"
- Verify assessment percentage shows

---

### 2. PAYMENT VERIFICATION

**Test Steps:**
1. Complete consultation booking (see above)
2. Use Stripe test card: `4242 4242 4242 4242`
3. Expiry: Any future date (e.g., 12/25)
4. CVC: Any 3 digits (e.g., 123)
5. Complete payment

**Expected Results:**
- ✅ Payment status changes to "paid"
- ✅ Confirmation page shows success
- ✅ User redirected to thank you page
- ✅ Email confirmation sent

**What to Check in Admin:**
- Go to Admin → Consultations
- Check payment status = "paid"
- Verify payment amount matches
- See payment reference (PAY-XXXXX)

---

### 3. ASSESSMENT QUESTIONNAIRE

**Test Steps:**
1. Start consultation booking
2. Complete all 34 questions with varying scores
3. Submit

**Expected Results:**
- ✅ Scores recorded 0-10 per question
- ✅ Total calculated correctly (sum)
- ✅ Percentage calculated (total/340)*100

**What to Check in Admin:**
- Go to Admin → Consultations → Consultation Detail
- Look for "Assessment Summary" section
- Verify: Total Score, Readiness %, Readiness Level
- Check "Assessment Responses" table shows all questions

---

### 4. REBOOK REMINDER SYSTEM

**Test Steps:**
1. Create a consultation with past date
2. Go to Admin → Rebook Reminders
3. Find the consultation in "Pending" table
4. Click "Send Reminder Now"
5. Confirm the action

**Expected Results:**
- ✅ Success message appears
- ✅ Counter shows "Reminder 1 of 2"
- ✅ Entry appears in email history
- ✅ Status shows "Sent"
- ✅ Email sent to client

**What to Check:**
- Rebook history visible on detail page
- Can send up to 2 reminders only
- 3rd attempt blocked
- Sent date and admin name recorded

---

### 5. DASHBOARD METRICS

**Test Steps:**
1. Go to Admin Dashboard
2. Look at the 4 stat cards

**Expected Results:**
```
✅ Blog Posts: X (number of blogs)
✅ Contact Response: X (contact form submissions)
✅ Prospectus: X (prospectus requests)
✅ Consultations: X (actual client bookings - NOT page edits)
```

**To Verify Accuracy:**
1. Click "Rebook Reminders" button
2. Count pending consultations
3. Compare to dashboard Consultations card
4. Numbers should match

---

### 6. EMAIL NOTIFICATIONS

**Test Steps:**

**Consultation Booking Email:**
1. Complete a consultation booking
2. Check email inbox (test@example.com)
3. Should receive booking confirmation

**Rebook Reminder Email:**
1. Go to Admin → Rebook Reminders
2. Send reminder
3. Check client email inbox
4. Should receive rebook reminder

**Expected:**
- ✅ Email arrives within 1-2 seconds
- ✅ Contains relevant details
- ✅ Professional formatting
- ✅ No spam folder

---

### 7. CONTACT FORM

**Test Steps:**
1. Go to website: `/contact`
2. Fill form with test data
3. Submit

**Expected Results:**
- ✅ "Thank you" message appears
- ✅ Admin receives notification email
- ✅ Data in admin contact list

**Admin Verification:**
- Go to Admin → Contacts
- New message appears
- Contains all submitted data

---

### 8. BLOG SYSTEM

**Test Steps:**

**Create Blog:**
1. Admin → News Portal
2. Create new blog post
3. Add title, content, images
4. Publish

**Verify Frontend:**
1. Check website news page
2. New blog should appear
3. Should be clickable

**Dashboard:**
1. Go to Admin Dashboard
2. Blog count should increase

---

### 9. SEMINAR SUBSCRIPTIONS

**Test Steps:**
1. Go to website: `/seminars`
2. Click "Subscribe" on any seminar
3. Complete subscription

**Expected Results:**
- ✅ Subscription created
- ✅ User receives confirmation
- ✅ Admin sees new subscriber

**Admin Check:**
1. Dashboard "Subscribers" card increases
2. Recent subscribers listed

---

### 10. PROSPECTUS REQUESTS

**Test Steps:**
1. Go to website: `/request-prospectus`
2. Fill form with test data
3. Submit

**Expected Results:**
- ✅ Request received message
- ✅ Email confirmation
- ✅ Data in admin list

**Admin Check:**
1. Go to Admin → Prospectus
2. New request appears
3. Contains all submitted data

---

## 🔍 QUICK HEALTH CHECK

Run this checklist daily/weekly:

```
□ Dashboard loads without errors
□ Consultation count is accurate
□ Recent consultations display correctly
□ Can create new blog post
□ Emails send without delay
□ Payment processing works (use test card)
□ Admin filters work (status, payment)
□ Rebook reminders send successfully
□ Assessment scores calculate correctly
□ Database has no errors (logs clean)
```

---

## 🐛 DEBUGGING TIPS

### If Consultation Not Appearing:
1. Check database: `SELECT * FROM consultations WHERE email = 'test@example.com';`
2. Check logs: `storage/logs/laravel.log`
3. Verify form submission: Check browser console for errors
4. Check payment status: Might be incomplete

### If Email Not Sent:
1. Check mail config: `config/mail.php`
2. Check logs for error message
3. Verify from address is configured
4. Test with: `php artisan tinker` and `Mail::raw(...)`

### If Dashboard Wrong:
1. Manually count records: `SELECT COUNT(*) FROM consultations;`
2. Check controller: `AdminHomeController@index`
3. Verify model: Should use `Consultation` not `Bookconsultation`
4. Clear cache: `php artisan cache:clear`

### If Payment Fails:
1. Check Stripe keys in `.env`
2. Verify test mode is active
3. Check webhook configuration
4. Review Stripe dashboard for declined charges

---

## 📱 DEVICE TESTING

Test on:
- ✅ Desktop browser (Chrome, Firefox, Safari, Edge)
- ✅ Tablet (iPad, Android tablet)
- ✅ Mobile (iPhone, Android phone)

Check:
- Forms are responsive
- Buttons clickable on mobile
- Tables scroll properly
- No layout breaks

---

## 📊 LOAD TESTING

For production readiness:
1. Load test with 100+ concurrent users
2. Monitor database query times
3. Check payment processing under load
4. Verify email queue doesn't backup

---

## ✅ PRODUCTION DEPLOYMENT CHECKLIST

Before going live:

**Database:**
- [ ] All migrations applied
- [ ] Backups scheduled
- [ ] Indexes created on frequently queried fields

**Configuration:**
- [ ] Environment variables set (.env)
- [ ] Stripe API keys from production
- [ ] Email provider configured (SendGrid/AWS SES)
- [ ] Payment webhook URLs correct

**Code:**
- [ ] Debug mode OFF (APP_DEBUG=false)
- [ ] Error logging configured
- [ ] Security headers set
- [ ] HTTPS enforced

**Testing:**
- [ ] All 10 functionalities tested
- [ ] Real payment processed successfully
- [ ] Emails delivered correctly
- [ ] Admin dashboard accurate
- [ ] Mobile responsive

**Monitoring:**
- [ ] Error monitoring active (Sentry/etc)
- [ ] Performance monitoring active
- [ ] Log aggregation setup
- [ ] Alerting configured

---

**Status:** ✅ Ready for Testing
