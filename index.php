<?php
$yourName = "Your Name";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Pay <?=$yourName?></title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
        <link href='/assets/style.css' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            var publicTestKey = 'ENTER PUBLISHABLE TEST KEY HERE';
            var publicLiveKey = 'ENTER PUBLISHABLE LIVE KEY HERE';
            Stripe.setPublishableKey(publicTestKey);
        </script>
        <script type="text/javascript" src="standard.js"></script>
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
                        <input type="text" size="2" id="charge-amount" placeholder="Amount (eg: 35.99)" class="payment-amount main-form"/>
                    </div>
                    <button type="submit" class="submit-button">Submit Payment</button>

                </form>
            </section>
        </div>
        <div id="loading"><p>Processing...</p></div>
        <script type="text/javascript">
        $(document).ready(function () {
          $('#loading').bind("ajaxSend", function() {
            $(this).show();
          }).bind("ajaxComplete", function() {
            $(this).hide();
          });
        });
        </script>
    </body>
</html>