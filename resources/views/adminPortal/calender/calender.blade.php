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
        }
        .appointments {
            width: 300px;
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
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .calendar-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            border-left: 1px solid #ddd;
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
        }
        .day {
            background: #f1f1f1;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .day:hover {
            background: #d93025;
            color: white;
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .popup.show {
            display: block;
        }
        .popup input, .popup button {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 8px;
        }
    </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const calendarHeader = document.querySelector(".calendar-header span");
                const prevButton = document.querySelector(".calendar-header button:first-child");
                const nextButton = document.querySelector(".calendar-header button:last-child");
                const calendarGrid = document.querySelector(".calendar");
                const popup = document.querySelector(".popup");
                const closePopup = document.querySelector(".close-popup");
                const dateInput = document.querySelector("#event-date");
                
                let currentDate = new Date();
                
                function renderCalendar(date) {
                    const year = date.getFullYear();
                    const month = date.getMonth();
                    const firstDay = new Date(year, month, 1).getDay();
                    const lastDate = new Date(year, month + 1, 0).getDate();
                    calendarHeader.textContent = date.toLocaleString('default', { month: 'long' }) + " " + year;
                    
                    calendarGrid.innerHTML = "";
                    for (let i = 0; i < firstDay; i++) {
                        calendarGrid.innerHTML += '<div class="day"></div>';
                    }
                    for (let i = 1; i <= lastDate; i++) {
                        calendarGrid.innerHTML += `<div class="day" data-date="${year}-${month + 1}-${i}">${i}</div>`;
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
                    if (event.target.classList.contains("day")) {
                        dateInput.value = event.target.getAttribute("data-date");
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

            <h2>Appointments</h2>
            @foreach($events as $event)
                <div class="appointment-item">
                    <h3>{{ $event->event_title }} </h3>
                    <br> {{ $event->event_date }}, {{ $event->event_time }} 
                    <br> {{ $event->event_people }} 
                    <br> <b id="status-{{ $event->id }}">{{ $event->status }}</b><br>
            
                    @if($event->status === 'Pending')
                        <br><button class="complete-btn" style="background-color: rgb(41, 119, 18);color:white; height:50px; width:100px;" data-id="{{ $event->id }}">Complete</button>
                    @endif
            
                    <br><button class="remove-btn" style="background-color: red;color:white; height:50px; width:100px;" data-id="{{ $event->id }}">Remove</button>
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
            <h3>Add Event</h3>
            <label for="event-date">Date:</label>
            <input type="text" id="event-date" readonly>
            <label for="event-title">Time:</label>
            <input type="time" id="event-time">
            <label for="event-title">Event Title:</label>
            <input type="text" id="event-title"><br><br>
            <label for="event-people">People:</label>
            <textarea type="text" id="event-people"></textarea>
            <input type="hidden" value="Pending" id="event-status">

            <button class="close-popup" style="background-color:#d93025">Close</button>
            <button class="save-event" style="background-color:#328509">Save Event</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const saveButton = document.querySelector(".save-event");
            
            saveButton.addEventListener("click", function() {
                const eventDate = document.querySelector("#event-date").value;
                const eventTime = document.querySelector("#event-time").value;
                const eventTitle = document.querySelector("#event-title").value;
                const eventPeople = document.querySelector("#event-people").value;
                const eventStatus = document.querySelector("#event-status").value; // Get the status value

                fetch("/events", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        event_date: eventDate,
                        event_time: eventTime,
                        event_title: eventTitle,
                        event_people: eventPeople,
                        status: eventStatus,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => console.error("Error:", error));
            });
        });
    </script>
    

</body>
</html>
