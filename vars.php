<?php
$currency='usd';
$return_url= 'https://madridny.com/directsales/checkout/paysavecard-success.php';
$success_url= 'https://madridny.com/directsales/checkout/success.php?session_id={CHECKOUT_SESSION_ID}';
$cancel_url= 'https://madridny.com/directsales/checkout/cancel.php';


require_once 'stripe-php/init.php';
$stripe = new \Stripe\StripeClient('sk_test_qkEX6XQ67dIUi3F1m3ScBnjS00h8346qH3');

function PayCardbtn($product_price, $stripe_customer_id, $product_name, $btn_text) {
	return '<form action="https://madridny.com/directsales/checkout/create-checkout-session.php" method="POST">
					<input type="hidden" name="product_price" value="'.$product_price.'">
					<input type="hidden" name="cus" value="'.$stripe_customer_id.'">
					<input type="hidden" name="product_name" value="'.$product_name.'">
			  	<button type="submit">'.$btn_text.'</button>
			</form>';
}


function PaySaveCardbtn($product_price, $stripe_customer_id, $stripe_paymentMethod, $paymentMethod, $product_name, $btn_text) {
	return '<form action="https://madridny.com/directsales/checkout/paysavecard.php" method="POST">
					<p>Would you like to use your card on file ending in '.$paymentMethod->card->last4.' ?</p>
					<input type="hidden" name="product_price" value="'.$product_price.'">
					<input type="hidden" name="pm" value="'.$stripe_paymentMethod.'">
					<input type="hidden" name="cus" value="'.$stripe_customer_id.'">
					<input type="hidden" name="product_name" value="'.$product_name.'">
				  <button type="submit">'.$btn_text.'</button>
			</form>';
}