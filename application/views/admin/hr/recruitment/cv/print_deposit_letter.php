<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Security Deposit Letter</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 13px; width: 100%;line-height:20px;">

		<tr>
			<td>
				<p style="text-align: right;"><?= $print_date; ?></p>
				<br/><br/>
				<p>To,<br/>
				The HR Manager<br/>
				Maha Al Fala Trading Company.<br/>
				Riyadh Saudi Arabia.</p>
				<br/><br/>
				<p>Subject: <strong>Security Deposit</strong></p>
				<br/>
				<p>Dear Sir/Madam,</p>
				<p style="text-align: justify;">I, <?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?> holding <?php echo $cv_detail->nationality;?> Passport Number – <?php echo $cv_detail->passport_no;?>, will be working as <?php echo $cv_detail->pos_name;?>
				 for Maha Al Fala Trading Company. I confirm to hold SAR 130/- monthly for 24 
				months as security deposit until I complete my employment contract.</p>
				<p style="text-align: justify;">I affirm that Maha Al Fala Trading Company has full authority to hold this amount interest-free for 24 
				months and if I terminate the contract or am reported absconded for any reason, this security deposit will 
				be confiscated by the company for the loss of visa fees.</p>
				<br/>
				<p>Sincerely,</p>
				<p><?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?>.<br/>
				Date – <?php echo $signature_date; ?><br/><br/>
				Finger Print.</p>	
			</td>
		</tr>
	</table>

</body>

</html>
