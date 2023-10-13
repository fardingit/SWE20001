'use strict';

function validate() {
    var name = document.getElementById("name_input").value;
    var price = document.getElementById("price_input").value;
    var stock = document.getElementById("stock_input").value;

    var errorMessages = [];

    // Name validation
    if (!name) {
        errorMessages.push("Enter the item name!");
    } else if (name.length < 2 || name.length > 50) {
        errorMessages.push("Item name should be between 2 and 50 characters.");
    }

    // Price validation
    if (price === "" || isNaN(parseFloat(price))) {
        errorMessages.push("Enter a valid price.");
    }

    // Stock validation
    if (stock === "" || isNaN(parseInt(stock))) {
        errorMessages.push("Enter a valid stock quantity.");
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

function storage(name_input, price_input, stock_input){

    sessionStorage.name_input = name_input;
    sessionStorage.price_input = price_input;
    sessionStorage.stock_input = stock_input;
}

function prefill(){
    if(sessionStorage.name_input != undefined){
    
    document.getElementById("name_input").value = sessionStorage.name_input;
    document.getElementById("price_input").value = sessionStorage.price_input;
    document.getElementById("stock_input").value = sessionStorage.stock_input;
    }
}

function init(){
    document.addEventListener("submit", function (event) {
        if (event.target && event.target.id === "grocery_form") {
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