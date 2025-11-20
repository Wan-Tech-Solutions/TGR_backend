<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TRG-AFRICA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .header {
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        p:last-child {
            margin-top: 30px;
        }

        .footer {margin-top: 30px;
            font-size: 13px;
            color: #999;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- <img src="cid:logo_default_slim" alt="TGR Logo"> -->
        <img src="http://www.tgrafrica.com/img/logo-default-slim.png" alt="TGR Logo">

    </div>
    <div class="content">
        <h5>Thank You, {{ $messageContent['full_name'] }}!</h5>
        <p>We have received your mail, a consultant will contact you shortly.</p>
        {{-- <p>Best regards,<br>TGR Africa Team</p> --}}
    </div>

    <div class="footer">
        <p>Best regards,</p>
        <p>The TGR Team</p>
        <p><small>&copy; 2024 TGR AFRICA. All rights reserved.</small></p>
    </div>
</body>

</html>