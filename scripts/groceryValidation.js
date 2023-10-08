'use strict';

function validate(){

const name_input = document.getElementById("name_input").value;
const price_input = document.getElementById("price_input").value;
const stock_input = document.getElementById("stock_input").value;

const name_feedback = document.getElementById("name_feedback");
const price_feedback = document.getElementById("price_feedback");
const stock_feedback = document.getElementById("stock_feedback");

let validations = false;
var result = true;

    /*-------- grocery validation--------*/
if(validations === true) {
    //Name validation
    if(name_input == null) {
        name_feedback.innerHTML = "Enter the product name!";
        result = false;
    }

    if (!name_input.match(/^[A-Za-z]{2,20}$/)) {
        name_feedback.innerHTML = "Name should conatin 2-20 alphabetical letters";
        result = false;
    }
    else {
        name_feedback.innerHTML = "";
    }

    //Price validation
    if(price_input == ""){
        price_feedback.innerHTML = "Enter product price!";
        result = false;
    }
    else if(!price_input.match(/^[0-9]{1,4}/)) {
        price_feedback.innerHTML = "Price should be 1-4 numbers";
        result = false;
    }
    else {
        price_feedback.innerHTML = "";
    }

    //Stock validation
    if(stock_input == ""){
        stock_feedback.innerHTML = "Enter stock amount!";
        result = false;
    }
    else if(!stock_input.match(/^[0-9]{1,5}/)) {
        stock_feedback.innerHTML = "Stock should conatin 1-5 numbers";
        result = false;
    }
    else {
        stock_feedback.innerHTML = "";
    }

}

else { 
    if (result) {
        storage(name_input, price_input, stock_input);
    }
    return result;
}
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
    var grocery_form = document.getElementById("grocery_form");
    grocery_form.addEventListener("submit", function(submitting) {
        if(!validate()) {
            submitting.preventDefault();  
        } else {
            prefill();
        }
    });
}

window.onload = init;