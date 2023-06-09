<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>

	<?php

		$has_commissions = false;
		$product_price = 2500;
		$product_name = 'directsalesmlm';

		if($has_commissions) {
			// pay with comissions

		} else {
			//pay with credit card

			$stripe_customer_id = 'cus_O2yfcSRHUNEnwL'; //get this from the database

			if($stripe_customer_id) {
				//if there is user id saved

				$stripe_paymentMethod = 'pm_1NGsi1HUGtW3QZJTpspRA4qE'; //get this from the database

				if($stripe_paymentMethod) {
					//if there is payment method saved

					try {

						require_once 'vars.php';
						$paymentMethod= $stripe->paymentMethods->retrieve(
						  $stripe_paymentMethod
						);


						echo PaySaveCardbtn($product_price, $stripe_customer_id, $stripe_paymentMethod, $paymentMethod, $product_name, 'Pay');


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

				  echo PayCardbtn($product_price, $stripe_customer_id, $product_name, 'No, other card');

				} else {

					echo PayCardbtn($product_price, $stripe_customer_id, $product_name, 'Pay');

				}				

			} else {

				echo PayCardbtn($product_price, $stripe_customer_id, $product_name, 'Pay');
			}

		}

	?>
    
</body>
</html>