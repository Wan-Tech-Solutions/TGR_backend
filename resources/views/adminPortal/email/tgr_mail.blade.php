@include('adminPortal.email.layout.app')

<style>

    .top-bar {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }

    .top-bar input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 25px;
        outline: none;
        background: #fff;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .top-bar input:focus {
        border-color: #007bff;
        box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.3);
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        color: #888;
        font-size: 18px;
        pointer-events: none;
    }

    .email-list {
        display: flex;
        gap: 20px;
    }

    .emails {
        flex: 1;
        max-width: 40%;
        overflow-y: auto;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .emails h2 {
        font-size: 18px;
        color: #333;
        text-align: center;
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    .email-item {
        padding: 12px;
        background: #f9f9f9;
        margin-bottom: 8px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .email-item:hover {
        background: #e3e3e3;
        transform: scale(1.02);
    }

    .reading-pane {
        flex: 2;
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        min-height: 250px;
    }

    .reading-pane h2 {
        font-size: 20px;
        color: #444;
        text-align: center;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    #email-details {
        font-size: 16px;
        color: #333;
    }

    #email-details h3 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    #email-details h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #555;
    }

    #email-details h5 {
        font-size: 14px;
        color: #777;
        margin-bottom: 10px;
    }

    #email-details p {
        font-size: 15px;
        background: #f8f8f8;
        padding: 12px;
        border-radius: 6px;
        line-height: 1.5;
        overflow-wrap: break-word;
    }
</style>

<div class="main-content">
    <div class="top-bar">
        <input type="text" id="search-box" placeholder="Filter Mail" onkeyup="filterEmails()" />
        <span class="search-icon">&#128269;</span>
    </div>

    <div class="email-list">
        <div class="emails">
            <h2>Inbox</h2>
            @foreach($messages as $message)
                <div class="email-item"
                     data-email="{{ strtolower($message->getFrom()[0]->mail) }}"
                     onclick="showEmailDetails(this)"
                     data-message='{"from": "{{ $message->getFrom()[0]->mail }}", "subject": "{{ addslashes($message->getSubject()) }}", "date": "{{ \Carbon\Carbon::parse($message->getDate())->format('d M Y, H:i') }}", "body": "{{ addslashes($message->getTextBody()) }}"}'>
                    <strong>{{ $message->getFrom()[0]->mail }}</strong>
                </div>
            @endforeach
        </div>

        <div class="reading-pane">
            <h2>Email</h2>
            <div id="email-details">
                <p style="text-align: center; color: #999;">Select an email to view its details</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showEmailDetails(element) {
        let emailData = JSON.parse(element.getAttribute('data-message'));
        let detailsPane = document.getElementById('email-details');
        detailsPane.innerHTML = `
            <h3>From: ${emailData.from}</h3>
            <h4>Subject: ${emailData.subject}</h4>
            <h5>Date: ${emailData.date}</h5>
            <p>${emailData.body}</p>
        `;
    }

    function filterEmails() {
        let input = document.getElementById('search-box').value.toLowerCase();
        let emails = document.querySelectorAll('.email-item');

        emails.forEach(email => {
            let emailText = email.getAttribute('data-email');
            if (emailText.includes(input)) {
                email.style.display = 'block';
            } else {
                email.style.display = 'none';
            }
        });
    }
</script>
