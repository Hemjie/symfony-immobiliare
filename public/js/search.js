/**
 * On va implémenter une recherche en JS avec le rechargement dynamique des ressources sur la page list
 *
 * - Écouter un événement en JS sur la barre de recherche dès qu'on saisit au clavier
 * - A chaque fois qu'on saisit quelque chose, on doit faire un appel AJAX à Symfony
 * - L'appel AJAX va se faire sur une nvl route (on peut dire endpoint) '/api/search/toto' sur laquelle on devra récupérer la valeur saisie
 * - Cette route devra renvoyer la liste des annonces (en JSON) qui correspondent à la recherche
 * - Quand on aura le JSON, en JS, on devra mettra à jour le DOM, càd la liste des annonces
 */

$('#search').keyup(function() {
   let value = $(this).val(); // Valeur saisie

   // console.log(value);

   // On doit faire un appel AJAX sur une route de Symfony
   // On va récupérer un résultat en JSON de Symfony
   $.ajax('/api/search/'+value, {type: 'GET' }).then(function (response) { // ajax(url, {options})
      console.log(response);
   }) ;
});