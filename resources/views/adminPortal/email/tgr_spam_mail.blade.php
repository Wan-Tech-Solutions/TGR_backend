@include('adminPortal.email.layout.app')

<div class="main-content">
    <div class="top-bar">
        <input type="text" placeholder="Filter Mail"/>
    </div>
    <div class="email-list">
        <div class="emails">
            <center><h2>Inbox</h2></center>
            @foreach($messages as $message)
                <div class="email-item" onclick="showEmailDetails(this)"
                     data-message='{"from": "{{ $message->getFrom()[0]->mail }}", "subject": "{{ addslashes($message->getSubject()) }}", "date": "{{ \Carbon\Carbon::parse($message->getDate())->format('d M Y, H:i') }}", "body": "{{ addslashes($message->getTextBody()) }}"}'>
                    <strong>{{ $message->getFrom()[0]->mail }}</strong>
                </div>
            @endforeach
        </div>
        <div class="reading-pane">
            <h2>Email</h2>
            <div id="email-details">
                <!-- Email details will be loaded here -->
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
</script>
