<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGR Phonebook | Contact Management</title>
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

        .phonebook-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .contacts-sidebar {
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

        .search-section {
            position: relative;
            margin: 10px 0;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: var(--light-bg);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
        }

        .add-contact-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
            margin: 10px 0;
        }

        .add-contact-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .contacts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .contacts-header h2 {
            color: var(--dark-text);
            font-size: 18px;
            font-weight: 700;
        }

        .contacts-count {
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .contacts-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
            overflow-y: auto;
        }

        .contact-item {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            background: #f8fbff;
        }

        .contact-item.active {
            background: var(--primary-light);
            color: white;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
            color: var(--dark-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-phone {
            font-size: 14px;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .contact-details-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            overflow: hidden;
        }

        .details-header {
            padding: 25px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .details-header h2 {
            color: var(--dark-text);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .details-subtitle {
            color: var(--light-text);
            font-size: 14px;
        }

        .details-content {
            flex: 1;
            padding: 30px;
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
            color: var(--light-text);
            max-width: 400px;
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

        .contact-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            text-align: left;
        }

        .contact-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .contact-card-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 28px;
            flex-shrink: 0;
        }

        .contact-card-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 5px;
        }

        .contact-card-role {
            color: var(--light-text);
            font-size: 16px;
        }

        .contact-details-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 12px;
            color: var(--light-text);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 16px;
            color: var(--dark-text);
            font-weight: 500;
        }

        .detail-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .detail-value a:hover {
            text-decoration: underline;
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
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
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
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
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

        .btn-secondary {
            background: var(--light-bg);
            color: var(--dark-text);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .phonebook-container {
                flex-direction: column;
            }
            
            .contacts-sidebar {
                width: 100%;
                max-height: 40vh;
            }
            
            .contact-card {
                padding: 20px;
            }
            
            .contact-card-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .modal {
                padding: 20px;
            }
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
                        <div style="display: flex; gap: 10px;">
                            <button class="btn" id="editContactBtn" style="padding: 10px 15px; background: var(--primary-color); color: white;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn" id="deleteContactBtn" style="padding: 10px 15px; background: var(--danger-color); color: white;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
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
                    <input type="text" id="contact-name" name="name" class="form-control" placeholder="Enter full name" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-phone" class="form-label">Phone Number *</label>
                    <input type="text" id="contact-phone" name="phone" class="form-control" placeholder="Enter phone number" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-email" class="form-label">Email Address</label>
                    <input type="email" id="contact-email" name="email" class="form-control" placeholder="Enter email address">
                </div>
                
                <div class="form-group">
                    <label for="contact-website" class="form-label">Website</label>
                    <input type="text" id="contact-website" name="website" class="form-control" placeholder="Enter website URL">
                </div>
                
                <div class="form-group">
                    <label for="contact-address" class="form-label">Address</label>
                    <input type="text" id="contact-address" name="address" class="form-control" placeholder="Enter full address">
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
                event.preventDefault();
                
                const name = document.getElementById("contact-name").value;
                const phone = document.getElementById("contact-phone").value;
                
                if (!name || !phone) {
                    alert("Name and Phone Number are required.");
                    return;
                }
                
                // Show loading state
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;
                
                // Submit form
                this.submit();
            });

            // Edit contact functionality
            const editContactBtn = document.getElementById("editContactBtn");
            const editContactModal = document.getElementById("editContactModal");
            const closeEditModal = document.getElementById("closeEditModal");
            const cancelEditModal = document.getElementById("cancelEditModal");
            const editContactForm = document.getElementById("editContactForm");

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