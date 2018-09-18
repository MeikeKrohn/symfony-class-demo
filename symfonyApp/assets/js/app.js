/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

import axios from 'axios';

function deleteButtonClicked(event)
{
    console.log(event);
    const itemId = event.target.getAttribute('data-id');

    //send the HTTP request
    axios.delete('/todoList/deleteItem/' + itemId)
        .then(response => location.reload());
}

function isDoneButtonClicked(event)
{
    console.log(event);
    const itemId = event.target.getAttribute('data-id');

    //send the HTTP Request
    axios.post('/todoList/doneItem/' + itemId)
        .then(response => location.reload());
}

let deleteButtons = document.querySelectorAll('.deleteButton');
//arrow function is short form for:     deleteButtons.forEach (function(button)) {...}
deleteButtons.forEach(button => button.addEventListener('click', deleteButtonClicked));

let isDoneButtons = document.querySelectorAll('.isDoneButton');
isDoneButtons.forEach(button => button.addEventListener('click', isDoneButtonClicked));