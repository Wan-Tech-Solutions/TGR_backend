<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phonebook</title>
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
        .modal {
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
            width: 300px;
        }
        .modal.show {
            display: block;
        }
        .modal input, .modal button {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="header">TGR Phonebook</div>
    <div class="phonebook-container">
        <div class="contacts-list">
            <a href="{{ route('admin.home.dashboard') }}"><button class="back-button">&#8592; Go Home</button></a>
            <img src="logo.png" height="100px" alt="TGR logo"/><br>
            <br><button class="add-contact-btn" style="background-color: red; color:white; height:50px; width:100px;">Add +</button>
            <br>
            <h2>Contacts</h2>
            <div id="contacts-list">
                @foreach($contacts as $contact)
                    <div class="contact-item"
                        data-name="{{ $contact->name }}"
                        data-phone="{{ $contact->phone }}"
                        data-email="{{ $contact->email }}"
                        data-website="{{ $contact->website }}"
                        data-address="{{ $contact->address }}">
                        {{ $contact->name }}
                    </div>
                @endforeach
            </div>
            
        </div>
        <div class="contact-details">
            <h2>Contact Details</h2>
            <div class="contact-info">Select a contact to view details</div>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal" id="addContactModal">
        <h3>Add Contact</h3>
        <form method="POST" action="{{url('/add-contacts')}}">
            @csrf
        <input type="text" id="contact-name" name="name" placeholder="Name" required>
        <input type="text" id="contact-phone" name="phone" placeholder="Phone Number" required>
        <input type="email" id="contact-email" name="email" placeholder="Email">
        <input type="text" id="contact-website" name="website" placeholder="Website (Optional)">
        <input type="text" id="contact-address" name="address" placeholder="Address">
        <button class="close-modal">Close</button>
        <button class="save-contact" type="submit">Save Contact</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addContactBtn = document.querySelector(".add-contact-btn");
            const modal = document.querySelector("#addContactModal");
            const closeModal = document.querySelector(".close-modal");
            const saveContactBtn = document.querySelector(".save-contact");

            addContactBtn.addEventListener("click", function() {
                modal.classList.add("show");
            });

            closeModal.addEventListener("click", function() {
                modal.classList.remove("show");
            });

            saveContactBtn.addEventListener("click", function() {
                const name = document.querySelector("#contact-name").value;
                const phone = document.querySelector("#contact-phone").value;
                const email = document.querySelector("#contact-email").value;
                const website = document.querySelector("#contact-website").value;
                const address = document.querySelector("#contact-address").value;

                if (!name || !phone) {
                    alert("Name and Phone Number are required.");
                    return;
                }

                fetch("/contacts", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({ name, phone, email, website, address })
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const contactItems = document.querySelectorAll(".contact-item");
        const contactDetails = document.querySelector(".contact-info");

        contactItems.forEach(item => {
            item.addEventListener("click", function() {
                const name = this.dataset.name;
                const phone = this.dataset.phone;
                const email = this.dataset.email || "N/A";
                const website = this.dataset.website || "N/A";
                const address = this.dataset.address || "N/A";

                contactDetails.innerHTML = `
                    <strong>Name:</strong> ${name} <br>
                    <strong>Phone:</strong> ${phone} <br>
                    <strong>Email:</strong> ${email} <br>
                    <strong>Website:</strong> ${website} <br>
                    <strong>Address:</strong> ${address}
                `;
            });
        });
    });
</script>

</body>
</html>
