<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Event - {{ $event->event_title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #d93025;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .event-details {
            background-color: #f8f9fa;
            border-left: 4px solid #d93025;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .event-details h2 {
            margin-top: 0;
            color: #d93025;
            font-size: 20px;
        }
        .detail-row {
            display: flex;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            min-width: 120px;
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .people-section {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .people-section h3 {
            margin-top: 0;
            color: #856404;
            font-size: 16px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .footer a {
            color: #d93025;
            text-decoration: none;
        }
        .cta-button {
            display: inline-block;
            background-color: #d93025;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 New Event Announcement</h1>
            <p style="margin: 10px 0 0 0;">You're invited to our upcoming event!</p>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>We're excited to announce a new event that you might be interested in:</p>
            
            <div class="event-details">
                <h2>{{ $event->event_title }}</h2>
                
                <div class="detail-row">
                    <div class="detail-label">📅 Date:</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($event->event_date)->format('l, F j, Y') }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">🕐 Time:</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">📍 Status:</div>
                    <div class="detail-value">
                        <span style="background-color: #ffc107; color: #856404; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            {{ $event->status }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if($event->event_people)
            <div class="people-section">
                <h3>👥 Attendees / Participants:</h3>
                <p style="margin: 5px 0 0 0; white-space: pre-line;">{{ $event->event_people }}</p>
            </div>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="cta-button">Visit Our Website</a>
            </div>
            
            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                We look forward to seeing you there! If you have any questions about this event, please don't hesitate to contact us.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>TGR Africa</strong></p>
            <p>This email was sent to you because you're subscribed to our newsletter.</p>
            <p>
                <a href="{{ url('/newsletter/unsubscribe') }}">Unsubscribe</a> | 
                <a href="{{ url('/') }}">Visit Website</a>
            </p>
            <p style="margin-top: 10px; color: #999;">
                © {{ date('Y') }} TGR Africa. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
