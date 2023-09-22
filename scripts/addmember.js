document.getElementById('addMemberForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let firstName = document.getElementById('firstName').value;
    let lastName = document.getElementById('lastName').value;
    let contact = document.getElementById('contact').value;
    let email = document.getElementById('email').value;
    let address = document.getElementById('address').value;

    // Validate the inputs if necessary

    // Send a request to a server-side script to save the member's details
    fetch('saveMember.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `firstName=${firstName}&lastName=${lastName}&contact=${contact}&email=${email}&address=${address}`,
    }).then(response => response.text()).then(data => {
        console.log(data);
    }).catch((error) => {
        console.error('Error:', error);
    });
});
