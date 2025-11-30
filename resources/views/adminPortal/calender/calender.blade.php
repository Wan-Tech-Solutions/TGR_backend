<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Calender | Appointments</title>
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
        .calendar-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .appointments {
            width: 320px;
            background-color: #e0e0e0;
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }
        .appointments h2 {
            margin-bottom: 10px;
            color: #d93025;
        }
        .appointment-item {
            background: white;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #d93025;
        }
        .appointment-item.priority-high {
            border-left-color: #dc3545;
        }
        .appointment-item.priority-medium {
            border-left-color: #ffc107;
        }
        .appointment-item.priority-low {
            border-left-color: #28a745;
        }
        .appointment-item h3 {
            margin: 0 0 8px 0;
            font-size: 15px;
        }
        .appointment-meta {
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 4px 0;
            font-size: 12px;
            color: #666;
        }
        .priority-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .priority-high {
            background: #dc3545;
            color: white;
        }
        .priority-medium {
            background: #ffc107;
            color: #333;
        }
        .priority-low {
            background: #28a745;
            color: white;
        }
        .calendar-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            border-left: 1px solid #ddd;
            overflow: hidden;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #d93025;
            color: white;
            font-size: 18px;
        }
        .calendar-header button {
            background: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        .calendar-header button:hover {
            background: #f0f0f0;
        }
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 10px;
            font-weight: bold;
            text-align: center;
            background: #eee;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(6, 1fr);
            gap: 5px;
            padding: 20px;
            background: white;
            flex: 1;
            overflow-y: auto;
        }
        .day {
            background: #f1f1f1;
            padding: 10px 5px;
            text-align: center;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .day:hover {
            background: #d93025;
            color: white;
            transform: scale(1.05);
        }
        .day.has-events {
            background: #fff3cd;
            font-weight: bold;
        }
        .day.has-events:hover {
            background: #d93025;
            color: white;
        }
        .event-indicator {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #d93025;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }
        .current-day {
            background: #d93025;
            color: white;
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
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .popup.show {
            display: block;
        }
        .popup h3 {
            margin-bottom: 20px;
            color: #d93025;
            font-size: 22px;
        }
        .popup label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #333;
            font-size: 13px;
        }
        .popup input, .popup textarea, .popup select {
            display: block;
            width: 100%;
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .popup textarea {
            resize: vertical;
            min-height: 60px;
        }
        .popup button {
            margin-top: 15px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }
        .file-info {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .legend {
            display: flex;
            gap: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 12px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
    </style>
        <script>
            // Events data from backend
            const eventsByDate = @json($eventsByDate ?? []);
            
            document.addEventListener("DOMContentLoaded", function() {
                const calendarHeader = document.querySelector(".calendar-header span");
                const prevButton = document.querySelector(".calendar-header button:first-child");
                const nextButton = document.querySelector(".calendar-header button:last-child");
                const calendarGrid = document.querySelector(".calendar");
                const popup = document.querySelector(".popup");
                const closePopup = document.querySelector(".close-popup");
                const dateInput = document.querySelector("#event-date");
                
                let currentDate = new Date();
                const today = new Date();
                
                function renderCalendar(date) {
                    const year = date.getFullYear();
                    const month = date.getMonth();
                    const firstDay = new Date(year, month, 1).getDay();
                    const lastDate = new Date(year, month + 1, 0).getDate();
                    calendarHeader.textContent = date.toLocaleString('default', { month: 'long' }) + " " + year;
                    
                    calendarGrid.innerHTML = "";
                    
                    // Add empty cells for days before month starts
                    for (let i = 0; i < firstDay; i++) {
                        calendarGrid.innerHTML += '<div class="day"></div>';
                    }
                    
                    // Add days of the month
                    for (let i = 1; i <= lastDate; i++) {
                        const dateKey = `${year}-${month + 1}-${i}`;
                        const eventCount = eventsByDate[dateKey] || 0;
                        const isToday = today.getDate() === i && today.getMonth() === month && today.getFullYear() === year;
                        
                        let dayClass = 'day';
                        if (isToday) dayClass += ' current-day';
                        if (eventCount > 0) dayClass += ' has-events';
                        
                        let dayHtml = `<div class="${dayClass}" data-date="${year}-${month + 1}-${i}">
                            <div>${i}</div>`;
                        
                        if (eventCount > 0) {
                            dayHtml += `<span class="event-indicator">${eventCount}</span>`;
                        }
                        
                        dayHtml += '</div>';
                        calendarGrid.innerHTML += dayHtml;
                    }
                }
                
                prevButton.addEventListener("click", function() {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    renderCalendar(currentDate);
                });
                
                nextButton.addEventListener("click", function() {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    renderCalendar(currentDate);
                });
                
                calendarGrid.addEventListener("click", function(event) {
                    const dayElement = event.target.closest('.day');
                    if (dayElement && dayElement.hasAttribute('data-date')) {
                        dateInput.value = dayElement.getAttribute("data-date");
                        popup.classList.add("show");
                    }
                });
                
                closePopup.addEventListener("click", function() {
                    popup.classList.remove("show");
                });
                
                renderCalendar(currentDate);
            });

            document.addEventListener("DOMContentLoaded", function () {
                // Mark event as complete
                document.querySelectorAll(".complete-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        const eventId = this.getAttribute("data-id");
            
                        fetch(`/events/${eventId}/complete`, {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector(`#status-${eventId}`).textContent = "Complete";
                                this.style.display = "none"; // Hide complete button
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    });
                });
            
                // Delete event
                document.querySelectorAll(".remove-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        const eventId = this.getAttribute("data-id");
            
                        if (confirm("Are you sure you want to delete this event?")) {
                            fetch(`/events/${eventId}`, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest(".appointment-item").remove(); // Remove event from UI
                                }
                            })
                            .catch(error => console.error("Error:", error));
                        }
                    });
                });
            });

        </script>
</head>
<body>
    <div class="header">
        TGR Appointments Scheduler
    </div>
    <div class="calendar-container">
        <div class="appointments">
            <a href="{{route('admin.home.dashboard')}}"><button class="back-button">&#8592; Go Home</button></a>
            <img src="logo.png" height="100px" alt="TGR logo"/>

            <div style="background: white; padding: 15px; margin: 15px 0; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; color: #d93025; font-size: 16px;">📧 Newsletter Subscribers</h3>
                <p style="margin: 5px 0; font-size: 14px;">
                    <strong>Active Subscribers:</strong> {{ $subscribersCount ?? 0 }}
                </p>
                <p style="margin: 5px 0; font-size: 12px; color: #666;">
                    Events can be sent to all active subscribers when created.
                </p>
            </div>

            <div class="legend">
                <div class="legend-item">
                    <span class="legend-dot priority-high"></span>
                    <span>High</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot priority-medium"></span>
                    <span>Medium</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot priority-low"></span>
                    <span>Low</span>
                </div>
            </div>

            <h2>Appointments ({{ $events->count() }})</h2>
            @foreach($events as $event)
                <div class="appointment-item priority-{{ $event->priority ?? 'medium' }}">
                    <h3>{{ $event->event_title }}</h3>
                    
                    <div class="appointment-meta">
                        📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                    </div>
                    <div class="appointment-meta">
                        🕐 {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                    </div>
                    
                    @if($event->location)
                    <div class="appointment-meta">
                        📍 {{ $event->location }}
                    </div>
                    @endif
                    
                    @if($event->description)
                    <div class="appointment-meta" style="white-space: pre-line;">
                        {{ Str::limit($event->description, 80) }}
                    </div>
                    @endif
                    
                    <div style="margin: 8px 0; display: flex; align-items: center; gap: 8px;">
                        <span class="priority-badge priority-{{ $event->priority ?? 'medium' }}">
                            {{ strtoupper($event->priority ?? 'medium') }}
                        </span>
                        <span id="status-{{ $event->id }}" style="font-weight: bold; color: {{ $event->status === 'Complete' ? '#28a745' : '#ffc107' }};">
                            {{ $event->status }}
                        </span>
                    </div>
                    
                    @if($event->attachment)
                    <div class="appointment-meta">
                        📎 <a href="{{ asset('storage/' . $event->attachment) }}" target="_blank" style="color: #d93025;">View Attachment</a>
                    </div>
                    @endif
            
                    @if($event->status === 'Pending')
                        <button class="complete-btn" style="background-color: rgb(41, 119, 18);color:white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 8px; font-size: 12px;" data-id="{{ $event->id }}">✓ Complete</button>
                    @endif
            
                    <button class="remove-btn" style="background-color: #dc3545;color:white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 8px; font-size: 12px;" data-id="{{ $event->id }}">🗑 Remove</button>
                </div>
            @endforeach

        </div>
        <div class="calendar-section">
            <div class="calendar-header">
                <button>&lt;</button>
                <span>March 2025</span>
                <button>&gt;</button>
            </div>
            <div class="calendar-days">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="calendar"></div>
        </div>

        <div class="popup">
            <h3>📅 Add New Event</h3>
            
            <div class="form-row">
                <div>
                    <label for="event-date">Date: *</label>
                    <input type="text" id="event-date" readonly>
                </div>
                <div>
                    <label for="event-time">Time: *</label>
                    <input type="time" id="event-time" required>
                </div>
            </div>
            
            <label for="event-title">Event Title: *</label>
            <input type="text" id="event-title" placeholder="Enter event title" required>
            
            <label for="event-description">Description:</label>
            <textarea id="event-description" placeholder="Add event details or notes..." rows="3"></textarea>
            
            <div class="form-row">
                <div>
                    <label for="event-location">Location:</label>
                    <input type="text" id="event-location" placeholder="Event location">
                </div>
                <div>
                    <label for="event-priority">Priority: *</label>
                    <select id="event-priority">
                        <option value="medium" selected>Medium</option>
                        <option value="low">Low</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            
            <label for="event-people">Attendees/Participants:</label>
            <textarea id="event-people" placeholder="List people involved..." rows="2"></textarea>
            
            <label for="event-attachment">Attachment (Optional):</label>
            <input type="file" id="event-attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
            <small class="file-info">Max 10MB. Allowed: PDF, DOC, DOCX, JPG, PNG, ZIP</small>
            
            <label for="event-color">Calendar Color:</label>
            <input type="color" id="event-color" value="#d93025" style="height: 40px;">
            
            <input type="hidden" value="Pending" id="event-status">
            
            <label for="send-notification" style="display: flex; align-items: center; gap: 8px; margin-top: 15px;">
                <input type="checkbox" id="send-notification" style="width: auto; margin: 0;">
                <span>📧 Send notification to all newsletter subscribers ({{ $subscribersCount ?? 0 }} active)</span>
            </label>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button class="close-popup" style="background-color:#6c757d; flex: 1; color: white;">✕ Close</button>
                <button class="save-event" style="background-color:#28a745; flex: 2; color: white;">💾 Save Event</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const saveButton = document.querySelector(".save-event");
            const popup = document.querySelector(".popup");
            
            saveButton.addEventListener("click", function() {
                const eventDate = document.querySelector("#event-date").value;
                const eventTime = document.querySelector("#event-time").value;
                const eventTitle = document.querySelector("#event-title").value;
                const eventDescription = document.querySelector("#event-description").value;
                const eventLocation = document.querySelector("#event-location").value;
                const eventPriority = document.querySelector("#event-priority").value;
                const eventPeople = document.querySelector("#event-people").value;
                const eventColor = document.querySelector("#event-color").value;
                const eventStatus = document.querySelector("#event-status").value;
                const sendNotification = document.querySelector("#send-notification").checked;
                const attachment = document.querySelector("#event-attachment").files[0];

                // Validation
                if (!eventTitle || !eventTime) {
                    alert('Please fill in all required fields (Title and Time)');
                    return;
                }

                // Show loading state
                saveButton.disabled = true;
                saveButton.innerHTML = '<span style="display: inline-block; animation: spin 1s linear infinite;">⏳</span> Saving...';

                // Use FormData for file upload
                const formData = new FormData();
                formData.append('event_date', eventDate);
                formData.append('event_time', eventTime);
                formData.append('event_title', eventTitle);
                formData.append('description', eventDescription);
                formData.append('location', eventLocation);
                formData.append('priority', eventPriority);
                formData.append('event_people', eventPeople);
                formData.append('color', eventColor);
                formData.append('status', eventStatus);
                formData.append('send_notification', sendNotification);
                
                if (attachment) {
                    formData.append('attachment', attachment);
                }

                fetch("/events", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert('Error saving event. Please try again.');
                    saveButton.disabled = false;
                    saveButton.innerHTML = '💾 Save Event';
                });
            });
            
            // Reset form when opening popup
            document.querySelector(".calendar").addEventListener("click", function(event) {
                const dayElement = event.target.closest('.day');
                if (dayElement && dayElement.hasAttribute('data-date')) {
                    // Clear all form fields
                    document.querySelector("#event-title").value = '';
                    document.querySelector("#event-description").value = '';
                    document.querySelector("#event-location").value = '';
                    document.querySelector("#event-people").value = '';
                    document.querySelector("#event-attachment").value = '';
                    document.querySelector("#event-priority").value = 'medium';
                    document.querySelector("#event-color").value = '#d93025';
                    document.querySelector("#event-time").value = '';
                    document.querySelector("#send-notification").checked = false;
                }
            });
        });
    </script>
    
    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
    

</body>
</html>
