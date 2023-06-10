<?php
/* This is a configuration file for the variables and functions that are repeated throughout the project. */
$currency='usd';
$return_url= 'https://stripe.therocketrecruiter.com/return.php';
$success_url= 'https://stripe.therocketrecruiter.com/return.php?session_id={CHECKOUT_SESSION_ID}';
$cancel_url= 'https://stripe.therocketrecruiter.com/cancel.php';
$checkout_session_url= 'https://stripe.therocketrecruiter.com/create-checkout-session.php';
$paysavecard_url= 'https://stripe.therocketrecruiter.com/paysavecard.php';


require_once 'stripe-php/init.php';
//You must put the secret key of your Stripe account. A test or production mode secret key.
$stripe = new \Stripe\StripeClient('sk_test_qkEX6XQ67dIUi3F1m3ScBnjS00h8346qH3');

function PayCardbtn($product_price, $stripe_customer_id, $product_name, $payment_metadata, $btn_text) {
	global $checkout_session_url;
	$pcb.='<form id="st_checkout_form" action="'.$checkout_session_url.'" method="POST">
					<input type="hidden" name="product_price" value="'.$product_price.'">
					<input type="hidden" name="cus" value="'.$stripe_customer_id.'">
					<input type="hidden" name="product_name" value="'.$product_name.'">';

					foreach ($payment_metadata as $key => $value) {
					   $pcb.='<input type="hidden" name="metadata['.$key.']" value="'.$value.'">';
					}

	$pcb.=' 		<button type="submit">'.$btn_text.'</button>
			</form>';

	return $pcb;
}


function PaySaveCardbtn($product_price, $stripe_customer_id, $stripe_paymentMethod, $paymentMethod, $product_name, $payment_metadata, $btn_text) {
	global $paysavecard_url;
	$pscb.= '<form action="'.$paysavecard_url.'" method="POST">
					<p>Would you like to use your card on file ending in '.$paymentMethod->card->last4.' ?</p>
					<input type="hidden" name="product_price" value="'.$product_price.'">
					<input type="hidden" name="pm" value="'.$stripe_paymentMethod.'">
					<input type="hidden" name="cus" value="'.$stripe_customer_id.'">
					<input type="hidden" name="product_name" value="'.$product_name.'">';

					foreach ($payment_metadata as $key => $value) {
					   $pscb.='<input type="hidden" name="metadata['.$key.']" value="'.$value.'">';
					}

	$pscb.='	   <button type="submit">'.$btn_text.'</button>
			</form>';

	return $pscb;
}


function CreateCheckoutSession($customer_id, $product_name, $product_price, $payment_metadata) {
	global $stripe;
	global $success_url;
	global $cancel_url;
	global $currency;

	try {

	    if($customer_id) {

	      $session = $stripe->checkout->sessions->create([
	        'payment_intent_data' => ['setup_future_usage' => 'off_session'],
	         'line_items' => [[
	          'price_data' => [
	            'currency' => $currency,
	            'product_data' => [
	              'name' => $product_name,
	            ],
	            'unit_amount' => $product_price,
	          ],
	          'quantity' => 1,
	        ]],
	        'mode' => 'payment',
	        'customer' => $customer_id,
	        'success_url' => $success_url,
	        'cancel_url' => $cancel_url,
	        'metadata' => $payment_metadata,
	      ]);

	    } else {

	      $session = $stripe->checkout->sessions->create([
	        'payment_intent_data' => ['setup_future_usage' => 'off_session'],
	         'line_items' => [[
	          'price_data' => [
	            'currency' => $currency,
	            'product_data' => [
	              'name' => $product_name,
	            ],
	            'unit_amount' => $product_price,
	          ],
	          'quantity' => 1,
	        ]],
	        'mode' => 'payment',
	        'success_url' => $success_url,
	        'cancel_url' => $cancel_url,
	        'metadata' => $payment_metadata,
	      ]);

	    }

    header("HTTP/1.1 303 See Other");
    header("Location: " . $session->url);

  } catch(\Stripe\Exception\CardException $e) {
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (\Stripe\Exception\RateLimitException $e) {
    // Too many requests made to the API too quickly
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (\Stripe\Exception\InvalidRequestException $e) {
    // Invalid parameters were supplied to Stripe's API
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (\Stripe\Exception\AuthenticationException $e) {
    // Authentication with Stripe's API failed
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (\Stripe\Exception\ApiConnectionException $e) {
    // Network communication with Stripe failed
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (\Stripe\Exception\ApiErrorException $e) {
    return 'Message is:' . $e->getError()->message . '\n';
  } catch (Exception $e) {
    return 'Message is:' . $e->getError()->message . '\n';
  }
}
?>