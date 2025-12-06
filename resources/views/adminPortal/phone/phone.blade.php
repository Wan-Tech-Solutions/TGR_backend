<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Phonebook | Contact Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #ef4444;
            --brand-2: #f97373;
            --brand-dark: #b91c1c;
            --ink: #0b0b0f;
            --muted: #6b7280;
            --border: #e6e6e6;
            --surface: #ffffff;
            --soft: #f8fafc;
            --shadow: 0 12px 32px rgba(15, 15, 19, 0.14);
            --shadow-soft: 0 10px 22px rgba(15, 15, 19, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Manrope', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 0%, #fdf2f2 45%, #fff 100%);
            color: var(--ink);
            position: relative;
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(239,68,68,0.12) 0%, rgba(239,68,68,0) 65%);
            filter: blur(4px);
            z-index: 0;
            pointer-events: none;
        }

        body::before { top: -40px; left: -80px; }
        body::after { bottom: -60px; right: -40px; }

        .header {
            background: linear-gradient(120deg, var(--brand), var(--brand-dark));
            color: #fff;
            padding: 18px 24px;
            box-shadow: var(--shadow-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .header-title {
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.2px;
        }

        .header-actions {
            display: inline-flex;
            gap: 10px;
            align-items: center;
        }

        .header-actions span {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
        }

        .phonebook-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .contacts-sidebar {
            width: 360px;
            background: var(--surface);
            padding: 22px;
            overflow-y: auto;
            border-right: 1px solid var(--border);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 18px;
            position: relative;
            z-index: 1;
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--soft);
            border: 1px solid var(--border);
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            transition: all 0.2s ease;
            width: fit-content;
        }

        .back-button:hover {
            background: #fff;
            border-color: var(--brand);
            color: var(--brand);
            transform: translateY(-1px);
            box-shadow: var(--shadow-soft);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 18px;
            box-shadow: var(--shadow-soft);
        }

        .logo-section h3 {
            margin: 0;
            color: var(--ink);
            font-size: 18px;
            font-weight: 800;
        }

        .logo-section p {
            margin: 0;
            font-size: 13px;
            color: var(--muted);
            font-weight: 600;
        }

        .search-section {
            position: relative;
            margin: 6px 0 4px;
        }

        .search-input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: var(--soft);
            color: var(--ink);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
            background: #fff;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
        }

        .add-contact-btn {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.2px;
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
            margin: 6px 0 2px;
            box-shadow: var(--shadow-soft);
        }

        .add-contact-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .contacts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .contacts-header h2 {
            color: var(--ink);
            font-size: 17px;
            font-weight: 800;
        }

        .contacts-count {
            background: rgba(239, 68, 68, 0.12);
            color: var(--brand-dark);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .contacts-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
            overflow-y: auto;
            padding-bottom: 12px;
        }

        .contact-item {
            background: var(--surface);
            padding: 16px;
            border-radius: 14px;
            box-shadow: var(--shadow-soft);
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .contact-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: rgba(239, 68, 68, 0.35);
        }

        .contact-item.active {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            border-color: transparent;
            box-shadow: var(--shadow);
        }

        .contact-item.active .contact-phone,
        .contact-item.active .contact-name {
            color: #fff;
        }

        .contact-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.14);
            border: 1px solid rgba(239, 68, 68, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-dark);
            font-weight: 800;
            font-size: 17px;
            flex-shrink: 0;
        }

        .contact-item.active .contact-avatar {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.35);
            color: #fff;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: 800;
            font-size: 15px;
            margin-bottom: 4px;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-phone {
            font-size: 13px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .contact-details-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--soft);
            border-left: 1px solid var(--border);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .details-header {
            padding: 22px 26px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .details-header h2 {
            color: var(--ink);
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .details-subtitle {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .details-content {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
            max-width: 420px;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 18px;
            color: rgba(239, 68, 68, 0.22);
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 8px;
            color: var(--ink);
            font-weight: 800;
        }

        .contact-card {
            background: var(--surface);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 26px;
            max-width: 520px;
            width: 100%;
            text-align: left;
            border: 1px solid var(--border);
        }

        .contact-card-header {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 22px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
            position: relative;
            padding-right: 20px; /* room for close button */
        }

        .contact-card-actions {
            display: inline-flex;
            gap: 10px;
            margin-left: auto;
            align-self: flex-start;
            flex-wrap: nowrap;
            flex-shrink: 0;
            align-items: center;
            margin-right: 30px; /* offset from close button */
        }

        .contact-card-actions .btn {
            padding: 0 12px;
            flex: none;
            min-width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .card-close {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 32px;
            height: 33px;
            border-radius: 12px;
            border: 1px solid rgba(239, 68, 68, 0.25);
            background: rgba(239, 68, 68, 0.08);
            color: var(--brand-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-soft);
        }

        .card-close:hover {
            background: rgba(239, 68, 68, 0.16);
            border-color: rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        .contact-card-avatar {
            width: 76px;
            height: 76px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 26px;
            flex-shrink: 0;
            box-shadow: var(--shadow-soft);
        }

        .contact-card-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .contact-card-role {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .contact-details-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .detail-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-dark);
            flex-shrink: 0;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .detail-content { flex: 1; }

        .detail-label {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 15px;
            color: var(--ink);
            font-weight: 700;
        }

        .detail-value a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 800;
        }

        .detail-value a:hover { text-decoration: underline; }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(2px);
        }

        .modal-overlay.show { display: flex; }

        .modal {
            background: var(--surface);
            padding: 26px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            max-width: 520px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            border: 1px solid var(--border);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--brand-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: var(--muted);
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-modal:hover {
            color: var(--brand-dark);
            background: rgba(239, 68, 68, 0.08);
        }

        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
            color: var(--ink);
            font-size: 13px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: var(--soft);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
            background: #fff;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 800;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
            letter-spacing: 0.2px;
        }

        .btn-secondary {
            background: var(--soft);
            color: var(--ink);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #fff;
            border-color: var(--brand);
            color: var(--brand-dark);
            box-shadow: var(--shadow-soft);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        @media (max-width: 1024px) {
            .contacts-sidebar { width: 320px; }
        }

        @media (max-width: 820px) {
            body { height: auto; min-height: 100vh; }
            .phonebook-container { flex-direction: column; }
            .contacts-sidebar {
                width: 100%;
                max-height: 44vh;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
            .contact-details-section { border-left: none; }
            .details-content { align-items: stretch; }
            .contact-card { margin: 0 auto; }
        }

        @media (max-width: 520px) {
            .header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .header-actions { width: 100%; justify-content: flex-start; }
            .contacts-sidebar { padding: 18px; }
            .details-content { padding: 20px 16px; }
            .contact-card { padding: 20px; }
            .contact-card-header { flex-direction: column; align-items: flex-start; }
            .form-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">
            <i class="fas fa-address-book"></i>
            TGR Phonebook
        </div>
        <div class="header-actions">
            <span>{{ $contacts->count() }} Contacts</span>
        </div>
    </div>

    <div class="phonebook-container">
        <div class="contacts-sidebar">
            <div class="sidebar-header">
                @if (session('message'))
                    <div style="background:#e6fffa;border:1px solid #38b2ac;color:#285e61;padding:12px 14px;border-radius:8px;font-size:13px;font-weight:600;margin-bottom:10px;">
                        {{ session('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div style="background:#fff5f5;border:1px solid #feb2b2;color:#742a2a;padding:12px 14px;border-radius:8px;font-size:13px;margin-bottom:10px;">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <a href="{{ route('admin.home.dashboard') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>

                <div class="logo-section">
                    <div class="logo">TGR</div>
                    <div>
                        <h3 style="margin: 0; color: var(--dark-text);">The Great Return</h3>
                        <p style="margin: 0; font-size: 13px; color: var(--light-text);">Contact Management</p>
                    </div>
                </div>

                <div class="search-section">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search contacts...">
                </div>

                <button class="add-contact-btn" id="addContactBtn">
                    <i class="fas fa-user-plus"></i> Add New Contact
                </button>
            </div>

            <div class="contacts-list-container">
                <div class="contacts-header">
                    <h2>Contacts</h2>
                    <span class="contacts-count">{{ $contacts->count() }}</span>
                </div>

                <div class="contacts-list" id="contactsList">
                    @if($contacts->count() > 0)
                        @foreach($contacts as $contact)
                            <div class="contact-item"
                                 data-id="{{ $contact->id }}"
                                 data-name="{{ $contact->name }}"
                                 data-phone="{{ $contact->phone }}"
                                 data-email="{{ $contact->email }}"
                                 data-website="{{ $contact->website }}"
                                 data-address="{{ $contact->address }}">
                                <div class="contact-avatar">
                                    {{ substr($contact->name, 0, 1) }}
                                </div>
                                <div class="contact-info">
                                    <div class="contact-name">{{ $contact->name }}</div>
                                    <div class="contact-phone">
                                        <i class="fas fa-phone"></i>
                                        {{ $contact->phone }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-address-book"></i>
                            <h3>No Contacts</h3>
                            <p>Add your first contact to get started</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="contact-details-section">
            <div class="details-header">
                <h2>Contact Details</h2>
                <p class="details-subtitle">Select a contact to view detailed information</p>
            </div>
            <div class="details-content">
                <div class="empty-state" id="emptyDetails">
                    <i class="fas fa-user-circle"></i>
                    <h3>No Contact Selected</h3>
                    <p>Choose a contact from the list to view their details</p>
                </div>

                <div class="contact-card" id="contactCard" style="display: none;" data-contact-id="">
                    <div class="contact-card-header">
                        <div class="contact-card-avatar" id="detailAvatar">J</div>
                        <div style="flex: 1;">
                            <h2 class="contact-card-name" id="detailName">John Doe</h2>
                            <p class="contact-card-role" id="detailRole">Contact</p>
                        </div>
                        <div class="contact-card-actions">
                            <button class="btn" id="editContactBtn" style="background: linear-gradient(135deg, var(--brand), var(--brand-dark)); color: white;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn" id="deleteContactBtn" style="background: var(--brand-dark); color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <button class="card-close" id="closeCardBtn" aria-label="Close details">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="contact-details-list">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Phone Number</div>
                                <div class="detail-value" id="detailPhone">+1 (555) 123-4567</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Email Address</div>
                                <div class="detail-value" id="detailEmail">john.doe@example.com</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Website</div>
                                <div class="detail-value" id="detailWebsite">
                                    <a href="#" target="_blank">www.example.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Address</div>
                                <div class="detail-value" id="detailAddress">123 Main Street, City, Country</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal-overlay" id="addContactModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Add New Contact
                </h3>
                <button class="close-modal" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form method="POST" action="{{ url('/add-contacts') }}" id="contactForm">
                @csrf
                <div class="form-group">
                    <label for="contact-name" class="form-label">Full Name *</label>
                    <input type="text" id="contact-name" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="contact-phone" class="form-label">Phone Number *</label>
                    <input type="text" id="contact-phone" name="phone" class="form-control" placeholder="Enter phone number" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label for="contact-email" class="form-label">Email Address</label>
                    <input type="email" id="contact-email" name="email" class="form-control" placeholder="Enter email address" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="contact-website" class="form-label">Website</label>
                    <input type="text" id="contact-website" name="website" class="form-control" placeholder="Enter website URL (optional)" value="{{ old('website') }}">
                </div>

                <div class="form-group">
                    <label for="contact-address" class="form-label">Address</label>
                    <input type="text" id="contact-address" name="address" class="form-control" placeholder="Enter full address" value="{{ old('address') }}">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelModal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Contact
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Contact Modal -->
    <div class="modal-overlay" id="editContactModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Contact
                </h3>
                <button class="close-modal" id="closeEditModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="editContactForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-contact-id">

                <div class="form-group">
                    <label for="edit-contact-name" class="form-label">Full Name *</label>
                    <input type="text" id="edit-contact-name" name="name" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="form-group">
                    <label for="edit-contact-phone" class="form-label">Phone Number *</label>
                    <input type="text" id="edit-contact-phone" name="phone" class="form-control" placeholder="Enter phone number" required>
                </div>

                <div class="form-group">
                    <label for="edit-contact-email" class="form-label">Email Address</label>
                    <input type="email" id="edit-contact-email" name="email" class="form-control" placeholder="Enter email address">
                </div>

                <div class="form-group">
                    <label for="edit-contact-website" class="form-label">Website</label>
                    <input type="text" id="edit-contact-website" name="website" class="form-control" placeholder="Enter website URL">
                </div>

                <div class="form-group">
                    <label for="edit-contact-address" class="form-label">Address</label>
                    <input type="text" id="edit-contact-address" name="address" class="form-control" placeholder="Enter full address">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelEditModal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Contact
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addContactBtn = document.getElementById("addContactBtn");
            const modalOverlay = document.getElementById("addContactModal");
            const closeModal = document.getElementById("closeModal");
            const cancelModal = document.getElementById("cancelModal");
            const contactForm = document.getElementById("contactForm");
            const contactItems = document.querySelectorAll(".contact-item");
            const emptyDetails = document.getElementById("emptyDetails");
            const contactCard = document.getElementById("contactCard");
            const searchInput = document.querySelector(".search-input");
            const contactsList = document.getElementById("contactsList");
            const closeCardBtn = document.getElementById("closeCardBtn");

            // Modal functionality
            addContactBtn.addEventListener("click", function() {
                modalOverlay.classList.add("show");
            });

            closeModal.addEventListener("click", function() {
                modalOverlay.classList.remove("show");
            });

            cancelModal.addEventListener("click", function() {
                modalOverlay.classList.remove("show");
            });

            // Close modal when clicking outside
            modalOverlay.addEventListener("click", function(event) {
                if (event.target === modalOverlay) {
                    modalOverlay.classList.remove("show");
                }
            });

            // Contact selection functionality
            contactItems.forEach(item => {
                item.addEventListener("click", function() {
                    // Remove active class from all items
                    contactItems.forEach(i => i.classList.remove("active"));

                    // Add active class to clicked item
                    this.classList.add("active");

                    const contactId = this.dataset.id;
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const email = this.dataset.email || "Not provided";
                    const website = this.dataset.website || "Not provided";
                    const address = this.dataset.address || "Not provided";

                    // Store contact ID in card
                    contactCard.dataset.contactId = contactId;

                    // Update contact card
                    document.getElementById("detailAvatar").textContent = name.charAt(0);
                    document.getElementById("detailName").textContent = name;
                    document.getElementById("detailPhone").textContent = phone;
                    document.getElementById("detailEmail").textContent = email;

                    const websiteElement = document.getElementById("detailWebsite");
                    if (website !== "Not provided") {
                        websiteElement.innerHTML = `<a href="${website.startsWith('http') ? website : 'https://' + website}" target="_blank">${website}</a>`;
                    } else {
                        websiteElement.textContent = website;
                    }

                    document.getElementById("detailAddress").textContent = address;

                    // Show contact card and hide empty state
                    emptyDetails.style.display = "none";
                    contactCard.style.display = "block";
                });
            });

            // Search functionality
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase();
                const items = contactsList.querySelectorAll(".contact-item");

                items.forEach(item => {
                    const name = item.dataset.name.toLowerCase();
                    const phone = item.dataset.phone.toLowerCase();

                    if (name.includes(searchTerm) || phone.includes(searchTerm)) {
                        item.style.display = "flex";
                    } else {
                        item.style.display = "none";
                    }
                });
            });

            // Form submission with validation
            contactForm.addEventListener("submit", function(event) {
                const name = document.getElementById("contact-name").value;
                const phone = document.getElementById("contact-phone").value;

                console.log('Form submitting with:', { name, phone });

                if (!name || !phone) {
                    event.preventDefault();
                    alert("Name and Phone Number are required.");
                    return;
                }

                // Show loading state
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;

                console.log('Form is being submitted...');
                // Form will submit normally
            });

            // Edit contact functionality
            const editContactBtn = document.getElementById("editContactBtn");
            const editContactModal = document.getElementById("editContactModal");
            const closeEditModal = document.getElementById("closeEditModal");
            const cancelEditModal = document.getElementById("cancelEditModal");
            const editContactForm = document.getElementById("editContactForm");

            closeCardBtn.addEventListener("click", function() {
                contactCard.style.display = "none";
                emptyDetails.style.display = "block";
                contactCard.dataset.contactId = "";
                document.querySelectorAll('.contact-item.active').forEach(i => i.classList.remove('active'));
            });

            editContactBtn.addEventListener("click", function() {
                const contactId = contactCard.dataset.contactId;
                const activeContact = document.querySelector(".contact-item.active");

                if (activeContact) {
                    document.getElementById("edit-contact-id").value = contactId;
                    document.getElementById("edit-contact-name").value = activeContact.dataset.name;
                    document.getElementById("edit-contact-phone").value = activeContact.dataset.phone;
                    document.getElementById("edit-contact-email").value = activeContact.dataset.email || '';
                    document.getElementById("edit-contact-website").value = activeContact.dataset.website || '';
                    document.getElementById("edit-contact-address").value = activeContact.dataset.address || '';

                    editContactModal.classList.add("show");
                }
            });

            closeEditModal.addEventListener("click", function() {
                editContactModal.classList.remove("show");
            });

            cancelEditModal.addEventListener("click", function() {
                editContactModal.classList.remove("show");
            });

            editContactModal.addEventListener("click", function(event) {
                if (event.target === editContactModal) {
                    editContactModal.classList.remove("show");
                }
            });

            // Edit form submission
            editContactForm.addEventListener("submit", function(event) {
                event.preventDefault();

                const contactId = document.getElementById("edit-contact-id").value;
                const formData = new FormData(this);

                const submitBtn = editContactForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                submitBtn.disabled = true;

                fetch(`/contacts/${contactId}`, {
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
                    alert('Error updating contact.');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });

            // Delete contact functionality
            const deleteContactBtn = document.getElementById("deleteContactBtn");

            deleteContactBtn.addEventListener("click", function() {
                const contactId = contactCard.dataset.contactId;

                if (confirm("Are you sure you want to delete this contact?")) {
                    fetch(`/contacts/${contactId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert('Error deleting contact.');
                    });
                }
            });
        });
    </script>
</body>
</html>
