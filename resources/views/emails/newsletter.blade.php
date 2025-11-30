<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div style="font-family: Arial, sans-serif; color: #222;">
        {!! nl2br(e($bodyContent)) !!}
        @if(!empty($unsubscribeToken))
            <hr />
            <p style="font-size:12px;color:#666;">If you no longer wish to receive these emails, you can <a href="{{ route('newsletter.unsubscribe', $unsubscribeToken) }}">unsubscribe here</a>.</p>
        @endif
    </div>
</body>
</html>
