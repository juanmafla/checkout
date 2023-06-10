<?php
//Here the Stripe checkout session is created. If the result of the request is correct, it is redirected to the payment form.

require_once 'vars.php';

  echo CreateCheckoutSession($_POST['cus'], $_POST['product_name'], $_POST['product_price'], $_POST['metadata'] );

?>