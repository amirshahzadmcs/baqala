<?php
	$requestDetails = $request_info['request_detail'];
	$requestDetailArray = json_decode($requestDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $subject;?> - Maha Al Fala Trading Company</title>
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
            <tr>
                <td valign="center" style="text-align: left;">
                    <table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
                        <tr>
                            <td valign="center" style="text-align: left;"><strong><?= $requestDetailArray->title_english;?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <!-- start header -->
			<tr>
				<td valign="center" style="text-align: left;">
					<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="center" style="text-align: left;">To,<br><strong><?= $request_info['emp_no'] .'_'. $request_info['employee_name']; ?></strong><br><?= $request_info['employee_iqama_no']; ?><br><?= $request_info['designation_name']; ?><br><?= $request_info['emp_department_name']; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td></td></tr>
            <tr>
                <td valign="center" style="text-align: left;">
                    <table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
                        <tr>
                            <td valign="center" style="text-align: left;"><strong>Dear <?= $request_info['employee_name'];?>, </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        
            <!-- start copy block -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- start copy -->
                        <tr>
                            <td align="left" style="padding: 10px 0px 0px; font-size: 16px; line-height: 24px;color:#000000">
                                <p style="line-height: 15px;"><?= nl2br($requestDetailArray->description_english); ?></p>
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
                                <p>Amal Al Anazi</p>
                                <p>HR Manager</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>
