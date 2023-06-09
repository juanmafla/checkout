<?php
require_once 'vars.php';

try {

    if($_POST['cus']) {

      $session = $stripe->checkout->sessions->create([
        'payment_intent_data' => ['setup_future_usage' => 'off_session'],
         'line_items' => [[
          'price_data' => [
            'currency' => $currency,
            'product_data' => [
              'name' => $_POST['product_name'],
            ],
            'unit_amount' => $_POST['product_price'],
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'customer' => $_POST['cus'],
        'success_url' => $success_url,
        'cancel_url' => $cancel_url,
      ]);

    } else {

      $session = $stripe->checkout->sessions->create([
        'payment_intent_data' => ['setup_future_usage' => 'off_session'],
         'line_items' => [[
          'price_data' => [
            'currency' => $currency,
            'product_data' => [
              'name' => $_POST['product_name'],
            ],
            'unit_amount' => $_POST['product_price'],
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $success_url,
        'cancel_url' => $cancel_url,
      ]);

    }

    header("HTTP/1.1 303 See Other");
    header("Location: " . $session->url);

  } catch(\Stripe\Exception\CardException $e) {
    echo 'Status is:' . $e->getHttpStatus() . '\n';
    echo 'Type is:' . $e->getError()->type . '\n';
    echo 'Code is:' . $e->getError()->code . '\n';
    // param is '' in this case
    echo 'Param is:' . $e->getError()->param . '\n';
    echo 'Message is:' . $e->getError()->message . '\n';
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