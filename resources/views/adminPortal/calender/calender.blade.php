<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Calendar | Appointments Management</title>
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
        }

        .calendar-container {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .appointments-sidebar {
            width: 360px;
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

        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary-color);
        }

        .stats-card h3 {
            margin-bottom: 10px;
            color: var(--primary-color);
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stats-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 5px;
        }

        .stats-description {
            font-size: 13px;
            color: var(--light-text);
        }

        .legend {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: var(--light-bg);
            border-radius: 10px;
            margin: 10px 0;
            font-size: 13px;
            justify-content: space-between;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .priority-high {
            background: var(--danger-color);
        }

        .priority-medium {
            background: var(--warning-color);
        }

        .priority-low {
            background: var(--success-color);
        }

        .appointments-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .appointments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .appointments-header h2 {
            color: var(--dark-text);
            font-size: 18px;
            font-weight: 700;
        }

        .appointment-count {
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .appointment-item {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--warning-color);
            transition: all 0.3s ease;
            position: relative;
        }

        .appointment-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .appointment-item.priority-high {
            border-left-color: var(--danger-color);
        }

        .appointment-item.priority-medium {
            border-left-color: var(--warning-color);
        }

        .appointment-item.priority-low {
            border-left-color: var(--success-color);
        }

        .appointment-item h3 {
            margin: 0 0 12px 0;
            font-size: 16px;
            color: var(--dark-text);
            line-height: 1.4;
        }

        .appointment-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0;
            font-size: 13px;
            color: white;
        }

        .priority-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .priority-high {
            background: var(--danger-color);
            color: white;
        }

        .priority-medium {
            background: var(--warning-color);
            color: var(--dark-text);
        }

        .priority-low {
            background: var(--success-color);
            color: white;
        }

        .appointment-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-complete {
            background: var(--success-color);
            color: white;
        }

        .btn-complete:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-remove {
            background: var(--danger-color);
            color: white;
        }

        .btn-remove:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .calendar-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            overflow: hidden;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            z-index: 5;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .calendar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-text);
            min-width: 200px;
            text-align: center;
        }

        .calendar-nav-btn {
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            color: var(--dark-text);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .calendar-nav-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 15px 25px;
            font-weight: 600;
            text-align: center;
            background: var(--light-bg);
            color: var(--light-text);
            font-size: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(6, 1fr);
            gap: 8px;
            padding: 20px 25px;
            background: white;
            flex: 1;
            overflow-y: auto;
        }

        .day {
            background: white;
            padding: 12px 8px;
            text-align: center;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            border: 1px solid var(--border-color);
        }

        .day:hover {
            background: var(--primary-light);
            color: white;
            transform: scale(1.03);
            box-shadow: var(--shadow);
        }

        .day.has-events {
            background: #fff9e6;
            font-weight: 600;
            border: 1px solid #ffeaa7;
        }

        .day.has-events:hover {
            background: var(--primary-light);
            color: white;
        }

        .event-indicator {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: var(--secondary-color);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            box-shadow: var(--shadow);
        }

        .current-day {
            background: var(--primary-color);
            color: white;
            font-weight: 700;
            box-shadow: var(--shadow);
        }

        .popup-overlay {
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

        .popup-overlay.show {
            display: flex;
        }

        .popup {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .popup-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-popup {
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

        .close-popup:hover {
            color: var(--danger-color);
            background: var(--light-bg);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
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
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .file-info {
            font-size: 12px;
            color: var(--light-text);
            margin-top: 5px;
        }

        .notification-section {
            background: var(--light-bg);
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .notification-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-weight: 600;
            color: var(--dark-text);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .checkbox-group input {
            width: auto;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-secondary {
            background: var(--light-bg);
            color: var(--dark-text);
            border: 1px solid var(--border-color);
            flex: 1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            flex: 2;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--light-text);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--border-color);
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 1024px) {
            .calendar-container {
                flex-direction: column;
            }
            
            .appointments-sidebar {
                width: 100%;
                max-height: 40vh;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            
            .calendar-header {
                padding: 15px;
            }
            
            .calendar-grid {
                padding: 15px;
            }
            
            .popup {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">
            <i class="fas fa-calendar-alt"></i>
            TGR Appointments Scheduler
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" id="quick-add-btn">
                <i class="fas fa-plus"></i> Quick Add
            </button>
        </div>
    </div>

    <div class="calendar-container">
        <div class="appointments-sidebar">
            <div class="sidebar-header">
                <a href="{{route('admin.home.dashboard')}}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                
                <div class="logo-section">
                    <div class="logo">TGR</div>
                    <div>
                        <h3 style="margin: 0; color: var(--dark-text);">The Great Return</h3>
                        <p style="margin: 0; font-size: 13px; color: var(--light-text);">Appointment Management</p>
                    </div>
                </div>
                
                <div class="stats-card">
                    <h3><i class="fas fa-envelope"></i> Newsletter Subscribers</h3>
                    <div class="stats-value">{{ $subscribersCount ?? 0 }}</div>
                    <p class="stats-description">Active subscribers for event notifications</p>
                </div>
            </div>

            <div class="legend">
                <div class="legend-item">
                    <span class="legend-dot priority-high"></span>
                    <span>High Priority</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot priority-medium"></span>
                    <span>Medium Priority</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot priority-low"></span>
                    <span>Low Priority</span>
                </div>
            </div>

            <div class="appointments-list">
                <div class="appointments-header">
                    <h2>Upcoming Appointments</h2>
                    <span class="appointment-count">{{ $events->count() }}</span>
                </div>
                
                @if($events->count() > 0)
                    @foreach($events as $event)
                        <div class="appointment-item priority-{{ $event->priority ?? 'medium' }}">
                            <h3>{{ $event->event_title }}</h3>
                            
                            <div class="appointment-meta">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                            </div>
                            <div class="appointment-meta">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                            </div>
                            
                            @if($event->location)
                            <div class="appointment-meta">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event->location }}
                            </div>
                            @endif
                            
                            @if($event->description)
                            <div class="appointment-meta" style="white-space: pre-line;">
                                <i class="fas fa-align-left"></i>
                                {{ Str::limit($event->description, 80) }}
                            </div>
                            @endif
                            
                            <div style="margin: 12px 0; display: flex; align-items: center; gap: 10px;">
                                <span class="priority-badge priority-{{ $event->priority ?? 'medium' }}">
                                    {{ strtoupper($event->priority ?? 'medium') }}
                                </span>
                                <span id="status-{{ $event->id }}" style="font-weight: 600; color: {{ $event->status === 'Complete' ? 'var(--success-color)' : 'var(--warning-color)' }};">
                                    {{ $event->status }}
                                </span>
                            </div>
                            
                            @if($event->attachment)
                            <div class="appointment-meta">
                                <i class="fas fa-paperclip"></i>
                                <a href="{{ asset('storage/' . $event->attachment) }}" target="_blank" style="color: var(--primary-color);">View Attachment</a>
                            </div>
                            @endif
                    
                            <div class="appointment-actions">
                                <button class="btn btn-primary view-btn" data-id="{{ $event->id }}" style="background: var(--primary-color); color: white;">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-secondary edit-btn" data-id="{{ $event->id }}" style="background: #6c757d; color: white;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                @if($event->status === 'Pending')
                                    <button class="btn btn-complete complete-btn" data-id="{{ $event->id }}">
                                        <i class="fas fa-check"></i> Complete
                                    </button>
                                @endif
                        
                                <button class="btn btn-remove remove-btn" data-id="{{ $event->id }}">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-plus"></i>
                        <h3>No Appointments</h3>
                        <p>Click on a date to create your first appointment</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="calendar-section">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button class="calendar-nav-btn prev-month">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="calendar-title">March 2025</div>
                    <button class="calendar-nav-btn next-month">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="calendar-actions">
                    <button class="btn btn-secondary" id="today-btn">
                        <i class="fas fa-calendar-day"></i> Today
                    </button>
                </div>
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
            <div class="calendar-grid"></div>
        </div>
    </div>

    <div class="popup-overlay" id="event-popup">
        <div class="popup">
            <div class="popup-header">
                <h3 class="popup-title">
                    <i class="fas fa-calendar-plus"></i>
                    Add New Event
                </h3>
                <button class="close-popup" id="close-popup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="event-date" class="form-label">Date *</label>
                    <input type="text" id="event-date" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="event-time" class="form-label">Time *</label>
                    <input type="time" id="event-time" class="form-control" required>
                </div>
                
                <div class="form-group full-width">
                    <label for="event-title" class="form-label">Event Title *</label>
                    <input type="text" id="event-title" class="form-control" placeholder="Enter event title" required>
                </div>
                
                <div class="form-group full-width">
                    <label for="event-description" class="form-label">Description</label>
                    <textarea id="event-description" class="form-control" placeholder="Add event details or notes..." rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="event-location" class="form-label">Location</label>
                    <input type="text" id="event-location" class="form-control" placeholder="Event location">
                </div>
                <div class="form-group">
                    <label for="event-priority" class="form-label">Priority *</label>
                    <select id="event-priority" class="form-control">
                        <option value="medium" selected>Medium</option>
                        <option value="low">Low</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="event-people" class="form-label">Attendees/Participants</label>
                    <textarea id="event-people" class="form-control" placeholder="List people involved..." rows="2"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="event-attachment" class="form-label">Attachment (Optional)</label>
                    <input type="file" id="event-attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                    <small class="file-info">Max 10MB. Allowed: PDF, DOC, DOCX, JPG, PNG, ZIP</small>
                </div>
                <div class="form-group">
                    <label for="event-color" class="form-label">Calendar Color</label>
                    <input type="color" id="event-color" class="form-control" value="#2c5aa0" style="height: 45px; padding: 5px;">
                </div>
            </div>
            
            <input type="hidden" value="Pending" id="event-status">
            
            <div class="notification-section">
                <div class="notification-header">
                    <i class="fas fa-envelope"></i>
                    Email Notifications
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="send-notification">
                    <label for="send-notification">Send to all newsletter subscribers ({{ $subscribersCount ?? 0 }} active)</label>
                </div>
                
                <div class="form-group full-width">
                    <label for="additional-emails" class="form-label">Additional Email Addresses</label>
                    <textarea id="additional-emails" class="form-control" placeholder="Enter email addresses separated by commas&#10;Example: john@example.com, jane@example.com, admin@company.com" rows="3"></textarea>
                    <small class="file-info">Add custom email addresses (comma-separated). These will receive notifications even if not subscribed.</small>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-secondary" id="cancel-popup">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn btn-primary" id="save-event">
                    <i class="fas fa-save"></i> Save Event
                </button>
            </div>
        </div>
    </div>

    <!-- View Event Popup -->
    <div class="popup-overlay" id="view-popup">
        <div class="popup">
            <div class="popup-header">
                <h3 class="popup-title">
                    <i class="fas fa-eye"></i>
                    View Event Details
                </h3>
                <button class="close-popup" id="close-view-popup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="view-content">
                <!-- Content will be loaded dynamically -->
            </div>

            <div class="form-actions">
                <button class="btn btn-secondary" id="cancel-view-popup">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Event Popup -->
    <div class="popup-overlay" id="edit-popup">
        <div class="popup">
            <div class="popup-header">
                <h3 class="popup-title">
                    <i class="fas fa-edit"></i>
                    Edit Event
                </h3>
                <button class="close-popup" id="close-edit-popup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="edit-event-date" class="form-label">Date *</label>
                    <input type="date" id="edit-event-date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-time" class="form-label">Time *</label>
                    <input type="time" id="edit-event-time" class="form-control" required>
                </div>
                
                <div class="form-group full-width">
                    <label for="edit-event-title" class="form-label">Event Title *</label>
                    <input type="text" id="edit-event-title" class="form-control" placeholder="Enter event title" required>
                </div>
                
                <div class="form-group full-width">
                    <label for="edit-event-description" class="form-label">Description</label>
                    <textarea id="edit-event-description" class="form-control" placeholder="Add event details or notes..." rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit-event-location" class="form-label">Location</label>
                    <input type="text" id="edit-event-location" class="form-control" placeholder="Event location">
                </div>
                <div class="form-group">
                    <label for="edit-event-priority" class="form-label">Priority *</label>
                    <select id="edit-event-priority" class="form-control">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="edit-event-people" class="form-label">Attendees/Participants</label>
                    <textarea id="edit-event-people" class="form-control" placeholder="List people involved..." rows="2"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit-event-attachment" class="form-label">Attachment (Optional)</label>
                    <input type="file" id="edit-event-attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                    <small class="file-info" id="current-attachment-info"></small>
                </div>
                <div class="form-group">
                    <label for="edit-event-color" class="form-label">Calendar Color</label>
                    <input type="color" id="edit-event-color" class="form-control" style="height: 45px; padding: 5px;">
                </div>
                
                <div class="form-group full-width">
                    <label for="edit-event-status" class="form-label">Status *</label>
                    <select id="edit-event-status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="Complete">Complete</option>
                    </select>
                </div>
            </div>
            
            <input type="hidden" id="edit-event-id">

            <div class="form-actions">
                <button class="btn btn-secondary" id="cancel-edit-popup">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn btn-primary" id="update-event">
                    <i class="fas fa-save"></i> Update Event
                </button>
            </div>
        </div>
    </div>

    <script>
        // Events data from backend
        const eventsByDate = @json($eventsByDate ?? []);
        
        document.addEventListener("DOMContentLoaded", function() {
            const calendarTitle = document.querySelector(".calendar-title");
            const prevButton = document.querySelector(".prev-month");
            const nextButton = document.querySelector(".next-month");
            const todayButton = document.querySelector("#today-btn");
            const calendarGrid = document.querySelector(".calendar-grid");
            const popupOverlay = document.querySelector("#event-popup");
            const closePopup = document.querySelector("#close-popup");
            const cancelPopup = document.querySelector("#cancel-popup");
            const dateInput = document.querySelector("#event-date");
            const quickAddBtn = document.querySelector("#quick-add-btn");
            
            let currentDate = new Date();
            const today = new Date();
            
            function renderCalendar(date) {
                const year = date.getFullYear();
                const month = date.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const lastDate = new Date(year, month + 1, 0).getDate();
                calendarTitle.textContent = date.toLocaleString('default', { month: 'long' }) + " " + year;
                
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
            
            todayButton.addEventListener("click", function() {
                currentDate = new Date();
                renderCalendar(currentDate);
            });
            
            calendarGrid.addEventListener("click", function(event) {
                const dayElement = event.target.closest('.day');
                if (dayElement && dayElement.hasAttribute('data-date')) {
                    dateInput.value = dayElement.getAttribute("data-date");
                    popupOverlay.classList.add("show");
                }
            });
            
            quickAddBtn.addEventListener("click", function() {
                // Set today's date as default
                const today = new Date();
                const dateString = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;
                dateInput.value = dateString;
                popupOverlay.classList.add("show");
            });
            
            closePopup.addEventListener("click", function() {
                popupOverlay.classList.remove("show");
            });
            
            cancelPopup.addEventListener("click", function() {
                popupOverlay.classList.remove("show");
            });
            
            // Close popup when clicking outside
            popupOverlay.addEventListener("click", function(event) {
                if (event.target === popupOverlay) {
                    popupOverlay.classList.remove("show");
                }
            });
            
            renderCalendar(currentDate);
        });

        // Event completion and deletion functionality
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

            // View event details
            document.querySelectorAll(".view-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const eventId = this.getAttribute("data-id");
                    viewEvent(eventId);
                });
            });

            // Edit event
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const eventId = this.getAttribute("data-id");
                    editEvent(eventId);
                });
            });
        });

        // View event function
        function viewEvent(eventId) {
            fetch(`/events/${eventId}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(response => response.json())
            .then(data => {
                const event = data.event;
                const priorityBadgeClass = event.priority === 'high' ? 'priority-high' : (event.priority === 'low' ? 'priority-low' : 'priority-medium');
                
                let html = `
                    <div style="display: grid; gap: 20px;">
                        <div style="background: var(--light-bg); padding: 15px; border-radius: 8px;">
                            <h3 style="margin: 0 0 10px 0; color: var(--primary-color);">${event.event_title}</h3>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <span class="priority-badge ${priorityBadgeClass}">${event.priority.toUpperCase()}</span>
                                <span style="padding: 4px 10px; border-radius: 20px; background: ${event.status === 'Complete' ? 'var(--success-color)' : 'var(--warning-color)'}; color: white; font-size: 11px; font-weight: 700;">${event.status}</span>
                            </div>
                        </div>
                        
                        <div>
                            <div class="appointment-meta" style="margin: 10px 0;">
                                <i class="fas fa-calendar"></i> <strong>Date:</strong> ${new Date(event.event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}
                            </div>
                            <div class="appointment-meta" style="margin: 10px 0;">
                                <i class="fas fa-clock"></i> <strong>Time:</strong> ${event.event_time}
                            </div>
                            ${event.location ? `<div class="appointment-meta" style="margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> ${event.location}</div>` : ''}
                            ${event.event_people ? `<div class="appointment-meta" style="margin: 10px 0;"><i class="fas fa-users"></i> <strong>Attendees:</strong> ${event.event_people}</div>` : ''}
                        </div>
                        
                        ${event.description ? `
                            <div>
                                <strong style="color: var(--dark-text);">Description:</strong>
                                <p style="margin: 8px 0; padding: 12px; background: var(--light-bg); border-radius: 6px; white-space: pre-line;">${event.description}</p>
                            </div>
                        ` : ''}
                        
                        ${event.attachment ? `
                            <div>
                                <strong style="color: var(--dark-text);">Attachment:</strong>
                                <div style="margin-top: 8px;">
                                    <a href="/storage/${event.attachment}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-paperclip"></i> View/Download Attachment
                                    </a>
                                </div>
                            </div>
                        ` : ''}
                        
                        ${event.additional_emails ? `
                            <div>
                                <strong style="color: var(--dark-text);">Additional Email Recipients:</strong>
                                <p style="margin: 8px 0; padding: 12px; background: var(--light-bg); border-radius: 6px; font-family: monospace; font-size: 13px;">${event.additional_emails}</p>
                            </div>
                        ` : ''}
                    </div>
                `;
                
                document.querySelector('#view-content').innerHTML = html;
                document.querySelector('#view-popup').classList.add('show');
            })
            .catch(error => {
                console.error("Error:", error);
                alert('Error loading event details.');
            });
        }

        // Edit event function
        function editEvent(eventId) {
            fetch(`/events/${eventId}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(response => response.json())
            .then(data => {
                const event = data.event;
                
                // Populate form fields
                document.querySelector('#edit-event-id').value = event.id;
                document.querySelector('#edit-event-date').value = event.event_date;
                document.querySelector('#edit-event-time').value = event.event_time;
                document.querySelector('#edit-event-title').value = event.event_title;
                document.querySelector('#edit-event-description').value = event.description || '';
                document.querySelector('#edit-event-location').value = event.location || '';
                document.querySelector('#edit-event-priority').value = event.priority;
                document.querySelector('#edit-event-people').value = event.event_people || '';
                document.querySelector('#edit-event-color').value = event.color || '#2c5aa0';
                document.querySelector('#edit-event-status').value = event.status;
                
                // Show current attachment if exists
                if (event.attachment) {
                    document.querySelector('#current-attachment-info').innerHTML = `Current: <a href="/storage/${event.attachment}" target="_blank">View attachment</a> (upload new to replace)`;
                } else {
                    document.querySelector('#current-attachment-info').innerHTML = 'Max 10MB. Allowed: PDF, DOC, DOCX, JPG, PNG, ZIP';
                }
                
                document.querySelector('#edit-popup').classList.add('show');
            })
            .catch(error => {
                console.error("Error:", error);
                alert('Error loading event for editing.');
            });
        }

        // Close view popup
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('#close-view-popup').addEventListener('click', function() {
                document.querySelector('#view-popup').classList.remove('show');
            });
            document.querySelector('#cancel-view-popup').addEventListener('click', function() {
                document.querySelector('#view-popup').classList.remove('show');
            });
            document.querySelector('#view-popup').addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('show');
            });
            
            // Close edit popup
            document.querySelector('#close-edit-popup').addEventListener('click', function() {
                document.querySelector('#edit-popup').classList.remove('show');
            });
            document.querySelector('#cancel-edit-popup').addEventListener('click', function() {
                document.querySelector('#edit-popup').classList.remove('show');
            });
            document.querySelector('#edit-popup').addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('show');
            });
            
            // Update event
            document.querySelector('#update-event').addEventListener('click', function() {
                const eventId = document.querySelector('#edit-event-id').value;
                const eventDate = document.querySelector('#edit-event-date').value;
                const eventTime = document.querySelector('#edit-event-time').value;
                const eventTitle = document.querySelector('#edit-event-title').value;
                const eventDescription = document.querySelector('#edit-event-description').value;
                const eventLocation = document.querySelector('#edit-event-location').value;
                const eventPriority = document.querySelector('#edit-event-priority').value;
                const eventPeople = document.querySelector('#edit-event-people').value;
                const eventColor = document.querySelector('#edit-event-color').value;
                const eventStatus = document.querySelector('#edit-event-status').value;
                const attachment = document.querySelector('#edit-event-attachment').files[0];

                if (!eventTitle || !eventTime || !eventDate) {
                    alert('Please fill in all required fields');
                    return;
                }

                const updateBtn = document.querySelector('#update-event');
                updateBtn.disabled = true;
                const originalText = updateBtn.innerHTML;
                updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';

                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('event_date', eventDate);
                formData.append('event_time', eventTime);
                formData.append('event_title', eventTitle);
                formData.append('description', eventDescription);
                formData.append('location', eventLocation);
                formData.append('priority', eventPriority);
                formData.append('event_people', eventPeople);
                formData.append('color', eventColor);
                formData.append('status', eventStatus);
                
                if (attachment) {
                    formData.append('attachment', attachment);
                }

                fetch(`/events/${eventId}`, {
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
                    alert('Error updating event.');
                    updateBtn.disabled = false;
                    updateBtn.innerHTML = originalText;
                });
            });
        });

        // Save event functionality
        document.addEventListener("DOMContentLoaded", function() {
            const saveButton = document.querySelector("#save-event");
            const popupOverlay = document.querySelector("#event-popup");
            
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
                const additionalEmails = document.querySelector("#additional-emails").value;
                const attachment = document.querySelector("#event-attachment").files[0];

                // Validation
                if (!eventTitle || !eventTime) {
                    alert('Please fill in all required fields (Title and Time)');
                    return;
                }

                // Show loading state
                saveButton.disabled = true;
                const originalText = saveButton.innerHTML;
                saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

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
                formData.append('additional_emails', additionalEmails);
                
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
                    saveButton.innerHTML = originalText;
                });
            });
            
            // Reset form when opening popup
            document.querySelector(".calendar-grid").addEventListener("click", function(event) {
                const dayElement = event.target.closest('.day');
                if (dayElement && dayElement.hasAttribute('data-date')) {
                    // Clear all form fields
                    document.querySelector("#event-title").value = '';
                    document.querySelector("#event-description").value = '';
                    document.querySelector("#event-location").value = '';
                    document.querySelector("#event-people").value = '';
                    document.querySelector("#event-attachment").value = '';
                    document.querySelector("#event-priority").value = 'medium';
                    document.querySelector("#event-color").value = '#2c5aa0';
                    document.querySelector("#event-time").value = '';
                    document.querySelector("#send-notification").checked = false;
                    document.querySelector("#additional-emails").value = '';
                }
            });
        });
    </script>
</body>
</html>