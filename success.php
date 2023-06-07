<?php

require_once 'vars.php';

$session_id= $stripe->checkout->sessions->retrieve(
  $_GET["session_id"],
  ['expand' => ['setup_intent']]
);


$pi= $stripe->paymentIntents->create([
  'customer'=> $session_id->setup_intent->customer,
  'payment_method' => 'pm_1NG8lAHUGtW3QZJT4zdZBYBL',
  'amount' => 2000,
  'currency' => 'eur',
  'automatic_payment_methods' => [
    'enabled' => true,
  ],
]);

var_dump($pi);