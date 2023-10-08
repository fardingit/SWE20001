'use strict';

function validate(){

const firstName = document.getElementById("firstName").value;
const lastName = document.getElementById("lastName").value;
const contact = document.getElementById("contact").value;
const email = document.getElementById("email").value;
const address = document.getElementById("address").value;

const firstName_feedback = document.getElementById("firstName_feedback");
const lastName_feedback = document.getElementById("lastName_feedback");
const contact_feedback = document.getElementById("contact_feedback");
const email_feedback = document.getElementById("email_feedback");
const address_feedback = document.getElementById("address_feedback");


let validations = false;
var result = true;

    /*-------- grocery validation--------*/
if(validations === true) {
    //FirstName validation
    if(firstName == null) {
        firstName_feedback.innerHTML = "Enter the product name!";
        result = false;
    }

    if (!firstName.match(/^[A-Za-z]{2,20}$/)) {
        firstName_feedback.innerHTML = "Name should conatin 2-20 alphabetical letters";
        result = false;
    }
    else {
        firstName_feedback.innerHTML = "";
    }

    //Lastname validation
    if(lastName == ""){
        lastName_feedback.innerHTML = "Enter product price!";
        result = false;
    }
    else if(!lastName.match(/^[A-Za-z]{2,20}$/)) {
        lastName_feedback.innerHTML = "Name should conatin 2-20 alphabetical letters";
        result = false;
    }
    else {
        lastName_feedback.innerHTML = "";
    }

    //Contact validation
    if(contact == ""){
        contact_feedback.innerHTML = "Enter ocntact!";
        result = false;
    }
    else if(!contact.match(/^(?:\04\)?[1-9]\d\d\)?\d{3}\d{3})$/)) {
        contact_feedback.innerHTML = "Format: (04xx) xxx xxx";
        result = false;
    }
    else {
        contact_feedback.innerHTML = "";
    }

    //Email validation
    if(email == ""){
        email_feedback.innerHTML = "Enter your email!";
        result = false;
    }
    else if(!email.match(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/)) {
        email_feedback.innerHTML =  "Enter a valid email\n";
        result = false;
    }
    else {
        email_feedback.innerHTML = "";
    }

    //Address validation
    if(address == "") {
        address_feedback.innerHTML =  "Enter your address! ";
        result = false;
    }
    else if(!address.match(/^[A-Za-z]{5,40}$/)) {
        address_feedback.innerHTML =  "The addess needs to be between 5 to 40 characters. ";
        result = false;
    }
    else {
        address_feedback.innerHTML = "";
    }

}

else { 
    if (result) {
        storage(firstName, lastName, contact, email, address);
    }
    return result;
}
}

function storage(firstName, lastName, contact, email, address){

    sessionStorage.firstName = firstName;
    sessionStorage.lastName = lastName;
    sessionStorage.contact = contact;
    sessionStorage.email = email;
    sessionStorage.address = address;
}

function prefill(){
    if(sessionStorage.firstName != undefined){
    
    document.getElementById("firstName").value = sessionStorage.firstName;
    document.getElementById("lastName").value = sessionStorage.lastName;
    document.getElementById("contact").value = sessionStorage.contact;
    document.getElementById("email").value = sessionStorage.email;
    document.getElementById("address").value = sessionStorage.address;
    }
}

function init(){
    var addMemberForm = document.getElementById("addMemberForm");
    addMemberForm.addEventListener("submit", function(submitting) {
        if(!validate()) {
            submitting.preventDefault();  
        } else {
            prefill();
        }
    });
}

window.onload = init;