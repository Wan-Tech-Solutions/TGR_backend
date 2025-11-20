<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? 'No Subject' }}</title>
</head>
<body>
    <p>{!! nl2br(e($messageContent ?? 'No Message')) !!}</p>
</body>
</html>
