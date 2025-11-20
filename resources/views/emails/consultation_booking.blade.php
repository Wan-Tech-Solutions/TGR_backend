<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thank You for Booking a Consultation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        

        .header {
            margin-bottom: 30px;
        }

        .header img {
            max-width: 150px;
            
        }
        .content p {
            font-size: 12px;  /* Increase font size here */
        }

        .content {
            color: #333;
            line-height: 1.6;
        }

        .content h5 {
            color: #2c3e50;
        }

        

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    
        <div class="header">
            <!-- The 'cid' reference should match the contentId in the Mailable class -->
            <!-- <img src="cid:logo_default_slim" alt="TGR Africa Logo"> -->
            <img src="http://www.tgrafrica.com/img/logo-default-slim.png" alt="TGR Logo">
        </div>
        
        <div class="content">
            <h4>Thank You, {{ $messageContent['full_name'] }}!</h4>
            <p>You have successfully booked a consultation with TGR Africa.</p>
            <p>An advisor will contact you on the date and time specified in your booking.</p>
            <p>Please make sure to add us on WhatsApp as all consultations will be done via <strong>+233500200335</strong>.</p>
        </div>

        <div class="footer">
            <p>Best regards,</p>
            <p>The TGR Africa Team</p>
            <p><small>&copy; 2024 TGR Africa. All rights reserved.</small></p>
        </div>
    
</body>

</html>
