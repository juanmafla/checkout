<?php
		//Homepage. This page is where all the variables are set. This page is where the buttons appear or the payment form is redirected.

		require_once 'vars.php';

		$has_commissions = false; // has comissions?
		$product_price = 2700; // price *required
		$product_name = 'directsalesmlm'; //product name *required

		if($has_commissions) {
			// pay with comissions

		} else {
			//pay with credit card


			// customer or product metadata. You can save any data that you want. *must be an array
			$Payment_metadata= array(
				'name' => 'John',
				'lastname' => 'Doe',
				'product' => 'a fine product',
				'SKU' => '3jda7223a',
				'date' => '06-09-23',
				'shop' => 'my shop',
			);

			/* YOU NEED THIS FOR SETTING PAYMENTS FORM, IF USER EXIST IN STRIPE */
			$stripe_customer_id = 'cus_O2yfcSRHUNEnwL'; //get this from the database

			if($stripe_customer_id) {
				//if there is user id saved

				/* YOU NEED THIS FOR CHARGE A SAVED CARD*/
				$stripe_paymentMethod = 'pm_1NHGQWHUGtW3QZJTm6JlX7FL'; //get this from the database

				if($stripe_paymentMethod) {
					//if there is payment method saved

					try {

						//FOR GET THE LAST 4 DIGITS OF THE SAVED CARD
						$paymentMethod= $stripe->paymentMethods->retrieve(
						  $stripe_paymentMethod
						);


						// pay with saved card button
						echo PaySaveCardbtn($product_price, $stripe_customer_id, $stripe_paymentMethod, $paymentMethod, $product_name, $Payment_metadata, 'Pay');


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

				  // pay with other card button
				  echo PayCardbtn($product_price, $stripe_customer_id, $product_name, $Payment_metadata, 'No, other card');

				} else {

					//If the customer do not have a saved card, he will be redirected to the payment form
					echo CreateCheckoutSession($stripe_customer_id, $product_name, $product_price, $Payment_metadata);

				}				

			} else {
				// pay with other card button
				echo PayCardbtn($product_price, $stripe_customer_id, $product_name, $Payment_metadata, 'Pay');
			}

		}

?>