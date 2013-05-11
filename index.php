<?php
$yourName = "Put Your Name Here";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Pay Tyler Longren</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='style.css' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            var publicTestKey = 'ENTER PUBLISHABLE TEST KEY HERE';
            var publicLiveKey = 'ENTER PUBLISHABLE LIVE KEY HERE';
            Stripe.setPublishableKey(publicTestKey);
        </script>
        <script type="text/javascript">
            function showErrorDialogWithMessage(message) {
                $('.payment-alert').show().html(message);
                // Re-enable the submit button so the user can try again
                $('.submit-button').removeAttr("disabled");
            }
            function stripeResponseHandler(status, response) {;
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
                    $('.submit-button').attr("disabled", "disabled");
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
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="ribbon">
              Pay <?=$yourName?>
              <i></i>
              <i></i>
              <i></i>
              <i></i>
            </div>
            <span class="payment-alert" style="display:none;"></span>
            <span class="payment-error" style="display:none;">Something went wrong and your card was not charged.</span>
            <span class="payment-success" style="display:none;">Thanks for your payment!</span>
            <span class="ajax-fail" style="display:none;">Something went seriously wrong, please contact me.</span>
            <section>
                <!-- to display errors returned by createToken -->
                <form action="javascript:" method="POST" id="payment-form">
                    <div class="form-row">
                        <input type="text" size="20" autocomplete="off" id="card-number" placeholder="Card Number (eg: 1111222233334444)" class="card-number main-form" />
                    </div>
                    <div class="form-row">
                        <input type="text" size="4" autocomplete="off" id="card-security-code" placeholder="CVC Code/Security Code (eg: 112)" class="card-cvc main-form" />
                    </div>
                    <div class="form-row">
                        <input type="text" size="2" id="expiration-month" placeholder="Expiration Month (eg: 05)" class="card-expiry-month main-form"/>
                    </div>
                    <div class="form-row">
                        <input type="text" size="4" id="expiration-year" placeholder="Expiration Year (eg: 2013)" class="card-expiry-year main-form"/>
                    </div>
                    <div class="form-row">
                        <input type="text" size="2" id="charge-amount" placeholder="Ammount (eg: 35.99)" class="payment-amount main-form"/>
                    </div>
                    <button type="submit" class="submit-button">Submit Payment</button>

                </form>
            </section>
        </div>
    </body>
</html>