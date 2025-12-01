<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Notebook | Notes Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c5aa0;
            --primary-dark: #1e3d72;
            --primary-light: #4a7bce;
            --secondary-color: #d93025;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --dark-text: #2d3748;
            --light-text: #718096;
            --border-color: #e2e8f0;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --note-yellow: #fff9c4;
            --note-blue: #e3f2fd;
            --note-green: #e8f5e8;
            --note-pink: #fce4ec;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f5f7fa;
            color: var(--dark-text);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 18px 25px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .notebook-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 380px;
            background-color: white;
            padding: 25px;
            overflow-y: auto;
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: var(--dark-text);
            text-decoration: none;
            transition: all 0.3s ease;
            width: fit-content;
        }

        .back-button:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: var(--shadow);
        }

        .note-form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary-color);
        }

        .note-form h2 {
            margin-bottom: 20px;
            color: var(--primary-color);
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-text);
            font-size: 14px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-secondary {
            background: var(--light-bg);
            color: var(--dark-text);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .notes-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            overflow: hidden;
        }

        .notes-header {
            padding: 25px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .notes-header h2 {
            color: var(--dark-text);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .notes-subtitle {
            color: var(--light-text);
            font-size: 14px;
        }

        .notes-content {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            align-content: flex-start;
        }

        .note-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid var(--note-yellow);
            position: relative;
            overflow: hidden;
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .note-card.note-blue {
            border-left-color: var(--note-blue);
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
        }

        .note-card.note-green {
            border-left-color: var(--note-green);
            background: linear-gradient(135deg, #ffffff 0%, #f0fff0 100%);
        }

        .note-card.note-pink {
            border-left-color: var(--note-pink);
            background: linear-gradient(135deg, #ffffff 0%, #fff0f5 100%);
        }

        .note-card.note-yellow {
            border-left-color: var(--note-yellow);
            background: linear-gradient(135deg, #ffffff 0%, #fffdf0 100%);
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .note-title {
            font-weight: 700;
            font-size: 16px;
            color: var(--dark-text);
            line-height: 1.4;
            flex: 1;
            margin-right: 10px;
        }

        .note-actions {
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .note-card:hover .note-actions {
            opacity: 1;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: none;
            background: var(--light-bg);
            color: var(--light-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .note-content {
            color: var(--light-text);
            font-size: 14px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .note-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--light-text);
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
        }

        .note-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--light-text);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: var(--border-color);
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark-text);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            max-width: 600px;
            width: 100%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--light-text);
            transition: color 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-modal:hover {
            color: var(--danger-color);
            background: var(--light-bg);
        }

        .modal-content {
            line-height: 1.6;
            font-size: 15px;
            color: var(--dark-text);
            white-space: pre-line;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            justify-content: flex-end;
        }

        @media (max-width: 1024px) {
            .notebook-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                max-height: 40vh;
            }
            
            .notes-content {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            
            .notes-header {
                padding: 20px;
            }
            
            .notes-content {
                padding: 20px;
                grid-template-columns: 1fr;
            }
            
            .modal {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">
            <i class="fas fa-book"></i>
            TGR Notebook
        </div>
        <div class="header-actions">
            <span class="stats-badge" id="notesCount">0 Notes</span>
        </div>
    </div>

    <div class="notebook-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.home.dashboard') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                
                <div class="logo-section">
                    <div class="logo">TGR</div>
                    <div>
                        <h3 style="margin: 0; color: var(--dark-text);">The Great Return</h3>
                        <p style="margin: 0; font-size: 13px; color: var(--light-text);">Notes Management</p>
                    </div>
                </div>
            </div>

            <div class="note-form">
                <h2><i class="fas fa-plus-circle"></i> Create New Note</h2>
                <form action="{{ url('/add-notes') }}" method="POST" id="noteForm">
                    @csrf
                    <div class="form-group">
                        <label for="note-title" class="form-label">Note Title *</label>
                        <input type="text" id="note-title" name="title" class="form-control" placeholder="Enter note title" required maxlength="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="note-content" class="form-label">Note Content *</label>
                        <textarea id="note-content" name="content" class="form-control" placeholder="Write your note here..." required maxlength="1000"></textarea>
                        <div style="text-align: right; margin-top: 5px;">
                            <small style="color: var(--light-text); font-size: 12px;">
                                <span id="charCount">0</span>/1000 characters
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="clearForm">
                            <i class="fas fa-eraser"></i> Clear
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="notes-section">
            <div class="notes-header">
                <h2>Your Notes</h2>
                <p class="notes-subtitle">All your saved notes in one place</p>
            </div>
            <div class="notes-content" id="notesList">
                <div class="empty-state" id="emptyNotes">
                    <i class="fas fa-sticky-note"></i>
                    <h3>No Notes Yet</h3>
                    <p>Create your first note to get started</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Note Preview Modal -->
    <div class="modal-overlay" id="previewModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-sticky-note"></i>
                    <span id="previewTitle">Note Title</span>
                </h3>
                <button class="close-modal" id="closePreview">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content" id="previewContent">
                Note content will appear here...
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" id="closePreviewBtn">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Note Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Note
                </h3>
                <button class="close-modal" id="closeEdit">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editNoteForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-note-id">
                
                <div class="form-group">
                    <label for="edit-note-title" class="form-label">Note Title *</label>
                    <input type="text" id="edit-note-title" name="title" class="form-control" placeholder="Enter note title" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="edit-note-content" class="form-label">Note Content *</label>
                    <textarea id="edit-note-content" name="content" class="form-control" placeholder="Write your note here..." required maxlength="1000"></textarea>
                    <div style="text-align: right; margin-top: 5px;">
                        <small style="color: var(--light-text); font-size: 12px;">
                            <span id="editCharCount">0</span>/1000 characters
                        </small>
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancelEdit">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Note
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const noteForm = document.getElementById('noteForm');
            const clearFormBtn = document.getElementById('clearForm');
            const notesList = document.getElementById('notesList');
            const emptyNotes = document.getElementById('emptyNotes');
            const previewModal = document.getElementById('previewModal');
            const closePreview = document.getElementById('closePreview');
            const closePreviewBtn = document.getElementById('closePreviewBtn');
            const charCount = document.getElementById('charCount');
            const noteContent = document.getElementById('note-content');
            const notesCount = document.getElementById('notesCount');

            // Character counter for note content
            noteContent.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });

            // Clear form
            clearFormBtn.addEventListener('click', function() {
                noteForm.reset();
                charCount.textContent = '0';
            });

            // Fetch and display notes
            function fetchNotes() {
                fetch("{{ route('notes.index') }}")
                    .then(response => response.json())
                    .then(notes => {
                        notesList.innerHTML = '';
                        
                        if (notes.length === 0) {
                            emptyNotes.style.display = 'block';
                            notesCount.textContent = '0 Notes';
                            return;
                        }
                        
                        emptyNotes.style.display = 'none';
                        notesCount.textContent = `${notes.length} ${notes.length === 1 ? 'Note' : 'Notes'}`;
                        
                        notes.forEach((note, index) => {
                            const noteColors = ['note-yellow', 'note-blue', 'note-green', 'note-pink'];
                            const colorClass = noteColors[index % noteColors.length];
                            
                            const noteDate = new Date(note.created_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            
                            const noteCard = document.createElement('div');
                            noteCard.className = `note-card ${colorClass}`;
                                noteCard.innerHTML = `
                                    <div class="note-header">
                                        <div class="note-title">${note.title}</div>
                                        <div class="note-actions">
                                            <button class="action-btn view-btn" data-id="${note.id}" data-title="${note.title}" data-content="${note.content}" title="Preview Note">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn edit-btn" data-id="${note.id}" data-title="${note.title}" data-content="${note.content}" title="Edit Note">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn delete-btn" data-id="${note.id}" title="Delete Note">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="note-content">${note.content}</div>
                                    <div class="note-meta">
                                        <div class="note-date">
                                            <i class="far fa-calendar"></i>
                                            ${noteDate}
                                        </div>
                                        <div class="note-length">
                                            ${note.content.length} characters
                                        </div>
                                    </div>
                                `;
                            
                            notesList.appendChild(noteCard);
                        });
                        
                        // Add event listeners to action buttons
                        document.querySelectorAll('.view-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const title = this.getAttribute('data-title');
                                const content = this.getAttribute('data-content');
                                previewNote(title, content);
                            });
                        });
                        
                        document.querySelectorAll('.edit-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const noteId = this.getAttribute('data-id');
                                const title = this.getAttribute('data-title');
                                const content = this.getAttribute('data-content');
                                editNote(noteId, title, content);
                            });
                        });
                        
                        document.querySelectorAll('.delete-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const noteId = this.getAttribute('data-id');
                                deleteNote(noteId);
                            });
                        });
                        
                        // Add click event to note cards for preview
                        document.querySelectorAll('.note-card').forEach(card => {
                            card.addEventListener('click', function() {
                                const title = this.querySelector('.note-title').textContent;
                                const content = this.querySelector('.note-content').textContent;
                                previewNote(title, content);
                            });
                        });
                    })
                    .catch(error => console.error("Error fetching notes:", error));
            }

            // Preview note in modal
            function previewNote(title, content) {
                document.getElementById('previewTitle').textContent = title;
                document.getElementById('previewContent').textContent = content;
                previewModal.classList.add('show');
            }

            // Edit note
            const editModal = document.getElementById('editModal');
            const closeEdit = document.getElementById('closeEdit');
            const cancelEdit = document.getElementById('cancelEdit');
            const editNoteForm = document.getElementById('editNoteForm');
            const editCharCount = document.getElementById('editCharCount');
            const editNoteContent = document.getElementById('edit-note-content');

            // Character counter for edit note content
            editNoteContent.addEventListener('input', function() {
                editCharCount.textContent = this.value.length;
            });

            function editNote(noteId, title, content) {
                document.getElementById('edit-note-id').value = noteId;
                document.getElementById('edit-note-title').value = title;
                document.getElementById('edit-note-content').value = content;
                editCharCount.textContent = content.length;
                editModal.classList.add('show');
            }

            // Close edit modal
            closeEdit.addEventListener('click', function() {
                editModal.classList.remove('show');
            });

            cancelEdit.addEventListener('click', function() {
                editModal.classList.remove('show');
            });

            editModal.addEventListener('click', function(event) {
                if (event.target === editModal) {
                    editModal.classList.remove('show');
                }
            });

            // Edit form submission
            editNoteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const noteId = document.getElementById('edit-note-id').value;
                const title = document.getElementById('edit-note-title').value.trim();
                const content = document.getElementById('edit-note-content').value.trim();
                
                if (!title || !content) {
                    alert('Please fill in both title and content fields.');
                    return;
                }
                
                const submitBtn = editNoteForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                submitBtn.disabled = true;
                
                const formData = new FormData(this);
                
                fetch(`/notes/${noteId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    editModal.classList.remove('show');
                    fetchNotes();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                })
                .catch(error => {
                    console.error("Error updating note:", error);
                    alert('Error updating note. Please try again.');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });

            // Delete note
            function deleteNote(noteId) {
                if (confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    
                    fetch(`/notes/${noteId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchNotes();
                    })
                    .catch(error => console.error("Error deleting note:", error));
                }
            }

            // Close preview modal
            closePreview.addEventListener('click', function() {
                previewModal.classList.remove('show');
            });

            closePreviewBtn.addEventListener('click', function() {
                previewModal.classList.remove('show');
            });

            // Close modal when clicking outside
            previewModal.addEventListener('click', function(event) {
                if (event.target === previewModal) {
                    previewModal.classList.remove('show');
                }
            });

            // Form submission handling
            noteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const title = document.getElementById('note-title').value.trim();
                const content = document.getElementById('note-content').value.trim();
                
                if (!title || !content) {
                    alert('Please fill in both title and content fields.');
                    return;
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;
                
                // Submit form
                this.submit();
            });

            // Initial fetch of notes
            fetchNotes();
        });
    </script>
</body>
</html>