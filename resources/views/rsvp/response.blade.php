<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Response - {{ $event->event_title }}</title>
    <style>
        :root {
            --brand: #ef4444;
            --brand-dark: #b91c1c;
            --ink: #0b0b0f;
            --muted: #6b7280;
            --surface: #ffffff;
            --card: rgba(255, 255, 255, 0.9);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fb 0%, #e8ecf5 50%, #f7f9fc 100%);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .container {
            max-width: 520px;
            width: 100%;
            background: var(--card);
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.18);
            overflow: hidden;
            border: 1px solid rgba(17, 24, 39, 0.06);
        }

        .header {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            color: white;
            padding: 22px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 4px;
            letter-spacing: 0.2px;
        }

        .header p {
            opacity: 0.9;
            font-size: 12.5px;
        }

        .content {
            padding: 22px 20px 26px;
        }

        .event-title {
            font-size: 20px;
            color: var(--ink);
            margin-bottom: 12px;
            text-align: center;
            font-weight: 700;
        }

        .eyebrow {
            text-align: center;
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .event-details {
            background: #f8fafc;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            border-left: 4px solid var(--brand);
        }

        .event-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
            color: var(--muted);
            font-weight: 600;
        }

        .event-detail strong {
            color: var(--ink);
        }

        .icon {
            font-size: 18px;
        }

        .success-message {
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 14px;
        }

        .success-message h3 {
            color: #166534;
            margin-bottom: 4px;
            font-size: 16px;
        }

        .success-message p {
            color: #14532d;
            line-height: 1.5;
            font-size: 12.5px;
        }

        .response-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 14px;
            font-weight: 700;
            margin: 6px 0;
            font-size: 11.5px;
        }

        .response-yes {
            background: #22c55e;
            color: white;
        }

        .response-no {
            background: #ef4444;
            color: white;
        }

        .response-maybe {
            background: #f59e0b;
            color: #111827;
        }

        .email-form {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 12px;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
        }

        .email-form h3 {
            color: #9a3412;
            margin-bottom: 6px;
            font-size: 15px;
        }

        .email-form p {
            color: #9a3412;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 9px 11px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.2s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.14);
        }

        .btn {
            background: var(--brand);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.16);
        }

        .btn:hover {
            background: var(--brand-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(185, 28, 28, 0.18);
        }

        .back-link {
            text-align: center;
            margin-top: 14px;
        }

        .back-link a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border-bottom: 1px dashed rgba(239, 68, 68, 0.4);
            padding-bottom: 2px;
        }

        .back-link a:hover {
            border-bottom-color: rgba(185, 28, 28, 0.7);
        }

        @media (max-width: 600px) {
            .content {
                padding: 26px 22px 30px;
            }

            .event-title {
                font-size: 20px;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Event RSVP</h1>
            <p>Thank you for your response!</p>
        </div>

        <div class="content">
            <h2 class="event-title">{{ $event->event_title }}</h2>

            <p class="eyebrow">Event details</p>

            <div class="event-details">
                <div class="event-detail">
                    <span class="icon">📅</span>
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('l, F j, Y') }}
                </div>
                <div class="event-detail">
                    <span class="icon">🕐</span>
                    <strong>Time:</strong> {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                </div>
                @if($event->location)
                <div class="event-detail">
                    <span class="icon">📍</span>
                    <strong>Location:</strong> {{ $event->location }}
                </div>
                @endif
            </div>

            @if(isset($success) && $success)
                <div class="success-message">
                    <h3>✓ Response Recorded Successfully!</h3>
                    <p>
                        Your response:
                        <span class="response-badge response-{{ $response }}">
                            @if($response === 'yes')
                                ✓ I'll Attend
                            @elseif($response === 'maybe')
                                ? Maybe
                            @else
                                ✗ Can't Attend
                            @endif
                        </span>
                    </p>
                    <p style="margin-top: 8px;">
                        We've received your RSVP for this event.
                        @if($response === 'yes')
                            We're excited to see you there!
                        @elseif($response === 'maybe')
                            We hope you can make it!
                        @else
                            We're sorry you can't make it. Maybe next time!
                        @endif
                    </p>
                    <p style="margin-top: 10px; font-size: 12.5px;">
                        Don't forget to add this event to your calendar using the .ics file attached to the email.
                    </p>
                </div>
            @elseif(isset($needsEmail) && $needsEmail)
                <div class="email-form">
                    <h3>Please provide your email address</h3>
                    <p style="color: #856404; margin-bottom: 10px; font-size: 12px;">We need your email to record your RSVP response.</p>
                    <form method="POST" action="{{ route('rsvp.submit', ['eventId' => $event->id, 'response' => $response]) }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="your.email@example.com" required>
                        </div>
                        <button type="submit" class="btn">Submit RSVP</button>
                    </form>
                </div>
            @endif

            <div class="back-link">
                <a href="{{ url('/') }}">← Back to Website</a>
            </div>
        </div>
    </div>
</body>
</html>
