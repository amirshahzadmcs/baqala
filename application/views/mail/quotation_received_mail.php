<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta content="width=device-width" name="viewport"/>-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <title>Quotation Received | Baqala Station</title>
        <style type="text/css">
            
            body {
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /**
		   * Collapse table borders to avoid space between cells.
		   */
            table {
                border-collapse: collapse !important;
            }

            a {
                color: #1a82e2;
            }

            img {
                height: auto;
                line-height: 100%;
                text-decoration: none;
                border: 0;
                outline: none;
            }
			ul li{
				display:block;
			}
			p{
				font-size: 13px;
                color: #000000;
                margin-bottom: 0px;
                margin-top: 5px;
			}
        </style>
    </head>
    <body style="background-color: #ffffff; font-family:Arial, Helvetica, sans-serif;color:#000000">
        
        <!-- start body -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 750px; margin: 0 auto;">
            <!-- start logo -->
            <tr>
                <td align="center">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" valign="top" style="padding: 36px 24px 0px;">
                                <a href="#" target="_blank" style="display: inline-block;">
                                    <img src="<?php echo base_url();?>assets/image/logo.png" alt="Logo" border="0" style="display: block; width: 65%; max-width: 80%;" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- end logo -->
        
            <!-- start hero -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="left" style="padding: 36px 0px 5px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;">Hello!</h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- end hero -->
        
            <!-- start copy block -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- start copy -->
                        <tr>
                            <td align="left" style="padding: 10px 0px 0px; font-size: 15px; line-height: 24px;color:#000000">
                                <p style="line-height: 15px;">You have received new requisition <?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['quotation_no'];?> from <?php echo $result['order']['c_company'];?>.</p>
                                <p style="line-height: 15px;">Kindly login, review and update the requisition to client review.</p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        
            <tr>
                <td align="left" style="padding: 10px 0px 0px; font-size: 13px;">
                    <p>Should you need any further assistance please do not hesitate to contact us on care@baqalastation.com</p><br>
        
                    <p style="margin: 0;">
                        Best Regards<br />
                        Customer Care<br /><br>
                        Email: care@baqalastation.com<br />
                        Website: baqalastation.com<br />
                        Tel: 05104 05106<br />
                    </p><br>
                </td>
            </tr>
            <tr>
                <td align="justify" style="padding: 10px 0px; font-size: 13px;">
                    <p style="margin: 0; color: #9f3668 !important;">
                        This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender
                        immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. E-mail transmission cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted,
                        lost, destroyed, arrive late or incomplete, or contain viruses. The sender therefore does not accept liability for any errors or omissions in the contents of this message, which arise as a result of e-mail transmission.
                    </p><br>
                    <p>If verification is required, please request a hard-copy version.</p>
                </td>
            </tr>
        </table>

    </body>
</html>
