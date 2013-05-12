function showErrorDialogWithMessage(message) {
    $('.payment-alert').show().html(message);
    // Re-enable the submit button so the user can try again
    $('.submit-button').removeAttr("disabled");
}
function stripeResponseHandler(status, response) {
    if (response.error) {
      $('.payment-alert').show().html(response.error.message);
    } else {  
      // Stripe.js generated a token successfully. We're ready to charge the card!
      var token = response.id;
      var cardNumber = $("#card-number").val();
      var cardCVC = $("#card-security-code").val();
      var expirationMonth = $("#expiration-month").val();
      var expirationYear = $("#expiration-year").val();
      var price = $("#charge-amount").val();
      
      var request = $.ajax ({
         type: "POST",
         url: "pay.php",
         dataType: "json",
         data: {
            "stripeToken" : token,
            "cardNumber" : cardNumber,
            "cardCVC" : cardCVC,
            "expirationMonth" : expirationMonth,
            "expirationYear" : expirationYear,
            "price" : price
            }
      });
     
      request.done(function(msg) {
         if (msg.result === 0)
         {
            // show success message, hide error message container
            $('.payment-success').show();
            $('.payment-error').hide();
            $('.payment-alert').hide();
         }
         else
         {
            //This means there's an issue with users card.
            // show error message and hide previous success message container if needed
            $('.payment-success').hide();
            $('.payment-alert').hide();
            $('.payment-error').show();
         }
      });
     
      request.fail(function(jqXHR, textStatus) {
         // We failed to make the AJAX call to pay.php. Something's wrong on our end.
         // This should not normally happen, but we need to handle it if it does.
         $('.ajax-fail').show();
      });
    }
}
$(document).ready(function() {
    $('#payment-form').submit(function(event) {
        // immediately disable the submit button to prevent double submits
        //$('.submit-button').attr("disabled", "disabled");
        var cardNumber = $("#card-number").val();
        var cardCVC = $("#card-security-code").val();
        var expirationMonth = $("#expiration-month").val();
        var expirationYear = $("#expiration-year").val();
        var price = $("#charge-amount").val();
        
         
        // Stripe will validate the card number and CVC for us, so just make sure they're not blank
        if (cardNumber === "") {
            showErrorDialogWithMessage("Please enter your card number.");
            return;
        }
        if (cardCVC === "") {
            showErrorDialogWithMessage("Please enter your card security code.");
            return;
        }
        
        // Boom! We passed the basic validation, so request a token from Stripe:
        Stripe.createToken({
            number: cardNumber,
            cvc: cardCVC,
            exp_month: $('#expiration-month').val(),
            exp_year: $('#expiration-year').val()
        }, stripeResponseHandler);

        // Prevent the default submit action on the form
        return false;
    });
});