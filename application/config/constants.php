<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('WEBSITE_NAME', 'Baqala Stores');
define('INV_MOBILE', '0510549211');
define('COMPANY_VAT_NO', '300034911400003');
define('CURRENT_TIME', date('Y-m-d H:i:s', time ()));    //Date TIme

/*---- Fields Length -----*/
define('VAT_LENGTH', 15);
define('CR_LENGTH', 10);
define('SPONSOR_LENGTH', 10);
define('MOL_LENGTH', 9);
define('DL_LENGTH', 10);
define('MOB_LENGTH', 10);
define('SIM_LENGTH', 19);
define('FAX_LENGTH', 10);
define('EMAIL_LENGTH', 120);
define('ZIP_LENGTH', 6);
define('SAUDI_ZIP_LENGTH', 5);
define('IBAN_LENGTH', 24);
define('STC_PAY_LENGTH', 10);
define('ICAMA_LENGTH', 10);
define('BANK_ACCOUNT', 20);
define('PASSPORT_LENGTH', 10);

/*---- QR Path -----*/
define('FILE_PATH_QR', $_SERVER['DOCUMENT_ROOT'].'/uploads/qrcodes/'); //server
//define('FILE_PATH_QR', $_SERVER['DOCUMENT_ROOT'].'/new-projects/warehouse/uploads/qrcodes/'); //local

/*---- Invoice Path -----*/
define('FILE_PATH_INVOICE', $_SERVER['DOCUMENT_ROOT'].'/invoice-pdf/'); //server
//define('FILE_PATH_INVOICE', $_SERVER['DOCUMENT_ROOT'].'/new-projects/warehouse/invoice-pdf/'); //local

/*---- Quote Path -----*/
define('FILE_PATH_QUOTE', $_SERVER['DOCUMENT_ROOT'].'/quotation-pdf/'); //server
//define('FILE_PATH_QUOTE', $_SERVER['DOCUMENT_ROOT'].'/new-projects/warehouse/quotation-pdf/'); //local

/*---- Upload Path -----*/
define('FILE_PATH_UPLOAD', $_SERVER['DOCUMENT_ROOT'].'/uploads/'); //server
//define('FILE_PATH_UPLOAD', $_SERVER['DOCUMENT_ROOT'].'/new-projects/warehouse/uploads/'); //local

/*---- Download Path -----*/
define('FILE_PATH_DOWNLOAD', $_SERVER['DOCUMENT_ROOT'].'/'); //server
//define('FILE_PATH_DOWNLOAD', $_SERVER['DOCUMENT_ROOT'].'/projects/warehouse7/'); //local

/**
 * Define APP_URL Dynamically
 * Write this at the bottom of index.php
 *
 * Automatic base url
 */
$__scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) ? 'https' : 'http';
$__appUrl = $__scheme . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
defined('APP_URL') OR define('APP_URL', $__appUrl);

/*---- Attendance File -----*/
defined('SELFIE_PATH_UPLOAD') OR define('SELFIE_PATH_UPLOAD', rtrim(getenv('SELFIE_PATH_UPLOAD') ?: APP_URL.'uploads/selfie-storage/', '/').'/');
defined('EXTERNAL_API_KEY') OR define('EXTERNAL_API_KEY', (string) getenv('EXTERNAL_API_KEY'));
defined('EXTERNAL_API_ALLOWED_ORIGIN') OR define('EXTERNAL_API_ALLOWED_ORIGIN', (string) (getenv('EXTERNAL_API_ALLOWED_ORIGIN') ?: APP_URL));
defined('DISPUTE_TO_EMAIL') OR define('DISPUTE_TO_EMAIL', (string) getenv('DISPUTE_TO_EMAIL'));
defined('DISPUTE_CC_EMAILS') OR define('DISPUTE_CC_EMAILS', (string) getenv('DISPUTE_CC_EMAILS'));
defined('PAYPAL_BUSINESS_EMAIL') OR define('PAYPAL_BUSINESS_EMAIL', (string) getenv('PAYPAL_BUSINESS_EMAIL'));
defined('SMS_GATEWAY_BASE_URL') OR define('SMS_GATEWAY_BASE_URL', (string) getenv('SMS_GATEWAY_BASE_URL'));
