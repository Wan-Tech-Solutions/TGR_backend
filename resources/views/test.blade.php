<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phonebook</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f5f7fa;
        }
        .header {
            background: #d93025;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }
        .phonebook-container {
            display: flex;
            flex: 1;
        }
        .contacts-list {
            width: 300px;
            background-color: #e0e0e0;
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }
        .contacts-list h2 {
            margin-bottom: 10px;
            color: #d93025;
        }
        .contact-item {
            background: white;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .contact-item:hover {
            background: #d93025;
            color: white;
        }
        .contact-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            background: white;
            border-left: 1px solid #ddd;
        }
        .contact-details h2 {
            color: #d93025;
            margin-bottom: 15px;
        }
        .contact-info {
            font-size: 18px;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            margin-right: 15px;
            color: #555;
            transition: color 0.3s ease;
        }
        .back-button:hover {
            color: #d93025;
        }
    </style>
</head>
<body>
    <div class="header">TGR Phonebook</div>
    <div class="phonebook-container">
        <div class="contacts-list">
            <a href="{{route('admin.home.dashboard')}}"><button class="back-button">&#8592; Go Home</button></a>
            <img src="logo.png" height="100px" alt="TGR logo"/><br>
            <br><button class="remove-btn" style="background-color: red;color:white; height:50px; width:100px;">Add +</button>
            <br>

            <h2>Contacts</h2>
            <div class="contact-item">Brimah</div>
            <div class="contact-item">Lantam</div>
            <div class="contact-item">Logic</div>
            <div class="contact-item">Michael</div>

        </div>
        <div class="contact-details">
            <h2>Contact Details</h2>
            <div class="contact-info">Select a contact to view details</div>
        </div>
    </div>
</body>
</html>
