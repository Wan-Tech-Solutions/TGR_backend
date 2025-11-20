<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notebook</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            font-size: 20px;
            font-weight: bold;
        }
        .notebook-container {
            display: flex;
            flex: 1;
        }
        .add-note-section {
            width: 300px;
            background-color: #e0e0e0;
            padding: 20px;
            border-right: 1px solid #ddd;
        }
        .add-note-section h2 {
            margin-bottom: 10px;
            color: #d93025;
        }
        .note-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            transition: border 0.3s ease;
        }
        .note-input:focus {
            border-color: #d93025;
            outline: none;
        }
        textarea.note-input {
            resize: none;
            height: 100px;
        }
        .add-button {
            background: #d93025;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .add-button:hover {
            background: #b8261a;
        }
        .notes-section {
            flex: 1;
            padding: 20px;
            background: white;
            overflow-y: auto;
        }
        .notes-section h2 {
            color: #d93025;
            margin-bottom: 10px;
        }
        .note-card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .note-card:hover {
            transform: scale(1.05);
            box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.2);
        }
        .preview-section {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 350px;
            text-align: center;
        }
        .close-button {
            background: #d93025;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .close-button:hover {
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
    <div class="header">
        TGR Notebook
    </div>
    <div class="notebook-container">
        <div class="add-note-section">
            <a href="{{route('admin.home.dashboard')}}"><button class="back-button">&#8592; Go Home</button></a>
            <img src="logo.png" height="100px" alt="TGR logo"/>

            
            <h2>Add a Note</h2>
            <form action="{{url('/add-notes')}}" method="POST">
                @csrf
            <input id="note-title" class="note-input" name="title" type="text" placeholder="Note Title">
            <textarea id="note-content" class="note-input" name="content" placeholder="Note Content"></textarea>
            <button class="add-button" type="submit">Add Note</button>
            </form>
        </div>
        <div class="notes-section">
            <h2>Saved Notes</h2>
            <div id="notes-list"></div>
        </div>
    </div>
    <div class="preview-section" id="preview">
        <h2 id="preview-title"></h2>
        <p id="preview-content"></p>
        <button class="close-button" onclick="closePreview()">Close</button>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchNotes();
        });

        function fetchNotes() {
            fetch("{{ route('notes.index') }}")
                .then(response => response.json())
                .then(notes => {
                    let notesList = document.getElementById("notes-list");
                    notesList.innerHTML = "";
                    notes.forEach(note => {
                        notesList.innerHTML += `<div class="note-card" onclick="previewNote('${note.title}', '${note.content}')">${note.title}</div>`;
                    });
                })
                .catch(error => console.error("Error fetching notes:", error));
        }

        function addNote() {
            let title = document.getElementById("note-title").value;
            let content = document.getElementById("note-content").value;
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            fetch("{{ route('notes.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ title, content })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchNotes();
                document.getElementById("note-title").value = "";
                document.getElementById("note-content").value = "";
            })
            .catch(error => console.error("Error adding note:", error));
        }

        function previewNote(title, content) {
            document.getElementById("preview-title").innerText = title;
            document.getElementById("preview-content").innerText = content;
            document.getElementById("preview").style.display = "block";
        }

        function closePreview() {
            document.getElementById("preview").style.display = "none";
        }
    </script>

</body>
</html>
