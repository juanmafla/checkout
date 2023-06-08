<?php  
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vars.php';

$pi= $stripe->paymentIntents->create([
  'customer'=> 'cus_O2Cj5HObCaPIls',
  'payment_method' => 'pm_1NG8aLHUGtW3QZJTDnIFHBej',
  'confirm' => 'true',
  'amount' => 2000,
  'currency' => 'eur',
  'automatic_payment_methods' => [
    'enabled' => true,
  ],
  'return_url' => 'https://madridny.com/directsales/checkout/success2.php'
]);



?>
<p>
  		you have been charged $20
  	</p>