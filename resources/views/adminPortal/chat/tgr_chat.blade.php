<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
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
        .chat-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }
        .chat-list {
            width: 300px;
            background-color: #e0e0e0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }
        .chat-list h2 {
            margin-bottom: 15px;
            color: #d93025;
        }
        .chat-item {
            padding: 15px;
            background: white;
            margin-bottom: 10px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
        }
        .chat-item:hover {
            background-color: #f1f3f4;
        }
        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            padding: 20px;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .message {
            padding: 12px 15px;
            border-radius: 20px;
            max-width: 60%;
            word-wrap: break-word;
            font-size: 14px;
        }
        .message.sent {
            background: #d93025;
            color: white;
            align-self: flex-end;
        }
        .message.received {
            background: #e0e0e0;
            align-self: flex-start;
        }
        .chat-input {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .chat-input input {
            flex: 1;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 25px;
            outline: none;
        }
        .chat-input button {
            background: #d93025;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 14px;
        }
        .chat-input button:hover {
            background: #b8261a;
        }
        .file-input {
            display: none;
        }
        .file-label {
            cursor: pointer;
            background: #d93025;
            color: white;
            padding: 12px 15px;
            border-radius: 25px;
            transition: background 0.3s ease;
            font-size: 14px;
        }
        .file-label:hover {
            background: #b8261a;
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
    <div class="chat-container">
        <div class="chat-list">
            <a href="{{route('admin.home.dashboard')}}"><button class="back-button">&#8592; Go Home</button></a>
            <img src="logo.png" height="100px" alt="TGR logo"/>

            <h2>Chats</h2>
            <div class="chat-item">Brimah</div>
            <div class="chat-item">Lantam</div>
            <div class="chat-item">Login</div>
            <div class="chat-item">Michael</div>
        </div>
        <div class="chat-window">
            <div class="chat-messages">
                <div class="message sent">Hey, how are you?</div>
                <div class="message received">I'm good, thanks! How about you?</div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Type a message...">
                <input type="file" class="file-input" id="fileInput">
                <label for="fileInput" class="file-label">📎</label>
                <button>Send</button>
            </div>
        </div>
    </div>
</body>
</html>
