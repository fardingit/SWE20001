'use strict';

function validate() {
    var firstName = document.getElementById("first_name").value;
    var lastName = document.getElementById("last_name").value;
    var contact = document.getElementById("number").value;
    var email = document.getElementById("email").value;
    var address = document.getElementById("street").value;

    var errorMessages = []; // Array to store error messages

    // FirstName validation
    if (!firstName) {
        errorMessages.push("Enter the first name!");
    } else if (!firstName.match(/^[A-Za-z]{2,20}$/)) {
        errorMessages.push("Name should contain 2-20 alphabetical letters");
    }

    // Last name validation
    if (!lastName) {
        errorMessages.push("Enter the last name!");
    } else if (!lastName.match(/^[A-Za-z]{2,20}$/)) {
        errorMessages.push("Name should contain 2-20 alphabetical letters");
    }

    // Contact validation
    if (!contact) {
        errorMessages.push("Enter contact!");
    } else if (!contact.match(/^\(04\d{2}\)\s\d{3}\s\d{3}$/)) {
        errorMessages.push("Format: (04xx) xxx xxx");
    }

    // Email validation
    if (!email) {
        errorMessages.push("Enter your email!");
    } else if (!email.match(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/)) {
        errorMessages.push("Enter a valid email");
    }

    // Address validation
    if (!address) {
        errorMessages.push("Enter your address!");
    } else if (!address.match(/^[A-Za-z0-9\s\-,']{5,40}$/)) {
        errorMessages.push("The address needs to be between 5 to 40 characters.");
    }

    if (errorMessages.length > 0) {
        // Display error messages on the screen
        var errorList = document.getElementById("errorMessages");
        errorList.innerHTML = "<ul>";
        errorMessages.forEach(function (message) {
            errorList.innerHTML += "<li>" + message + "</li>";
        });
        errorList.innerHTML += "</ul>";
        return false;
    }

    // No errors, return true to allow form submission
    return true;
}

function storage(firstName, lastName, contact, email, address) {
    sessionStorage.firstName = firstName;
    sessionStorage.lastName = lastName;
    sessionStorage.contact = contact;
    sessionStorage.email = email;
    sessionStorage.address = address;
}

function prefill() {
    if (sessionStorage.firstName) {
        document.getElementById("first_name").value = sessionStorage.firstName;
        document.getElementById("last_name").value = sessionStorage.lastName;
        document.getElementById("number").value = sessionStorage.contact;
        document.getElementById("email").value = sessionStorage.email;
        document.getElementById("street").value = sessionStorage.address;
    }
}

function init() {
    document.addEventListener("submit", function (event) {
        if (event.target && event.target.id === "addMemberForm") {
            var errorList = document.getElementById("errorMessages");
            errorList.innerHTML = ""; // Clear any previous error messages
            if (!validate()) {
                event.preventDefault();
            } else {
                prefill();
            }
        }
    });

}

window.onload = init;
