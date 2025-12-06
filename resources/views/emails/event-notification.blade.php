<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Invitation - {{ $event->event_title }}</title>
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
        .rsvp-section {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        .rsvp-section h3 {
            margin-top: 0;
            color: #2e7d32;
            font-size: 18px;
        }
        .rsvp-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        .rsvp-button {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .rsvp-accept {
            background-color: #4caf50;
            color: white;
        }
        .rsvp-decline {
            background-color: #f44336;
            color: white;
        }
        .rsvp-maybe {
            background-color: #ff9800;
            color: white;
        }
        .calendar-section {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        .calendar-section h3 {
            margin-top: 0;
            color: #1565c0;
            font-size: 18px;
        }
        .calendar-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
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
            margin: 10px 5px;
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
            .rsvp-buttons {
                flex-direction: column;
            }
            .rsvp-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Event Invitation</h1>
            <p style="margin: 10px 0 0 0;">TGR Africa invites you to our upcoming event!</p>
        </div>

        <div class="content">
            <p>Hello,</p>
            <p>We're excited to invite you to our upcoming event. Please find the details below:</p>

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

                @if($event->location)
                <div class="detail-row">
                    <div class="detail-label">📍 Location:</div>
                    <div class="detail-value">{{ $event->location }}</div>
                </div>
                @endif

                @if($event->description)
                <div class="detail-row">
                    <div class="detail-label">📝 Description:</div>
                    <div class="detail-value" style="white-space: pre-line;">{{ $event->description }}</div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">⚡ Priority:</div>
                    <div class="detail-value">
                        <span style="background-color: {{ $event->priority === 'high' ? '#f44336' : ($event->priority === 'low' ? '#4caf50' : '#ff9800') }}; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            {{ strtoupper($event->priority ?? 'MEDIUM') }}
                        </span>
                    </div>
                </div>
            </div>

            @if($event->event_people)
            <div class="people-section">
                <h3>👥 Expected Attendees / Participants:</h3>
                <p style="margin: 5px 0 0 0; white-space: pre-line;">{{ $event->event_people }}</p>
            </div>
            @endif

            <div class="rsvp-section">
                <h3>📬 Will you be attending?</h3>
                <p style="margin: 10px 0; color: #555;">Click a button below to RSVP:</p>
                <div class="rsvp-buttons">
                    <a href="{{ route('rsvp.response', ['eventId' => $event->id, 'response' => 'yes']) }}" class="rsvp-button rsvp-accept">✓ Yes, I'll Attend</a>
                    <a href="{{ route('rsvp.response', ['eventId' => $event->id, 'response' => 'maybe']) }}" class="rsvp-button rsvp-maybe">? Maybe</a>
                    <a href="{{ route('rsvp.response', ['eventId' => $event->id, 'response' => 'no']) }}" class="rsvp-button rsvp-decline">✗ Can't Attend</a>
                </div>
                <p style="margin-top: 15px; font-size: 13px; color: #666;">
                    One click and you're done - no forms to fill out!
                </p>
            </div>

            <div class="calendar-section">
                <h3>📆 Add to Your Calendar</h3>
                <p class="calendar-info">
                    A calendar file (.ics) is attached to this email. Click on it to automatically add this event to:
                </p>
                <p style="font-size: 13px; color: #666; margin-top: 15px;">
                    Simply open the attached <strong>{{ 'event-' . \Str::slug($event->event_title) . '.ics' }}</strong> file, and your calendar app will prompt you to add this event with all the details.
                </p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('https://tgrafrica.com') }}" class="cta-button">Visit Our Website</a>
            </div>

            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                We look forward to seeing you there! If you have any questions about this event, please don't hesitate to contact us at <a href="mailto:info@tgrafrica.com" style="color: #d93025;">events@tgr-africa.com</a>.
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
