// import 'bootstrap';
import 'bootstrap-sass';
import './add-collection-widget';

import './navbar.js';
require('../images');

$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#dogTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
