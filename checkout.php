<html>
  <head>
    <title>Checkout</title>
  </head>
  <body>
  	<?php
  	require_once 'vars.php';
		global $stripe;

		$has_commissions= false;

		if($has_commissions) {

		} else {

		$pm= $stripe->paymentMethods->retrieve(
		  'pm_1NG8aLHUGtW3QZJTDnIFHBej',
		  []
		);




	?>

		<form action="https://madridny.com/directsales/checkout/paysavecard.php" method="POST">
			<p>Would you like to use your card on file ending in <?php echo $pm->card->last4; ?>?</p>
	      <button type="submit">Pay</button>


	  </form>

	  <form action="https://madridny.com/directsales/checkout/create-checkout-session.php" method="POST">
	  	<button type="submit">No, other card</button>
	  </form>

	<?php
		}
	?>
    
  </body>
</html>
