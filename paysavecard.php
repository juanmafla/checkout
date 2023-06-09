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

  require_once 'vars.php';

  try {    

    $paymentIntent= $stripe->paymentIntents->create([
      'customer'=> $_POST['cus'],
      'description' => $_POST['product_name'],
      'payment_method' => $_POST['pm'],
      'confirm' => 'true',
      'amount' => $_POST['product_price'],
      'currency' => $currency,
      'automatic_payment_methods' => [
        'enabled' => true,
      ],
      'return_url' => $return_url
    ]);

    header("HTTP/1.1 303 See Other");

    if($paymentIntent->next_action) {
       header("Location: " . $paymentIntent->next_action->redirect_to_url->url);
    } else {
      header("Location: " . $paymentIntent->charges->data['0']->receipt_url);
    }
   
  } catch(\Stripe\Exception\CardException $e) {
    echo 'Status is:' . $e->getHttpStatus() . '\n';
    echo 'Type is:' . $e->getError()->type . '\n';
    echo 'Code is:' . $e->getError()->code . '\n';
    echo 'Message is:' . $e->getError()->message . '\n';

    echo PayCardbtn($_POST['product_price'], $_POST['cus'], $_POST['product_name'], 'Pay with other card');

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

