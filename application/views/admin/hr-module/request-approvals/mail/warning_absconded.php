<?php
	$requestDetails = $request_info['request_detail'];
	$requestDetailArray = json_decode($requestDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Unauthorized Absence from Work - Maha Al Fala Company</title>
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
            <!-- start header -->
			<tr>
				<td valign="center" style="text-align: left;">
					<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
						<tr>
							<td valign="center" style="text-align: left;">To<br><strong><?= $name;?></strong><br><?= $emp_no;?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td></td></tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="padding: 36px 0px 5px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;">Subject: Unauthorized Absence from Work</h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			<tr><td></td></tr>
            <!-- end header -->
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
        
            <!-- start copy block -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- start copy -->
                        <tr>
                            <td align="left" style="padding: 10px 0px 0px; font-size: 16px; line-height: 24px;color:#000000">
                                <p style="line-height: 15px;">We hope you are doing well.</p>
                                <p style="line-height: 15px;">This is to bring to your attention that you have been absent from your duties without any prior notice or approval, and we have observed consecutive absences over the past few days. Despite several attempts to contact you, there has been no response or communication from your side.</p>
                                <p style="line-height: 15px;">Your unauthorized absence is a serious violation of company policies and has affected the workflow of your department. Kindly treat this matter with urgency.</p>
                                <p style="line-height: 15px;">You are hereby requested to report to work or provide a valid explanation for your absence immediately upon receipt of this email. Failure to do so will compel us to initiate disciplinary action, which may include marking your status as “Absconded” and proceeding with the termination of your employment with Maha Al Fala Company, as per company policy.</p>
                                <p style="line-height: 15px;">Please consider this as a final notice.</p>
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
                                <p>Maha Al Fala Company.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>
