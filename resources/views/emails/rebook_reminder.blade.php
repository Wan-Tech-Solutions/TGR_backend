<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Your Consultation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ea6666 0%, #a24b4b 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #000000;
            margin-top: 0;
        }
        .highlight {
            background-color: #f0f4ff;
            border-left: 4px solid #f50b0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .highlight strong {
            color: #ea6666;
        }
        .cta-button {
            display: inline-block;
            background-color: #ea6666;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s;
            text-decoration-color: #f9f9f9
        }
        .cta-button:hover {
            background-color: #a24b4b;
            color: white;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
        }
        .detail-value {
            color: #333;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
        }
        .warning {
            color: #d32f2f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>We Noticed You Missed Your Consultation</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $consultation->name }},</h2>

            <p>We noticed that you missed your scheduled consultation appointment with TGR Africa. We understand that life gets busy, and sometimes scheduling conflicts happen!</p>

            <div class="highlight">
                <p><strong>Good News!</strong> You have <strong>{{ $rebooksRemaining }} free rebook opportunity(ies)</strong> available. We won't charge you again for rescheduling your consultation.</p>
            </div>

            <h3>Your Original Consultation Details:</h3>
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Scheduled Date:</span>
                    <span class="detail-value">{{ optional($consultation->scheduled_for)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $consultation->consultation_hours }} hour(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">{{ ucfirst($consultation->status) }}</span>
                </div>
            </div>

            <h3>How to Reschedule:</h3>
            <p>Click the button below to select a new date and time for your consultation. Your assessment responses have been saved, so you won't need to fill out the questionnaire again.</p>

            <center>
                <a href="{{ $bookingUrl }}" class="cta-button">Reschedule Your Consultation</a>
            </center>

            <p>Simply choose a new available date, confirm your details, and you'll be all set!</p>

            <div class="highlight">
                <p><span class="warning">⚠️ Important:</span> You have up to <strong>2 free rebook opportunities</strong>. After that, you'll need to book a new consultation and make a payment. We encourage you to reschedule at your earliest convenience.</p>
            </div>

            <h3>Need Help?</h3>
            <p>If you have any questions or need assistance rescheduling, please don't hesitate to reach out to our support team. We're here to help!</p>

            <p>
                <strong>Best regards,</strong><br>
                The Great Return (TGR) Africa Team<br>
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} The Great Return (TGR) Africa. All rights reserved.</p>
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>
