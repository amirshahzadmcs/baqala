<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome Mail | Baqala Station</title>
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
				font-size: 14px;
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
                                    <img src="<?php echo base_url();?>assets/image/logo.png" alt="Logo" border="0" style="display: block; width: 90%; max-width: 90%;" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- end logo -->
			<tr><td style="padding: 10px;"></td></tr>
            <!-- start hero -->
            <tr>
                <td>
					<div style="border:1px solid #000;padding: 20px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="left" style="padding: 36px 0px 5px;">
									<h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;">Dear Partner,</h4>
								</td>
							</tr>
							<!-- start copy block -->
							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<!-- start copy -->
										<tr>
											<td align="left" style="padding: 10px 0px 0px; font-size: 16px; line-height: 24px;color:#000000">
												<p style="line-height: 15px;">Your logistic partner contract has been successfully completed and we are glad to have you onboard the partner family.</p><br>
												<p style="line-height: 15px; font-weight: 600;">Below is the link to register your rider captains on our platform.</p><br>
												<p style="margin: 0;">
													Representative Registration Link: <a href="<?php echo base_url('logistic-partner/login');?>"><?php echo base_url('logistic-partner/login');?></a><br>
													Registered Company Name: <?php echo $company_name;?><br>
													Vendor ID Number: <?php echo $username;?><br>
													Password: <?php echo $password;?><br>
												</p><br>
												<p>You may log in and set your new password.</p><br>
											</td>
										</tr>
									</table>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td colspan="4">
												<p style="line-height: 15px; font-weight: 600;">Communication Mechanism:</p><br>
												<p>The official communication with Baqala Station would be via email only. And the account managers will be the point of contact & shall be responsible for verifying the activation status of registered representatives.</p><br>
												<p>Please contact the support email for any queries.</p><br>
											</td>
										</tr>
										<tr>
											<td>
												<table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size:14px;">
													<tr>
														<th>Name</th>
														<th>Position</th>
														<th>Mobile No</th>
														<th>Email ID</th>
													</tr>
													<tr>
														<td>Driver Support</td>
														<td>Support</td>
														<td></td>
														<td>3pl.ftr@baqalastation.com</td>
													</tr>
													<tr>
														<td><?php echo $manager_detail->full_name;?></td>
														<td><?php echo $manager_detail->designation_name;?></td>
														<td></td>
														<td><?php echo $manager_detail->local_email;?></td>
													</tr>
												</table>
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
									</p>
								</td>
							</tr>
						</table>
					</div>
                </td>
            </tr>
            <!-- end hero -->
        </table>

    </body>
</html>
