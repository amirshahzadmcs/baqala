<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $subject;?> | Baqala Station</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--[if !mso]><!-->
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
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
				font-size: 16px;
                color: #000000;
                margin-bottom: 0px;
                margin-top: 5px;
			}
        </style>
    </head>
    <body style="background-color: #ffffff;color:#000000">
        
        <!-- start body -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 650px; margin: 0 auto;">
            <!-- start logo --
            <tr>
                <td align="center">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" valign="top" style="padding: 36px 24px 0px;">
                                <a href="#" target="_blank" style="display: inline-block;">
                                    <img src="" alt="Logo" border="0" style="display: block; width: 65%; max-width: 80%;" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             end logo -->
        
            <!-- start header -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="padding: 36px 0px 5px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;"><?= $subject;?></h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- end header -->

            <!-- start hero -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="left" style="padding: 36px 0px 5px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;">Dear <?= $name;?></h4>
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
                            <td align="left" style="padding: 10px 0px 0px; font-size: 16px; line-height: 24px;color:#000000">
                                <p style="line-height: 15px;">Please use <strong><?= $otp;?></strong> as one time password to book you Medical Shuttle Service.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- start copy -->
                        <tr>
                            <td align="left" style="padding: 10px 0px 0px; font-size: 15px; line-height: 24px;color:#000000">
                                <p><b>Regards,</b></p>
                                <p>HR Administration</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>
