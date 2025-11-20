<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Mailing</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #f5f7fa;
        }
        .sidebar {
            width: 250px;
            background-color: #e0e0e0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #ddd;
        }
        .compose-button {
            background-color: #d93025;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .compose-button:hover {
            background-color: #b8261a;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            padding: 12px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 15px;
            color: #333;
            transition: background 0.3s ease;
        }
        .sidebar ul li:hover {
            background-color: #f1f3f4;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .top-bar {
            padding: 15px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 16px;
            color: #555;
        }
        .top-bar input {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 10px;
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
        .email-list {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .emails {
            width: 350px;
            background: #fff;
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }
        .email-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .email-item:hover {
            background: #eef3fc;
        }
        .reading-pane {
            flex: 1;
            padding: 20px;
            background: #fff;
            font-size: 14px;
            color: #333;
            display: flex;
            flex-direction: column;
        }
        .reading-pane h2 {
            margin-bottom: 10px;
        }
        .reading-pane p {
            margin-bottom: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 450px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .modal-content h3 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }
        .modal input, .modal textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .modal textarea {
            height: 100px;
            resize: none;
        }
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .modal-buttons button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .modal-buttons .send {
            background-color: #1a73e8;
            color: white;
        }
        .modal-buttons .send:hover {
            background-color: #1558c0;
        }
        .modal-buttons .cancel {
            background-color: #ccc;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 10px;
            }
            .email-list {
                flex-direction: column;
            }
            .emails {
                width: 100%;
            }
            .reading-pane {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="{{route('admin.home.dashboard')}}"><button class="back-button">&#8592; Go Home</button></a>
        <img src="logo.png" height="100px" alt="TGR logo"/>
        <button class="compose-button" onclick="showModal()">Compose</button>
        <ul>
            <a href="{{url('/tgr-mail')}}"><li>Inbox</li></a>
            <a href="{{route('admin.tgr.sent')}}"><li>Sent</li></a>
            <a href="{{route('admin.tgr.spam')}}"><li>Spam</li></a>
            <a href="{{route('admin.tgr.trash')}}"><li>Trash</li></a>
        </ul>
    </div>