<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Rider Disputes | Baqala Station</title>
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
            
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="left" style="padding: 36px 0px 5px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;">Dear Support Team,</h4>
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; letter-spacing: 0px; line-height: 14px; color: #181818;text-align:right;direction: rtl;"> السادة في فريق الدعم </h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- start content block -->
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0px;">
                        <!-- start copy -->
                        <tr>
                            <td align="left" style="padding: 10px 0px 0px;line-height: 24px;color:#000000">
                                <p style="line-height: 24px;font-size: 16px;">We would like to raise an issue encountered with one of our riders and a penalty has been imposed as per the below details.</p>
                                <p style="line-height: 24px;font-size: 16px;text-align:right;direction: rtl;"> نحن نرغب في رفع  مشكلة واجهت أحد سائقي الدراجات النارية لدينا، وقد تم فرض عقوبة عليه حسب التفاصيل التالية: </p>
                            </td>
                        </tr>
                    </table>
					<table class="table" border="1" cellpadding="5" style="width:100%;margin: 0px 0px 40px 0px;">
						<tbody>
							<tr>
								<td width="30%"><strong>Driver’s ID</strong></td>
								<td align="center"><?php echo $dispute->driver_id;?></td>
								<td width="30%" align="right"><strong> رقم هوية السائق </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Drivers Username</strong></td>
								<td align="center"><?php echo $dispute->driver_username;?></td>
								<td width="30%" align="right"><strong> اسم المستخدم الخاص بالسائق </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Reference ID</strong></td>
								<td align="center"><?php echo $dispute->ref_id;?></td>
								<td width="30%" align="right"><strong> الرقم المرجعي </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Rider Name</strong></td>
								<td align="center"><?php echo $dispute->rider_name;?></td>
								<td width="30%" align="right"><strong> اسم قائد الدراجة </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Dispute Type</strong></td>
								<td align="center"><?php echo $dispute->dispute_type_en;?> / <?php echo $dispute->dispute_type_ar;?></td>
								<td width="30%" align="right"><strong> اسم قائد الدراجة </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Dispatch Time</strong></td>
								<td align="center"><?php echo date('d-m-Y H:i:s',strtotime($dispute->dispatch_date));?></td>
								<td width="30%" align="right"><strong> زمن الإرسال  </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Drivers Debit Amount</strong></td>
								<td align="center"><?php echo $dispute->debit_amount;?></td>
								<td width="30%" align="right"><strong> مبلغ الحسم الخاص بالسائقين </strong></td>
							</tr>
							<tr>
								<td width="30%"><strong>Explanation</strong></td>
								<td align="center"><?php echo $dispute->explanations;?></td>
								<td width="30%" align="right"><strong> التوضيح والتبرير </strong></td>
							</tr>
						</tbody>
					</table>
                </td>
            </tr>
        
            <tr>
                <td align="left" style="padding: 10px 0px 0px;">
                    <p style="font-size: 16px;"><strong> Regards,  </strong></p>
                    <p style="font-size: 16px;text-align:right;direction: rtl;"><strong> مع التحية </strong></p>
                    <p style="font-size: 16px;"><strong> Logistic Support Team </strong></p>
                    <p style="font-size: 16px;text-align:right;direction: rtl;"><strong> فريق الدعم اللوجستي </strong></p>
                    <p style="font-size: 16px;"><strong> Maha Al Fala Company </strong></p>
                    <p style="font-size: 16px;text-align:right;direction: rtl;"><strong> شركة مها الفلاة </strong></p>
                </td>
            </tr>
        </table>

    </body>
</html>
