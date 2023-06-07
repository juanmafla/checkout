<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vars.php';
global $stripe;

$session = $stripe->checkout->sessions->create([
  'payment_method_types' => ['card'],
  'mode' => 'setup',
  'customer' => 'cus_O2Cj5HObCaPIls',
  'success_url' => 'https://madridny.com/directsales/checkout/success.php?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => 'https://madridny.com/directsales/checkout/cancel.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $session->url);