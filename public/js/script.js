/**
 * On peut faire une petite requête AJAX en Symfony
 */
$('#ajax-properties').click(function() {
    //$.get équivaut à this.http.get en Angular mais en jQuery
    $.get('/property.json').then(function(properties) {
        console.log(properties);
    })
});