{{-- @extends('website.layouts.main')
@section('title')
    Contact
@endsection
@section('content')
<h5>New Contact Message from {{ $messageContent['full_name'] ?? 'N/A' }}</h5>
<p>Email: {{ $messageContent['email'] ?? 'N/A' }}</p>
<p>Country of Residence: {{ $messageContent['country_of_residence'] ?? 'N/A' }}</p>
<p>Nationality: {{ $messageContent['nationality'] ?? 'N/A' }}</p>
<p>Subject: {{ $messageContent['subject'] ?? 'N/A' }}</p>
<p>Message: {{ $messageContent['message'] ?? 'N/A' }}</p>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        h5 {
            color: #2c3e50;
            font-size: 14px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }

        p {
            font-size: 12px;
            margin: 10px 0;
        }

        strong {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="content">
        <h5>New Contact Message from {{ $messageContent['full_name'] ?? 'N/A' }}</h5>
        <p>Email: {{ $messageContent['email'] ?? 'N/A' }}</p>
        <p>Country of Residence: {{ $messageContent['country_of_residence'] ?? 'N/A' }}</p>
        <p>Nationality: {{ $messageContent['nationality'] ?? 'N/A' }}</p>
        <p>Subject: {{ $messageContent['subject'] ?? 'N/A' }}</p>
        <p>Message: {{ $messageContent['message'] ?? 'N/A' }}</p>
    </div>
</body>

</html>