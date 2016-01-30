<?php
$yourName = "Your Name";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pay <?=$yourName?></title>
        <link href='//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/pure-min.css">
        <link rel="stylesheet" href="assets/grids-responsive-min.css">
        <link rel="stylesheet" href="assets/style.css">
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            var publicTestKey = 'ENTER PUBLISHABLE TEST KEY HERE';
            var publicLiveKey = 'ENTER PUBLISHABLE LIVE KEY HERE';
            Stripe.setPublishableKey(publicTestKey);
        </script>
    </head>
    <body>
        <div class="header">
            <div class="home-menu pure-menu pure-menu-horizontal pure-menu-fixed">
                <a class="pure-menu-heading" href="#">Owe Me Money???</a>

                <ul class="pure-menu-list">
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Contact Me</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">My Blog</a></li>
                </ul>
            </div>
        </div>

        <div class="content-wrapper">

            <div class="content">
                <h2 class="content-head is-center">Dolore magna aliqua. Uis aute irure.</h2>

                <div class="pure-g">
                    <div class="l-box-lrg pure-u-1">
                        <span class="payment-alert" style="display:none;"></span>
                        <span class="payment-error" style="display:none;">Something went wrong and your card was not charged.</span>
                        <span class="payment-success" style="display:none;">Thanks for your payment!</span>
                        <span class="ajax-fail" style="display:none;">Something went seriously wrong, please contact me.</span>
                        <section>
                            <!-- to display errors returned by createToken -->
                            <form action="javascript:" method="POST" id="payment-form" class="pure-form pure-form-stacked">
                                <fieldset>
                                    <label for="card-number" class="form-row">
                                        <input type="text" autocomplete="off" id="card-number" placeholder="Card Number (eg: 1111222233334444)" class="card-number main-form" />
                                    </label>
                                    <label for="card-security-code" class="form-row">
                                        <input type="text" autocomplete="off" id="card-security-code" placeholder="CVC Code/Security Code (eg: 112)" class="card-cvc main-form" />
                                    </label>
                                    <label for="expiration-month" class="form-row">
                                        <input type="text" id="expiration-month" maxlength="2" placeholder="Expiration Month (eg: 05)" class="card-expiry-month main-form"/>
                                    </label>
                                    <label for="expiration-year" class="form-row">
                                        <input type="text" id="expiration-year" maxlength="4" placeholder="Expiration Year (eg: 2018)" class="card-expiry-year main-form"/>
                                    </label>
                                    <label for="charge-amount" class="form-row">
                                        <input type="text" id="charge-amount" placeholder="Amount in USD (eg: 35.99)" class="payment-amount main-form"/>
                                    </label>
                                    <button type="submit" class="submit-button pure-button">Submit Payment</button>
                                </fieldset>
                            </form>
                        </section>
                    </div>

                </div>

            </div>

        </div>

        <div class="footer l-box is-center">
            Built by <a href="https://longren.io/">Tyler Longren</a>, layout is from <a href="http://purecss.io">Purecss.io</a>.
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
        <script type="text/javascript" src="assets/standard.js"></script>
    </body>
</html>