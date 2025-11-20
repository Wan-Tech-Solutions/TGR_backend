<!DOCTYPE html>
<html>

<head>
    <title>Prospectus</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .header {
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            color: #333;
            line-height: 1.6;
        }

        .content p {
            font-size: 12px;  /* Increase font size here */
        }
        
        .content a {
            color: rgb(0, 0, 255);
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
            <p>Thank you for reaching out.</p>
            <p>Please find below a link/attached Investors Community Prospectus.</p>
            
            <a href="{{ $pdfUrl }}" target="_blank" class="cta-link">Download TGR Prospectus</a>
        </div>

        <div class="footer">
            <p>Best regards,</p>
            <p>The TGR Team</p>
            <p><small>&copy; 2024 TGR AFRICA. All rights reserved.</small></p>
        </div>

</body>

      

</html>
