'use strict';

function validate() {
    var itemName = document.getElementById("item_name").value;
    var date = document.getElementById("date").value;
    var amount = document.getElementById("amount_input").value;

    var errorMessages = [];

    // Item Name validation
    if (!itemName) {
        errorMessages.push("Enter the item name!");
    } else if (itemName.length < 2 || itemName.length > 50) {
        errorMessages.push("Item name should be between 2 and 50 characters.");
    }

    // Date validation
    if (!date) {
        errorMessages.push("Enter a valid date!");
    }

    // Amount validation
    if (amount === "" || isNaN(parseFloat(amount))) {
        errorMessages.push("Enter a valid amount.");
    }

    var errorList = document.getElementById("errorMessages");
    errorList.innerHTML = ""; // Clear any previous error messages

    if (errorMessages.length > 0) {
        errorList.innerHTML = "<ul>";
        errorMessages.forEach(function (message) {
            errorList.innerHTML += "<li>" + message + "</li>";
        });
        errorList.innerHTML += "</ul>";
        return false;
    }
    return true;
}

function storage(item_name, date_input, amount_input){

    sessionStorage.item_name = item_name;
    sessionStorage.date_input = date_input;
    sessionStorage.amount_input = amount_input;
}

function prefill(){
    if(sessionStorage.item_name != undefined){
    
    document.getElementById("item_name").value = sessionStorage.item_name;
    document.getElementById("date").value = sessionStorage.date_input;
    document.getElementById("amount_input").value = sessionStorage.amount_input;
    }
}

function init(){
    document.addEventListener("submit", function (event) {
        if (event.target && event.target.id === "sales_form") {
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