MoneyCollector
==============

Simple website to accept payments through Stripe. You've gotta get a [Stripe account](https://stripe.com/).

You can see it action [here at longren.org/pay/](http://www.longren.org/pay).

This was inspired by [begriffs/lucre heroku hosted option](https://github.com/begriffs/lucre).


Setup
-----------------------------
1. Open index.php and pay.php.

2. In index.php, change the $yourName variable at line 2 to whatever you want it to be.

3. In Index.php, edit javascript variables publicTestKey and publicLiveKey. You can find those keys in your Stripe settings. These keys are publishable.

4. In pay.php, set your private live key and your private test key (on line 12 and 13).

5. Upload all files to a PHP enabled webserver.

6. If you uploaded to a folder called pay-me at domain.com, your payment form will be at http://domain.com/pay-me/.