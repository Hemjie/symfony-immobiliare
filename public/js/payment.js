//On initialise Stripe
var stripe = Stripe('pk_test_51IDu9rA4Zgbsrd0k1O6D9BgvQg1zsgIoUGKiFDfOvVaijdLwtYUAWi7iGjcHDWyVBTJnoL3xyPoTGQIJAXzCZbLM00ifWoTyvG');

//On initialise le formulaire de CB
var elements = stripe.elements();
var card = elements.create('card', {
    style: {
        base: {
            lineHeight: 1.75,
        }
    }
});
card.mount('#stripe-card');

card.on('change', function(event) {
    //Si CB n'est pas remplie, on désactive le bouton
   $('#stripe-pay').attr('disabled', event.empty);
   // Affiche les erreurs s'il y en a
   $('#card-error').text(event.error ? event.error.message : '');
});

//On fait le paiement
$('#stripe-pay').click(function () {
    var clientSecret = $(this).data('client-secret');
    stripe.confirmCardPayment(clientSecret, {
        payment_method: { card: card }
    }).then(function (result) {
        if (result.error) {
            $('#card-error').text(result.error.message);
        } else {
            //Afficher un msg de succès quand le paiement a eu lieu
            // alert('Votre paiement a bien été effectué');
            //Redirection en JS
            window.location = '/cart/success/' + result.paymentIntent.id;
        }
    });
});