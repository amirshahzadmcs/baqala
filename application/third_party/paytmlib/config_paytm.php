<?php
 
/*

- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.

*/

// live creditional start//
define('PAYTM_ENVIRONMENT', 'PROD'); // PROD //TEST
define('PAYTM_MERCHANT_KEY', '5r_0uqyOcPrTqhQh'); //Change this constant's value with Merchant key downloaded from portal
define('PAYTM_MERCHANT_MID', 'IXIANA74262053139693'); //Change this constant's value with MID (Merchant ID) received from Paytm
define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm
//  live creditional end//

/*
// test creditional start//
    define('PAYTM_ENVIRONMENT', 'TEST'); // PROD //TEST
    define('PAYTM_MERCHANT_KEY', 'rHoo7RYajx0oLodD'); //Change this constant's value with Merchant key downloaded from portal
    define('PAYTM_MERCHANT_MID', 'IXIANA62631058331918'); //Change this constant's value with MID (Merchant ID) received from Paytm
    define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm
// test creditional end////
*/
define('CALLBACK_URL', base_url().'paytm/paytmCallback');
/*$PAYTM_DOMAIN = "pguat.paytm.com";
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_DOMAIN = 'secure.paytm.in';
}
//WEBPROD
//WEBSTAGING
define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
define('PAYTM_STATUS_QUERY_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/TXNSTATUS');
define('PAYTM_STATUS_QUERY_NEW_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/getTxnStatus');
define('PAYTM_TXN_URL', 'https://'.$PAYTM_DOMAIN.'/oltp-web/processTransaction');*/

//$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';
//$PAYTM_TXN_URL='https://securegw-stage.paytm.in/order/process';

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/order/status';
$PAYTM_TXN_URL='https://securegw.paytm.in/order/process';


define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

?>
