<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay</title>
</head>
<body>   
<?php  
  try {

    require_once 'vars.php';

    $paymentIntents= $stripe->paymentIntents->retrieve(
      $_GET["payment_intent"],
      []
    );

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
?>
</body>
</html>