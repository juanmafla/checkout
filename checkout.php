<html>
  <head>
    <title>Checkout</title>
  </head>
  <body>
  	<?php

		$has_commissions= false;

		if($has_commissions) {

		} else {
	?>

		<form action="https://madridny.com/directsales/checkout/create-checkout-session.php" method="POST">
	      <button type="submit">Pay</button>
	    </form>

	<?php
		}
	?>
    
  </body>
</html>
