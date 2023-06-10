<!-- All Stripe responses arrive on this page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return</title>
</head>
<body>   
<?php  
  
  if($_GET["payment_intent"]) {
    try {

      require_once 'vars.php';

      $paymentIntents= $stripe->paymentIntents->retrieve(
        $_GET["payment_intent"],
        []
      );

      // print de payment intent. You can get the "amount_captured", "amout_received" or others variables.
      // -> you can get metadata
      // ****IF YOU WANT SAVE A CARD POR FUTURE CHARGES YOU NEED SAVE THE payment_method AND customer ***
      print "<pre>";
      print_r($paymentIntents);
      print "</pre>";

    } catch (\Stripe\Exception\RateLimitException $e) {
      // Too many requests made to the API too quickly
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Invalid parameters were supplied to Stripe's API
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Authentication with Stripe's API failed
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Network communication with Stripe failed
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\ApiErrorException $e) {
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (Exception $e) {
      echo 'Message is:' . $e->getError()->message . '\n';
    }

  } else if($_GET["session_id"]) {

    try {

      require_once 'vars.php';

      $session= $stripe->checkout->sessions->retrieve(
        $_GET["session_id"]
      );

      // print de the session object. You can get several variables.
      print "<pre>";
      print_r($session);
      print "</pre>";

      //with sessoin object you can get the "payment intent ID" and get the "payment intent"
      $PaymentIntent= $stripe->paymentIntents->retrieve(
        $session->payment_intent,
      );

      // print de payment intent. You can get the "amount_captured", "amout_received" or others variables.
      // -> you can get metadata
      // ****IF YOU WANT SAVE A CARD POR FUTURE CHARGES YOU NEED SAVE THE payment_method AND customer ***
      print "<pre>";
      print_r($PaymentIntent);
      print "</pre>";

    } catch (\Stripe\Exception\RateLimitException $e) {
      // Too many requests made to the API too quickly
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Invalid parameters were supplied to Stripe's API
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Authentication with Stripe's API failed
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Network communication with Stripe failed
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (\Stripe\Exception\ApiErrorException $e) {
      echo 'Message is:' . $e->getError()->message . '\n';
    } catch (Exception $e) {
      echo 'Message is:' . $e->getError()->message . '\n';
    }

  }
?>
</body>
</html>