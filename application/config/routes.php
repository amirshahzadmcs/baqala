<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
a
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['login'] = 'account/login';
$route['login-submit'] = 'account/submit_login';
$route['logout'] = 'account/logout';
$route['forgot-password'] = 'account/forgot_password';
$route['categories/(:num)'] = 'home/category/$1';
$route['product/(:num)'] = 'home/detail/$1';
$route['cart'] = 'order/cart';
$route['add-to-cart'] = 'order/add_to_cart';
$route['empty-basket'] = 'order/remove_all_items';
$route['checkout'] = 'order/checkout';
$route['confirm-checkout'] = 'order/checkout_quotation_order';
$route['order-history'] = 'order/order_list';
$route['order-detail/(:num)'] = 'order/order_detail/$1';
$route['copy-order-basket'] = 'order/copy_order_basket';
$route['quotation-history'] = 'order/quotation_list';
$route['approve-quotation'] = 'order/approve_quotation';
$route['quotation-detail/(:num)'] = 'order/quotation_detail/$1';
$route['copy-quotation-basket'] = 'order/copy_quotation_basket';
$route['export-order/(:num)'] = 'export/orderExcel/$1';
$route['export-quotation/(:num)'] = 'export/quotationExcel/$1';
$route['change-password'] = 'account/change_password';
$route['update-password'] = 'account/submit_change_password';
$route['profile'] = 'account/index';
$route['address-detail'] = 'account/get_address';
$route['contact-us'] = 'home/contact_us';
$route['submit-contact'] = 'home/submit_contact_us';
$route['thanks-for-order'] = 'order/thanks_order';
$route['search'] = 'home/search';
$route['landing'] = 'welcome/index';
$route['3-pl-form'] = 'welcome/three_pl_form';
#$route['category/:any'] = 'home/category/:any';
/*
$route['about-us'] = 'home/page/about-us';
$route['payment-policy'] = 'home/page/payment-policy';
$route['help-and-faqs'] = 'home/page/help-and-faqs';
$route['return-policy'] = 'home/page/return-policy';
$route['shipping-policy'] = 'home/page/shipping-policy';
$route['cancellation-policy'] = 'home/page/cancellation-policy';
$route['terms-condition'] = 'home/page/terms-condition';
$route['disclaimer'] = 'home/page/disclaimer';
$route['privacy-policy'] = 'home/page/privacy-policy';
$route['help-ticket'] = 'home/help_ticket';
$route['notification'] = 'home/notification';
$route['blogs'] = 'home/blogs';
$route['blog/:any'] = 'home/blog/:any';
$route['search-page'] = 'home/search_page';
$route['search'] = 'home/search';
$route['order_history'] = 'account/order_history';
$route['browsing'] = 'home/browsingHistory';
$route['order-detail/:any'] = 'account/order_detail/:any';
$route['product/:any'] = 'home/detail/:any';
$route['product/gp/:any'] = 'home/gift_card/:any';
$route['category/:any'] = 'home/other_category/:any';
$route['wishlist'] = 'order/wishlist';
$route['buy_now'] = 'order/buy_now_gift';
$route['order-address'] = 'order/checkout_address';
$route['delivery-slots'] = 'order/delivery_slot';
$route['checkout'] = 'order/checkout';
$route['gift-checkout'] = 'order/set_giftckout';
$route['thanks-for-order'] = 'order/thanks_order';
$route['register'] = 'account/new_user';
$route['business_account'] = 'account/business_account';
$route['verify-email'] = 'account/verification';
$route['referral'] = 'account/referral';
$route['order-error'] = 'order/order_error';
$route['return'] = 'home/return_product';
$route['contact-us'] = 'home/contact_us';
$route['unsubscribe-newsletter'] = 'home/unsubscribe_newsletter';
$route['dashboard'] = 'account/dashboard';
$route['redeem'] = 'account/redeem_form';
$route['redeem-gift-card'] = 'account/redeem_gift';
$route['credit-detail'] = 'account/creditDetail';
$route['wallet-history'] = 'account/wallet_history';
$route['rewards-history'] = 'account/rewards_history';
$route['kyc'] = 'account/docsForm';
$route['account'] = 'account/index';
$route['download-invoice'] = 'order/invoice_page';
$route['print-invoice'] = 'order/print_invoice_by_qr';
*/


/*-----------------------------------*/
/*========= Cron Routes Start ==========*/
/*-----------------------------------*/
# Unsuspend
$route['cron/unsuspend-riders'] = 'admin/Cron/unsuspend_riders';
$route['cron/insurance-expiry-notifications'] = 'admin/Cron/send_insurance_expiry_notifications';
$route['cron/expire-requests'] = 'admin/Cron/expire_requests';

$route['api/upload-repair-video'] = 'UploadVideo/index';
$route['api/delete-repair-video'] = 'UploadVideo/delete';

$route['api/upload-repair-image'] = 'UploadImage/index';
$route['api/delete-repair-image'] = 'UploadImage/delete';

$route['api/upload-request-image'] = 'UploadImage/upload';
$route['api/delete-request-image'] = 'UploadImage/delete_image';

$route['api/send-test-email'] = 'SendMailApi/test_email';
$route['api/send-confirmation-email'] = 'SendMailApi/send_confirmation_email';

/*-----------------------------------*/
/*========= Delivery Boy Routes Start ==========*/
/*-----------------------------------*/
# Auth
$route['delivery-partner/registation'] = 'deliveryboy/Auth_controller/signup';
$route['delivery-partner/verify-email'] = 'deliveryboy/Auth_controller/submit_signup_email';
$route['delivery-partner/resend-otp'] = 'deliveryboy/Auth_controller/resend_otp';
$route['delivery-partner/otp-verification'] = 'deliveryboy/Auth_controller/otp_verification';
$route['delivery-partner/verify-otp'] = 'deliveryboy/Auth_controller/verify_otp';
$route['delivery-partner/password'] = 'deliveryboy/Auth_controller/signup_password';
$route['delivery-partner/submit-registration'] = 'deliveryboy/Auth_controller/submit_registration';
$route['delivery-partner/login'] = 'deliveryboy/Auth_controller/login';
$route['delivery-partner/login-submit'] = 'deliveryboy/Auth_controller/submit_login';
$route['delivery-partner/logout'] = 'deliveryboy/Auth_controller/logout';
$route['delivery-partner'] = 'deliveryboy/Auth_controller/index';

# Profile
$route['delivery-partner/profile'] = 'deliveryboy/Profile_controller/index';
$route['delivery-partner/application-form'] = 'deliveryboy/Profile_controller/application_form';
$route['delivery-partner/save-basic-detail'] = 'deliveryboy/Profile_controller/save_basic_info';
$route['delivery-partner/save-vehicle-info'] = 'deliveryboy/Profile_controller/save_vehicle_info';
$route['delivery-partner/save-bank-info'] = 'deliveryboy/Profile_controller/save_bank_info';
$route['delivery-partner/upload-profile-pic'] = 'deliveryboy/Profile_controller/upload_profile_pic';
$route['delivery-partner/upload-iqama-front'] = 'deliveryboy/Profile_controller/upload_iqama_front';
$route['delivery-partner/upload-iqama-back'] = 'deliveryboy/Profile_controller/upload_iqama_back';
$route['delivery-partner/upload-licence-front'] = 'deliveryboy/Profile_controller/upload_licence_front';
$route['delivery-partner/upload-licence-back'] = 'deliveryboy/Profile_controller/upload_licence_back';
$route['delivery-partner/upload-iban'] = 'deliveryboy/Profile_controller/upload_iban';
$route['delivery-partner/upload-car-reg-front'] = 'deliveryboy/Profile_controller/upload_car_reg_front';
$route['delivery-partner/upload-car-reg-back'] = 'deliveryboy/Profile_controller/upload_car_reg_back';
$route['delivery-partner/upload-car-insurance'] = 'deliveryboy/Profile_controller/upload_car_insurance';
$route['delivery-partner/upload-car-front'] = 'deliveryboy/Profile_controller/upload_car_front';
$route['delivery-partner/upload-car-back'] = 'deliveryboy/Profile_controller/upload_car_back';
$route['delivery-partner/upload-car-left'] = 'deliveryboy/Profile_controller/upload_car_left';
$route['delivery-partner/upload-car-right'] = 'deliveryboy/Profile_controller/upload_car_right';
$route['delivery-partner/change-password'] = 'deliveryboy/Profile_controller/change_password';
$route['delivery-partner/update-password'] = 'deliveryboy/Profile_controller/submit_change_password';


/*-----------------------------------*/
/*========= Logistic Partner Routes Start ==========*/
/*-----------------------------------*/
# Auth
$route['logistic-partner/login'] = 'logistic/Auth_controller/login';
$route['logistic-partner/login-submit'] = 'logistic/Auth_controller/submit_login';
$route['logistic-partner/logout'] = 'logistic/Auth_controller/logout';
$route['logistic-partner'] = 'logistic/Auth_controller/index';
$route['logistic-partner/profile'] = 'logistic/Profile_controller/profile';
$route['logistic-partner/change-password'] = 'logistic/Profile_controller/change_password';
$route['logistic-partner/update-password'] = 'logistic/Profile_controller/submit_change_password';

# Riders
$route['logistic-partner/rider/list'] = 'logistic/Riders/index';
$route['logistic-partner/rider/ajax-list'] = 'logistic/Riders/get_list';
$route['logistic-partner/rider/delete'] = 'logistic/Riders/delete';
$route['logistic-partner/rider/form'] = 'logistic/Riders/add';
$route['logistic-partner/rider/detail'] = 'logistic/Riders/detail';
$route['logistic-partner/org-tracking'] = 'logistic/Org_controller/index';
$route['logistic-partner/sdp/dashboard'] = 'logistic/Sdp_controller/index';
$route['logistic-partner/sdp/report'] = 'logistic/RSdp_controller/index';
$route['logistic-partner/account-payment-report'] = 'logistic/Payment_controller/index';
$route['logistic-partner/organization-payment'] = 'logistic/Payment_controller/Payment_organisation';


/*-----------------------------------*/
/*========= Admin Routes Start ==========*/
/*-----------------------------------*/
$route['admin'] = 'admin/common';
$route['admin/login'] = 'admin/common/login';
$route['admin/change-user'] = 'admin/common/change_user';
$route['admin/check-login'] = 'admin/common/check_login';
$route['admin/send-otp'] = 'admin/common/sendOtp';
$route['admin/otp'] = 'admin/common/otp_form';
$route['admin/verify-otp'] = 'admin/common/verify_otp';

$route['admin/unauthorized'] = 'admin/common/access_denied';
$route['admin/unauthorized-request'] = 'admin/common/unauthorized_request';

#3Pl Logistic Partner
$route['admin/3p-fleet/applications'] = 'admin/3pl/ThreePlApplication/list_page';
$route['admin/3p-fleet/ajax-list'] = 'admin/3pl/ThreePlApplication/get_list';
$route['admin/3p-fleet/delete'] = 'admin/3pl/ThreePlApplication/delete';
$route['admin/3p-fleet/delete-datewise'] = 'admin/3pl/ThreePlApplication/delete_by_date';
$route['admin/3p-fleet/export-excel'] = 'admin/3pl/ThreePlApplication/export_rider_applications';

#Admin User
$route['admin/users/list'] = 'admin/Admin_controller/index';
$route['admin/users/add'] = 'admin/Admin_controller/add';
$route['admin/users/submit'] = 'admin/Admin_controller/add_user';
$route['admin/users/password-change'] = 'admin/Admin_controller/changePassword';
$route['admin/users/detail'] = 'admin/Admin_controller/detail';
$route['admin/users/delete'] = 'admin/Admin_controller/delete';
$route['admin/users/status-enable'] = 'admin/Admin_controller/setStatusEnable';
$route['admin/users/status-disable'] = 'admin/Admin_controller/setStatusDisable';
$route['admin/users/search-emp'] = 'admin/Admin_controller/search_emp';


#Store
$route['admin/store/list'] = 'admin/Store_manage/index';
$route['admin/store/add'] = 'admin/Store_manage/add';
$route['admin/store/submit'] = 'admin/Store_manage/add_store';
$route['admin/store/login-detail'] = 'admin/Store_manage/getStoreLoginDetail';
$route['admin/store/change-password'] = 'admin/Store_manage/changePassword';
$route['admin/store/third-party'] = 'admin/Store_third/add_thirdparty';
$route['admin/store/submit-third-party'] = 'admin/Store_third/save_thirdparty';
$route['admin/store/third-party-detail'] = 'admin/Store_third/thirdparty_detail';
$route['admin/store/password-change'] = 'admin/Store_third/changePassword';
$route['admin/store/detail'] = 'admin/Store_manage/detail';
$route['admin/store/delete'] = 'admin/Store_manage/delete';

#Sim Card
$route['admin/sim/list'] = 'admin/Sim_card/index';
$route['admin/sim/add'] = 'admin/Sim_card/add_sim';
$route['admin/sim/edit'] = 'admin/Sim_card/edit_sim';
$route['admin/sim/submit'] = 'admin/Sim_card/save_sim';
$route['admin/sim/update'] = 'admin/Sim_card/update_sim';
$route['admin/sim/detail'] = 'admin/Sim_card/sim_detail';
$route['admin/sim/delete'] = 'admin/Sim_card/delete';
$route['admin/sim/replace-form'] = 'admin/Sim_card/replaceSim';
$route['admin/sim/replace-save'] = 'admin/Sim_card/replace_save';
$route['admin/sim/allotment-form'] = 'admin/Sim_card/updateAllotment';
$route['admin/sim/save-allotment'] = 'admin/Sim_card/simAllotment';
$route['admin/sim/check-duplicate-mob'] = 'admin/Sim_card/ajax_check_mobile';
$route['admin/sim/check-duplicate-sim'] = 'admin/Sim_card/ajax_check_simno';
$route['admin/sim/change-status-form'] = 'admin/Sim_card/update_status_form';
$route['admin/sim/status-update'] = 'admin/Sim_card/update_status';
$route['admin/sim/export-pdf'] = 'admin/Sim_card/print_sim_list';
$route['admin/sim/print-handover-form'] = 'admin/Sim_card/print_handover_form';
$route['admin/sim/export-excel'] = 'admin/Export/allSimExcel';

$route['admin/sim/port-list'] = 'admin/Sim_card/port_index';
$route['admin/sim/port-ajax-list'] = 'admin/Sim_card/get_port_list';
$route['admin/sim/port-form'] = 'admin/Sim_card/port_sim';
$route['admin/sim/port-sim-detail'] = 'admin/Sim_card/porting_sim_detail';
$route['admin/sim/save-port-detail'] = 'admin/Sim_card/save_port_detail';

$route['admin/sim/vouchers'] = 'admin/Vouchers/index';
$route['admin/sim/vouchers/ajax-list'] = 'admin/Vouchers/get_list';
$route['admin/sim/vouchers/add'] = 'admin/Vouchers/add';
$route['admin/sim/vouchers/edit'] = 'admin/Vouchers/edit';
$route['admin/sim/vouchers/detail'] = 'admin/Vouchers/detail';
$route['admin/sim/vouchers/save'] = 'admin/Vouchers/save';
$route['admin/sim/vouchers/save-vouchers'] = 'admin/Vouchers/add_vouchers';
$route['admin/sim/vouchers/update-vouchers'] = 'admin/Vouchers/update_vouchers';
$route['admin/sim/vouchers/update'] = 'admin/Vouchers/update';
$route['admin/sim/vouchers/delete'] = 'admin/Vouchers/delete';
$route['admin/sim/vouchers/print-detail'] = 'admin/Vouchers/print_detail';
$route['admin/sim/vouchers/excel-export'] = 'admin/Export/voucherDetailExcel';

#Sim Allotment
$route['admin/allot-sim/list'] = 'admin/Sim_allot/index';
$route['admin/allot-sim/add'] = 'admin/Sim_allot/add_sim';
$route['admin/allot-sim/submit'] = 'admin/Sim_allot/save_sim';
$route['admin/allot-sim/detail'] = 'admin/Sim_allot/sim_detail';
$route['admin/allot-sim/delete'] = 'admin/Sim_allot/delete';

#Mobile Invoice
$route['admin/mobile-invoice/list'] = 'admin/Mobile_invoice/index';
$route['admin/mobile-invoice/check-invoice-no'] = 'admin/Mobile_invoice/ajax_check_invoiceno';
$route['admin/mobile-invoice/check-invoice'] = 'admin/Mobile_invoice/ajax_check_invoice';
$route['admin/mobile-invoice/check-prevoius-invoice'] = 'admin/Mobile_invoice/ajax_check_prevoiuse_invoice';
$route['admin/mobile-invoice/add'] = 'admin/Mobile_invoice/add_sim';
$route['admin/mobile-invoice/submit'] = 'admin/Mobile_invoice/save_sim';
$route['admin/mobile-invoice/detail'] = 'admin/Mobile_invoice/sim_detail';
$route['admin/mobile-invoice/update-payment'] = 'admin/Mobile_invoice/update_payment';
$route['admin/mobile-invoice/delete'] = 'admin/Mobile_invoice/delete';
$route['admin/mobile-invoice/delete-doc'] = 'admin/Mobile_invoice/doc_delete';
$route['admin/mobile-invoice/print'] = 'admin/Mobile_invoice/print';
$route['admin/mobile-invoice/print_report'] = 'admin/Mobile_invoice/print_report';
$route['admin/mobile-invoice/consolidate-report'] = 'admin/Mobile_invoice/consolidate_report';
$route['admin/mobile-invoice/print-consolidate-report'] = 'admin/Mobile_invoice/print_consolidate_report';

#Prepaid Mobile Invoice
$route['admin/prepaid-mobile-invoice/list'] = 'admin/PrepaidMobileInvoice/index';
$route['admin/prepaid-mobile-invoice/check-invoice-no'] = 'admin/PrepaidMobileInvoice/ajax_check_invoiceno';
$route['admin/prepaid-mobile-invoice/check-invoice'] = 'admin/PrepaidMobileInvoice/ajax_check_invoice';
$route['admin/prepaid-mobile-invoice/add'] = 'admin/PrepaidMobileInvoice/add_invoice';
$route['admin/prepaid-mobile-invoice/submit'] = 'admin/PrepaidMobileInvoice/save_invoice';
$route['admin/prepaid-mobile-invoice/detail'] = 'admin/PrepaidMobileInvoice/invoice_detail';
$route['admin/prepaid-mobile-invoice/update-payment'] = 'admin/PrepaidMobileInvoice/update_payment';
$route['admin/prepaid-mobile-invoice/delete'] = 'admin/PrepaidMobileInvoice/delete';
$route['admin/prepaid-mobile-invoice/delete-doc'] = 'admin/PrepaidMobileInvoice/doc_delete';
$route['admin/prepaid-mobile-invoice/print'] = 'admin/PrepaidMobileInvoice/print';
$route['admin/prepaid-mobile-invoice/print-report'] = 'admin/PrepaidMobileInvoice/print_report';
$route['admin/prepaid-mobile-invoice/consolidate-report'] = 'admin/PrepaidMobileInvoice/consolidate_report';
$route['admin/prepaid-mobile-invoice/print-consolidate-report'] = 'admin/PrepaidMobileInvoice/print_consolidate_report';

#Master disputes Types
$route['admin/masters/dispute-types'] = 'admin/masters/DisputeTypes/index';
$route['admin/masters/dispute-types/add'] = 'admin/masters/DisputeTypes/add';
$route['admin/masters/dispute-types/submit'] = 'admin/masters/DisputeTypes/save';
$route['admin/masters/dispute-types/detail'] = 'admin/masters/DisputeTypes/detail';
$route['admin/masters/dispute-types/delete'] = 'admin/masters/DisputeTypes/delete';

#Disputes
$route['admin/disputes/list'] = 'admin/Disputes/index';
$route['admin/disputes/ajax-list'] = 'admin/Disputes/get_list';
$route['admin/disputes/delete'] = 'admin/Disputes/delete';
$route['admin/disputes/add'] = 'admin/Disputes/add_dispute';
$route['admin/disputes/update-status'] = 'admin/Disputes/update_status';
$route['admin/disputes/dispute-detail'] = 'admin/Disputes/dispute_detail';
$route['admin/disputes/manual-send-mail'] = 'admin/Disputes/manual_send_mail';

#sales report
$route['admin/sales-report'] = 'admin/SalesReport/index';
$route['admin/report/revenue'] = 'admin/SalesReport/revenue';
$route['admin/report/payments'] = 'admin/SalesReport/payments';
$route['admin/report/products_profit'] = 'admin/SalesReport/products_profit';
$route['admin/report/products'] = 'admin/SalesReport/products';
$route['admin/report/stock_transactions_profit'] = 'admin/SalesReport/stock_transactions_profit';
$route['admin/report/print_report'] = 'admin/SalesReport/print_report';

#payroll report
$route['admin/payroll-reports'] = 'admin/PayrollReport/index';
$route['admin/report/payslips'] = 'admin/PayrollReport/payslips';

#purchase report
$route['admin/purchase-reports'] = 'admin/PurchaseReport/index';
$route['admin/report/purchases'] = 'admin/PurchaseReport/purchases';
$route['admin/report/supplier'] = 'admin/PurchaseReport/supplier';
$route['admin/report/supplier_balance'] = 'admin/PurchaseReport/supplier_balance';
$route['admin/report/purchase'] = 'admin/PurchaseReport/purchase';
$route['admin/report/paid_purchases'] = 'admin/PurchaseReport/paid_purchases';
$route['admin/report/journal_transactions'] = 'admin/PurchaseReport/journal_transactions';
$route['admin/report/product_purchases'] = 'admin/PurchaseReport/product_purchases';
$route['admin/report/popayments'] = 'admin/PurchaseReport/popayments';
$route['admin/purchase/print_report'] = 'admin/PurchaseReport/print_report';

#block reasons
$route['admin/block-reasons'] = 'admin/new/BlockReason/index';
$route['admin/block-reasons/add'] = 'admin/new/BlockReason/add';
$route['admin/block-reasons/submit'] = 'admin/new/BlockReason/save';
$route['admin/block-reasons/detail'] = 'admin/new/BlockReason/detail';
$route['admin/block-reasons/delete'] = 'admin/new/BlockReason/delete';

#doc rejection reasons
$route['admin/doc-rejection-reasons'] = 'admin/new/DocRejectionReason/index';
$route['admin/doc-rejection-reasons/add'] = 'admin/new/DocRejectionReason/add';
$route['admin/doc-rejection-reasons/submit'] = 'admin/new/DocRejectionReason/save';
$route['admin/doc-rejection-reasons/detail'] = 'admin/new/DocRejectionReason/detail';
$route['admin/doc-rejection-reasons/delete'] = 'admin/new/DocRejectionReason/delete';


# ====== HR Module 
$route['admin/hr/dashboard'] = 'admin/hr/Human_resources/index';

# ---- Master

# Education
$route['admin/hr/master/education'] = 'admin/HrMaster/index_edu';
$route['admin/hr/master/education/add'] = 'admin/HrMaster/add_edu';
$route['admin/hr/master/education/submit'] = 'admin/HrMaster/save_edu';
$route['admin/hr/master/education/detail'] = 'admin/HrMaster/edu_detail';
$route['admin/hr/master/education/delete'] = 'admin/HrMaster/delete_edu';

# Profession
$route['admin/hr/master/profession'] = 'admin/masters/profession/index';
$route['admin/hr/master/profession/ajax-list'] = 'admin/masters/profession/get_list';
$route['admin/hr/master/profession/add'] = 'admin/masters/profession/add';
$route['admin/hr/master/profession/submit'] = 'admin/masters/profession/save';
$route['admin/hr/master/profession/delete'] = 'admin/masters/profession/delete';

# Job Title
$route['admin/hr/master/designations'] = 'admin/HrMaster/index_job_title';
$route['admin/hr/master/designations/add'] = 'admin/HrMaster/add_job_title';
$route['admin/hr/master/designations/submit'] = 'admin/HrMaster/save_job_title';
$route['admin/hr/master/designations/detail'] = 'admin/HrMaster/job_title_detail';
$route['admin/hr/master/designations/delete'] = 'admin/HrMaster/delete_job_title';

# Employee Level
$route['admin/hr/master/employee-level'] = 'admin/hr/master/Employee_level/index';
$route['admin/hr/master/employee-level/add'] = 'admin/hr/master/Employee_level/add';
$route['admin/hr/master/employee-level/submit'] = 'admin/hr/master/Employee_level/save';
$route['admin/hr/master/employee-level/detail'] = 'admin/hr/master/Employee_level/detail';
$route['admin/hr/master/employee-level/delete'] = 'admin/hr/master/Employee_level/delete';

# Employee Types
$route['admin/hr/master/employment-types'] = 'admin/hr/master/Employment_types/index';
$route['admin/hr/master/employment-types/add'] = 'admin/hr/master/Employment_types/add';
$route['admin/hr/master/employment-types/submit'] = 'admin/hr/master/Employment_types/save';
$route['admin/hr/master/employment-types/detail'] = 'admin/hr/master/Employment_types/detail';
$route['admin/hr/master/employment-types/delete'] = 'admin/hr/master/Employment_types/delete';

# Department
$route['admin/hr/master/department'] = 'admin/hr/master/Department/index';
$route['admin/hr/master/department/employee-list'] = 'admin/hr/master/Department/get_employee_list';
$route['admin/hr/master/department/export-employee-list/(:num)'] = 'admin/hr/master/Department/export_employee_excel/$1';
$route['admin/hr/master/department/print-employee-list/(:num)'] = 'admin/hr/master/Department/print_employee_list/$1';
$route['admin/hr/master/department/add'] = 'admin/hr/master/Department/add';
$route['admin/hr/master/department/submit'] = 'admin/hr/master/Department/save';
$route['admin/hr/master/department/detail'] = 'admin/hr/master/Department/detail';
$route['admin/hr/master/department/delete'] = 'admin/hr/master/Department/delete';

# Branch
$route['admin/hr/master/branch'] = 'admin/hr/master/Branch/index';
$route['admin/hr/master/branch/add'] = 'admin/hr/master/Branch/add';
$route['admin/hr/master/branch/submit'] = 'admin/hr/master/Branch/save';
$route['admin/hr/master/branch/detail'] = 'admin/hr/master/Branch/detail';
$route['admin/hr/master/branch/delete'] = 'admin/hr/master/Branch/delete';

# allowance
$route['admin/hr/master/allowance'] = 'admin/HrMaster/index_allowance';
$route['admin/hr/master/allowance/add'] = 'admin/HrMaster/add_allowance';
$route['admin/hr/master/allowance/submit'] = 'admin/HrMaster/save_allowance';
$route['admin/hr/master/allowance/detail'] = 'admin/HrMaster/allowance_detail';
$route['admin/hr/master/allowance/delete'] = 'admin/HrMaster/delete_allowance';

# leave / vacation
$route['admin/hr/master/leave'] = 'admin/HrMaster/index_leave';
$route['admin/hr/master/leave/add'] = 'admin/HrMaster/add_leave';
$route['admin/hr/master/leave/submit'] = 'admin/HrMaster/save_leave';
$route['admin/hr/master/leave/detail'] = 'admin/HrMaster/leave_detail';
$route['admin/hr/master/leave/delete'] = 'admin/HrMaster/delete_leave';

# Pay Head
$route['admin/hr/master/pay_head'] = 'admin/HrMaster/index_pay_head';
$route['admin/hr/master/pay_head/add'] = 'admin/HrMaster/add_pay_head';
$route['admin/hr/master/pay_head/submit'] = 'admin/HrMaster/save_pay_head';
$route['admin/hr/master/pay_head/detail'] = 'admin/HrMaster/pay_head_detail';
$route['admin/hr/master/pay_head/delete'] = 'admin/HrMaster/delete_pay_head';

# Nationality
$route['admin/hr/master/nationality'] = 'admin/hr/master/Nationality/index';
$route['admin/hr/master/nationality/add'] = 'admin/hr/master/Nationality/add';
$route['admin/hr/master/nationality/submit'] = 'admin/hr/master/Nationality/save';
$route['admin/hr/master/nationality/detail'] = 'admin/hr/master/Nationality/detail';
$route['admin/hr/master/nationality/delete'] = 'admin/hr/master/Nationality/delete';

# Employee
$route['admin/hr/employees'] = 'admin/hr-module/employees/Employee/index';
$route['admin/hr/employees/all'] = 'admin/hr-module/employees/Employee/index/all';
$route['admin/hr/employees/active'] = 'admin/hr-module/employees/Employee/index/active';
$route['admin/hr/employees/terminated'] = 'admin/hr-module/employees/Employee/index/terminated';

$route['admin/hr-module/iqama-renewal-list'] = 'admin/hr-module/employees/Employee/iqama_list';
$route['admin/hr-module/iqama-renewal-list-ajax'] = 'admin/hr-module/employees/Employee/get_iqama_insurance_status';
$route['admin/hr-module/print-iqama-renewal-list'] = 'admin/hr-module/employees/Employee/print_iqama_insurance_status';
$route['admin/hr-module/export-iqama-renewal-list'] = 'admin/hr-module/employees/Employee/exportIqamaToExcel';
$route['admin/hr-module/bulk-update-iqama-renewal'] = 'admin/hr-module/employees/Employee/bulkUpdateIqamaRenewal';
$route['admin/hr-module/bulk-update-profession'] = 'admin/hr-module/employees/Employee/bulkProfessionUpdateModal';
$route['admin/hr-module/bulk-update-driver-card'] = 'admin/hr-module/employees/Employee/bulkDriverCardUpdateModal';

$route['admin/hr/employees/add/step-1'] = 'admin/hr-module/employees/Employee/add_step1';
$route['admin/hr/employees/submit-step-1'] = 'admin/hr-module/employees/Employee/save_step1';
$route['admin/hr/employees/edit/step-1/(:num)'] = 'admin/hr-module/employees/Employee/edit_step1/$1';
$route['admin/hr/employees/update-step-1'] = 'admin/hr-module/employees/Employee/update_step1';

$route['admin/hr/employees/add/step-2/(:num)'] = 'admin/hr-module/employees/Employee/add_step2/$1';
$route['admin/hr/employees/update/step-2'] = 'admin/hr-module/employees/Employee/save_step2';

$route['admin/hr/employees/add/step-3/(:num)'] = 'admin/hr-module/employees/Employee/add_step3/$1';
$route['admin/hr/employees/update/step-3'] = 'admin/hr-module/employees/Employee/save_step3';

$route['admin/hr/employees/add/step-4/(:num)'] = 'admin/hr-module/employees/Employee/add_step4/$1';
$route['admin/hr/employees/update/step-4'] = 'admin/hr-module/employees/Employee/save_step4';

$route['admin/hr/employees/add/step-5/(:num)'] = 'admin/hr-module/employees/Employee/add_step5/$1';
$route['admin/hr/employees/update/step-5'] = 'admin/hr-module/employees/Employee/save_step5';

$route['admin/hr/employees/add/step-6/(:num)'] = 'admin/hr-module/employees/Employee/add_step6/$1';
$route['admin/hr/employees/add/step-7/(:num)'] = 'admin/hr-module/employees/Employee/add_step7/$1';
$route['admin/hr/employees/update/step-7'] = 'admin/hr-module/employees/Employee/save_step7';

$route['admin/hr/employees/add/step-8/(:num)'] = 'admin/hr-module/employees/Employee/add_step8/$1';

$route['admin/hr/employees/add-family'] = 'admin/hr-module/employees/Employee/add_family';
$route['admin/hr/employees/update-family'] = 'admin/hr-module/employees/Employee/update_family';
$route['admin/hr/employees/delete-family/(:any)/(:any)/(:any)'] = 'admin/hr-module/employees/Employee/deleteFamilyMem/$1/$2/$3';

$route['admin/hr/employees/add-contract'] = 'admin/hr-module/employees/Employee/add_contract';
$route['admin/hr/employees/update-contract'] = 'admin/hr-module/employees/Employee/update_contract';
$route['admin/hr/employees/add-secondary-dl'] = 'admin/hr-module/employees/Employee/save_secondary_dl';
$route['admin/hr/employees/delete-secondary-dl'] = 'admin/hr-module/employees/Employee/delete_secondary_dl';
$route['admin/hr/employees/update-salary'] = 'admin/hr-module/employees/Employee/update_salary';
$route['admin/hr/employees/salary-log_detail'] = 'admin/hr-module/employees/Employee/salary_log_detail';
$route['admin/hr/employees/get-department-head'] = 'admin/hr-module/employees/Employee/getLineManageOfLm';
$route['admin/hr/employees/submit-documents'] = 'admin/hr-module/employees/Employee/upload_documents_form';
$route['admin/hr/employees/submit-comp-documents'] = 'admin/hr-module/employees/Employee/upload_comp_documents';
$route['admin/hr/employees/export-employee-documents/(:num)'] = 'admin/hr-module/employees/Employee/export_combined_pdf/$1';
$route['admin/hr/employees/delete-image'] = 'admin/hr-module/employees/Employee/delete_image';

$route['admin/hr/employees/view/step-1/(:num)'] = 'admin/hr-module/employees/Employee/view_step1/$1';
$route['admin/hr/employees/view/step-2/(:num)'] = 'admin/hr-module/employees/Employee/view_step2/$1';
$route['admin/hr/employees/view/step-3/(:num)'] = 'admin/hr-module/employees/Employee/view_step3/$1';
$route['admin/hr/employees/view/step-4/(:num)'] = 'admin/hr-module/employees/Employee/view_step4/$1';
$route['admin/hr/employees/view/step-5/(:num)'] = 'admin/hr-module/employees/Employee/view_step5/$1';
$route['admin/hr/employees/view/step-6/(:num)'] = 'admin/hr-module/employees/Employee/view_step6/$1';
$route['admin/hr/employees/view/step-7/(:num)'] = 'admin/hr-module/employees/Employee/view_step7/$1';
$route['admin/hr/employees/view/step-8/(:num)'] = 'admin/hr-module/employees/Employee/view_step8/$1';
$route['admin/hr/employees/view/step-9/(:num)'] = 'admin/hr-module/employees/Employee/view_step9/$1';
$route['admin/hr/employees/view/step-10/(:num)'] = 'admin/hr-module/employees/Employee/view_step10/$1';

$route['admin/hr/employees/print-loan-req'] = 'admin/hr-module/employees/Employee/print_loan_req_form';
$route['admin/hr/employees/print-reporting-absconded'] = 'admin/hr-module/employees/Employee/print_reporting_absconded';
$route['admin/hr/employees/print-absence-notification'] = 'admin/hr-module/employees/Employee/print_absence_notification';
$route['admin/hr/employees/bulk-import'] = 'admin/hr-module/employees/Employee/import_file';
$route['admin/hr/employees/update-profile-pic'] = 'admin/hr-module/employees/Employee/upload_profile_pic';
$route['admin/hr/employees/remove-profile-pic'] = 'admin/hr-module/employees/Employee/remove_profile_pic';
$route['admin/hr/employees/manage-status'] = 'admin/hr-module/employees/Employee/show_status_form';
$route['admin/hr/employees/update-status'] = 'admin/hr-module/employees/Employee/update_status_form';
$route['admin/hr/employees/iqama-updation-form'] = 'admin/hr-module/employees/Employee/show_iqama_form';
$route['admin/hr/employees/update-iqama-detail'] = 'admin/hr-module/employees/Employee/update_iqama_detail';

$route['admin/hr/employees/save-asset-request'] = 'admin/hr-module/employees/Employee_requests/save_request_asset';
$route['admin/hr/employees/save-loan-request'] = 'admin/hr-module/employees/Employee_requests/save_loan_request';
$route['admin/hr/employees/save-dl-request'] = 'admin/hr-module/employees/Employee_requests/save_dl_request';
$route['admin/hr/employees/save-transaction-request'] = 'admin/hr-module/employees/Employee_requests/save_transaction_request';
$route['admin/hr/employees/save-vehicle-allotment-request'] = 'admin/hr-module/employees/Employee_requests/save_vehicle_allotment_request';

$route['admin/hr/employees/clinical-request/send-otp'] = 'admin/hr-module/employees/Employee_requests/send_otp';
$route['admin/hr/employees/clinical-request/re-send-otp'] = 'admin/hr-module/employees/Employee_requests/resend_otp';
$route['admin/hr/employees/clinical-request/verify-otp'] = 'admin/hr-module/employees/Employee_requests/verify_otp';
$route['admin/hr/employees/check-slot-availability'] = 'admin/hr-module/employees/Employee_requests/ajax_slot_availability';
$route['admin/hr/employees/save-clinical-request'] = 'admin/hr-module/employees/Employee_requests/save_clinical_request';

$route['admin/hr/employees/save-warning-request'] = 'admin/hr-module/employees/Employee_requests/save_warning_request';
$route['admin/hr/employees/save-transfer-request'] = 'admin/hr-module/employees/Employee_requests/save_transfer_request';
$route['admin/hr/employees/save-profession-request'] = 'admin/hr-module/employees/Employee_requests/save_profession_request';

#$route['admin/hr/employees/edit'] = 'admin/hr-module/employees/Employee/edit';
$route['admin/hr/employees/submit'] = 'admin/hr-module/employees/Employee/save';
$route['admin/hr/employees/detail'] = 'admin/hr-module/employees/Employee/detail';
$route['admin/hr/employees/check-empid'] = 'admin/hr-module/employees/Employee/ajax_check_empid';
$route['admin/hr/employees/check-email'] = 'admin/hr-module/employees/Employee/ajax_check_email';
$route['admin/hr/employees/check-passport'] = 'admin/hr-module/employees/Employee/ajax_check_passport';
$route['admin/hr/employees/delete'] = 'admin/hr-module/employees/Employee/delete';
$route['admin/hr/employees/send-credential'] = 'admin/hr-module/employees/Employee/sendManualCredential';
$route['admin/hr/employees/update-password'] = 'admin/hr-module/employees/Employee/change_password';
$route['admin/hr/employees/get-cv-detail'] = 'admin/hr-module/employees/Employee/get_cv_detail';
$route['admin/hr/employees/upload-form'] = 'admin/hr-module/employees/Employee/show_documents_form';
$route['admin/hr/employees/excel-export'] = 'admin/Export/employeeExport';
$route['admin/hr/employees/bulk-export'] = 'admin/hr-module/employees/Employee/exportEmployees';
$route['admin/hr/employees/export-salary-file'] = 'admin/Export/activeEmployeeExport';
$route['admin/hr/employees/print-offer-letter/(:num)'] = 'admin/hr-module/employees/Employee/print_job_offer/$1';
$route['admin/hr/employees/print-promissory-note/(:num)'] = 'admin/hr-module/employees/Employee/print_promissory_note/$1';
$route['admin/hr/employees/print-contract-letter/(:num)'] = 'admin/hr-module/employees/Employee/print_contract_letter/$1';

//Temporary Pay Slip
$route['admin/hr/payslip/list'] = 'admin/hr-module/employees/Employee_payslip/index';
$route['admin/hr/payslip/ajax-list'] = 'admin/hr-module/employees/Employee_payslip/get_list';
$route['admin/hr/payslip/detail/(:num)'] = 'admin/hr-module/employees/Employee_payslip/detail/$1';
$route['admin/hr/payslip/bulk-import'] = 'admin/hr-module/employees/Employee_payslip/import_file';
$route['admin/hr/payslip/delete/(:num)'] = 'admin/hr-module/employees/Employee_payslip/delete/$1';
$route['admin/hr/payslip/print'] = 'admin/hr-module/employees/Employee_payslip/print_payslip';
$route['admin/hr/payslip/update-status'] = 'admin/hr-module/employees/Employee_payslip/update_status';
$route['admin/hr/payslip/export/(:num)'] = 'admin/Export/payrollDetailExport/$1';
$route['admin/hr/payslip/download-selected/(:num)'] = 'admin/hr-module/employees/Employee_payslip/download_selected/$1';

//New Attendance
$route['admin/hr/attendance/list'] = 'admin/hr-module/employees/Attendance/index';
$route['admin/hr/attendance/ajax-list'] = 'admin/hr-module/employees/Attendance/get_list';
$route['admin/hr/attendance/generate-attendance'] = 'admin/hr-module/employees/Attendance/generate_monthly_attendance';
$route['admin/hr/attendance/check-month-exists'] = 'admin/hr-module/employees/Attendance/check_month_exists';
$route['admin/hr/attendance/detail/(:any)'] = 'admin/hr-module/employees/Attendance/detail/$1';
$route['admin/hr/attendance/monthly-attendance/(:any)'] = 'admin/hr-module/employees/Attendance/get_list/$1';
$route['admin/hr/attendance/print-monthly-attendance-summary/(:any)'] = 'admin/hr-module/employees/Attendance/print_monthly_attendance_summary/$1';
$route['admin/hr/attendance/filter-modal/(:any)'] = 'admin/hr-module/employees/Attendance/filter_modal_form/$1';
$route['admin/hr/attendance/export-report-modal/(:any)'] = 'admin/hr-module/employees/Attendance/export_modal_form/$1';
$route['admin/hr/attendance/print-attendance-report/(:any)'] = 'admin/hr-module/employees/Attendance/print_attendance_report/$1';
$route['admin/hr/attendance/delete/(:any)'] = 'admin/hr-module/employees/Attendance/delete/$1';
$route['admin/hr/attendance/view_logs/(:any)'] = 'admin/hr-module/employees/Attendance/view_logs/$1';
$route['admin/hr/attendance/print'] = 'admin/hr-module/employees/Attendance/print_payslip';
$route['admin/hr/attendance/update'] = 'admin/hr-module/employees/Attendance/update';
$route['admin/hr/attendance/print-employee-attendance/(:num)'] = 'admin/hr-module/employees/Attendance/print_employee_attendance/$1';

//Fuel Consumption
$route['admin/logistic-management/fuel/list'] = 'admin/logistic-management/Fuel/index';
$route['admin/logistic-management/fuel-management/list'] = 'admin/logistic-management/Fuel/vehicle_list';
$route['admin/logistic-management/fuel-management/ajax-list'] = 'admin/logistic-management/Fuel/vehicle_list_ajax';
$route['admin/logistic-management/fuel-management/add-vehicle'] = 'admin/logistic-management/Fuel/add_vehicles';
$route['admin/logistic-management/fuel-management/search-vehicle'] = 'admin/logistic-management/Fuel/vehicle_search_list';
$route['admin/logistic-management/fuel-management/vehicle-detail'] = 'admin/logistic-management/Fuel/get_vehicle_detail';
$route['admin/logistic-management/fuel-management/submit-vehicle'] = 'admin/logistic-management/Fuel/submit_vehicle';
$route['admin/logistic-management/fuel-management/filter-modal'] = 'admin/logistic-management/Fuel/filter_modal';
$route['admin/logistic-management/fuel-management/daily-consumption-report'] = 'admin/logistic-management/Fuel/daily_consumption_report';
$route['admin/logistic-management/fuel/import'] = 'admin/logistic-management/Fuel/import_file';
$route['admin/logistic-management/fuel/check-month-exists'] = 'admin/logistic-management/Fuel/check_month_exists';
$route['admin/logistic-management/fuel/search-emp-list'] = 'admin/logistic-management/Fuel/search_employee';
$route['admin/logistic-management/fuel/detail/(:any)'] = 'admin/logistic-management/Fuel/detail/$1';
$route['admin/logistic-management/fuel/monthly-fuel/(:any)'] = 'admin/logistic-management/Fuel/get_list/$1';
$route['admin/logistic-management/fuel/view-monthly-fuel-summary/(:any)'] = 'admin/logistic-management/Fuel/view_monthly_fuel_summary/$1';
$route['admin/logistic-management/fuel/print-monthly-fuel-summary/(:any)'] = 'admin/logistic-management/Fuel/print_monthly_fuel_summary/$1';
$route['admin/logistic-management/fuel/export-monthly-fuel-summary-excel/(:any)'] = 'admin/logistic-management/Fuel/export_monthly_fuel_summary_excel/$1';
$route['admin/logistic-management/fuel/export-monthly-fuel-summary-excel-new/(:any)'] = 'admin/logistic-management/Fuel/export_monthly_fuel_summary_excel_new/$1';
$route['admin/logistic-management/fuel/delete/(:any)'] = 'admin/logistic-management/Fuel/delete/$1';

#Sanat Al Amar
$route['admin/hr-module/sanat-al-amar/list'] = 'admin/hr-module/SanatAlAmar/index';
$route['admin/hr-module/sanat-al-amar/add'] = 'admin/hr-module/SanatAlAmar/add';
$route['admin/hr-module/sanat-al-amar/search-emp'] = 'admin/hr-module/SanatAlAmar/get_employee_detail';
$route['admin/hr-module/sanat-al-amar/ajax-list'] = 'admin/hr-module/SanatAlAmar/get_ajax_list';
$route['admin/hr-module/sanat-al-amar/edit'] = 'admin/hr-module/SanatAlAmar/edit';
$route['admin/hr-module/sanat-al-amar/submit'] = 'admin/hr-module/SanatAlAmar/save';
$route['admin/hr-module/sanat-al-amar/update'] = 'admin/hr-module/SanatAlAmar/update';
$route['admin/hr-module/sanat-al-amar/detail'] = 'admin/hr-module/SanatAlAmar/detail';
$route['admin/hr-module/sanat-al-amar/delete'] = 'admin/hr-module/SanatAlAmar/delete';
$route['admin/hr-module/sanat-al-amar/print-list'] = 'admin/hr-module/SanatAlAmar/exportToPDF';

# Clinical Report
$route['admin/hr-module/clinical-report'] = 'admin/hr-module/employees/Clinical_vist_report/index';
$route['admin/hr-module/clinical-report/detail'] = 'admin/hr-module/employees/Clinical_vist_report/view_group_detail';
$route['admin/hr-module/clinical-report/print'] = 'admin/hr-module/employees/Clinical_vist_report/print_visit_detail';

# Accidents
$route['admin/hr/accidents'] = 'admin/hr-module/employees/accident/index';
$route['admin/hr/accidents/ajax-list'] = 'admin/hr-module/employees/accident/get_list';
$route['admin/hr/accidents/search-employee'] = 'admin/hr-module/employees/accident/get_employee_detail';
$route['admin/hr/accidents/add'] = 'admin/hr-module/employees/accident/add';
$route['admin/hr/accidents/submit'] = 'admin/hr-module/employees/accident/save';
$route['admin/hr/accidents/edit/(:num)'] = 'admin/hr-module/employees/accident/edit/$1';
$route['admin/hr/accidents/update'] = 'admin/hr-module/employees/accident/update';
$route['admin/hr/accidents/detail/(:num)'] = 'admin/hr-module/employees/accident/detail/$1';
$route['admin/hr/accidents/delete'] = 'admin/hr-module/employees/accident/delete';

# Accidents Management
$route['admin/hr/accident-management'] = 'admin/hr-module/employees/accident_management/index';
$route['admin/hr/accident-management/ajax-list'] = 'admin/hr-module/employees/accident_management/get_list';
$route['admin/hr/accident-management/vehicle-list'] = 'admin/hr-module/employees/accident_management/vehicle_list';
$route['admin/hr/accident-management/search-vehicle'] = 'admin/hr-module/employees/accident_management/get_vehicle_detail';
$route['admin/hr/accident-management/search-employee'] = 'admin/hr-module/employees/accident_management/get_employee_detail';
$route['admin/hr/accident-management/add'] = 'admin/hr-module/employees/accident_management/add';
$route['admin/hr/accident-management/submit'] = 'admin/hr-module/employees/accident_management/save';
$route['admin/hr/accident-management/edit/(:num)'] = 'admin/hr-module/employees/accident_management/edit/$1';
$route['admin/hr/accident-management/update'] = 'admin/hr-module/employees/accident_management/update';
$route['admin/hr/accident-management/detail/(:num)'] = 'admin/hr-module/employees/accident_management/detail/$1';
$route['admin/hr/accident-management/print-injury-form/(:num)'] = 'admin/hr-module/employees/accident_management/print_injury_form/$1';
$route['admin/hr/accident-management/delete'] = 'admin/hr-module/employees/accident_management/delete';

# Memos Management
$route['admin/hr/announcements'] = 'admin/hr-module/Announcements/index';
$route['admin/hr/announcements/ajax-list'] = 'admin/hr-module/Announcements/get_list';
$route['admin/hr/announcements/search-employee'] = 'admin/hr-module/Announcements/get_employee_detail';
$route['admin/hr/announcements/add'] = 'admin/hr-module/Announcements/add';
$route['admin/hr/announcements/submit'] = 'admin/hr-module/Announcements/save';
$route['admin/hr/announcements/edit/(:num)'] = 'admin/hr-module/Announcements/edit/$1';
$route['admin/hr/announcements/update'] = 'admin/hr-module/Announcements/update';
$route['admin/hr/announcements/detail/(:num)'] = 'admin/hr-module/Announcements/detail/$1';
$route['admin/hr/announcements/delete'] = 'admin/hr-module/Announcements/delete';

#Facility Management
$route['admin/facility-management/property/list'] = 'admin/facility-management/Property/index';
$route['admin/facility-management/property/ajax-list'] = 'admin/facility-management/Property/get_list';
$route['admin/facility-management/property/add'] = 'admin/facility-management/Property/add';
$route['admin/facility-management/property/edit/(:num)'] = 'admin/facility-management/Property/edit/$1';
$route['admin/facility-management/property/submit'] = 'admin/facility-management/Property/save_property';
$route['admin/facility-management/property/update'] = 'admin/facility-management/Property/update_property';
$route['admin/facility-management/property/detail/(:num)'] = 'admin/facility-management/Property/view/$1';
$route['admin/facility-management/property/delete'] = 'admin/facility-management/Property/delete';

#Facility Bedding Management
$route['admin/facility-management/bedding/list'] = 'admin/facility-management/Property/bedding_list';
$route['admin/facility-management/bedding/ajax-list'] = 'admin/facility-management/Property/get_bedding_ajax_list';
$route['admin/facility-management/bedding/add'] = 'admin/facility-management/Property/add_bedding';
$route['admin/facility-management/bedding/edit/(:num)'] = 'admin/facility-management/Property/edit_bedding/$1';
$route['admin/facility-management/bedding/store'] = 'admin/facility-management/Property/store_bedding';
$route['admin/facility-management/bedding/update'] = 'admin/facility-management/Property/update_bedding';
$route['admin/facility-management/bedding/detail/(:num)'] = 'admin/facility-management/Property/bedding_detail/$1';
$route['admin/facility-management/bedding/delete'] = 'admin/facility-management/Property/delete_beddings';


#Rent Schedule
$route['admin/facility-management/rent/list/(:num)'] = 'admin/facility-management/Rent/index/$1';
$route['admin/facility-management/rent/ajax-list'] = 'admin/facility-management/Rent/get_list';
$route['admin/facility-management/rent/add/(:num)'] = 'admin/facility-management/Rent/add/$1';
$route['admin/facility-management/rent/edit/(:num)'] = 'admin/facility-management/Rent/edit/$1';
$route['admin/facility-management/rent/submit'] = 'admin/facility-management/Rent/save';
$route['admin/facility-management/rent/update'] = 'admin/facility-management/Rent/update';
$route['admin/facility-management/rent/detail/(:num)'] = 'admin/facility-management/Rent/view/$1';
$route['admin/facility-management/rent/delete'] = 'admin/facility-management/Rent/delete';

#Payroll Contract
$route['admin/hr/payroll/contract'] = 'admin/new/payroll/Payroll/index_contract';

#Payroll Payrun
$route['admin/hr/payroll/payrun'] = 'admin/new/payroll/Payrun/index';
$route['admin/hr/payroll/payrun/add'] = 'admin/new/payroll/Payrun/creat';

#Payroll Payslip
$route['admin/hr/payroll/payslip'] = 'admin/new/payroll/Payslip/index';
$route['admin/hr/payroll/payslip/add'] = 'admin/new/payroll/Payslip/creat';

#Payroll Loans
$route['admin/hr/payroll/loan'] = 'admin/new/payroll/loan/index';
$route['admin/hr/payroll/loan/add'] = 'admin/new/payroll/loan/creat';

#Payroll salary-components
$route['admin/hr/payroll/salary-components'] = 'admin/new/payroll/Scomponents/index';
$route['admin/hr/payroll/salary-components/add'] = 'admin/new/payroll/Scomponents/creat';

#Payroll salary-structure
$route['admin/hr/payroll/salary-structure'] = 'admin/new/payroll/Salarystructure/index';
$route['admin/hr/payroll/salary-structure/add'] = 'admin/new/payroll/Salarystructure/creat';

# ---- Recruitment
# cv
#$route['admin/hr/recruitment/cv'] = 'admin/Cv_controller/index_cv';
$route['admin/hr/recruitment/cv-ajax'] = 'admin/Cv_controller/get_cv_list';
$route['admin/hr/recruitment/check/passport'] = 'admin/Cv_controller/ajax_check_passport';
$route['admin/hr/recruitment/check/border-entry'] = 'admin/Cv_controller/ajax_check_border_entry';
#$route['admin/hr/recruitment/cv/export-excel'] = 'admin/Export/cvExport';
#$route['admin/hr/recruitment/cv/export-iqama-excel'] = 'admin/Export/cvExportMedical';
#$route['admin/hr/recruitment/cv/add'] = 'admin/Cv_controller/add_cv';
#$route['admin/hr/recruitment/cv/submit'] = 'admin/Cv_controller/save_cv';
#$route['admin/hr/recruitment/cv/edit'] = 'admin/Cv_controller/edit_cv';
#$route['admin/hr/recruitment/cv/update'] = 'admin/Cv_controller/update_cv';
#$route['admin/hr/recruitment/cv/detail'] = 'admin/Cv_controller/cv_detail';
#$route['admin/hr/recruitment/cv/delete'] = 'admin/Cv_controller/delete_cv';
#$route['admin/hr/recruitment/cv/delete-image'] = 'admin/Cv_controller/delete_image';
#$route['admin/hr/recruitment/cv/upload-form'] = 'admin/Cv_controller/upload_certificate_form';
#$route['admin/hr/recruitment/cv/upload-medical-certificates'] = 'admin/Cv_controller/upload_medical_certificate';
#$route['admin/hr/recruitment/cv/upload-certificates'] = 'admin/Cv_controller/upload_certificate';
#$route['admin/hr/recruitment/cv/print-offer-letter'] = 'admin/Cv_controller/print_offer_letter';
#$route['admin/hr/recruitment/cv/print-security-letter'] = 'admin/Cv_controller/print_security_letter';
#$route['admin/hr/recruitment/cv/print-dl-expenses-letter'] = 'admin/Cv_controller/print_dl_letter';
#$route['admin/hr/recruitment/cv/print-backoffice-offer'] = 'admin/Cv_controller/print_backoffice_offer';
#$route['admin/hr/recruitment/cv/print-promissory-note'] = 'admin/Cv_controller/print_promissory_note';
#$route['admin/hr/recruitment/cv/food-req-form'] = 'admin/Cv_controller/print_food_req_form';
#$route['admin/hr/recruitment/cv/contract-form'] = 'admin/Cv_controller/print_contract_form';

# interview
$route['admin/hr/recruitment/interview'] = 'admin/hr-module/Interview_controller/index';
$route['admin/hr/recruitment/interview/dashboard'] = 'admin/hr-module/Interview_controller/dashboard';
$route['admin/hr/recruitment/interview-ajax'] = 'admin/hr-module/Interview_controller/get_interview_list';
$route['admin/hr/recruitment/interview/export-excel'] = 'admin/hr-module/Interview_controller/export_excel';
$route['admin/hr/recruitment/interview/add'] = 'admin/hr-module/Interview_controller/addInterviewForm';
$route['admin/hr/recruitment/interview/submit'] = 'admin/hr-module/Interview_controller/save';
$route['admin/hr/recruitment/interview/edit'] = 'admin/hr-module/Interview_controller/editInterviewForm';
$route['admin/hr/recruitment/interview/update'] = 'admin/hr-module/Interview_controller/update_interview';
$route['admin/hr/recruitment/interview/status-form'] = 'admin/hr-module/Interview_controller/status_form';
$route['admin/hr/recruitment/interview/status-update'] = 'admin/hr-module/Interview_controller/update_status';
$route['admin/hr/recruitment/interview/detail'] = 'admin/hr-module/Interview_controller/interviewDetail';
$route['admin/hr/recruitment/interview/delete'] = 'admin/hr-module/Interview_controller/delete_interview';
$route['admin/hr/recruitment/interview/delete-image'] = 'admin/hr-module/Interview_controller/delete_document';
$route['admin/hr/recruitment/interview/print-job-application-form/(:num)'] = 'admin/hr-module/Interview_controller/print_job_application_form/$1';
$route['admin/hr/recruitment/interview/print-cash-advance-letter/(:num)'] = 'admin/hr-module/Interview_controller/print_cash_advance_letter/$1';
$route['admin/hr/recruitment/interview/download-txt/(:num)'] = 'admin/hr-module/Interview_controller/download_txt/$1';

# Jahez Rent Agreement
$route['admin/logistic-management/jahez-rent'] = 'admin/logistic-management/Jahez_rent/index';
$route['admin/logistic-management/jahez-rent-ajax'] = 'admin/logistic-management/Jahez_rent/get_list';
$route['admin/logistic-management/jahez-rent/add'] = 'admin/logistic-management/Jahez_rent/add';
$route['admin/logistic-management/jahez-rent/submit'] = 'admin/logistic-management/Jahez_rent/save';
$route['admin/logistic-management/jahez-rent/edit'] = 'admin/logistic-management/Jahez_rent/edit';
$route['admin/logistic-management/jahez-rent/update'] = 'admin/logistic-management/Jahez_rent/update';
$route['admin/logistic-management/jahez-rent/detail'] = 'admin/logistic-management/Jahez_rent/detail';
$route['admin/logistic-management/jahez-rent/delete'] = 'admin/logistic-management/Jahez_rent/delete';
$route['admin/logistic-management/jahez-rent/print-rent-agreement/(:num)'] = 'admin/logistic-management/Jahez_rent/print_agreement_letter/$1';

# Food Allowance Distribution
$route['admin/hr/food-allowance/index'] = 'admin/hr-module/FoodAllowance/index';
$route['admin/hr/food-allowance/ajax-list'] = 'admin/hr-module/FoodAllowance/get_list';
$route['admin/hr/food-allowance/add-allowance-form'] = 'admin/hr-module/FoodAllowance/add_allowance_form';
$route['admin/hr/food-allowance/get-cv-list'] = 'admin/hr-module/FoodAllowance/get_employee_view';
$route['admin/hr/food-allowance/get-batch-cvs'] = 'admin/hr-module/FoodAllowance/get_batch_cv';
$route['admin/hr/food-allowance/save-form'] = 'admin/hr-module/FoodAllowance/save_allowance';
$route['admin/hr/food-allowance/update-form'] = 'admin/hr-module/FoodAllowance/update_allowance';
$route['admin/hr/food-allowance/view-batch-detail'] = 'admin/hr-module/FoodAllowance/view_batch_detail';
$route['admin/hr/food-allowance/refresh-user-allowance'] = 'admin/hr-module/FoodAllowance/refresh_user_allowance';
$route['admin/hr/food-allowance/print-detail'] = 'admin/hr-module/FoodAllowance/print_batch_detail';
$route['admin/hr/food-allowance/print-detail2'] = 'admin/hr-module/FoodAllowance/print_batch_detail_new';
$route['admin/hr/food-allowance/export-excel'] = 'admin/Export/export_food_allowance_detail';
$route['admin/hr/food-allowance/print-iqama-cost'] = 'admin/hr-module/FoodAllowance/print_iqama_cost';
$route['admin/hr/food-allowance/print-food-receipt'] = 'admin/hr-module/FoodAllowance/print_food_receipt';
$route['admin/hr/food-allowance/print-recruitment-invoice'] = 'admin/hr-module/FoodAllowance/print_recruitment_invoice';
$route['admin/hr/food-allowance/delete'] = 'admin/hr-module/FoodAllowance/delete_food_allowance';

# Employee Transfer
$route['admin/hr/employee-transfer/index'] = 'admin/hr-module/Transfer/index';
$route['admin/hr/employee-transfer/ajax-list'] = 'admin/hr-module/Transfer/get_list';
$route['admin/hr/employee-transfer/update-form'] = 'admin/hr-module/Transfer/update_form';
$route['admin/hr-module/transfer/update-status'] = 'admin/hr-module/Transfer/update_status';
$route['admin/hr/employee-transfer/view-batch-detail'] = 'admin/hr-module/Transfer/view_batch_detail';
$route['admin/hr/employee-transfer/export-excel/(:any)'] = 'admin/hr-module/Transfer/export_batch_excel/$1';
$route['admin/hr/employee-transfer/export-pdf/(:any)'] = 'admin/hr-module/Transfer/print_batch_detail/$1';
$route['admin/hr/employee-transfer/print-transfer-detail/(:any)'] = 'admin/hr-module/Transfer/print_employee_batch_detail/$1';
$route['admin/hr/employee-transfer/delete'] = 'admin/hr-module/Transfer/delete';

# Change Profession
$route['admin/hr/change-profession/index'] = 'admin/hr-module/Change_profession_controller/index';
$route['admin/hr/change-profession/ajax-list'] = 'admin/hr-module/Change_profession_controller/get_list';
$route['admin/hr/change-profession/view-batch-detail'] = 'admin/hr-module/Change_profession_controller/view_batch_detail';
#$route['admin/hr/change-profession/export-excel/(:any)'] = 'admin/hr-module/Change_profession_controller/export_batch_excel/$1';
$route['admin/hr/change-profession/export-pdf/(:any)'] = 'admin/hr-module/Change_profession_controller/print_batch_detail/$1';
$route['admin/hr/change-profession/print-profession-detail/(:any)'] = 'admin/hr-module/Change_profession_controller/print_employee_batch_detail/$1';
$route['admin/hr/change-profession/delete'] = 'admin/hr-module/Change_profession_controller/delete';

# Agency
#$route['admin/hr/master/agency/list'] = 'admin/hr/master/Hiring_agency/index';
#$route['admin/hr/master/agency/ajax-list'] = 'admin/hr/master/Hiring_agency/get_list';
#$route['admin/hr/master/agency/add'] = 'admin/hr/master/Hiring_agency/add';
#$route['admin/hr/master/agency/edit'] = 'admin/hr/master/Hiring_agency/edit';
#$route['admin/hr/master/agency/save'] = 'admin/hr/master/Hiring_agency/save';
#$route['admin/hr/master/agency/detail'] = 'admin/hr/master/Hiring_agency/detail';
#$route['admin/hr/master/agency/delete'] = 'admin/hr/master/Hiring_agency/delete';

#Instant Work Visa
$route['admin/talent-aquisition/visa'] = 'admin/Instant_visa/index';
$route['admin/talent-aquisition/visa/ajax-list'] = 'admin/Instant_visa/get_list';
$route['admin/talent-aquisition/visa/add'] = 'admin/Instant_visa/add';
$route['admin/talent-aquisition/visa/edit'] = 'admin/Instant_visa/edit';
$route['admin/talent-aquisition/visa/detail'] = 'admin/Instant_visa/detail';
$route['admin/talent-aquisition/visa/print-detail/(:num)'] = 'admin/Instant_visa/print_visa_detail/$1';
$route['admin/talent-aquisition/visa/save'] = 'admin/Instant_visa/save';
$route['admin/talent-aquisition/visa/save-visa'] = 'admin/Instant_visa/add_visas';
$route['admin/talent-aquisition/visa/update-visa'] = 'admin/Instant_visa/update_visas';
$route['admin/talent-aquisition/visas/update'] = 'admin/Instant_visa/update';
$route['admin/talent-aquisition/visa/delete'] = 'admin/Instant_visa/delete';

# Insurance Company
$route['admin/master/insurance-company/list'] = 'admin/masters/Insurance_company/index';
$route['admin/master/insurance-company/ajax-list'] = 'admin/masters/Insurance_company/get_list';
$route['admin/master/insurance-company/add'] = 'admin/masters/Insurance_company/add';
$route['admin/master/insurance-company/save'] = 'admin/masters/Insurance_company/save';
$route['admin/master/insurance-company/delete'] = 'admin/masters/Insurance_company/delete';

# Insurance Policies
$route['admin/master/insurance-policies/list'] = 'admin/masters/Insurance_policies/index';
$route['admin/master/insurance-policies/ajax-list'] = 'admin/masters/Insurance_policies/get_list';
$route['admin/master/insurance-policies/add'] = 'admin/masters/Insurance_policies/add';
$route['admin/master/insurance-policies/save'] = 'admin/masters/Insurance_policies/create';
$route['admin/master/insurance-policies/update'] = 'admin/masters/Insurance_policies/update';
$route['admin/master/insurance-policies/delete'] = 'admin/masters/Insurance_policies/delete';
$route['admin/master/insurance-policies/allotments'] = 'admin/masters/Insurance_policies/view_allotments';
$route['admin/master/insurance-policies/print-allotments/(:num)'] = 'admin/masters/Insurance_policies/print_allotment_detail/$1';

# Insurance Type
$route['admin/master/insurance-type/list'] = 'admin/masters/Insurance_type/index';
$route['admin/master/insurance-type/ajax-list'] = 'admin/masters/Insurance_type/get_list';
$route['admin/master/insurance-type/add'] = 'admin/masters/Insurance_type/add';
$route['admin/master/insurance-type/save'] = 'admin/masters/Insurance_type/save';
$route['admin/master/insurance-type/delete'] = 'admin/masters/Insurance_type/delete';

# Remuneration Company
$route['admin/hr/master/remuneration/list'] = 'admin/hr/master/Remuneration/index';
$route['admin/hr/master/remuneration/ajax-list'] = 'admin/hr/master/Remuneration/get_list';
$route['admin/hr/master/remuneration/add'] = 'admin/hr/master/Remuneration/add';
$route['admin/hr/master/remuneration/save'] = 'admin/hr/master/Remuneration/save';
$route['admin/hr/master/remuneration/delete'] = 'admin/hr/master/Remuneration/delete';

# Master Packages
$route['admin/hr/master/package/list'] = 'admin/hr/master/Packages/index';
$route['admin/hr/master/package/ajax-list'] = 'admin/hr/master/Packages/get_list';
$route['admin/hr/master/package/add'] = 'admin/hr/master/Packages/add';
$route['admin/hr/master/package/save'] = 'admin/hr/master/Packages/save';
$route['admin/hr/master/package/delete'] = 'admin/hr/master/Packages/delete';
$route['admin/hr/master/package/departmentwise_designations'] = 'admin/hr/master/Packages/get_designations';

# letter of intent
$route['admin/hr/recruitment/loi'] = 'admin/RecruitmentMaster/index_loi';
$route['admin/hr/recruitment/loi/add'] = 'admin/RecruitmentMaster/add_loi';
$route['admin/hr/recruitment/loi/submit'] = 'admin/RecruitmentMaster/save_loi';
$route['admin/hr/recruitment/loi/detail'] = 'admin/RecruitmentMaster/loi_detail';
$route['admin/hr/recruitment/loi/delete'] = 'admin/RecruitmentMaster/delete_loi';
$route['admin/hr/recruitment/loi/getCvDetail'] = 'admin/RecruitmentMaster/get_cv_detail';

# letter of unpaid internship
$route['admin/hr/recruitment/loui'] = 'admin/RecruitmentMaster/index_loui';
$route['admin/hr/recruitment/loui/add'] = 'admin/RecruitmentMaster/add_loui';
$route['admin/hr/recruitment/loui/submit'] = 'admin/RecruitmentMaster/save_loui';
$route['admin/hr/recruitment/loui/detail'] = 'admin/RecruitmentMaster/loui_detail';
$route['admin/hr/recruitment/loui/delete'] = 'admin/RecruitmentMaster/delete_loui';
$route['admin/hr/recruitment/loui/getLoiDetail'] = 'admin/RecruitmentMaster/get_loi_detail';

# contract letter
$route['admin/hr/recruitment/cl'] = 'admin/RecruitmentMaster/index_cl';
$route['admin/hr/recruitment/cl/add'] = 'admin/RecruitmentMaster/add_cl';
$route['admin/hr/recruitment/cl/submit'] = 'admin/RecruitmentMaster/save_cl';
$route['admin/hr/recruitment/cl/detail'] = 'admin/RecruitmentMaster/cl_detail';
$route['admin/hr/recruitment/cl/delete'] = 'admin/RecruitmentMaster/delete_cl';
$route['admin/hr/recruitment/cl/getLoiDetail'] = 'admin/RecruitmentMaster/get_loi_detail';

# offer letter
$route['admin/hr/recruitment/ol'] = 'admin/hr/recruitment/OfferLetter/index_ol';
$route['admin/hr/recruitment/ol/add'] = 'admin/hr/recruitment/OfferLetter/add_ol';
$route['admin/hr/recruitment/ol/submit'] = 'admin/hr/recruitment/OfferLetter/save_ol';
$route['admin/hr/recruitment/ol/detail'] = 'admin/hr/recruitment/OfferLetter/ol_detail';
$route['admin/hr/recruitment/ol/delete'] = 'admin/hr/recruitment/OfferLetter/delete_ol';
$route['admin/hr/recruitment/ol/getLoiDetail'] = 'admin/hr/recruitment/OfferLetter/get_loi_detail';
$route['admin/hr/recruitment/ol/print'] = 'admin/hr/recruitment/OfferLetter/print';

# Id Ack
$route['admin/hr/recruitment/id_ack'] = 'admin/hr/recruitment/IdAck/index_id_ack';
$route['admin/hr/recruitment/id_ack/add'] = 'admin/hr/recruitment/IdAck/add_id_ack';
$route['admin/hr/recruitment/id_ack/submit'] = 'admin/hr/recruitment/IdAck/save_id_ack';
$route['admin/hr/recruitment/id_ack/detail'] = 'admin/hr/recruitment/IdAck/id_ack_detail';
$route['admin/hr/recruitment/id_ack/delete'] = 'admin/hr/recruitment/IdAck/delete_id_ack';
$route['admin/hr/recruitment/id_ack/getCvDetail'] = 'admin/hr/recruitment/IdAck/get_cv_detail';

# sim card
$route['admin/hr/recruitment/sim-card'] = 'admin/hr/recruitment/SimCard/index';
$route['admin/hr/recruitment/sim-card/add'] = 'admin/hr/recruitment/SimCard/add';
$route['admin/hr/recruitment/sim-card/submit'] = 'admin/hr/recruitment/SimCard/save';
$route['admin/hr/recruitment/sim-card/detail'] = 'admin/hr/recruitment/SimCard/detail';
$route['admin/hr/recruitment/sim-card/delete'] = 'admin/hr/recruitment/SimCard/delete';
$route['admin/hr/recruitment/sim-card/getEmpDetail'] = 'admin/hr/recruitment/SimCard/get_emp_detail';

# Experience Letter
$route['admin/hr/recruitment/exp-letter'] = 'admin/hr/recruitment/ExpLetter/index';
$route['admin/hr/recruitment/exp-letter/add'] = 'admin/hr/recruitment/ExpLetter/add';
$route['admin/hr/recruitment/exp-letter/submit'] = 'admin/hr/recruitment/ExpLetter/save';
$route['admin/hr/recruitment/exp-letter/detail'] = 'admin/hr/recruitment/ExpLetter/detail';
$route['admin/hr/recruitment/exp-letter/delete'] = 'admin/hr/recruitment/ExpLetter/delete';
$route['admin/hr/recruitment/exp-letter/getEmpDetail'] = 'admin/hr/recruitment/ExpLetter/get_emp_detail';

# Attendance
$route['admin/hr/attendance/settings'] = 'admin/attendance/Attendance';

#Inhouse Attendance Logs
$route['admin/attendance-logs/list'] = 'admin/attendance/Attendancelog/index';
$route['admin/attendance-logs/ajax-list'] = 'admin/attendance/Attendancelog/get_ajax_list';
$route['admin/attendance-logs/edit'] = 'admin/attendance/Attendancelog/edit';
$route['admin/attendance-logs/detail'] = 'admin/attendance/Attendancelog/detail';
$route['admin/attendance-logs/delete'] = 'admin/attendance/Attendancelog/delete';
$route['admin/attendance-logs/add-attendance'] = 'admin/attendance/Attendancelog/add_attendance';
$route['admin/attendance-logs/export-pdf'] = 'admin/attendance/Attendancelog/export_attendance_log';
$route['admin/attendance-logs/export-excel'] = 'admin/Export/attendanceLogExcel';

#Holiday List
$route['admin/attendance/holidays-list'] = 'admin/attendance/Holidays_list/index';
$route['admin/attendance/holidays/ajax-list'] = 'admin/attendance/Holidays_list/get_list';
$route['admin/attendance/holidays/add'] = 'admin/attendance/Holidays_list/add';
$route['admin/attendance/holidays/edit'] = 'admin/attendance/Holidays_list/edit';
$route['admin/attendance/holidays/submit'] = 'admin/attendance/Holidays_list/save';
$route['admin/attendance/holidays/detail'] = 'admin/attendance/Holidays_list/detail';
$route['admin/attendance/holidays/delete'] = 'admin/attendance/Holidays_list/delete';
$route['admin/attendance/holidays/check-name'] = 'admin/attendance/Holidays_list/ajax_holiday_duplicate';

#Shifts
$route['admin/attendance/shift-list'] = 'admin/attendance/Shifts/index';
$route['admin/attendance/shift/ajax-list'] = 'admin/attendance/Shifts/get_list';
$route['admin/attendance/shift/add'] = 'admin/attendance/Shifts/add';
$route['admin/attendance/shift/edit'] = 'admin/attendance/Shifts/edit';
$route['admin/attendance/shift/submit'] = 'admin/attendance/Shifts/save';
$route['admin/attendance/shift/detail'] = 'admin/attendance/Shifts/detail';
$route['admin/attendance/shift/delete'] = 'admin/attendance/Shifts/delete';
$route['admin/attendance/shift/check-name'] = 'admin/attendance/Shifts/ajax_shift_duplicate';

#Leave Types New
$route['admin/hr-module/leave-types/annual-leave'] = 'admin/hr-module/leaves/Leave_types/index';
$route['admin/hr-module/leave-types/save-entitlement-days'] = 'admin/hr-module/leaves/Leave_types/save_entitlement_days';
$route['admin/hr-module/leave-types/delete-entitlement'] = 'admin/hr-module/leaves/Leave_types/delete_entitlement';
$route['admin/hr-module/leave-types/get-entitlements'] = 'admin/hr-module/leaves/Leave_types/get_entitlements';
$route['admin/hr-module/leave-types/update-leave-calculation'] = 'admin/hr-module/leaves/Leave_types/update_leave_calculation';
$route['admin/hr-module/leave-types/update-half-day'] = 'admin/hr-module/leaves/Leave_types/update_half_day';
$route['admin/hr-module/leave-types/update-starting-balance'] = 'admin/hr-module/leaves/Leave_types/update_starting_balance';
$route['admin/hr-module/leave-types/update-leave-auto-upgrade'] = 'admin/hr-module/leaves/Leave_types/update_leave_auto_upgrade';
$route['admin/hr-module/leave-types/get-employee-list'] = 'admin/hr-module/leaves/Leave_types/get_employee_view';
$route['admin/hr-module/leave-types/add-selected-employees'] = 'admin/hr-module/leaves/Leave_types/add_selected_employees';
$route['admin/hr-module/leave-types/save-auto-upgrade-settings'] = 'admin/hr-module/leaves/Leave_types/save_auto_upgrade_settings';
$route['admin/hr-module/leave-types/save-return-confirmation'] = 'admin/hr-module/leaves/Leave_types/save_return_confirmation';
$route['admin/hr-module/leave-types/save-remaining-balance'] = 'admin/hr-module/leaves/Leave_types/save_remaining_balance';

$route['admin/hr-module/leave-types/labour-law'] = 'admin/hr-module/leaves/Leave_types/labour_law';

$route['admin/hr-module/leave-types/custom-leaves'] = 'admin/hr-module/leaves/Leave_types/custom_leaves';
$route['admin/hr-module/leave-types/edit-labour-law'] = 'admin/hr-module/leaves/Leave_types/get_labour_law_form';
$route['admin/hr-module/leave-types/update-labour-law'] = 'admin/hr-module/leaves/Leave_types/update_labour_law';
$route['admin/hr-module/leave-types/update-labour-law-status'] = 'admin/hr-module/leaves/Leave_types/update_labour_law_status';

$route['admin/hr-module/leave-types/add-custom-leave-form'] = 'admin/hr-module/leaves/Leave_types/add_custom_leave_form';
$route['admin/hr-module/leave-types/edit-custom-leave-form'] = 'admin/hr-module/leaves/Leave_types/edit_custom_leave_form';
$route['admin/hr-module/leave-types/save-custom-leave'] = 'admin/hr-module/leaves/Leave_types/save_custom_leave';
$route['admin/hr-module/leave-types/update-custom-leave'] = 'admin/hr-module/leaves/Leave_types/update_custom_leave';
$route['admin/hr-module/leave-types/delete-custom-leave'] = 'admin/hr-module/leaves/Leave_types/delete_custom_leave';

#Holidays
$route['admin/hr-module/leave-types/holidays'] = 'admin/hr-module/leaves/Public_holidays/index';
$route['admin/hr-module/leave-types/add-holidays-form'] = 'admin/hr-module/leaves/Public_holidays/add_holidays_form';
$route['admin/hr-module/leave-types/edit-holidays-form'] = 'admin/hr-module/leaves/Public_holidays/edit_holidays_form';
$route['admin/hr-module/leave-types/save-holidays'] = 'admin/hr-module/leaves/Public_holidays/save_holidays';
$route['admin/hr-module/leave-types/update-holidays'] = 'admin/hr-module/leaves/Public_holidays/update_holidays';
$route['admin/hr-module/leave-types/delete-holidays'] = 'admin/hr-module/leaves/Public_holidays/delete_holidays';

#Leave Types Old
$route['admin/attendance/leave-list'] = 'admin/attendance/Leave_types/index';
$route['admin/attendance/leave/ajax-list'] = 'admin/attendance/Leave_types/get_list';
$route['admin/attendance/leave/add'] = 'admin/attendance/Leave_types/add';
$route['admin/attendance/leave/edit'] = 'admin/attendance/Leave_types/edit';
$route['admin/attendance/leave/submit'] = 'admin/attendance/Leave_types/save';
$route['admin/attendance/leave/detail'] = 'admin/attendance/Leave_types/detail';
$route['admin/attendance/leave/delete'] = 'admin/attendance/Leave_types/delete';
$route['admin/attendance/leave/check-name'] = 'admin/attendance/Leave_types/ajax_leave_duplicate';

#Leave Policies
$route['admin/attendance/leave-policy'] = 'admin/attendance/Leave_policy/index';
$route['admin/attendance/leave-policy/ajax-list'] = 'admin/attendance/Leave_policy/get_list';
$route['admin/attendance/leave-policy/add'] = 'admin/attendance/Leave_policy/add';
$route['admin/attendance/leave-policy/edit'] = 'admin/attendance/Leave_policy/edit';
$route['admin/attendance/leave-policy/submit'] = 'admin/attendance/Leave_policy/save';
$route['admin/attendance/leave-policy/detail'] = 'admin/attendance/Leave_policy/detail';
$route['admin/attendance/leave-policy/delete'] = 'admin/attendance/Leave_policy/delete';
$route['admin/attendance/leave-policy/check-name'] = 'admin/attendance/Leave_policy/ajax_title_duplicate';

#Attendance Restrictions
$route['admin/attendance/restriction-list'] = 'admin/attendance/Attendance_restrictions/index';
$route['admin/attendance/restriction/ajax-list'] = 'admin/attendance/Attendance_restrictions/get_list';
$route['admin/attendance/restriction/add'] = 'admin/attendance/Attendance_restrictions/add';
$route['admin/attendance/restriction/edit'] = 'admin/attendance/Attendance_restrictions/edit';
$route['admin/attendance/restriction/submit'] = 'admin/attendance/Attendance_restrictions/save';
$route['admin/attendance/restriction/detail'] = 'admin/attendance/Attendance_restrictions/detail';
$route['admin/attendance/restriction/delete'] = 'admin/attendance/Attendance_restrictions/delete';
$route['admin/attendance/restriction/check-name'] = 'admin/attendance/Attendance_restrictions/ajax_title_duplicate';

#Logistic Riders
$route['admin/logistic-management/rider/list'] = 'admin/logistic-management/Rider_profile/index';
$route['admin/logistic-management/rider/add'] = 'admin/logistic-management/Rider_profile/add';
$route['admin/logistic-management/rider/get-platform-ids'] = 'admin/logistic-management/Rider_profile/getPlatformIds';
$route['admin/logistic-management/rider/get-aggregator-id-detail'] = 'admin/logistic-management/Rider_profile/getAggregatorIdDetail';
$route['admin/logistic-management/rider/search-emp'] = 'admin/logistic-management/Rider_profile/get_employee_detail';
$route['admin/logistic-management/rider/ajax-list'] = 'admin/logistic-management/Rider_profile/get_ajax_list';
$route['admin/logistic-management/rider/edit'] = 'admin/logistic-management/Rider_profile/edit';
$route['admin/logistic-management/rider/submit'] = 'admin/logistic-management/Rider_profile/save';
$route['admin/logistic-management/rider/update'] = 'admin/logistic-management/Rider_profile/update';
$route['admin/logistic-management/rider/detail'] = 'admin/logistic-management/Rider_profile/detail';
$route['admin/logistic-management/rider/transfer'] = 'admin/logistic-management/Rider_profile/profile_transfer';
$route['admin/logistic-management/rider/save-transfer'] = 'admin/logistic-management/Rider_profile/save_transfer_data';
$route['admin/logistic-management/rider/suspend'] = 'admin/logistic-management/Rider_profile/profile_suspend';
$route['admin/logistic-management/rider/save-suspend'] = 'admin/logistic-management/Rider_profile/save_suspend_data';
$route['admin/logistic-management/rider/unallot'] = 'admin/logistic-management/Rider_profile/unallotId';
$route['admin/logistic-management/rider/save-unallot'] = 'admin/logistic-management/Rider_profile/saveUnallotment';
$route['admin/logistic-management/rider/allot'] = 'admin/logistic-management/Rider_profile/allotId';
$route['admin/logistic-management/rider/save-allot'] = 'admin/logistic-management/Rider_profile/saveAllotment';
$route['admin/logistic-management/rider/check-id-allotment'] = 'admin/logistic-management/Rider_profile/check_id_number';
$route['admin/logistic-management/rider/check-empid'] = 'admin/logistic-management/Rider_profile/ajax_check_empid';
$route['admin/logistic-management/rider/delete'] = 'admin/logistic-management/Rider_profile/delete';
$route['admin/logistic-management/rider/print-employement-contract'] = 'admin/logistic-management/riderProfile/print_employement_contract';
$route['admin/logistic-management/rider/print-vehicle-ack-receipt'] = 'admin/logistic-management/riderProfile/print_vehicle_ack_receipt';
$route['admin/logistic-management/rider/export-excel'] = 'admin/Export/riderExport';
$route['admin/logistic-management/rider/print-overall-deliv-report'] = 'admin/logistic-management/Rider_profile/print_overall_deliv_report';

#Logistic Platform Ids
$route['admin/logistic-management/platform-id'] = 'admin/logistic-management/Logistic_ids/index';
$route['admin/logistic-management/platform-id/list'] = 'admin/logistic-management/Logistic_ids/index';
$route['admin/logistic-management/platform/ajax-list'] = 'admin/logistic-management/Logistic_ids/get_ajax_list';
$route['admin/logistic-management/platform-id/add'] = 'admin/logistic-management/Logistic_ids/add';
$route['admin/logistic-management/platform-id/submit'] = 'admin/logistic-management/Logistic_ids/save';
$route['admin/logistic-management/platform-id/edit'] = 'admin/logistic-management/Logistic_ids/edit';
$route['admin/logistic-management/platform-id/update'] = 'admin/logistic-management/Logistic_ids/update';
$route['admin/logistic-management/platform-id/detail'] = 'admin/logistic-management/Logistic_ids/detail';
$route['admin/logistic-management/platform-id/fetch-filter-data'] = 'admin/logistic-management/Logistic_ids/fetch_filter_data';
$route['admin/logistic-management/platform-id/delete'] = 'admin/logistic-management/Logistic_ids/delete';
$route['admin/logistic-management/platform-id/export-excel'] = 'admin/Export/aggregatorDetailExport';

#Logistic Riders Logs
$route['admin/logistic-management/rider/transfer-log'] = 'admin/logistic-management/Rider_log/index';
$route['admin/logistic-management/rider/transfer-ajax-list'] = 'admin/logistic-management/Rider_log/get_ajax_list';

$route['admin/logistic-management/rider/allot-unallot-log'] = 'admin/logistic-management/Rider_log/swap_index';
$route['admin/logistic-management/rider/swap-ajax-list'] = 'admin/logistic-management/Rider_log/get_swap_ajax_list';

$route['admin/logistic-management/rider/suspend-log'] = 'admin/logistic-management/Rider_log/suspend_index';
$route['admin/logistic-management/rider/suspend-ajax-list'] = 'admin/logistic-management/Rider_log/get_suspend_ajax_list';
$route['admin/logistic-management/rider/print-suspend-report'] = 'admin/logistic-management/Rider_log/printMonthlySuspendLogs';
$route['admin/logistic-management/rider/print-daily-suspend-report'] = 'admin/logistic-management/Rider_log/printDailySuspendLogs';

# Master Reasons
$route['admin/master/master-reason'] = 'admin/masters/Reasons_master/index';
$route['admin/master/master-reason/get-list'] = 'admin/masters/Reasons_master/get_list';
$route['admin/master/master-reason/add'] = 'admin/masters/Reasons_master/add';
$route['admin/master/master-reason/edit'] = 'admin/masters/Reasons_master/edit';
$route['admin/master/master-reason/save'] = 'admin/masters/Reasons_master/save';
$route['admin/master/master-reason/update'] = 'admin/masters/Reasons_master/update';
$route['admin/master/master-reason/delete'] = 'admin/masters/Reasons_master/delete';

#Employed Riders
$route['admin/employed-rider/list'] = 'admin/Employed_riders/index';
$route['admin/employed-rider/add'] = 'admin/Employed_riders/add';
$route['admin/employed-rider/edit'] = 'admin/Employed_riders/edit';
$route['admin/employed-rider/submit'] = 'admin/Employed_riders/save';
$route['admin/employed-rider/update'] = 'admin/Employed_riders/update';
$route['admin/employed-rider/detail'] = 'admin/Employed_riders/detail';
$route['admin/employed-rider/check-empid'] = 'admin/Employed_riders/ajax_check_empid';
$route['admin/employed-rider/delete'] = 'admin/Employed_riders/delete';
$route['admin/employed-rider/print-employement-contract'] = 'admin/Employed_riders/print_employement_contract';
$route['admin/employed-rider/print-vehicle-ack-receipt'] = 'admin/Employed_riders/print_vehicle_ack_receipt';

#Import Jahez Riders Order Summary
$route['admin/logistic-management/jahez/index'] = 'admin/logistic-management/Jahez/index';
$route['admin/logistic-management/jahez/get-report'] = 'admin/logistic-management/Jahez/get_report';
$route['admin/logistic-management/jahez/print-report'] = 'admin/logistic-management/Jahez/print_report';
$route['admin/logistic-management/jahez/print-detail-report'] = 'admin/logistic-management/Jahez/print_detail_report';
$route['admin/logistic-management/jahez/print-modal/(:any)'] = 'admin/logistic-management/Jahez/print_modal_form/$1';
$route['admin/logistic-management/jahez/print-daywise-summary'] = 'admin/logistic-management/Jahez/print_daywise_report';
$route['admin/logistic-management/jahez/print-weekly-summary'] = 'admin/logistic-management/Jahez/print_weekly_report';
$route['admin/logistic-management/jahez/print-monthly-summary'] = 'admin/logistic-management/Jahez/print_monthly_performance';
$route['admin/logistic-management/jahez/upload'] = 'admin/logistic-management/Jahez/upload';
$route['admin/logistic-management/jahez/import'] = 'admin/logistic-management/Jahez/import_file';
$route['admin/logistic-management/jahez/ajax-list'] = 'admin/logistic-management/Jahez/get_list';
$route['admin/logistic-management/jahez/delete'] = 'admin/logistic-management/Jahez/delete';

#New Jahez Riders Order Summary
$route['admin/logistic-management/new-jahez/list'] = 'admin/logistic-management/NewJahez/list_page';
$route['admin/logistic-management/new-jahez/get-report'] = 'admin/logistic-management/NewJahez/get_report';
$route['admin/logistic-management/new-jahez/import'] = 'admin/logistic-management/NewJahez/import_file';
$route['admin/logistic-management/new-jahez/ajax-list'] = 'admin/logistic-management/NewJahez/get_list';
$route['admin/logistic-management/new-jahez/upload'] = 'admin/logistic-management/NewJahez/upload';
$route['admin/logistic-management/new-jahez/delete'] = 'admin/logistic-management/NewJahez/delete';
$route['admin/logistic-management/new-jahez/delete-datewise'] = 'admin/logistic-management/NewJahez/delete_by_date';
$route['admin/logistic-management/new-jahez/print-order-summary'] = 'admin/logistic-management/NewJahez/print_monthly_performance';
$route['admin/logistic-management/new-jahez/export-daily-summary'] = 'admin/logistic-management/NewJahez/export_order_data';
$route['admin/logistic-management/new-jahez/print-daily-performance'] = 'admin/logistic-management/NewJahez/print_daily_performance';
$route['admin/logistic-management/new-jahez/print-daywise-performance'] = 'admin/logistic-management/NewJahez/print_daywise_report';
$route['admin/logistic-management/new-jahez/print-weekly-performance'] = 'admin/logistic-management/NewJahez/print_weekly_report';
$route['admin/logistic-management/new-jahez/print-monthly-performance'] = 'admin/logistic-management/NewJahez/print_monthly_performance';
$route['admin/logistic-management/new-jahez/print-monthly-revenue'] = 'admin/logistic-management/NewJahez/print_monthly_revenue';
$route['admin/logistic-management/new-jahez/print-cash-summary'] = 'admin/logistic-management/NewJahez/print_cash_report';

#Import Keeta Riders Order Summary
$route['admin/logistic-management/keeta/index'] = 'admin/logistic-management/Keeta/index';
$route['admin/logistic-management/keeta/get-report'] = 'admin/logistic-management/Keeta/get_report';
$route['admin/logistic-management/keeta/print-report'] = 'admin/logistic-management/Keeta/print_report';
$route['admin/logistic-management/keeta/upload'] = 'admin/logistic-management/Keeta/upload';
$route['admin/logistic-management/keeta/import'] = 'admin/logistic-management/Keeta/import_file';
$route['admin/logistic-management/keeta/ajax-list'] = 'admin/logistic-management/Keeta/get_list';
$route['admin/logistic-management/keeta/delete'] = 'admin/logistic-management/Keeta/delete';

#Noon Sales Data New
$route['admin/logistic-management/noon/list'] = 'admin/logistic-management/noon/Noon_order_summary/index';
$route['admin/logistic-management/noon/ajax-list'] = 'admin/logistic-management/noon/Noon_order_summary/ajax_list';
$route['admin/logistic-management/noon/import-file'] = 'admin/logistic-management/noon/Noon_order_summary/import_file';
$route['admin/logistic-management/noon/detail/(:num)'] = 'admin/logistic-management/noon/Noon_order_summary/detail/$1';
$route['admin/logistic-management/noon/delete'] = 'admin/logistic-management/noon/Noon_order_summary/delete';
$route['admin/logistic-management/noon/print-order-summary'] = 'admin/logistic-management/noon/Noon_order_summary/print_monthly_performance';
$route['admin/logistic-management/noon/export-daily-summary'] = 'admin/logistic-management/noon/Noon_order_summary/export_order_data';

#Noon Penelty Data New
$route['admin/logistic-management/noon-penelty/list'] = 'admin/logistic-management/noon/Noon_penelty/index';
$route['admin/logistic-management/noon-penelty/ajax-list'] = 'admin/logistic-management/noon/Noon_penelty/ajax_list';
$route['admin/logistic-management/noon-penelty/import-file'] = 'admin/logistic-management/noon/Noon_penelty/import_file';
$route['admin/logistic-management/noon-penelty/detail/(:num)'] = 'admin/logistic-management/noon/Noon_penelty/detail/$1';
$route['admin/logistic-management/noon-penelty/delete'] = 'admin/logistic-management/noon/Noon_penelty/delete';
$route['admin/logistic-management/noon-penelty/print-daily-panelty'] = 'admin/logistic-management/noon/Noon_penelty/print_panelty_report';
$route['admin/logistic-management/noon-penelty/export-daily-panelty'] = 'admin/logistic-management/noon/Noon_penelty/export_panelty_report';

#Noon COD Data New
$route['admin/logistic-management/noon-cod/list'] = 'admin/logistic-management/noon/Noon_cod_summary/index';
$route['admin/logistic-management/noon-cod/ajax-list'] = 'admin/logistic-management/noon/Noon_cod_summary/ajax_list';
$route['admin/logistic-management/noon-cod/import-file'] = 'admin/logistic-management/noon/Noon_cod_summary/import_file';
$route['admin/logistic-management/noon-cod/detail/(:num)'] = 'admin/logistic-management/noon/Noon_cod_summary/detail/$1';
$route['admin/logistic-management/noon-cod/delete'] = 'admin/logistic-management/noon/Noon_cod_summary/delete';
$route['admin/logistic-management/noon-cod/print-cod-report'] = 'admin/logistic-management/noon/Noon_cod_summary/print_monthly_performance';
$route['admin/logistic-management/noon-cod/export-cod-report'] = 'admin/logistic-management/noon/Noon_cod_summary/export_order_data';

#Import Hunger Riders Order Summary
$route['admin/logistic-management/hunger/list'] = 'admin/logistic-management/Hunger/index';
$route['admin/logistic-management/hunger/ajax-list'] = 'admin/logistic-management/Hunger/get_list';
$route['admin/logistic-management/hunger/get-report'] = 'admin/logistic-management/Hunger/get_report';
$route['admin/logistic-management/hunger/get-daywise-report'] = 'admin/logistic-management/Hunger/get_daywise_report';
$route['admin/logistic-management/hunger/get-userwise-report'] = 'admin/logistic-management/Hunger/get_userwise_report';
$route['admin/logistic-management/hunger/print-report'] = 'admin/logistic-management/Hunger/print_daily_performance';
$route['admin/logistic-management/hunger/print-report2'] = 'admin/logistic-management/Hunger/print_daily_performance2';
$route['admin/logistic-management/hunger/weekly-report'] = 'admin/logistic-management/Hunger/weekly_report';
$route['admin/logistic-management/hunger/export-excel'] = 'admin/Export/hungerReportExcel';
$route['admin/logistic-management/hunger/upload'] = 'admin/logistic-management/Hunger/upload';
$route['admin/logistic-management/hunger/import'] = 'admin/logistic-management/Hunger/import_file';
$route['admin/logistic-management/hunger/delete'] = 'admin/logistic-management/Hunger/delete';
$route['admin/logistic-management/hunger/delete-datewise'] = 'admin/logistic-management/Hunger/delete_by_date';

$route['admin/logistic-management/hunger/compliance-list'] = 'admin/logistic-management/Hunger_compliances/index';
$route['admin/logistic-management/hunger/compliance-ajax-list'] = 'admin/logistic-management/Hunger_compliances/get_list';
$route['admin/logistic-management/hunger/compliance-import'] = 'admin/logistic-management/Hunger_compliances/import_file';
$route['admin/logistic-management/hunger/compliance-delete'] = 'admin/logistic-management/Hunger_compliances/delete';

$route['admin/logistic-management/hunger/wallet-report'] = 'admin/logistic-management/Hunger_wallet/index';
$route['admin/logistic-management/hunger/wallet-report-list'] = 'admin/logistic-management/Hunger_wallet/get_list';
$route['admin/logistic-management/hunger/wallet-import'] = 'admin/logistic-management/Hunger_wallet/import_file';
$route['admin/logistic-management/hunger/wallet-delete'] = 'admin/logistic-management/Hunger_wallet/delete';

$route['admin/logistic-management/hunger/invoice-list'] = 'admin/logistic-management/Hunger_invoices/index';
$route['admin/logistic-management/hunger/invoice-ajax-list'] = 'admin/logistic-management/Hunger_invoices/get_list';
$route['admin/logistic-management/hunger/invoice-import'] = 'admin/logistic-management/Hunger_invoices/import_file';
$route['admin/logistic-management/hunger/invoice-delete'] = 'admin/logistic-management/Hunger_invoices/delete';
$route['admin/logistic-management/hunger/invoice-print'] = 'admin/logistic-management/Hunger_invoices/print_invoice';
$route['admin/logistic-management/hunger/print-acceptance-report'] = 'admin/logistic-management/Hunger_invoices/avgRiderAcceptance';

#Hunger Team
$route['admin/logistic-management/hunger/hunger-team'] = 'admin/logistic-management/Hunger_team/index';
$route['admin/logistic-management/hunger/team-list'] = 'admin/logistic-management/Hunger_team/get_teams';
$route['admin/logistic-management/hunger/team-create'] = 'admin/logistic-management/Hunger_team/create_team';
$route['admin/logistic-management/hunger/team-delete'] = 'admin/logistic-management/Hunger_team/delete_team';
$route['admin/logistic-management/hunger/team-view'] = 'admin/logistic-management/Hunger_team/view_team';
$route['admin/logistic-management/hunger/get_team_member'] = 'admin/logistic-management/Hunger_team/get_team_member';
$route['admin/logistic-management/hunger/team_edit'] = 'admin/logistic-management/Hunger_team/team_edit';
$route['admin/logistic-management/hunger/team_update'] = 'admin/logistic-management/Hunger_team/team_update';
$route['admin/logistic-management/hunger/team_member_remove'] = 'admin/logistic-management/Hunger_team/team_member_remove';
$route['admin/logistic-management/hunger/team_member_move'] = 'admin/logistic-management/Hunger_team/team_member_move';
$route['admin/logistic-management/hunger/team_member_moveUpdate'] = 'admin/logistic-management/Hunger_team/team_member_moveUpdate';
$route['admin/logistic-management/hunger/get_team_leader'] = 'admin/logistic-management/Hunger_team/get_team_leader';
$route['admin/logistic-management/hunger/print-hunger-team'] = 'admin/logistic-management/Hunger_team/print_hunger_team';
$route['admin/logistic-management/hunger/print-hunger-team-attendance/(:num)'] = 'admin/logistic-management/Hunger_team/print_hunger_team_attendance/$1';
$route['admin/logistic-management/hunger/export-hunger-team/(:num)'] = 'admin/Export/hungerTeamExport/$1';

#Form Center
$route['admin/form-center/list'] = 'admin/form-center/Form_center/index';
$route['admin/form-center/list-ajax'] = 'admin/form-center/Form_center/get_list';
$route['admin/form-center/add'] = 'admin/form-center/Form_center/create';
$route['admin/form-center/search-emp'] = 'admin/form-center/Form_center/create';
$route['admin/form-center/save'] = 'admin/form-center/Form_center/store';
$route['admin/form-center/edit'] = 'admin/form-center/Form_center/edit';
$route['admin/form-center/update'] = 'admin/form-center/Form_center/update';
$route['admin/form-center/detail'] = 'admin/form-center/Form_center/detail';
$route['admin/form-center/delete'] = 'admin/form-center/Form_center/delete';
$route['admin/form-center/print-detail'] = 'admin/form-center/Form_center/print_form_detail';
$route['admin/form-center/payment-request-form'] = 'admin/form-center/Form_center/print_form_detail2';
$route['admin/form-center/check-warning-issued'] = 'admin/form-center/Form_center/check_warning_issued';

#Request and Approvals
$route['admin/hr-module/request'] = 'admin/hr-module/requests/Leaves/index';
$route['admin/hr-module/request/leave'] = 'admin/hr-module/requests/Leaves/index';
$route['admin/hr-module/request/add-leave-form'] = 'admin/hr-module/requests/Leaves/add_leave_form';
$route['admin/hr-module/request/edit-leave-form'] = 'admin/hr-module/requests/Leaves/edit_leave_form';
$route['admin/hr-module/request/save-leave'] = 'admin/hr-module/requests/Leaves/save_leave_approval';
$route['admin/hr-module/request/update-leave'] = 'admin/hr-module/requests/Leaves/update_leave_approval';
$route['admin/hr-module/request/delete-leave'] = 'admin/hr-module/requests/Leaves/delete_leave_approval';

#Loan Approval
$route['admin/hr-module/request/loans'] = 'admin/hr-module/requests/Loans/index';
$route['admin/hr-module/request/add-loan-form'] = 'admin/hr-module/requests/Loans/add_form';
$route['admin/hr-module/request/get-employee-list'] = 'admin/hr-module/requests/Loans/get_employee_view';
$route['admin/hr-module/request/edit-loan-form'] = 'admin/hr-module/requests/Loans/edit_form';
$route['admin/hr-module/request/save-loan'] = 'admin/hr-module/requests/Loans/save_approval';
$route['admin/hr-module/request/update-loan'] = 'admin/hr-module/requests/Loans/update_approval';
$route['admin/hr-module/request/delete-loan'] = 'admin/hr-module/requests/Loans/delete_approval';

#DL Approval
$route['admin/hr-module/request/driving-licence'] = 'admin/hr-module/requests/Driving_licence/index';
$route['admin/hr-module/request/driving-licence/add-form'] = 'admin/hr-module/requests/Driving_licence/add_form';
$route['admin/hr-module/request/driving-licence/get-employee-list'] = 'admin/hr-module/requests/Driving_licence/get_employee_view';
$route['admin/hr-module/request/driving-licence/edit-form'] = 'admin/hr-module/requests/Driving_licence/edit_form';
$route['admin/hr-module/request/driving-licence/save'] = 'admin/hr-module/requests/Driving_licence/save_approval';
$route['admin/hr-module/request/driving-licence/update'] = 'admin/hr-module/requests/Driving_licence/update_approval';
$route['admin/hr-module/request/driving-licence/delete'] = 'admin/hr-module/requests/Driving_licence/delete_approval';

#Vehicle Allotment Approval
$route['admin/hr-module/request/vehicle-allotment'] = 'admin/hr-module/requests/Vehicle_allotment/index';
$route['admin/hr-module/request/vehicle-allotment/add-form'] = 'admin/hr-module/requests/Vehicle_allotment/add_form';
$route['admin/hr-module/request/vehicle-allotment/get-employee-list'] = 'admin/hr-module/requests/Vehicle_allotment/get_employee_view';
$route['admin/hr-module/request/vehicle-allotment/edit-form'] = 'admin/hr-module/requests/Vehicle_allotment/edit_form';
$route['admin/hr-module/request/vehicle-allotment/save'] = 'admin/hr-module/requests/Vehicle_allotment/save_approval';
$route['admin/hr-module/request/vehicle-allotment/update'] = 'admin/hr-module/requests/Vehicle_allotment/update_approval';
$route['admin/hr-module/request/vehicle-allotment/delete'] = 'admin/hr-module/requests/Vehicle_allotment/delete_approval';

#Transfer Approval
$route['admin/hr-module/request/transfer'] = 'admin/hr-module/requests/Transfers/index';
$route['admin/hr-module/request/transfer/add-form'] = 'admin/hr-module/requests/Transfers/add_form';
$route['admin/hr-module/request/transfer/get-employee-list'] = 'admin/hr-module/requests/Transfers/get_employee_view';
$route['admin/hr-module/request/transfer/edit-form'] = 'admin/hr-module/requests/Transfers/edit_form';
$route['admin/hr-module/request/transfer/save'] = 'admin/hr-module/requests/Transfers/save_approval';
$route['admin/hr-module/request/transfer/update'] = 'admin/hr-module/requests/Transfers/update_approval';
$route['admin/hr-module/request/transfer/delete'] = 'admin/hr-module/requests/Transfers/delete_approval';

#Change Profession Approval
$route['admin/hr-module/request/change-profession'] = 'admin/hr-module/requests/Change_profession/index';
$route['admin/hr-module/request/change-profession/add-form'] = 'admin/hr-module/requests/Change_profession/add_form';
$route['admin/hr-module/request/change-profession/get-employee-list'] = 'admin/hr-module/requests/Change_profession/get_employee_view';
$route['admin/hr-module/request/change-profession/edit-form'] = 'admin/hr-module/requests/Change_profession/edit_form';
$route['admin/hr-module/request/change-profession/save'] = 'admin/hr-module/requests/Change_profession/save_approval';
$route['admin/hr-module/request/change-profession/update'] = 'admin/hr-module/requests/Change_profession/update_approval';
$route['admin/hr-module/request/change-profession/delete'] = 'admin/hr-module/requests/Change_profession/delete_approval';

#Notice/Warning Approval
$route['admin/hr-module/request/notice-warning'] = 'admin/hr-module/requests/Notice_warning/index';
$route['admin/hr-module/request/notice-warning/add-form'] = 'admin/hr-module/requests/Notice_warning/add_form';
$route['admin/hr-module/request/notice-warning/get-employee-list'] = 'admin/hr-module/requests/Notice_warning/get_employee_view';
$route['admin/hr-module/request/notice-warning/edit-form'] = 'admin/hr-module/requests/Notice_warning/edit_form';
$route['admin/hr-module/request/notice-warning/save'] = 'admin/hr-module/requests/Notice_warning/save_approval';
$route['admin/hr-module/request/notice-warning/update'] = 'admin/hr-module/requests/Notice_warning/update_approval';
$route['admin/hr-module/request/notice-warning/delete'] = 'admin/hr-module/requests/Notice_warning/delete_approval';

#Dispute Approval
$route['admin/hr-module/request/disputes'] = 'admin/hr-module/requests/Disputes/index';
$route['admin/hr-module/request/disputes/add-form'] = 'admin/hr-module/requests/Disputes/add_form';
$route['admin/hr-module/request/disputes/get-employee-list'] = 'admin/hr-module/requests/Disputes/get_employee_view';
$route['admin/hr-module/request/disputes/edit-form'] = 'admin/hr-module/requests/Disputes/edit_form';
$route['admin/hr-module/request/disputes/save'] = 'admin/hr-module/requests/Disputes/save_approval';
$route['admin/hr-module/request/disputes/update'] = 'admin/hr-module/requests/Disputes/update_approval';
$route['admin/hr-module/request/disputes/delete'] = 'admin/hr-module/requests/Disputes/delete_approval';

#Team Request and Approvals
$route['admin/hr-module/requests/team-requests/(:any)'] = 'admin/hr-module/request-approvals/Team_requests/index/$1';
$route['admin/hr-module/requests/request-detail'] = 'admin/hr-module/request-approvals/Team_requests/request_detail';
$route['admin/hr-module/requests/save-comment'] = 'admin/hr-module/request-approvals/Team_requests/save_comment';
$route['admin/hr-module/requests/get-comments'] = 'admin/hr-module/request-approvals/Team_requests/get_comments';
$route['admin/hr-module/requests/get-correction-form'] = 'admin/hr-module/request-approvals/Team_requests/get_correction_form';
$route['admin/hr-module/requests/save-correction'] = 'admin/hr-module/request-approvals/Team_requests/save_correction_comment';
$route['admin/hr-module/requests/get-status-form'] = 'admin/hr-module/request-approvals/Team_requests/get_status_form';
$route['admin/hr-module/requests/update-request-status'] = 'admin/hr-module/request-approvals/Team_requests/update_request_status';
$route['admin/hr-module/requests/approve-request-status'] = 'admin/hr-module/request-approvals/Team_requests/approve_request_status';
$route['admin/hr-module/requests/reject-request-status'] = 'admin/hr-module/request-approvals/Team_requests/reject_request_status';
$route['admin/hr-module/requests/get-correction'] = 'admin/hr-module/request-approvals/Team_requests/get_correction_comments';
$route['admin/hr-module/requests/download-request-docs'] = 'admin/hr-module/request-approvals/Team_requests/download_documents';
$route['admin/hr-module/requests/view-request-docs'] = 'admin/hr-module/request-approvals/Team_requests/view_all_docs';

$route['admin/hr-module/requests/edit-team-request/(:num)'] = 'admin/hr-module/request-approvals/Team_requests/get_team_request_data/$1';
$route['admin/hr-module/requests/update-loan'] = 'admin/hr-module/request-approvals/Team_requests/update_loan_request';
$route['admin/hr-module/requests/print-warning-request/(:num)'] = 'admin/hr-module/request-approvals/Team_requests/print_warning_notices/$1';

# Payment Request Form
$route['admin/finance/payment-request'] = 'admin/finance/payment_request/index';
$route['admin/finance/payment-request/add'] = 'admin/finance/payment_request/create';
$route['admin/finance/payment-request/fetch-filter-data'] = 'admin/finance/payment_request/fetch_filter_data';
$route['admin/finance/payment-request/edit/(:any)'] = 'admin/finance/payment_request/edit/$1';
$route['admin/finance/payment-request/detail/(:any)'] = 'admin/finance/payment_request/detail/$1';
$route['admin/finance/payment-request/save'] = 'admin/finance/payment_request/store';
$route['admin/finance/payment-request/update'] = 'admin/finance/payment_request/update';
$route['admin/finance/payment-request/payment-update-form'] = 'admin/finance/payment_request/quick_update';
$route['admin/finance/payment-request/payment-update'] = 'admin/finance/payment_request/payment_status_update';
$route['admin/finance/payment-request/list-ajax'] = 'admin/finance/payment_request/get_list';
$route['admin/finance/payment-request/get-employees-vendor'] = 'admin/finance/payment_request/getOptionsByType';
$route['admin/finance/payment-request/get-requester'] = 'admin/finance/payment_request/get_requester_details';
$route['admin/finance/payment-request/get-bank-details'] = 'admin/finance/payment_request/getUserBankDetails';
$route['admin/finance/payment-request/payment-request-print/(:any)'] = 'admin/finance/payment_request/print_form_detail/$1';
$route['admin/finance/payment-request/print-personal-finance/(:any)'] = 'admin/finance/payment_request/print_personal_finance_detail/$1';

#Shift Masters
$route['admin/logistic-management/hunger/hunger-shift'] = 'admin/logistic-management/ShiftMaster/index';
$route['admin/logistic-management/hunger/get-shift'] = 'admin/logistic-management/ShiftMaster/get_shifts';
$route['admin/logistic-management/hunger/create-shift'] = 'admin/logistic-management/ShiftMaster/create_shift';
$route['admin/logistic-management/hunger/edit-shift'] = 'admin/logistic-management/ShiftMaster/update_shift';
$route['admin/logistic-management/hunger/delete-shift'] = 'admin/logistic-management/ShiftMaster/delete_shift';

#Area Masters
$route['admin/logistic-management/hunger/hunger-area'] = 'admin/logistic-management/AreaMaster/index';
$route['admin/logistic-management/hunger/get-area'] = 'admin/logistic-management/AreaMaster/get_areas';
$route['admin/logistic-management/hunger/create-area'] = 'admin/logistic-management/AreaMaster/create_area';
$route['admin/logistic-management/hunger/edit-area'] = 'admin/logistic-management/AreaMaster/update_area';
$route['admin/logistic-management/hunger/delete-area'] = 'admin/logistic-management/AreaMaster/delete_area';

#Shift Management
$route['admin/logistic-management/hunger/rider-shift'] = 'admin/logistic-management/ShiftController/index';
$route['admin/logistic-management/hunger/get-riders-shift'] = 'admin/logistic-management/ShiftController/get_riders_shift';
$route['admin/logistic-management/hunger/search-rider'] = 'admin/logistic-management/ShiftController/search_rider';
$route['admin/logistic-management/hunger/riders-check-availability'] = 'admin/logistic-management/ShiftController/rider_check_availability';
$route['admin/logistic-management/hunger/rider-shift-assign'] = 'admin/logistic-management/ShiftController/shiftAssign';
$route['admin/logistic-management/hunger/rider-shift-change-get'] = 'admin/logistic-management/ShiftController/getShiftChange';
$route['admin/logistic-management/hunger/rider-shift-delete'] = 'admin/logistic-management/ShiftController/shiftDelete';
$route['admin/logistic-management/hunger/rider-shift-swap'] = 'admin/logistic-management/ShiftController/shiftSwap';


#Shift Report print
$route['admin/logistic-management/hunger/search-team_leader'] = 'admin/logistic-management/ShiftController/searchTeamLeader';
$route['admin/logistic-management/hunger/print-weekly-shift'] = 'admin/logistic-management/ShiftController/print_weeklyShiftReport';
$route['admin/logistic-management/hunger/print-daily-shift'] = 'admin/logistic-management/ShiftController/print_dailyShiftReport';

#Import Hunger Riders Reports
$route['admin/logistic-management/hunger/monthly-report'] = 'admin/logistic-management/Hunger/print_monthly_performance';
$route['admin/logistic-management/hunger/monthly-revenue-report'] = 'admin/logistic-management/Hunger/print_monthly_revenue';

#Import Petrol Summary
$route['admin/petrol-summary/index'] = 'admin/Petrol/index';
$route['admin/petrol-summary/ajax-list'] = 'admin/Petrol/get_list';
$route['admin/petrol-summary/upload'] = 'admin/Petrol/upload';
$route['admin/petrol-summary/import'] = 'admin/Petrol/import_file';
$route['admin/petrol-summary/delete'] = 'admin/Petrol/delete';

#Incentives Master
$route['admin/incentives/list'] = 'admin/Incentives/index';
$route['admin/incentives/ajax-list'] = 'admin/Incentives/get_list';
$route['admin/incentives/add'] = 'admin/Incentives/add';
$route['admin/incentives/edit'] = 'admin/Incentives/edit';
$route['admin/incentives/submit'] = 'admin/Incentives/save';
$route['admin/incentives/update'] = 'admin/Incentives/update';
$route['admin/incentives/update-status'] = 'admin/Incentives/update_status';
$route['admin/incentives/delete'] = 'admin/Incentives/delete';
$route['admin/incentives/export-data-pdf'] = 'admin/Incentives/Export_pdf_all';
$route['admin/incentives/export-detail-pdf/(:num)'] = 'admin/Incentives/Export_pdf_single/$1';

#Cash Collection
$route['admin/logistic-management/cash-collection/list'] = 'admin/logistic-management/Cash_collection/index';
$route['admin/logistic-management/cash-collection/add'] = 'admin/logistic-management/Cash_collection/add';
$route['admin/logistic-management/cash-collection/emp-list'] = 'admin/logistic-management/Cash_collection/search_employee';
$route['admin/logistic-management/cash-collection/search-emp'] = 'admin/logistic-management/Cash_collection/get_employee_detail';
$route['admin/logistic-management/cash-collection/ajax-list'] = 'admin/logistic-management/Cash_collection/get_ajax_list';
$route['admin/logistic-management/cash-collection/monthly-filter/(:any)'] = 'admin/logistic-management/Cash_collection/filter_modal_form/$1';
$route['admin/logistic-management/cash-collection/edit'] = 'admin/logistic-management/Cash_collection/edit';
$route['admin/logistic-management/cash-collection/submit'] = 'admin/logistic-management/Cash_collection/save';
$route['admin/logistic-management/cash-collection/update'] = 'admin/logistic-management/Cash_collection/update';
$route['admin/logistic-management/cash-collection/detail'] = 'admin/logistic-management/Cash_collection/detail';
$route['admin/logistic-management/cash-collection/delete'] = 'admin/logistic-management/Cash_collection/delete';
$route['admin/logistic-management/cash-collection/generate-otp'] = 'admin/logistic-management/Cash_collection/generate_otp';
$route['admin/logistic-management/cash-collection/print-cod-statement'] = 'admin/logistic-management/Cash_collection/print_cash_report';
$route['admin/logistic-management/cash-collection/print-collection-report'] = 'admin/logistic-management/Cash_collection/print_collection_wise_summary';
$route['admin/logistic-management/cash-collection/print-cod-report'] = 'admin/logistic-management/Cash_collection/print_employewise_summary';
$route['admin/logistic-management/cash-collection/print-pending-report'] = 'admin/logistic-management/Cash_collection/print_pending_collection_report';
$route['admin/logistic-management/cash-collection/full-cash-report'] = 'admin/logistic-management/Cash_collection/print_full_cash_report';

# master country
$route['admin/master/country'] = 'admin/masters/Country/index';
$route['admin/master/country/add'] = 'admin/masters/Country/add';
$route['admin/master/country/save'] = 'admin/masters/Country/save';
$route['admin/master/country/delete'] = 'admin/masters/Country/delete';

# master City
$route['admin/master/city'] = 'admin/masters/City/index';
$route['admin/master/city/add'] = 'admin/masters/City/add';
$route['admin/master/city/save'] = 'admin/masters/City/save';
$route['admin/master/city/delete'] = 'admin/masters/City/delete';

# Major/STreams
$route['admin/master/streams'] = 'admin/masters/MajorStream/index';
$route['admin/master/streams/get-list'] = 'admin/masters/MajorStream/get_list';
$route['admin/master/streams/add'] = 'admin/masters/MajorStream/add';
$route['admin/master/streams/save'] = 'admin/masters/MajorStream/save';
$route['admin/master/streams/delete'] = 'admin/masters/MajorStream/delete';

# Business Unit
$route['admin/master/business-unit'] = 'admin/masters/Businessunit/index';
$route['admin/master/business-unit/get-list'] = 'admin/masters/Businessunit/get_list';
$route['admin/master/business-unit/add'] = 'admin/masters/Businessunit/add';
$route['admin/master/business-unit/save'] = 'admin/masters/Businessunit/save';
$route['admin/master/business-unit/delete'] = 'admin/masters/Businessunit/delete';

# Grade
$route['admin/master/grade'] = 'admin/masters/Grade/index';
$route['admin/master/grade/get-list'] = 'admin/masters/Grade/get_list';
$route['admin/master/grade/add'] = 'admin/masters/Grade/add';
$route['admin/master/grade/save'] = 'admin/masters/Grade/save';
$route['admin/master/grade/delete'] = 'admin/masters/Grade/delete';

# Location
$route['admin/master/location'] = 'admin/masters/Location/index';
$route['admin/master/location/get-list'] = 'admin/masters/Location/get_list';
$route['admin/master/location/add'] = 'admin/masters/Location/add';
$route['admin/master/location/save'] = 'admin/masters/Location/save';
$route['admin/master/location/delete'] = 'admin/masters/Location/delete';

# Camps
$route['admin/master/camps'] = 'admin/masters/Camps/index';
$route['admin/master/camps/get-list'] = 'admin/masters/Camps/get_list';
$route['admin/master/camps/add'] = 'admin/masters/Camps/add';
$route['admin/master/camps/save'] = 'admin/masters/Camps/save';
$route['admin/master/camps/delete'] = 'admin/masters/Camps/delete';

# Rooms
$route['admin/master/rooms'] = 'admin/masters/Rooms/index';
$route['admin/master/rooms/get-list'] = 'admin/masters/Rooms/get_list';
$route['admin/master/rooms/add'] = 'admin/masters/Rooms/add';
$route['admin/master/rooms/save'] = 'admin/masters/Rooms/save';
$route['admin/master/rooms/delete'] = 'admin/masters/Rooms/delete';

# Beds
$route['admin/master/beds'] = 'admin/masters/Beds/index';
$route['admin/master/beds/get-list'] = 'admin/masters/Beds/get_list';
$route['admin/master/beds/add'] = 'admin/masters/Beds/add';
$route['admin/master/beds/save'] = 'admin/masters/Beds/save';
$route['admin/master/beds/delete'] = 'admin/masters/Beds/delete';

# Contract Status
$route['admin/master/contract-status'] = 'admin/masters/Contractstatus/index';
$route['admin/master/contract-status/get-list'] = 'admin/masters/Contractstatus/get_list';
$route['admin/master/contract-status/add'] = 'admin/masters/Contractstatus/add';
$route['admin/master/contract-status/save'] = 'admin/masters/Contractstatus/save';
$route['admin/master/contract-status/delete'] = 'admin/masters/Contractstatus/delete';

# Licence Type
$route['admin/master/licence-type'] = 'admin/masters/LicenceTypes/index';
$route['admin/master/licence-type/get-list'] = 'admin/masters/LicenceTypes/get_list';
$route['admin/master/licence-type/add'] = 'admin/masters/LicenceTypes/add';
$route['admin/master/licence-type/save'] = 'admin/masters/LicenceTypes/save';
$route['admin/master/licence-type/delete'] = 'admin/masters/LicenceTypes/delete';

# Qiwa Status
$route['admin/master/qiwa-status'] = 'admin/masters/Qiwastatus/index';
$route['admin/master/qiwa-status/get-list'] = 'admin/masters/Qiwastatus/get_list';
$route['admin/master/qiwa-status/add'] = 'admin/masters/Qiwastatus/add';
$route['admin/master/qiwa-status/save'] = 'admin/masters/Qiwastatus/save';
$route['admin/master/qiwa-status/delete'] = 'admin/masters/Qiwastatus/delete';

# Cash Receipt Reasons
$route['admin/master/cash-reason'] = 'admin/masters/Cashreason/index';
$route['admin/master/cash-reason/get-list'] = 'admin/masters/Cashreason/get_list';
$route['admin/master/cash-reason/add'] = 'admin/masters/Cashreason/add';
$route['admin/master/cash-reason/save'] = 'admin/masters/Cashreason/save';
$route['admin/master/cash-reason/delete'] = 'admin/masters/Cashreason/delete';

# File types
$route['admin/master/file-types'] = 'admin/masters/FileTypes/index';
$route['admin/master/file-types/get-list'] = 'admin/masters/FileTypes/get_list';
$route['admin/master/file-types/add'] = 'admin/masters/FileTypes/add';
$route['admin/master/file-types/save'] = 'admin/masters/FileTypes/save';
$route['admin/master/file-types/delete'] = 'admin/masters/FileTypes/delete';

# Transaction Types
$route['admin/master/transaction-type'] = 'admin/masters/TransactionTypes/index';
$route['admin/master/transaction-type/get-list'] = 'admin/masters/TransactionTypes/get_list';
$route['admin/master/transaction-type/add'] = 'admin/masters/TransactionTypes/add';
$route['admin/master/transaction-type/save'] = 'admin/masters/TransactionTypes/save';
$route['admin/master/transaction-type/delete'] = 'admin/masters/TransactionTypes/delete';

# Sponsors
$route['admin/master/sponsors'] = 'admin/masters/Sponsors/index';
$route['admin/master/sponsors/get-list'] = 'admin/masters/Sponsors/get_list';
$route['admin/master/sponsors/add'] = 'admin/masters/Sponsors/add';
$route['admin/master/sponsors/save'] = 'admin/masters/Sponsors/save';
$route['admin/master/sponsors/edit'] = 'admin/masters/Sponsors/edit';
$route['admin/master/sponsors/update'] = 'admin/masters/Sponsors/update';
$route['admin/master/sponsors/delete'] = 'admin/masters/Sponsors/delete';

#Vendor
$route['admin/vendor/list'] = 'admin/vendor/index';
$route['admin/vendor/add'] = 'admin/vendor/add';
$route['admin/vendor/submit'] = 'admin/vendor/add_vendor';
$route['admin/vendor/detail'] = 'admin/vendor/detail';
$route['admin/vendor/delete'] = 'admin/vendor/delete';

#Purchase
$route['admin/purchase/list'] = 'admin/purchase_order/index';
$route['admin/purchase/purchase-list'] = 'admin/purchase_order/get_list';
$route['admin/purchase/create-purchase'] = 'admin/purchase_order/create_order';
$route['admin/purchase/add'] = 'admin/purchase_order/form';
$route['admin/purchase/submit'] = 'admin/purchase_order/add_vendor';
$route['admin/purchase/detail'] = 'admin/purchase_order/purchase_detail';
$route['admin/purchase/delete'] = 'admin/purchase_order/delete';
$route['admin/purchase/send-mail'] = 'admin/mail_po/send_mail';

#GRV
$route['admin/grv/list'] = 'admin/grv/index';
$route['admin/grv/create-grv'] = 'admin/grv/generate_grv';
$route['admin/grv/add'] = 'admin/grv/form';
$route['admin/grv/submit'] = 'admin/grv/update_grv';
$route['admin/grv/detail'] = 'admin/grv/grv_detail';
#$route['admin/grv/delete'] = 'admin/grv/delete';

#Purchase Return
$route['admin/pr/list'] = 'admin/purchase_return/index';
$route['admin/pr/form'] = 'admin/purchase_return/return_form';
$route['admin/pr/submit'] = 'admin/purchase_return/add_order';
$route['admin/pr/print'] = 'admin/purchase_return/print_invoice';
$route['admin/pr/detail'] = 'admin/purchase_return/purchase_detail';

#Quotation
$route['admin/quotation/list'] = 'admin/quotation/index';
$route['admin/quotation/all-list'] = 'admin/quotation/get_list';
$route['admin/quotation/create-quotation'] = 'admin/quotation/create_order';
$route['admin/quotation/edit'] = 'admin/quotation/form';
$route['admin/quotation/update'] = 'admin/quotation/update_product_to_order';
$route['admin/quotation/update-basic'] = 'admin/quotation/update_basic_info';
$route['admin/quotation/convert-order'] = 'admin/quotation/convert_order';
$route['admin/quotation/detail'] = 'admin/quotation/detail';
$route['admin/quotation/delete'] = 'admin/quotation/delete';
$route['admin/quotation/update-status'] = 'admin/quotation/set_quotation_status';
$route['admin/quotation/send-mail'] = 'admin/mail_quotation/send_mail';
$route['admin/quotation/print-delivery-note'] = 'admin/quotation/delivery_note';

#Order
$route['admin/order/list'] = 'admin/order_process/index';
$route['admin/order/quick-view'] = 'admin/order_process/quick_view';
$route['admin/order/all-list'] = 'admin/order_process/get_list';
$route['admin/order/create-quotation'] = 'admin/order_process/create_order';
$route['admin/order/edit'] = 'admin/order_process/form';
$route['admin/order/update'] = 'admin/order_process/update_product_to_order';
$route['admin/order/convert-order'] = 'admin/order_process/convert_order';
$route['admin/order/detail'] = 'admin/order_process/detail';
$route['admin/order/delete'] = 'admin/order_process/delete';
$route['admin/order/mail-invoice'] = 'admin/mail_invoice/send_mail';
$route['admin/order/mail-delivery-note'] = 'admin/mail_invoice/send_mail';

#Invoice Print
$route['admin/order/print-delivery-note'] = 'admin/order_process/delivery_note';
$route['admin/order/print-label'] = 'admin/order_process/label';
$route['admin/order/print-retailer-invoice'] = 'admin/order_process/print_retailer_invoice';
$route['admin/order/print-invoice'] = 'admin/order_process/print_invoice';
$route['admin/order/print-invoice-wt'] = 'admin/order_process/print_invoice_wt';
$route['admin/order/print-arabic-invoice'] = 'admin/order_process/print_arabic_invoice';

#User
$route['admin/user/list'] = 'admin/user/index';
$route['admin/user/individual-form'] = 'admin/user/add';
$route['admin/user/submit-form'] = 'admin/user/add_customer';
$route['admin/user/detail'] = 'admin/user/detail';
$route['admin/user/delete'] = 'admin/user/delete';

#Business/Corporate User
$route['admin/business-user/list'] = 'admin/Corporate_user/business_user';
$route['admin/user/business-form'] = 'admin/Corporate_user/add_business';
$route['admin/business-user/list-ajax'] = 'admin/Corporate_user/get_business_list';
$route['admin/business-user/submit-business-form'] = 'admin/Corporate_user/save_business_customer';
$route['admin/user/corporate-detail'] = 'admin/Corporate_user/corporate_detail';
$route['admin/business-user/submit-corporate-address'] = 'admin/Corporate_user/add_corporate_address';
$route['admin/business-user/edit-corporate-address'] = 'admin/Corporate_user/edit_corporate_address';
$route['admin/business-user/delete-corporate-address'] = 'admin/Corporate_user/delete_address';
$route['admin/business-user/corporate-login-add'] = 'admin/Corporate_user/add_login_ajax';
$route['admin/business-user/corporate-login-edit'] = 'admin/Corporate_user/edit_login_ajax';
$route['admin/business-user/corporate-login-save'] = 'admin/Corporate_user/add_corporate_login';
$route['admin/business-user/delete-corporate-login'] = 'admin/Corporate_user/delete_corporate_login';
$route['admin/business-user/corporate-login-detail'] = 'admin/Corporate_user/getCorporateLoginDetail';
$route['admin/business-user/print-credit-application'] = 'admin/Corporate_user/print_credit_application';

#Credit Account
$route['admin/credit-account/list'] = 'admin/Credit_account/index';
$route['admin/credit-account/edit'] = 'admin/Credit_account/edit';
$route['admin/credit-account/update'] = 'admin/Credit_account/update_credits';
$route['admin/credit-account/report'] = 'admin/Credit_account/report';
$route['admin/credit-account/user-report'] = 'admin/Credit_account/get_report';
$route['admin/credit-account/print-report'] = 'admin/Credit_account/print_statement';

#Inventory
$route['admin/warehouse/inventory/list'] = 'admin/Inventory/index';
$route['admin/warehouse/inventory/instock'] = 'admin/Inventory/filter';
$route['admin/warehouse/inventory/outstock'] = 'admin/Inventory/filter';
$route['admin/warehouse/form'] = 'admin/Inventory/return_form';
$route['admin/warehouse/submit'] = 'admin/Inventory/add_order';
$route['admin/warehouse/print'] = 'admin/Inventory/print_invoice';
$route['admin/warehouse/detail'] = 'admin/Inventory/purchase_detail';

#Rack
$route['admin/rack/list'] = 'admin/rack/index';
$route['admin/rack/edit'] = 'admin/rack/add';
$route['admin/rack/submit'] = 'admin/rack/add_rack';
$route['admin/rack/delete'] = 'admin/rack/delete';

#Shelf
$route['admin/shelf/list'] = 'admin/shelf/index';
$route['admin/shelf/edit'] = 'admin/shelf/add';
$route['admin/shelf/submit'] = 'admin/shelf/add_shelf';
$route['admin/shelf/delete'] = 'admin/shelf/delete';

#Logistic Partner
$route['admin/logistic-partner/list'] = 'admin/Logistic_partner/index';
$route['admin/logistic-partner/partner-list'] = 'admin/Logistic_partner/get_list';
$route['admin/logistic-partner/add'] = 'admin/Logistic_partner/add';
$route['admin/logistic-partner/detail'] = 'admin/Logistic_partner/details';
$route['admin/logistic-partner/save'] = 'admin/Logistic_partner/save_basic_info';
$route['admin/logistic-partner/save-contact'] = 'admin/Logistic_partner/save_contact_info';
$route['admin/logistic-partner/save-bank'] = 'admin/Logistic_partner/save_bank_info';
$route['admin/logistic-partner/save-commission'] = 'admin/Logistic_partner/save_commission_info';
$route['admin/logistic-partner/send-welcome-mail'] = 'admin/Logistic_partner/sendManualCredential';
$route['admin/logistic-partner/delete'] = 'admin/Logistic_partner/delete';

#Inhouse Van
$route['admin/in-house-vehicle/list'] = 'admin/Inhouse_van/index';
$route['admin/in-house-vehicle/form'] = 'admin/Inhouse_van/form';
$route['admin/in-house-vehicle/save'] = 'admin/Inhouse_van/save_info';
$route['admin/in-house-vehicle/delete'] = 'admin/Inhouse_van/delete';
$route['admin/in-house-vehicle/list-ajax'] = 'admin/Inhouse_van/get_list';

#Online Food Delivery Company
$route['admin/ofd-company/list'] = 'admin/ofd_company/index';
$route['admin/ofd-company/edit'] = 'admin/ofd_company/form';
$route['admin/ofd-company/submit'] = 'admin/ofd_company/add';
$route['admin/ofd-company/delete'] = 'admin/ofd_company/delete';

#Daily Delivery Summary
$route['admin/daily-delivery-summary/list'] = 'admin/Daily_delivery_summary/index';
$route['admin/daily-delivery-summary/summary'] = 'admin/Daily_delivery_summary/get_list';
$route['admin/daily-delivery-summary/form'] = 'admin/Daily_delivery_summary/form';
$route['admin/daily-delivery-summary/submit'] = 'admin/Daily_delivery_summary/add';
$route['admin/daily-delivery-summary/add-detail'] = 'admin/Daily_delivery_summary/add_detail_summary';
$route['admin/daily-delivery-summary/quick-view'] = 'admin/Daily_delivery_summary/view_detail_summary';
$route['admin/daily-delivery-summary/quick-view-userwise'] = 'admin/Daily_delivery_summary/view_userwise_summary';
$route['admin/daily-delivery-summary/edit-detail-summary'] = 'admin/Daily_delivery_summary/edit_detail_summary';
$route['admin/daily-delivery-summary/update-summary'] = 'admin/Daily_delivery_summary/edit';
$route['admin/daily-delivery-summary/update-detail-summary'] = 'admin/Daily_delivery_summary/edit_detail';
$route['admin/daily-delivery-summary/delete'] = 'admin/Daily_delivery_summary/delete';
$route['admin/daily-delivery-summary/print-summary'] = 'admin/Daily_delivery_summary/print_summary';
$route['admin/daily-delivery-summary/print-detail-summary'] = 'admin/Daily_delivery_summary/print_detail_summary';

#Attendance Summary
$route['admin/attendance/list'] = 'admin/Attendance_summary/index';
$route['admin/attendance/summary'] = 'admin/Attendance_summary/get_list';
$route['admin/attendance/old-list'] = 'admin/Attendance_summary/summary_old';
$route['admin/attendance/add'] = 'admin/Attendance_summary/attendance_form';
$route['admin/attendance/save'] = 'admin/Attendance_summary/add_attendance';

#Master Vehicle
$route['admin/master-vehicle/list'] = 'admin/logistic-masters/Master_vehicle/index';
$route['admin/master-vehicle/ajax-list'] = 'admin/logistic-masters/Master_vehicle/get_list';
$route['admin/master-vehicle/fetch-filter-data'] = 'admin/logistic-masters/Master_vehicle/fetch_filter_data';
$route['admin/master-vehicle/add-vehicle'] = 'admin/logistic-masters/Master_vehicle/addVehicleForm';
$route['admin/master-vehicle/edit-vehicle/(:num)'] = 'admin/logistic-masters/Master_vehicle/editVehicleForm/$1';
$route['admin/master-vehicle/submit'] = 'admin/logistic-masters/Master_vehicle/saveForm';
$route['admin/master-vehicle/update'] = 'admin/logistic-masters/Master_vehicle/update';
$route['admin/master-vehicle/delete'] = 'admin/logistic-masters/Master_vehicle/delete';
$route['admin/master-vehicle/allotment-form'] = 'admin/logistic-masters/Master_vehicle/allotForm';
$route['admin/master-vehicle/print-handover-form'] = 'admin/logistic-masters/Master_vehicle/print_handover_form';
$route['admin/master-vehicle/download-certificates'] = 'admin/logistic-masters/Master_vehicle/download_documents';
$route['admin/master-vehicle/save-allotment'] = 'admin/logistic-masters/Master_vehicle/updateAllotment';
$route['admin/master-vehicle/parking-allotment-form'] = 'admin/logistic-masters/Master_vehicle/parkingAllotmentForm';
$route['admin/master-vehicle/save-parking-allotment'] = 'admin/logistic-masters/Master_vehicle/parkingAllotmentUpdate';
$route['admin/master-vehicle/send-otp'] = 'admin/logistic-masters/Master_vehicle/send_otp';
$route['admin/master-vehicle/re-send-otp'] = 'admin/logistic-masters/Master_vehicle/resend_otp';
$route['admin/master-vehicle/verify-otp'] = 'admin/logistic-masters/Master_vehicle/verify_otp';
$route['admin/master-vehicle/export-excel'] = 'admin/Export/vehicleExport';
$route['admin/master-vehicle/export-vehicle-documents/(:num)'] = 'admin/logistic-masters/Master_vehicle/export_combined_pdf/$1';

# Master Vehicle Reasons
$route['admin/master/vehicle-reason'] = 'admin/masters/VehicleReasons/index';
$route['admin/master/vehicle-reason/get-list'] = 'admin/masters/VehicleReasons/get_list';
$route['admin/master/vehicle-reason/add'] = 'admin/masters/VehicleReasons/add';
$route['admin/master/vehicle-reason/edit'] = 'admin/masters/VehicleReasons/edit';
$route['admin/master/vehicle-reason/save'] = 'admin/masters/VehicleReasons/save';
$route['admin/master/vehicle-reason/update'] = 'admin/masters/VehicleReasons/update';
$route['admin/master/vehicle-reason/delete'] = 'admin/masters/VehicleReasons/delete';

#Master Vehicle Logs
$route['admin/master-vehicle/all-logs'] = 'admin/logistic-masters/Vehicle_log/index';
$route['admin/master-vehicle/log-list'] = 'admin/logistic-masters/Vehicle_log/get_list';
$route['admin/master-vehicle/quick-log-list'] = 'admin/logistic-masters/Vehicle_log/single_vehicle_log';
$route['admin/master-vehicle/export-logs'] = 'admin/logistic-masters/Vehicle_log/export_excel';

#Spare Parts
$route['admin/spare-parts/list'] = 'admin/logistic-masters/Spare_parts/index';
$route['admin/spare-parts/ajax-list'] = 'admin/logistic-masters/Spare_parts/get_list';
$route['admin/spare-parts/add'] = 'admin/logistic-masters/Spare_parts/add';
$route['admin/spare-parts/submit'] = 'admin/logistic-masters/Spare_parts/save';
$route['admin/spare-parts/delete'] = 'admin/logistic-masters/Spare_parts/delete';
$route['admin/spare-parts/detail'] = 'admin/logistic-masters/Spare_parts/detail';
$route['admin/spare-parts/update-stock'] = 'admin/logistic-masters/Spare_parts/update_stock';
$route['admin/spare-parts/inventory-log'] = 'admin/logistic-masters/Spare_parts/inventory_log';
$route['admin/spare-parts/stock-out-log'] = 'admin/logistic-masters/spare_parts/log_job_cards';

#Spare Parts Requisition Master
$route['admin/spare-parts/requisition/list'] = 'admin/logistic-masters/Requisition/index';
$route['admin/spare-parts/requisition/ajax-list'] = 'admin/logistic-masters/Requisition/get_list';
$route['admin/spare-parts/requisition/create'] = 'admin/logistic-masters/Requisition/create_requisition';
$route['admin/spare-parts/requisition/edit'] = 'admin/logistic-masters/Requisition/form';
$route['admin/spare-parts/requisition/update'] = 'admin/logistic-masters/Requisition/update';
$route['admin/spare-parts/requisition/search-parts'] = 'admin/logistic-masters/Requisition/get_search_list';
$route['admin/spare-parts/requisition/detail'] = 'admin/logistic-masters/Requisition/requisition_detail';
$route['admin/spare-parts/requisition/print'] = 'admin/logistic-masters/Requisition/print_requisition';

#Spare Parts PO Master
$route['admin/spare-parts/po/list'] = 'admin/logistic-masters/Spare_po/index';
$route['admin/spare-parts/po/ajax-list'] = 'admin/logistic-masters/Spare_po/get_list';
$route['admin/spare-parts/po/create'] = 'admin/logistic-masters/Spare_po/create_po';
$route['admin/spare-parts/po/edit'] = 'admin/logistic-masters/Spare_po/form';
$route['admin/spare-parts/po/update'] = 'admin/logistic-masters/Spare_po/update';
$route['admin/spare-parts/po/update-international'] = 'admin/logistic-masters/Spare_po/update_international';
$route['admin/spare-parts/po/search-parts'] = 'admin/logistic-masters/Spare_po/get_search_list';
$route['admin/spare-parts/po/detail'] = 'admin/logistic-masters/Spare_po/po_detail';
$route['admin/spare-parts/po/print'] = 'admin/logistic-masters/Spare_po/print_po';
$route['admin/spare-parts/po/delete'] = 'admin/logistic-masters/Spare_po/delete';

#Spare Parts MRV Master
$route['admin/spare-parts/mrv/list'] = 'admin/logistic-masters/Spare_mrv/index';
$route['admin/spare-parts/mrv/ajax-list'] = 'admin/logistic-masters/Spare_mrv/get_list';
$route['admin/spare-parts/mrv/create'] = 'admin/logistic-masters/Spare_mrv/create';
$route['admin/spare-parts/mrv/edit'] = 'admin/logistic-masters/Spare_mrv/form';
$route['admin/spare-parts/mrv/update'] = 'admin/logistic-masters/Spare_mrv/update';
$route['admin/spare-parts/mrv/detail'] = 'admin/logistic-masters/Spare_mrv/mrv_detail';
$route['admin/spare-parts/mrv/print'] = 'admin/logistic-masters/Spare_mrv/print_mrv';
$route['admin/spare-parts/mrv/delete'] = 'admin/logistic-masters/Spare_mrv/delete';

#Job Card
$route['admin/job-card/list'] = 'admin/Jobcard/index';
$route['admin/job-card/ajax-list'] = 'admin/Jobcard/get_list';
$route['admin/job-card/create'] = 'admin/Jobcard/create_job';
$route['admin/job-card/add'] = 'admin/Jobcard/form';
$route['admin/job-card/submit'] = 'admin/Jobcard/update_job';
$route['admin/job-card/detail'] = 'admin/Jobcard/purchase_detail';
$route['admin/job-card/vehicle-detail'] = 'admin/Jobcard/vehicle_detail';
$route['admin/job-card/delete'] = 'admin/Jobcard/delete';
$route['admin/job-card/print-invoice'] = 'admin/Jobcard/print_invoice';
$route['admin/job-card/report'] = 'admin/Jobcard/report';
$route['admin/job-card/print-report'] = 'admin/Jobcard/print_report';
$route['admin/job-card/lock-job'] = 'admin/Jobcard/lock_job';

#Roles & Permission
$route['admin/roles/list'] = 'admin/Roles/index';
$route['admin/roles/ajax-list'] = 'admin/Roles/get_list';
$route['admin/roles/quick-edit'] = 'admin/Roles/quick_edit';
$route['admin/roles/submit'] = 'admin/Roles/add';
$route['admin/roles/delete'] = 'admin/Roles/delete';

#Roles Modules
$route['admin/modules/list'] = 'admin/Modules/index';
$route['admin/modules/ajax-list'] = 'admin/Modules/get_list';
$route['admin/modules/quick-edit'] = 'admin/Modules/quick_edit';
$route['admin/modules/submit'] = 'admin/Modules/add';
$route['admin/modules/delete'] = 'admin/Modules/delete';

#Permission
$route['admin/roles/permission/list'] = 'admin/Rolepermission/index';
$route['admin/roles/permission/quick-edit'] = 'admin/Rolepermission/quick_edit';
$route['admin/roles/permission/add/(:num)'] = 'admin/Rolepermission/add/$1';

#No Dues
$route['admin/no-dues'] = 'admin/new/Nodues/index';
$route['admin/no-dues/print'] = 'admin/new/Nodues/print';

#Products
$route['admin/product/deleted-product'] = 'admin/Product/deleted_product';
$route['admin/product/restore-deleted'] = 'admin/Product/restore_product';
$route['admin/product/soft-delete'] = 'admin/Product/soft_delete';
$route['admin/product/permanent-delete'] = 'admin/Product/permanent_delete';
$route['admin/product/delete-size'] = 'admin/Product/delete_size';

## Assets Management
#Assets Category
$route['admin/assets/category/list'] = 'admin/assets_management/category/index';
$route['admin/assets/category/ajax-list'] = 'admin/assets_management/category/get_list';
$route['admin/assets/category/edit'] = 'admin/assets_management/category/add';
$route['admin/assets/category/submit'] = 'admin/assets_management/category/save';
$route['admin/assets/category/delete'] = 'admin/assets_management/category/delete';

#Assets Sub Category
$route['admin/assets/sub-category/list'] = 'admin/assets_management/Subcategory/index';
$route['admin/assets/sub-category/ajax-list'] = 'admin/assets_management/Subcategory/get_list';
$route['admin/assets/sub-category/edit'] = 'admin/assets_management/Subcategory/add';
$route['admin/assets/sub-category/submit'] = 'admin/assets_management/Subcategory/save';
$route['admin/assets/sub-category/delete'] = 'admin/assets_management/Subcategory/delete';

#Assets Products
$route['admin/assets/product/list'] = 'admin/assets_management/Products/index';
$route['admin/assets/product/ajax-list'] = 'admin/assets_management/Products/get_list';
$route['admin/assets/product/sub-cat'] = 'admin/assets_management/Products/get_subcategories';
$route['admin/assets/product/edit'] = 'admin/assets_management/Products/add';
$route['admin/assets/product/detail'] = 'admin/assets_management/Products/details';
$route['admin/assets/product/copy'] = 'admin/assets_management/Products/copy';
$route['admin/assets/product/allot'] = 'admin/assets_management/Products/allot_prod_popup';
$route['admin/assets/product/unallot'] = 'admin/assets_management/Products/unallot_prod_popup';
$route['admin/assets/product/allot-product'] = 'admin/assets_management/Products/allot_prod';
$route['admin/assets/product/unallot-product'] = 'admin/assets_management/Products/unallot_prod';
$route['admin/assets/product/submit'] = 'admin/assets_management/Products/save';
$route['admin/assets/product/delete'] = 'admin/assets_management/Products/delete';
$route['admin/assets/product/asset-log'] = 'admin/assets_management/Products/assets_log';

## Acounting Routes
#Master Tax
$route['admin/tax-setting/list'] = 'admin/Accounting/Tax_controller/index';
$route['admin/tax-setting/ajax-list'] = 'admin/Accounting/Tax_controller/get_list';
$route['admin/tax-setting/add'] = 'admin/Accounting/Tax_controller/add';
$route['admin/tax-setting/submit'] = 'admin/Accounting/Tax_controller/save';
$route['admin/tax-setting/detail'] = 'admin/Accounting/Tax_controller/detail';
$route['admin/tax-setting/delete'] = 'admin/Accounting/Tax_controller/delete';

#Chart of Accounts
$route['admin/chart-of-accounts'] = 'admin/Accounting/Chart_of_accounts/index';
$route['admin/chart-of-accounts/add-account-form'] = 'admin/Accounting/Chart_of_accounts/add_account_form';
$route['admin/chart-of-accounts/edit-account-form'] = 'admin/Accounting/Chart_of_accounts/edit_account_form';
$route['admin/chart-of-accounts/check-code'] = 'admin/Accounting/Chart_of_accounts/ajax_check_code';
$route['admin/chart-of-accounts/form-submit'] = 'admin/Accounting/Chart_of_accounts/save';
$route['admin/chart-of-accounts/update-submit'] = 'admin/Accounting/Chart_of_accounts/update_main';
$route['admin/chart-of-accounts/delete/(:num)'] = 'admin/Accounting/Chart_of_accounts/delete/$1';
$route['admin/chart-of-accounts/cats'] = 'admin/Accounting/Chart_of_accounts/index';
$route['admin/chart-of-accounts/cats/(:num)'] = 'admin/Accounting/Chart_of_accounts/categories/$1';
$route['admin/chart-of-accounts/add-sub-account-form'] = 'admin/Accounting/Chart_of_accounts/add_sub_account_form';
$route['admin/chart-of-accounts/edit-sub-account-form'] = 'admin/Accounting/Chart_of_accounts/edit_sub_account_form';
$route['admin/chart-of-accounts/get-sidebar-cat'] = 'admin/Accounting/Chart_of_accounts/get_sidebar_cat';

#Journal entry
$route['admin/accounting/journal/list'] = 'admin/Accounting/Journal/index';
$route['admin/accounting/journal/edit/(:num)'] = 'admin/Accounting/Journal/edit/$1';
$route['admin/accounting/journal/delete/(:num)'] = 'admin/Accounting/Journal/delete/$1';
$route['admin/accounting/journal/update'] = 'admin/Accounting/Journal/update';
$route['admin/accounting/journal/create'] = 'admin/Accounting/Journal/createjournal';
$route['admin/accounting/journal/journallogs'] = 'admin/Accounting/Journal/journallogs';
$route['admin/accounting/journal/journaldetails/(:num)'] = 'admin/Accounting/Journal/journaldetails/$1';
$route['admin/accounting/journal/pdf/(:num)'] = 'admin/Accounting/Journal/journalpdf/$1';
$route['admin/accounting/journal/print/(:num)'] = 'admin/Accounting/Journal/journalprint/$1';
$route['admin/accounting/journal'] = 'admin/Accounting/Journal/createjournal';
$route['admin/accounting/journal/add'] = 'admin/Accounting/journal/add';
$route['admin/accounting/journal/check-duplicate'] = 'admin/Accounting/journal/ajax_check_journal';
$route['admin/accounting/journal/cloneadd'] = 'admin/Accounting/journal/cloneadd';
$route['admin/accounting/journal/add/(:num)'] = 'admin/Accounting/journal/clone/$1';
$route['admin/accounting/journal/recurring-profile/(:num)'] = 'admin/Accounting/journal/recurring_profile/$1';
$route['admin/accounting/journal/searchaccount'] = 'admin/Accounting/Journal/searchaccount';
$route['admin/accounting/journal/searchacostcenter'] = 'admin/Accounting/Journal/searchacostcenter';
$route['admin/accounting/recurring/add-profile'] = 'admin/Accounting/journal/addprofile';
$route['admin/accounting/recurring/update-profile'] = 'admin/Accounting/journal/updateprofile';
$route['admin/accounting/recurring/recurring-profile'] = 'admin/Accounting/journal/recurringlist';
$route['admin/accounting/recurring/profile-detail/(:num)'] = 'admin/Accounting/journal/profiledetail/$1';
$route['admin/accounting/recurring/edit/(:num)'] = 'admin/Accounting/journal/editrecurring/$1';
$route['admin/accounting/recurring/suspend-profile(:num)'] = 'admin/Accounting/journal/suspendprofile/$1';

#Cost Center
$route['admin/accounting/costcenters/list'] = 'admin/Accounting/CostCentersController/index';
$route['admin/accounting/costcenters/costcenterview'] = 'admin/Accounting/CostCentersController/costcenterview';
$route['admin/accounting/costcenters/headofficeedit'] = 'admin/Accounting/CostCentersController/headofficeedit';
$route['admin/accounting/costcenters/costcentertransactions'] = 'admin/Accounting/CostCentersController/costcentertransactions';
$route['admin/accounting/costcenters/costcenterreport'] = 'admin/Accounting/CostCentersController/costcenterreport';
$route['admin/accounting/costcenters/accountwithoutcostcenter'] = 'admin/Accounting/CostCentersController/accountwithoutcostcenter';
$route['admin/accounting/costcenters/accountwithcostcenter'] = 'admin/Accounting/CostCentersController/accountwithcostcenter';
$route['admin/accounting/costcenters/alltransaction'] = 'admin/Accounting/CostCentersController/alltransaction';
$route['admin/accounting/costcenters/managecostcenters'] = 'admin/Accounting/CostCentersController/managecostcenters';
$route['admin/accounting/costcenters/addcostcenter'] = 'admin/Accounting/CostCentersController/addcostcenter';
$route['admin/accounting/costcenters/editcostcenter'] = 'admin/Accounting/CostCentersController/editcostcenter';
$route['admin/accounting/costcenters/editwithoutcost'] = 'admin/Accounting/CostCentersController/editwithoutcost';
$route['admin/accounting/costcenters/assigncostcenter'] = 'admin/Accounting/CostCentersController/assigncostcenter';
$route['admin/accounting/costcenters/alltransactionedit'] = 'admin/Accounting/CostCentersController/alltransactionedit';

//new cost center
$route['admin/cost-center/add-account-form'] = 'admin/Accounting/CostCentersController/add_account_form';
$route['admin/cost-center/form-submit'] = 'admin/Accounting/CostCentersController/save';
$route['admin/cost-center/cats'] = 'admin/Accounting/CostCentersController/index';
$route['admin/cost-center/cats/(:num)'] = 'admin/Accounting/CostCentersController/categories/$1';
$route['admin/cost-center/add-sub-account-form'] = 'admin/Accounting/CostCentersController/add_sub_account_form';
$route['admin/cost-center'] = 'admin/Accounting/CostCentersController/index';
$route['admin/cost-center/edit-account-form'] = 'admin/Accounting/CostCentersController/edit_account_form';
$route['admin/cost-center/edit-sub-account-form'] = 'admin/Accounting/CostCentersController/edit_sub_account_form';
$route['admin/cost-center/update-submit'] = 'admin/Accounting/CostCentersController/update_main';
$route['admin/cost-center/delete/(:num)'] = 'admin/Accounting/CostCentersController/delete/$1';

// App Setting
$route['admin/app-setting/dasboard'] = 'admin/app_setting/App_setting/index';

#Banners
$route['admin/app/banner/list'] = 'admin/app_setting/Banners/index';
$route['admin/app/banner/add'] = 'admin/app_setting/Banners/add';
$route['admin/app/banner/edit'] = 'admin/app_setting/Banners/edit';
$route['admin/app/banner/save'] = 'admin/app_setting/Banners/save_banner';
$route['admin/app/banner/update'] = 'admin/app_setting/Banners/update_banner';
$route['admin/app/banner/delete'] = 'admin/app_setting/Banners/delete';

#Best Selling
$route['admin/app/best-selling/list'] = 'admin/app_setting/Best_selling/index';
$route['admin/app/best-selling/add'] = 'admin/app_setting/Best_selling/add';
$route['admin/app/best-selling/edit'] = 'admin/app_setting/Best_selling/edit';
$route['admin/app/best-selling/save'] = 'admin/app_setting/Best_selling/save';
$route['admin/app/best-selling/update'] = 'admin/app_setting/Best_selling/update';
$route['admin/app/best-selling/delete'] = 'admin/app_setting/Best_selling/delete';

#Offers Banners
$route['admin/app/offers/list'] = 'admin/app_setting/Offers/index';
$route['admin/app/offers/add'] = 'admin/app_setting/Offers/add';
$route['admin/app/offers/edit'] = 'admin/app_setting/Offers/edit';
$route['admin/app/offers/save'] = 'admin/app_setting/Offers/save';
$route['admin/app/offers/update'] = 'admin/app_setting/Offers/update';
$route['admin/app/offers/delete'] = 'admin/app_setting/Offers/delete';

#Offers Banners
$route['admin/app/trending-offers/list'] = 'admin/app_setting/Offers_banners/index';
$route['admin/app/trending-offers/add'] = 'admin/app_setting/Offers_banners/add';
$route['admin/app/trending-offers/edit'] = 'admin/app_setting/Offers_banners/edit';
$route['admin/app/trending-offers/save'] = 'admin/app_setting/Offers_banners/save';
$route['admin/app/trending-offers/update'] = 'admin/app_setting/Offers_banners/update';
$route['admin/app/trending-offers/delete'] = 'admin/app_setting/Offers_banners/delete';

#Product Groups
$route['admin/app/product-groups/list'] = 'admin/app_setting/Group_products/index';
$route['admin/app/product-groups/add'] = 'admin/app_setting/Group_products/add';
$route['admin/app/product-groups/edit'] = 'admin/app_setting/Group_products/edit';
$route['admin/app/product-groups/save'] = 'admin/app_setting/Group_products/save';
$route['admin/app/product-groups/update'] = 'admin/app_setting/Group_products/update';
$route['admin/app/product-groups/delete'] = 'admin/app_setting/Group_products/delete';
$route['admin/app/product-groups/product-search'] = 'admin/app_setting/Group_products/get_search_list';
$route['admin/app/product-groups/ajax-check-url'] = 'admin/app_setting/Group_products/ajax_check_url';

#DL Request
$route['admin/dl-request/list'] = 'admin/Dlrequest/index';
$route['admin/dl-request/ajax-list'] = 'admin/Dlrequest/get_ajax_list';
$route['admin/dl-request/add'] = 'admin/Dlrequest/add';
$route['admin/dl-request/search'] = 'admin/Dlrequest/get_employee_detail';
$route['admin/dl-request/edit'] = 'admin/Dlrequest/edit';
$route['admin/dl-request/submit'] = 'admin/Dlrequest/save';
$route['admin/dl-request/update'] = 'admin/Dlrequest/update';
$route['admin/dl-request/detail'] = 'admin/Dlrequest/detail';
$route['admin/dl-request/check-empid'] = 'admin/Dlrequest/ajax_check_empid';
$route['admin/dl-request/delete'] = 'admin/Dlrequest/delete';
$route['admin/dl-request/print/(:num)'] = 'admin/Dlrequest/print_dl_request/$1';
$route['admin/dl-request/export-excel'] = 'admin/Dlrequest/export_dl_request_excel';
$route['admin/dl-request/transaction-form'] = 'admin/Dlrequest/add_trans_form';
$route['admin/dl-request/edit-transaction'] = 'admin/Dlrequest/edit_trans_form';
$route['admin/dl-request/update-transaction-amount'] = 'admin/Dlrequest/update_amount';

#DL Transaction
$route['admin/dl-transaction/list'] = 'admin/Dltransaction/index';
$route['admin/dl-transaction/ajax-list'] = 'admin/Dltransaction/get_ajax_list';
$route['admin/dl-transaction/add'] = 'admin/Dltransaction/add';
$route['admin/dl-transaction/edit/(:num)'] = 'admin/Dltransaction/edit/$1';
$route['admin/dl-transaction/submit'] = 'admin/Dltransaction/save';
$route['admin/dl-transaction/update'] = 'admin/Dltransaction/update';
$route['admin/dl-transaction/detail'] = 'admin/Dltransaction/detail';
$route['admin/dl-transaction/delete'] = 'admin/Dltransaction/delete';

#Coupon
$route['admin/coupon/list'] = 'admin/Coupon/index';
$route['admin/coupon/form'] = 'admin/Coupon/add';
$route['admin/coupon/submit-form'] = 'admin/Coupon/add_coupon';
$route['admin/coupon/delete'] = 'admin/Coupon/delete';

//====================New Routes Start=====================//
#Hunger Monthly Summary New
$route['admin/logistic-management/invoices/hunger/list'] = 'admin/logistic-management/aggregator/hunger/Hunger/index';
$route['admin/logistic-management/invoices/hunger/import-file'] = 'admin/logistic-management/aggregator/hunger/Hunger/import_file';
$route['admin/logistic-management/invoices/hunger/detail/(:num)'] = 'admin/logistic-management/aggregator/hunger/Hunger/detail/$1';
$route['admin/logistic-management/invoices/hunger/print-monthly-performance'] = 'admin/logistic-management/aggregator/hunger/Hunger/print_monthly_performance';
$route['admin/logistic-management/invoices/hunger/export-monthly-performance'] = 'admin/logistic-management/aggregator/hunger/Hunger/export_monthly_performance';
$route['admin/logistic-management/invoices/hunger/export-monthly-data/(:num)'] = 'admin/logistic-management/aggregator/hunger/Hunger/export_raw_data/$1';
$route['admin/logistic-management/invoices/hunger/delete'] = 'admin/logistic-management/aggregator/hunger/Hunger/delete';

#Hunger Sales Data New
$route['admin/logistic-management/invoices/hunger-sales/list'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/index';
$route['admin/logistic-management/invoices/hunger-sales/import-file'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/import_file';
$route['admin/logistic-management/invoices/hunger-sales/detail/(:num)'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/detail/$1';
$route['admin/logistic-management/invoices/hunger-sales/delete'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/delete';
$route['admin/logistic-management/invoices/hunger-sales/print-monthly-sales'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/print_sales_data';
$route['admin/logistic-management/invoices/hunger-sales/export-monthly-sales'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales/export_sales_data';

#Hunger Sales Invoice New
$route['admin/logistic-management/invoices/hunger-sales-invoice/list'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/index';
$route['admin/logistic-management/invoices/hunger-sales-invoice/ajax-list'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/ajax_list';
$route['admin/logistic-management/invoices/hunger-sales-invoice/import-file'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/import_file';
$route['admin/logistic-management/invoices/hunger-sales-invoice/detail/(:num)'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/detail/$1';
$route['admin/logistic-management/invoices/hunger-sales-invoice/delete'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/delete';
$route['admin/logistic-management/invoices/hunger-sales-invoice/print-monthly-sales'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/print_sales_data';
$route['admin/logistic-management/invoices/hunger-sales-invoice/export-monthly-sales'] = 'admin/logistic-management/aggregator/hunger/Hunger_sales_invoice/export_sales_data';

#Keeta Monthly Summary New
$route['admin/logistic-management/invoices/keeta/list'] = 'admin/logistic-management/aggregator/keeta/Keeta/index';
$route['admin/logistic-management/invoices/keeta/import-file'] = 'admin/logistic-management/aggregator/keeta/Keeta/import_file';
$route['admin/logistic-management/invoices/keeta/detail/(:num)'] = 'admin/logistic-management/aggregator/keeta/Keeta/detail/$1';
$route['admin/logistic-management/invoices/keeta/print-monthly-performance'] = 'admin/logistic-management/aggregator/keeta/Keeta/print_monthly_performance';
$route['admin/logistic-management/invoices/keeta/export-monthly-performance'] = 'admin/logistic-management/aggregator/keeta/Keeta/export_monthly_performance';

#Keeta Sales Data New
$route['admin/logistic-management/invoices/keeta-sales/list'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/index';
$route['admin/logistic-management/invoices/keeta-sales/import-file'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/import_file';
$route['admin/logistic-management/invoices/keeta-sales/detail/(:num)'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/detail/$1';
$route['admin/logistic-management/invoices/keeta-sales/delete'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/delete';
$route['admin/logistic-management/invoices/keeta-sales/print-monthly-sales'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/print_sales_data';
$route['admin/logistic-management/invoices/keeta-sales/export-monthly-sales'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales/export_sales_data';

#Keeta Sales Invoice New
$route['admin/logistic-management/invoices/keeta-sales-invoice/list'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/index';
$route['admin/logistic-management/invoices/keeta-sales-invoice/ajax-list'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/ajax_list';
$route['admin/logistic-management/invoices/keeta-sales-invoice/import-file'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/import_file';
$route['admin/logistic-management/invoices/keeta-sales-invoice/detail/(:num)'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/detail/$1';
$route['admin/logistic-management/invoices/keeta-sales-invoice/delete'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/delete';
$route['admin/logistic-management/invoices/keeta-sales-invoice/print-monthly-sales'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/print_sales_data';
$route['admin/logistic-management/invoices/keeta-sales-invoice/export-monthly-sales'] = 'admin/logistic-management/aggregator/keeta/Keeta_sales_invoice/export_sales_data';

#Jahez Monthly Summary New
$route['admin/logistic-management/invoices/jahez/list'] = 'admin/logistic-management/aggregator/jahez/Jahez/index';
$route['admin/logistic-management/invoices/jahez/import-file'] = 'admin/logistic-management/aggregator/jahez/Jahez/import_file';
$route['admin/logistic-management/invoices/jahez/detail/(:num)'] = 'admin/logistic-management/aggregator/jahez/Jahez/detail/$1';
$route['admin/logistic-management/invoices/jahez/print-monthly-performance'] = 'admin/logistic-management/aggregator/jahez/Jahez/print_monthly_performance';
$route['admin/logistic-management/invoices/jahez/export-monthly-performance'] = 'admin/logistic-management/aggregator/jahez/Jahez/export_monthly_performance';

$route['admin/manage-column/get-column-form'] = 'admin/settings/ColumnPreferenceController/get_column_form';
$route['admin/manage-column/save-preferences'] = 'admin/settings/ColumnPreferenceController/savePreferences';


//====================Asset Module Routes Start=====================//
$route['admin/asset-manage/all-assets'] = 'admin/assets/AssetController/index';
$route['admin/asset-manage/add-asset'] = 'admin/assets/AssetController/add_asset';

// ======================Asset App Setting======================//
//  Categories Routes
$route['admin/asset/get-category'] = 'admin/assets/app_setting/CategoryController/get_categories';
$route['admin/asset/all-categories'] = 'admin/assets/app_setting/CategoryController/all_categories'; //Ajax
$route['admin/get-single-category'] = 'admin/assets/app_setting/CategoryController/single_category'; //Ajax
$route['admin/asset/create-category'] = 'admin/assets/app_setting/CategoryController/create_category';
$route['admin/asset/get-assignee'] = 'admin/assets/app_setting/CategoryController/get_assignee';
$route['admin/asset/edit-category'] = 'admin/assets/app_setting/CategoryController/update_category';
$route['admin/asset/delete-category'] = 'admin/assets/app_setting/CategoryController/delete_category';
// Locations Rotes
$route['admin/asset/add-location'] = 'admin/assets/app_setting/LocationController/create_location';
$route['admin/asset/get-locations'] = 'admin/assets/app_setting/LocationController/get_location';

// Add Asset Status
$route['admin/asset/add-status'] = 'admin/assets/app_setting/AssetStatusController/create_status';
$route['admin/asset/get-status'] = 'admin/assets/app_setting/AssetStatusController/get_status';

// Asset Condition Routes
$route['admin/asset/all-conditions'] = 'admin/assets/app_setting/ConditionController/all_conditions';
$route['admin/asset/create-condition'] = 'admin/assets/app_setting/ConditionController/create_condition';
$route['admin/asset/edit-condition'] = 'admin/assets/app_setting/ConditionController/update_condition';
$route['admin/asset/delete-condition'] = 'admin/assets/app_setting/ConditionController/delete_condition';

// Model Routes
$route['admin/asset/all-models'] = 'admin/assets/app_setting/ModelController/all_models';
$route['admin/asset/create-model'] = 'admin/assets/app_setting/ModelController/create_model';
$route['admin/asset/edit-model'] = 'admin/assets/app_setting/ModelController/update_model';
$route['admin/asset/delete-model'] = 'admin/assets/app_setting/ModelController/delete_model';

//  Inventory Setting Start
// Manage Items
$route['admin/asset/inventory/manage-items'] = 'admin/assets/inventory/ItemController/index';
$route['admin/asset/inventory/get-items'] = 'admin/assets/inventory/ItemController/get_items';
$route['admin/asset/inventory/create-item'] = 'admin/assets/inventory/ItemController/create_item';
$route['admin/asset/inventory/get-brands'] = 'admin/assets/inventory/ItemController/get_brands';
$route['admin/asset/inventory/edit-item'] = 'admin/assets/inventory/ItemController/update_item';
$route['admin/asset/inventory/delete-item'] = 'admin/assets/inventory/ItemController/delete_item';
$route['admin/asset/inventory/print-item'] = 'admin/assets/inventory/ItemController/print_item';
$route['admin/asset/inventory/check-sku'] = 'admin/assets/inventory/ItemController/check_sku';

//  Manage Inventory
$route['admin/asset/inventory/manage-inventory'] = 'admin/assets/inventory/InventoryController/index';
$route['admin/asset/inventory/list-items'] = 'admin/assets/inventory/InventoryController/get_items';
$route['admin/asset/inventory/get-stock'] = 'admin/assets/inventory/InventoryController/get_stock';
// $route['admin/asset/inventory/create-item'] = 'admin/assets/inventory/ItemController/create_item';
// $route['admin/asset/inventory/edit-item'] = 'admin/assets/inventory/ItemController/update_item';
// $route['admin/asset/inventory/delete-item'] = 'admin/assets/inventory/ItemController/delete_item';

// Brand Routes
$route['admin/asset/all-brands'] = 'admin/assets/inventory/inventory_setting/BrandController/all_brands';
$route['admin/asset/create-brand'] = 'admin/assets/inventory/inventory_setting/BrandController/create_brand';
$route['admin/asset/edit-brand'] = 'admin/assets/inventory/inventory_setting/BrandController/update_brand';
$route['admin/asset/delete-brand'] = 'admin/assets/inventory/inventory_setting/BrandController/delete_brand';
// Unit Routes
$route['admin/asset/inventory/all-units'] = 'admin/assets/inventory/inventory_setting/UnitController/all_units';
$route['admin/asset/inventory/create-unit'] = 'admin/assets/inventory/inventory_setting/UnitController/create_unit';
$route['admin/asset/inventory/edit-unit'] = 'admin/assets/inventory/inventory_setting/UnitController/update_unit';
$route['admin/asset/inventory/delete-unit'] = 'admin/assets/inventory/inventory_setting/UnitController/delete_unit';

// Movement Status Routes
$route['admin/asset/inventory/all-movements'] = 'admin/assets/inventory/inventory_setting/MovementController/all_movements';
$route['admin/asset/inventory/create-movement'] = 'admin/assets/inventory/inventory_setting/MovementController/create_movement';
$route['admin/asset/inventory/edit-movement'] = 'admin/assets/inventory/inventory_setting/MovementController/update_movement';
$route['admin/asset/inventory/delete-movement'] = 'admin/assets/inventory/inventory_setting/MovementController/delete_movement';

//====================Asset Module Rotes End=====================//

#==Vehicle Timesheet Routes
$route['admin/vehicle/get-timesheet'] = 'admin/timesheet-management/TimesheetController/get_timesheet';
$route['admin/vehicle/get-list'] = 'admin/timesheet-management/TimesheetController/get_list';
$route['admin/vehicle/get-daily-timesheet'] = 'admin/timesheet-management/TimesheetController/get_monthly_attendance';
$route['admin/vehicle/get-daily-ajax-list'] = 'admin/timesheet-management/TimesheetController/get_monthly_attendance_list';
$route['admin/vehicle/print-daily-attendance'] = 'admin/timesheet-management/TimesheetController/print_attendance_summary';
$route['admin/vehicle/get-rider-timesheet'] = 'admin/timesheet-management/TimesheetController/get_monthly_attendance';
$route['admin/vehicle/check_employee'] = 'admin/timesheet-management/TimesheetController/check_emp_detail';
$route['admin/vehicle/create-timesheet'] = 'admin/timesheet-management/TimesheetController/create_timesheet';
$route['admin/vehicle/send-otp'] = 'admin/timesheet-management/TimesheetController/send_otp';
$route['admin/vehicle/submit-otp'] = 'admin/timesheet-management/TimesheetController/submit_otp';
$route['admin/vehicle/check_out'] = 'admin/timesheet-management/TimesheetController/checkout';
$route['admin/vehicle/check_in'] = 'admin/timesheet-management/TimesheetController/checkIn';
$route['admin/vehicle/delete-timesheet'] = 'admin/timesheet-management/TimesheetController/delete';
$route['admin/vehicle/print-timesheet'] = 'admin/timesheet-management/TimesheetController/print_timesheet';
$route['admin/vehicle/print-monthly-report'] = 'admin/timesheet-management/TimesheetController/print_monthly_report';
$route['admin/attendance/print-monthly-attendance-report'] = 'admin/timesheet-management/TimesheetController/print_monthly_attendance_report';
$route['admin/attendance/export-monthly-attendance-report'] = 'admin/Export/riderAttendanceExport';
#---------------------#

#=========Manage Attendance / Timesheet=========#
$route['admin/manage-attendance'] = 'admin/timesheet-management/ManageAttendance/index';
$route['admin/manage-attendance/get-list'] = 'admin/timesheet-management/ManageAttendance/get_list';
$route['admin/manage-attendance/add'] = 'admin/timesheet-management/ManageAttendance/add';
$route['admin/manage-attendance/search-empno'] = 'admin/timesheet-management/ManageAttendance/searchEmp';
$route['admin/manage-attendance/search-emp'] = 'admin/timesheet-management/ManageAttendance/get_employee_detail';
$route['admin/manage-attendance/check_date'] = 'admin/timesheet-management/ManageAttendance/check_date';
$route['admin/manage-attendance/save'] = 'admin/timesheet-management/ManageAttendance/save';

## Store Route ##
#---------------------#
$route['store'] = 'store/account';
$route['store/login'] = 'store/account/login';
$route['store/profile'] = 'store/account/profile';
$route['store/submit-login'] = 'store/account/submit_login';
$route['store/change-password'] = 'store/account/change_password';
$route['store/change-password/submit'] = 'store/account/submit_change_password';

#Store Rack
$route['store/rack/list'] = 'store/rack/index';
$route['store/rack/edit'] = 'store/rack/add';
$route['store/rack/submit'] = 'store/rack/add_rack';
$route['store/rack/delete'] = 'store/rack/delete';

#Store Shelf
$route['store/shelf/list'] = 'store/Shelf/index';
$route['store/shelf/ajaxlist'] = 'store/Shelf/get_list';
$route['store/shelf/edit'] = 'store/Shelf/add';
$route['store/shelf/submit'] = 'store/Shelf/add_shelf';
$route['store/shelf/delete'] = 'store/Shelf/delete';

#Store Supplier
$route['store/supplier-list'] = 'store/supplier/index';
$route['store/add-supplier'] = 'store/supplier/edit';
$route['store/submit-supplier'] = 'store/supplier/add_supplier';
$route['store/delete-supplier'] = 'store/supplier/delete';

#Store Store Sales
$route['store/sales-list'] = 'store/sales/index';
$route['store/add-sales'] = 'store/sales/edit';
$route['store/submit-sales'] = 'store/sales/add_sales';
$route['store/delete-sales'] = 'store/sales/delete';

#Store Warehouse
$route['store/warehouse/dashboard'] = 'store/warehouse/index';
$route['store/warehouse/stock-request'] = 'store/stockrequest';
$route['store/warehouse/stock-list'] = 'store/stockrequest/get_list';
$route['store/warehouse/stock-form'] = 'store/stockrequest/request_form';
$route['store/warehouse/stock-save'] = 'store/stockrequest/save_request';
$route['store/stock-request/product-list'] = 'store/stockrequest/get_search_list';
$route['store/warehouse/rejected-logs'] = 'store/stockrequest/rejected_logs';
$route['store/warehouse/damages'] = 'store/stockrequest/damages';

#Store Orders
$route['store/order/dashboard'] = 'store/orders/index';
$route['store/order/:any'] = 'store/orders/order_list/:any';
$route['store/order/detail/(:num)'] = 'store/orders/order_detail/$1';

#Store Inventory
$route['store/inventory'] = 'store/InventoryController/index';
$route['store/inventory/add-product'] = 'store/InventoryController/addproduct';
$route['store/inventory/add-product-modal'] = 'store/InventoryController/addproductmodal';
$route['store/inventory/manage-inventory'] = 'store/InventoryController/inventory_manage';
$route['store/inventory/store-products'] = 'store/InventoryController/get_store_product';
$route['store/inventory/remove-product'] = 'store/InventoryController/productremove';
$route['store/inventory/activate-product'] = 'store/InventoryController/setStatusEnable';
$route['store/inventory/deactivate-product'] = 'store/InventoryController/setStatusDisable';
$route['store/inventory/inventory-detail'] = 'store/InventoryController/product_detail_modal';
$route['store/inventory/update-inventory'] = 'store/InventoryController/product_update_modal';
$route['store/inventory/update-stock'] = 'store/InventoryController/stock_update_modal';
$route['store/inventory/save-edited-inventory'] = 'store/InventoryController/store_product_update';
$route['store/inventory/save-edited-stock'] = 'store/InventoryController/update_stock';
$route['store/inventory/inventory-logs'] = 'store/InventoryController/inventory_logs';
$route['store/inventory/inventory-logs-ajax'] = 'store/InventoryController/inventory_logs_ajax';
$route['store/logout'] = 'store/account/logout';


/*-----------------------------------*/
/*========= Hiring Agency Routes Start ==========*/
/*-----------------------------------*/
# Auth
$route['hiring-agency/login'] = 'agency/Auth_controller/login';
$route['hiring-agency/login-submit'] = 'agency/Auth_controller/submit_login';
$route['hiring-agency/logout'] = 'agency/Auth_controller/logout';
$route['hiring-agency'] = 'agency/Auth_controller/index';
$route['hiring-agency/change-password'] = 'agency/Profile_controller/change_password';
$route['hiring-agency/update-password'] = 'agency/Profile_controller/submit_change_password';
$route['hiring-agency/profile'] = 'agency/Profile_controller/profile';

# CV
$route['hiring-agency/cv/list'] = 'agency/Cv_controller/index';
$route['hiring-agency/cv/ajax-list'] = 'agency/Cv_controller/get_cv_list';
$route['hiring-agency/cv/filter/:any'] = 'agency/Cv_controller/filter_cv';
$route['hiring-agency/cv/filter-ajax/:any'] = 'agency/Cv_controller/filter_cv_ajax';
$route['hiring-agency/cv/delete'] = 'agency/Cv_controller/delete';
$route['hiring-agency/cv/delete-image'] = 'agency/Cv_controller/delete_image';
$route['hiring-agency/cv/form'] = 'agency/Cv_controller/add_cv';
$route['hiring-agency/cv/save'] = 'agency/Cv_controller/save_cv';
$route['hiring-agency/cv/detail'] = 'agency/Cv_controller/cv_detail';
$route['hiring-agency/cv/upload-form'] = 'agency/Cv_controller/upload_certificate_form';
$route['hiring-agency/cv/upload-medical-certificates'] = 'agency/Cv_controller/upload_medical_certificate';
$route['hiring-agency/cv/upload-certificates'] = 'agency/Cv_controller/upload_certificate';

/*-----------------------------------*/
/*========= Team Leader Routes Start ==========*/
/*-----------------------------------*/
# Auth
$route['team-leader/login'] = 'team_leader/Auth_controller/login';
$route['team-leader/login-submit'] = 'team_leader/Auth_controller/submit_login';
$route['team-leader/logout'] = 'team_leader/Auth_controller/logout';
$route['team-leader'] = 'team_leader/Auth_controller/index';
$route['team-leader/change-password'] = 'team_leader/Profile_controller/change_password';
$route['team-leader/update-password'] = 'team_leader/Profile_controller/submit_change_password';
$route['team-leader/profile'] = 'team_leader/Profile_controller/profile';

#==Mark Attendance 
$route['team-leader/mark-attendance'] = 'team_leader/TimeSheetController/mark_attendance';

#==Attendance Timesheet
$route['team-leader/vehicle/get-timesheet'] = 'team_leader/TimeSheetController/get_timesheet';
$route['team-leader/vehicle/get-list'] = 'team_leader/TimeSheetController/get_list';
$route['team-leader/vehicle/check_employee'] = 'team_leader/TimeSheetController/check_emp_detail';
$route['team-leader/vehicle/create-timesheet'] = 'team_leader/TimeSheetController/create_timesheet';
$route['team-leader/vehicle/send-otp'] = 'team_leader/TimeSheetController/send_otp';
$route['team-leader/vehicle/submit-otp'] = 'team_leader/TimeSheetController/submit_otp';
$route['team-leader/vehicle/check_out'] = 'team_leader/TimeSheetController/checkout';
$route['team-leader/vehicle/check_in'] = 'team_leader/TimeSheetController/checkIn';
$route['team-leader/vehicle/delete-timesheet'] = 'team_leader/TimeSheetController/delete';
$route['team-leader/vehicle/print-timesheet'] = 'team_leader/TimeSheetController/print_timesheet';

# Team Leader Team Mangement
$route['team-leader/hunger/team'] = 'team_leader/Hunger_team/index';
$route['team-leader/hunger/team-list'] = 'team_leader/Hunger_team/get_teams';
$route['team-leader/hunger/team-view'] = 'team_leader/Hunger_team/view_team';
$route['team-leader/hunger/get_team_member'] = 'team_leader/Hunger_team/get_team_member';
$route['team-leader/hunger/team_edit'] = 'team_leader/Hunger_team/team_edit';
$route['team-leader/hunger/team_update'] = 'team_leader/Hunger_team/team_update';
$route['team-leader/hunger/get_team_leader'] = 'team_leader/Hunger_team/get_team_leader';
$route['team-leader/hunger/team_member_remove'] = 'team_leader/Hunger_team/team_member_remove';
# Team leader Shift Management
$route['team-leader/hunger/shift'] = 'team_leader/ShiftController/index';
$route['team-leader/hunger/get-shift'] = 'team_leader/ShiftController/get_riders_shift';
$route['team-leader/hunger/search-rider'] = 'team_leader/ShiftController/search_rider';

/*========= Gate Keeper Routes Start ==========*/
/*-----------------------------------*/
# Auth
$route['gate-keeper/login'] = 'gate_keeper/Auth_controller/login';
$route['gate-keeper/login-submit'] = 'gate_keeper/Auth_controller/submit_login';
$route['gate-keeper/logout'] = 'gate_keeper/Auth_controller/logout';
$route['gate-keeper'] = 'gate_keeper/Auth_controller/index';
$route['gate-keeper/change-password'] = 'gate_keeper/Profile_controller/change_password';
$route['gate-keeper/update-password'] = 'gate_keeper/Profile_controller/submit_change_password';
$route['gate-keeper/profile'] = 'gate_keeper/Profile_controller/profile';

#==Vehicle Timesheet
$route['gate-keeper/vehicle/get-timesheet'] = 'gate_keeper/TimeSheetController/get_timesheet';
$route['gate-keeper/vehicle/get-list'] = 'gate_keeper/TimeSheetController/get_list';
$route['gate-keeper/vehicle/check_employee'] = 'gate_keeper/TimeSheetController/check_emp_detail';
$route['gate-keeper/vehicle/create-timesheet'] = 'gate_keeper/TimeSheetController/create_timesheet';
$route['gate-keeper/vehicle/send-otp'] = 'gate_keeper/TimeSheetController/send_otp';
$route['gate-keeper/vehicle/submit-otp'] = 'gate_keeper/TimeSheetController/submit_otp';
$route['gate-keeper/vehicle/check_out'] = 'gate_keeper/TimeSheetController/checkout';
$route['gate-keeper/vehicle/check_in'] = 'gate_keeper/TimeSheetController/checkIn';
$route['gate-keeper/vehicle/delete-timesheet'] = 'gate_keeper/TimeSheetController/delete';

# Hiring Agency End

$route['delivery'] = 'deliveryboy/common';
//$route['([^/]+)/?'] = 'home/category/:any';
#$route['admin/(:any)'] = 'errors/page_missing';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;
