<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Recruitment Invoice</title>
	<style>
	*{padding:0px;margin:0px;}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
	<table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;line-height:20px;">
		<tr>
			<td>
				<p style="text-align: left;">INVOICE: <?= $invoice_no;?></p>
			</td>
			<td>
				<p style="text-align: right;">DATE: <?= $print_date; ?></p>
			</td>
		</tr>
        <tr><td colspan="2"></td></tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">
		<tr>
			<td>
				<p>To,<br/>
				Maha Al Fala Trading Company.<br/>
				Riyadh,<br>
				Kingdom of Saudi Arabia.</p>
				<br/><br/>
				<p style="text-align: center;"><strong>SUB – INVOICE</strong></p>
				<br/>
				<p style="text-align: justify;line-height:25px;">Dear Sir/Madam,<br>Being reimbursement for the recruitment charges of <?= count($batch_detail);?> candidate as mentioned below.</p>	
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="1" style="width: 100%;font-size: 11px;">
		<thead>
			<tr style="background-color: #000;color:#fff;">
				<th width="8%" align="center"><strong>SR NO</strong></th>
				<th width="43%" align="center"><strong>CANDIDATE NAME</strong></th>
				<th width="20%" align="center"><strong>PASSPORT NO</strong></th>
				<th width="17%" align="center"><strong>TRAVEL DATE</strong></th>
				<th width="12%" align="center"><strong>AMOUNT $</strong></th>
			</tr>
		</thead>
		<tbody>
            <?php
            if(count($batch_detail) > 0){ 
                $count = 1;
                foreach ($batch_detail as $key => $value) {
            ?>
			<tr>
				<td width="8%" align="center"><?php echo $count++;?>.</td>
				<td width="43%" align="left"><?php echo implode(' ', array_filter([$value['first_name'], $value['middle_name'], $value['third_name'], $value['surname']])); ?></td>
				<td width="20%" align="center"><?php echo (($value['passport_no'] !=='') ? $value['passport_no'] : 'NA');?></td>
				<td width="17%" align="center"><?php echo date('d-m-Y', strtotime($value['arrival_date']));?></td>
				<td width="12%" align="center">$700.00</td>
			</tr>
            <?php }}else{ ?>
            <tr>
                <td colspan="5" align="center">Data not available</td>
            </tr>
            <?php } ?>
		</tbody>
	</table>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">
        <tr>
			<td>
                <?php
                    $total_amt = $count*700;
                    // Create a NumberFormatter instance for converting to words
                    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                    // Convert the amount to words
                    $amount_in_words = $formatter->format($total_amt);
                ?>
				<p style="line-height: 10px;"><strong>TOTAL INVOICE AMOUNT = $<?= $total_amt;?>/- (US Dolor <?= ucfirst($amount_in_words);?> Only) </strong></p>
			</td>
		</tr>
		<tr><td></td></tr>
        <tr><td><p>Kindly arrange for the payment at your earliest through bank transfer as details as follows:</p></td></tr>
        <tr><td></td></tr>
	</table>
    <table border="1" cellspacing="0" cellpadding="5" style="font-size: 11px; width: 70%;">
        <tr>
            <td width="35%">Account Name</td>
            <td width="65%">Source One Manpower Services</td>
        </tr>
        <tr>
            <td width="35%">Bank Name</td>
            <td width="65%">Kotak Mahindra Bank</td>
        </tr>
        <tr>
            <td width="35%">Account Number</td>
            <td width="65%">9948229139</td>
        </tr>
        <tr>
            <td width="35%">Branch</td>
            <td width="65%">Kalyan Branch, Mumbai</td>
        </tr>
        <tr>
            <td width="35%">IFSC Code</td>
            <td width="65%">KKBK0000627</td>
        </tr>
        <tr>
            <td width="35%">MICR Code</td>
            <td width="65%">400485040</td>
        </tr>
        <tr>
            <td width="35%">Swift Code</td>
            <td width="65%">KKBKINBBXXX</td>
        </tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">
		<tr><td></td></tr>
        <tr>
			<td>
				<p style="line-height: 5px;">Thanking You</p>
				<p style="line-height: 5px;">Yours Faithfully</p>
				<p style="line-height: 5px;">Source One Manpower Services</p>
			</td>
		</tr>
	</table>
</body>

</html>
