<?php
// don't allow direct access to pay.php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");

// Helper Function: used to post an error message back to our caller
function returnErrorWithMessage($message)
{
	$a = array('result' => 1, 'errorMessage' => $message);
	echo json_encode($a);
}

// Load stripe-php
require_once('vendor/autoload.php');

$privateTestKey = "ENTER YOUR PRIVATE TEST KEY HERE";	// These are the SECRET keys!
$privateLiveKey = "ENTER YOUR PRIVATE LIVE KEY HERE";

Stripe::setApiKey($privateTestKey);  // Switch to change between live and test environments

// Get all the values from the form
$token = $_POST['stripeToken'];
$cardNumber = $_POST['cardNumber'];
$cardCVC = $_POST['cardCVC'];
$expirationMonth = $_POST['expirationMonth'];
$expirationYear = $_POST['expirationYear'];
$price = $_POST['price'];
$name = $_POST['name'];
$email = $_POST['email'];

$priceInCents = $price * 100;	// Stripe requires the amount to be expressed in cents

try {
	// We must have all of this information to proceed. If it's missing, balk.
	if (!isset($token)) throw new Exception("Website Error: The Stripe token was not generated correctly or passed to the payment handler script. Your credit card was NOT charged. Please report this problem to the webmaster.");
	if (!isset($cardNumber)) throw new Exception("Website Error: Bad card number Your credit card was NOT charged. Please report this problem to the webmaster.");
	if (!isset($cardCVC)) throw new Exception("Website Error: Invalid security code (CVC). Your credit card was NOT charged. Please report this problem to the webmaster.");
	if (!isset($expirationMonth)) throw new Exception("Website Error: Expiration month was not set. Your credit card was NOT charged. Please report this problem to the webmaster.");
	if (!isset($expirationYear)) throw new Exception("Website Error: Expiration year was not set. Your credit card was NOT charged. Please report this problem to the webmaster.");
	if (!isset($price)) throw new Exception("Website Error: Gotta enter a value to pay. Your credit card was NOT charged. Please report this problem to the webmaster.");
	try
	{
		// create the charge on Stripe's servers. THIS WILL CHARGE THE CARD!
		$charge = \Stripe\Stripe::create(array(
			"amount" => $priceInCents,
			"currency" => "usd",
			"card" => $token,
			"description" => "payment to tyler")
		);

		// If no exception was thrown, the charge was successful!
		// Here, you might record the user's info in a database, email a receipt, etc.

		// Return a result code of '0' and whatever other information you'd like.
		// This is accessible to the jQuery Ajax call return-handler in "buy-controller.js"
		$array = array('result' => 0, 'email' => $email, 'price' => $price, 'message' => 'Thank you; your transaction was successful!');
		echo json_encode($array);
	}
	catch (Stripe_Error $e)	{
		// The charge failed for some reason. Stripe's message will explain why.
		$message = $e->getMessage();
		returnErrorWithMessage($message);
	}
}
catch (Exception $e) {
	// One or more variables was NULL
	$message = $e->getMessage();
	returnErrorWithMessage($message);
}
?>