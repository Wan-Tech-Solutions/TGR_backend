@include('adminPortal.email.layout.app')
    <div class="main-content">
        <div class="top-bar">
            <input type="text" placeholder="Filter Mail"/>
        </div>
        <div class="email-list">
            <div class="emails">
                <center><h2>Sent</h2></center>
                @foreach($sent_emails as $sent_email)
                    <div class="email-item" data-id="{{ $sent_email->id }}" onclick="showEmailDetails(this)">
                        {{ $sent_email->recipient_email }}
                    </div>
                @endforeach
            </div>
            
            <!-- Reading Pane (Initially Empty) -->
            <div class="reading-pane" id="emailDetails">
                <h2>Select an email to read</h2>
            </div>
            
        </div>
    </div>
    <div class="modal" id="composeModal">
        <div class="modal-content">
            <h3>Compose</h3>
            <form id="emailForm" enctype="multipart/form-data">
                @csrf
                <input type="text" id="subject" name="subject" placeholder="Enter Subject" required>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
                <textarea id="message" name="message" placeholder="Compose Message" required></textarea>
                <input type="file" id="attachment" name="attachment">
                <button class="send" type="submit" style="background-color:green;color:white;height:50px;width:100px;border-radius:10%">Send</button>
                <button class="cancel" onclick="closeModal()" style="background-color:red;color:white;height:50px;width:100px;border-radius:10%">Cancel</button>
            </form>
            
            <script>
                document.getElementById('emailForm').addEventListener('submit', function(e) {
                    e.preventDefault();
            
                    let formData = new FormData(this);
            
                    fetch("{{ route('send.mail') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => alert(data.message))
                    .catch(error => console.error('Error:', error));
                });
            </script>
            
        </div>
    </div>
    <script>
        function showModal() {
            document.getElementById("composeModal").style.display = "flex";
        }
        function closeModal() {
            document.getElementById("composeModal").style.display = "none";
        }
        function sendMail() {
            alert("Mail Sent!");
            closeModal();
        }
    </script>

<script>
    function showEmailDetails(element) {
        let emailId = element.getAttribute('data-id');

        fetch(`/email-details/${emailId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("emailDetails").innerHTML = `
                        <h2>${data.email.subject}</h2>
                        <p><strong>To:</strong> ${data.email.recipient_email}</p>
                        <p>${data.email.message}</p>
                        ${data.email.attachment ? `<p><a href="/storage/${data.email.attachment}" target="_blank">Download Attachment</a></p>` : ''}
                        <p><em>Sent on: ${data.email.created_at}</em></p>
                    `;
                } else {
                    alert("Email details not found.");
                }
            })
            .catch(error => console.error('Error fetching email:', error));
    }
</script>

</body>
</html>
