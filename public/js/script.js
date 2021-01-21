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

   // On va afficher un aperçu de l'image avant l'upload
    let reader = new FileReader();
    // On doit écouter un événement pour faire qqch avec cette image
    reader.addEventListener('load', function (file) {
        // Cleaner les anciennes images
        $('.custom-file img').remove();
        let base64 = file.target.result; //image en base 64
        //Je crée une balise img en JS
        let img = $('<img class="img-fluid mt-5" width="250" />');
        // Je mets le base 64 dans le src de l'image
        img.attr('src', base64);
        // Afficher l'image dans la div .custom-file
        $('.custom-file').prepend(img);
    })
    reader.readAsDataURL(this.files[0]);
});



