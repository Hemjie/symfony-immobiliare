/**
 * On peut faire une petite requête AJAX en Symfony
 */
$('#ajax-properties').click(function() {
    //$.get équivaut à this.http.get en Angular mais en jQuery
    $.get('/property.json').then(function(properties) {
        console.log(properties);
    })
});

// On supprime la div pour éviter les doublons
$('#result').remove();
// Je récupère la valeur du input et l'ajouter directement en dessous de celui-ci
$('#real_estate_surface').after('<div id="result">'+$('#real_estate_surface').val()+' m²</div>');
/*
* On écoute l'événement sur le range
*/

$('#real_estate_surface').on('input', function() { //id, on le voit dans la console HTML
    $('#result').remove();
    $(this).after('<div id="result">'+$(this).val()+' m²</div>');
});

// On va corriger l'affichage du label pour l'upload des images
$('[type="file"]').on('change', function () {
   var label = $(this).val().split('\\').pop(); // C:\\fakepath\5.png devient 5.png
   // On ajoute le label dans l'élément suivant le input
   $(this).next().text(label);
});
