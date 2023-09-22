document.getElementById('addMemberForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Create FormData object to hold form data
    const formData = new FormData(this);
    
    // Create XMLHttpRequest object to send the form data to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'addMemberAction.php', true);
    
    // When the request is complete, log the response to the console
    xhr.onload = function() {
        if (this.status === 200) {
            console.log(this.responseText);
        }
    }
    
    // Send the FormData object to the server
    xhr.send(formData);
});
