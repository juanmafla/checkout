<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vars.php';

$session_id= $stripe->checkout->sessions->retrieve(
  $_GET["session_id"],
  ['expand' => ['setup_intent']]
);

//var_dump($session_id);


/*$pi= $stripe->paymentIntents->create([
  'customer'=> $session_id->setup_intent->customer,
  'payment_method' => 'pm_1NGUtzHUGtW3QZJTneIxqdNO',
  'confirm' => 'true',
  'amount' => 2000,
  'currency' => 'eur',
  'automatic_payment_methods' => [
    'enabled' => true,
  ],
  'return_url' => 'https://madridny.com/directsales/checkout/success.php'
]);

var_dump($pi);*/
?>
<p>
      your card has been saved. You will be charged $20.
    </p>