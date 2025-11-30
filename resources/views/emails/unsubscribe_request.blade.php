<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div style="font-family: Arial, sans-serif; color: #222;">
        <p>We received a request to unsubscribe this email from our newsletter.</p>
        <p>If you made this request, please confirm by clicking the link below:</p>
        <p><a href="{{ route('newsletter.unsubscribe', $token) }}">Confirm unsubscribe</a></p>
        <p>If you did not request this, you can ignore this email.</p>
    </div>
</body>
</html>
