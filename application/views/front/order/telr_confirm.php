<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php //print_r($ivp_authkey); ?>
<html>
<head>
	<title>Purchase Example</title>
</head>
<body>
	<form action="https://secure.telr.com/gateway/order.json" method="post">
	<input name="ivp_store" type="hidden" value="24759">
	<input name="ivp_amount" type="hidden" value="19.95">
	<input name="ivp_currency" type="hidden" value="USD">
	<input name="ivp_test" type="hidden" value="1">
	<input name="ivp_timestamp" type="hidden" value="1293002624">
	<input name="ivp_cart" type="hidden" value="ABC123">
	<input name="ivp_desc" type="hidden" value="Items">
	<input name="ivp_signature" type="hidden" value="bc8113029c18be34a673f2e28ae0c6db5bf9b734">
	<input type="submit" value="Purchase">
	</form>
</body>
</html> 
