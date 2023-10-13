'use strict';

function validate(){

const item_name = document.getElementById("item_name").value;
const date_input = document.getElementById("date").value;
const amount_input = document.getElementById("amount_input").value;

const item_name_feedback = document.getElementById("item_name_feedback");
const date_input_feedback = document.getElementById("date_input_feedback");
const amount_feedback = document.getElementById("amount_feedback");

let validations = false;
var result = true;

    /*-------- Sales validation--------*/
if(validations === true) {
    //Item validation
    if(item_name == "") {
        item_name_feedback.innerHTML = "Enter the item name!";
        result = false;
    }

    if (!item_name.match(/^[a-zA-z]{0,20}$/)) {
        item_name_feedback.innerHTML = "Name should conatin 2-20 alphabetical letters";
        result = false;
    }
    else {
        item_name_feedback.innerHTML = "";
    }

    //Date validation
    if(date_input == ""){
        date_input_feedback.innerHTML = "Enter Date!";
        result = false;
    }
    else if(!date_input.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/)) {
        date_input_feedback.innerHTML = "Date needs to be following format: dd/mm/yyyy!";
        result = false;
    }
    else {
        date_input_feedback.innerHTML = "";
    }

    //Amount validation
    if(amount_input == ""){
        amount_feedback.innerHTML = "Enter sales amount!";
        result = false;
    }
    else if(!amount_input.match(/^[0-9]{1,4}$/)) {
        amount_feedback.innerHTML = "Sales amount should conatin 1-4 numbers";
        result = false;
    }
    else {
        amount_feedback.innerHTML = "";
    }

}

else { 
    if (result) {
        storage(item_name, date_input, amount_input);
    }
    return result;
}
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
    var sales_form = document.getElementById("sales_form");
    sales_form.addEventListener("submit", function(submitting) {
        if(!validate()) {
            submitting.preventDefault();  
        } else {
            prefill();
        }
    });
}

window.onload = init;