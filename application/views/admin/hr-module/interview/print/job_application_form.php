<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Interview Evaluation Form</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="40px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:38%;text-align: left;font-size: 14px;line-height:15px;">
				<strong>INTERVIEW EVALUATION FORM</strong><br><strong> نموذج تقييم المقابلة </strong>
			</td>
			<td valign="center" style="width:62%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="4" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" align="right">Date/التاريخ : <?php echo $data['print_date']; ?></td>
		</tr>
		<!-- <tr>
			<td colspan="4" valign="center"></td>
		</tr> -->
		<tr>
			<td colspan="4" valign="center" style="text-align: center;"><strong> Complete the following job application form to be considered for employement. </strong></td>
		</tr>
	</table>

    <table cellpadding="3" cellspacing="0" style="width: 100%;font-size: 8px;" style="border:1px solid #b1b1b1;">

        <!-- Header -->
        <tr bgcolor="#e6e6e6">
            <td colspan="2" style="border:1px solid #b1b1b1;border-bottom:2px solid #000;border-right:1px solid #e6e6e6;"><strong>PERSONAL INFORMATION</strong></td>
			<td colspan="2" style="border:1px solid #b1b1b1;border-bottom:2px solid #000;border-left:1px solid #e6e6e6;text-align:right;"><strong><?php echo $interview_detail->interview_no ?? ''; ?></strong></td>
        </tr>

        <!-- Row 1 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">1</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Full Name</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td cols="2" style="border-bottom:1px solid #b1b1b1;" width="76%"> <?php echo htmlspecialchars($interview_detail->applicant_name ?? ''); ?></td>
        </tr>

        <!-- Row 2 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">2</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Iqama No</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="33%" style="border-bottom:1px solid #b1b1b1;">
                <!-- 10 boxes -->
                <table border="1" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <?php $iqama = $interview_detail->iqama_number ?? ''; ?>
                    <tr><?php for ($i = 0; $i < 10; $i++): ?><td style="width:18px;height:18px;text-align:center;"><?php echo htmlspecialchars($iqama[$i] ?? ''); ?></td><?php endfor; ?></tr>
                </table>
            </td>
            <td width="43%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <?php 
                        $iqama_expiry = $interview_detail->iqama_expiry ?? ''; 

                        if (!empty($iqama_expiry)) {

                            $expiry_ts = strtotime($iqama_expiry);
                            $today_ts  = strtotime(date('Y-m-d'));

                            // Days difference (positive or negative)
                            $days_left = ceil(($expiry_ts - $today_ts) / (60 * 60 * 24));

                            // Status
                            $is_valid = $days_left >= 0;

                            if ($is_valid) {
                                $status_text = "(" . $days_left . "D Left)";
                            } else {
                                $status_text = "(" . abs($days_left) . "D ago)";
                            }

                        } else {
                            $is_valid = false;
                            $status_text = "_________";
                        }
                    ?>

                    <tr>

                        <!-- VALID -->
                        <td style="border:1px solid #000;width:18px;height:18px;text-align:center"><?= $is_valid ? '✔' : ''; ?></td>
                        <td width="120">Valid <?= $is_valid ? $status_text : '_________'; ?></td>

                        <!-- EXPIRED -->
                        <td style="border:1px solid #000;width:18px;height:18px;text-align:center"><?= !$is_valid && !empty($iqama_expiry) ? '✔' : ''; ?></td>
                        <td width="140">Expired <?= (!$is_valid && !empty($iqama_expiry)) ? $status_text : ''; ?></td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- Row 3 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">3</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Date of Birth</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;"> <?php echo !empty($interview_detail->date_of_birth) && $interview_detail->date_of_birth !== '0000-00-00' ? date('d-m-Y', strtotime($interview_detail->date_of_birth)) : 'NA'; ?></td>
        </tr>

        <!-- Row 4 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">4</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Mobile Number</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;"> <?php echo htmlspecialchars($interview_detail->mobile_number ?? 'NA'); ?></td>
        </tr>

        <!-- Row 5 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">5</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">E-mail</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;"> <?php echo htmlspecialchars($interview_detail->email ?? 'NA'); ?></td>
        </tr>

        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">5</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Nationality</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;"> <?php echo htmlspecialchars($interview_detail->nationality_name ?? 'NA'); ?></td>
        </tr>

        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">5</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">No of Transfer</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;"> <?php echo htmlspecialchars($interview_detail->no_of_transfer ?? 'NA'); ?></td>
        </tr>

        <!-- Row 6 (IBAN) -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">6</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Bank IBAN</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;">
                <table border="1" cellpadding="2" cellspacing="0" align="left">
                    <?php $iban = $interview_detail->iban_number ?? ''; ?>
                    <tr>
                        <!-- 22 IBAN boxes -->
                        <?php for ($i = 0; $i < 24; $i++): ?>
                        <td style="width:20px;height:20px;text-align:center;"><?php echo htmlspecialchars($iban[$i] ?? ''); ?></td>
                        <?php endfor; ?>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Row 7 Driving Licence -->
        <!-- Row 1 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">7</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Driving Licence</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="1" cellspacing="2">
                    <?php
                        $has_dl = $interview_detail->has_driving_license ?? 'no';
                        $has_dl_type = $interview_detail->driving_license_type ?? '';
                    ?>
                    <tr>
                        <?php if($has_dl === 'no'){ ?>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl === 'no' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">No</td>
                        <?php } elseif($has_dl === 'yes') { ?>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl === 'yes' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">Yes</td>
                        <?php } elseif($has_dl === 'home_land') { ?>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl === 'home_land' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">Home Land</td>
                        <?php } ?>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl_type === 'Car' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">Car</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl_type === 'Bike' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">Bike</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_dl_type === 'Light Transport' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">Light Transport</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;"></td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;"> </td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center"></td>
            <?php if($has_dl === 'home_land') { ?>
            <td width="39%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <?php 
                        $arrival_date      = $interview_detail->arrival_date ?? ''; 
                        $dl_arrival_date   = !empty($arrival_date) ? date('d-m-Y', strtotime($arrival_date)) : '';
                        $days_left         = '';

                        if (!empty($arrival_date)) {
                            $arrival   = new DateTime($arrival_date);
                            $today     = new DateTime(date('Y-m-d'));
                            $interval  = $today->diff($arrival);

                            // Positive if arrival is in the future, negative if already passed
                            $days_left = $interval->format('%r%a');  
                        }
                    ?>
                    <tr>
                        <td>Arrival Date: <?php echo $dl_arrival_date; ?> </td>
                    </tr>
                </table>
            </td>
            <td width="36%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <tr>
                        <td>Arrival in <?= $days_left ?> day(s) </td>
                    </tr>
                </table>
            </td>
            <?php }else { ?>
            <td width="39%" style="border-bottom:1px solid #b1b1b1;">
                <!-- 10 boxes -->
                <table border="1" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <?php $driving_license = $interview_detail->driving_license_number ?? ''; ?>
                    <tr>
                        <?php for ($i = 0; $i < 10; $i++): ?>
                        <td style="width:18px;height:18px;text-align:center;"><?php echo htmlspecialchars($driving_license[$i] ?? ''); ?></td>
                        <?php endfor; ?>
                    </tr>
                </table>
            </td>
            <td width="36%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="2" cellspacing="0" align="left" style="width:100%">
                    <?php 
                        $dl_expiry = $interview_detail->driving_license_expiry ?? ''; 
                        $dl_expiry_date = !empty($dl_expiry) ? date('d-m-Y', strtotime($dl_expiry)) : '';
                    ?>
                    <tr>
                        <td>Expiry Date: <?php echo $dl_expiry_date; ?> </td>
                    </tr>
                </table>
            </td>
            <?php } ?>
        </tr>

        <!-- Row 8 Work Experience -->
        <tr>
            <?php
                $has_hunger_station = $interview_detail->has_hunger_station ?? '0';
                $has_jahez = $interview_detail->has_jahez ?? '0';
                $has_keeta = $interview_detail->has_keeta ?? '0';
                $has_noon = $interview_detail->has_noon ?? '0';
                $has_toyou = $interview_detail->has_toyou ?? '0';
                $has_marsool = $interview_detail->has_marsool ?? '0';
                $has_chefz = $interview_detail->has_chefz ?? '0';

                $has_experience = 'no';
                if($has_hunger_station === '1' || $has_jahez === '1' || $has_keeta === '1' || $has_noon === '1' || $has_toyou === '1' || $has_marsool === '1' || $has_chefz === '1') {
                    $has_experience = 'yes';
                }
            ?>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">8</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Work Experience</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="1" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_experience === 'yes' ? ' ✔ ' : ''; ?></td>
                        <td width="20%">Experienced</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_experience === 'no' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">Fresher</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Row 9 Aggregator -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">9</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Aggregator</td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="1" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_hunger_station === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Hunger</td>

                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_jahez === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Jahez</td>

                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_keeta === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Keeta</td>

                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_chefz === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Chefz</td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;"></td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;"></td>
            <td width="3%" style="border-bottom:1px solid #b1b1b1;" align="center"></td>
            <td width="76%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="1" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_noon === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Noon</td>

                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_toyou === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> ToYou</td>

                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $has_marsool === '1' ? ' ✔ ' : ''; ?></td>
                        <td width="20%"> Marsool</td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>

	<table>
        <tr><td height="10px;"></td></tr>
    </table>
	<table cellpadding="2" cellspacing="0" style="width: 100%;font-size: 8px;" style="border:1px solid #b1b1b1;">

        <!-- Header -->
        <tr bgcolor="#e6e6e6">
            <td colspan="4" style="border:1px solid #b1b1b1;border-bottom:2px solid #000;"><strong>EMPLOYMENT INFORMATION</strong></td>
        </tr>

        <!-- Row 1 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">1</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Desired Job Title</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td cols="2" style="border-bottom:1px solid #b1b1b1;" width="75%"><?php echo $interview_detail->pos_name;?></td>
        </tr>

        <!-- Row 2 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">2</td>
            <td width="17%" style="border-bottom:1px solid #b1b1b1;">Preferred City</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="75%" style="border-bottom:1px solid #b1b1b1;"><?php $city_name = $interview_detail->city_name ?? 'NA'; echo htmlspecialchars($city_name);?></td>
        </tr>

        <!-- Row 3 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">3</td>
            <td width="60%" style="border-bottom:1px solid #b1b1b1;">Is the Applicant expected to have long term relation with company.</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="32%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->long_term_relation === 'yes' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">Yes</td>
                        <td width="20"></td>
                        <td width="15%"></td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->long_term_relation === 'no' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">No</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Row 4 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">4</td>
            <td width="60%" style="border-bottom:1px solid #b1b1b1;">Is the Applicant willing to transfer the sponsorship to company.</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="32%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->transfer_sponsorship === 'yes' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">Yes</td>
                        <td width="20"></td>
                        <td width="15%"></td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->transfer_sponsorship === 'no' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">No</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Row 5 -->
        <tr>
            <td width="4%" align="center" style="border-right:1px solid #b1b1b1;border-bottom:1px solid #b1b1b1;">5</td>
            <td width="60%" style="border-bottom:1px solid #b1b1b1;">Recommendation for Hiring.</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="32%" style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->recommendation === 'yes' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">Yes</td>
                        <td width="20"></td>
                        <td width="15%"></td>
                        <td style="border:1px solid #000;width:18px;height:18px;"><?php echo $interview_detail->recommendation === 'no' ? ' ✔ ' : ''; ?></td>
                        <td width="25%">No</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Row 6 Remarks -->
        <tr>
            <td colspan="2" width="10%" style="border-bottom:1px solid #b1b1b1;">Remarks</td>
            <td width="4%" style="border-bottom:1px solid #b1b1b1;" align="center">:</td>
            <td width="86%" style="border-bottom:1px solid #b1b1b1;">
                <?php echo nl2br(htmlspecialchars($interview_detail->remarks ?? 'NA')); ?>
            </td>
        </tr>
    </table>

    <table>
        <tr><td height="10px;"></td></tr>
    </table>
    <table cellspacing="0" cellpadding="3" border="1" style="width: 100%;font-size: 10px;">
        <!-- Header -->
        <tr bgcolor="#e6e6e6">
            <td colspan="6" style="border:1px solid #b1b1b1;border-bottom:2px solid #000;"><strong>CANDIDATE EVALUATION BY INTERVIEW (FOR OFFICE USE ONLY)</strong></td>
        </tr>  
        <tr>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: center;">Poor</td>
            <td valign="middle" style="text-align: center;">Medium</td>
            <td valign="middle" style="text-align: center;">Good</td>
            <td valign="middle" style="text-align: center;">Excellent</td>
            <td valign="middle" style="text-align: center;">Remarks</td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">Professional Skills</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">Self Confidence</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">Language</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">Decision Making</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">English</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
        <tr>
            <td valign="middle" style="text-align: left;">Arabic</td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
            <td valign="middle" style="text-align: left;"></td>
        </tr>
    </table>

    <table>
        <tr><td height="10px;"></td></tr>
    </table>
    <!--
	<table cellpadding="2" cellspacing="0" style="width: 100%;font-size: 8px;" style="border:1px solid #b1b1b1;">
        
        <tr bgcolor="#e6e6e6">
            <td style="border:1px solid #b1b1b1;border-bottom:2px solid #000;"><strong>CHECK LIST - LOCAL ON-BOARDING (FOR OFFICE USE ONLY)</strong></td>
        </tr>    
        <tr>
            <td style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2" style="width: 100%;">
                    
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Fill Job Application Form</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Attach Iqama + DL Copy + IBAN Certificate</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2" style="width: 100%;">
                    
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Make Nafiz Authorization (Bike + SIM Card)</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Allot Bike in system</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2" style="width: 100%;">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Allot User ID</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Allot SIM Card</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid #b1b1b1;">
                <table border="0" cellpadding="0" cellspacing="2" style="width: 100%;">
                    <tr>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Send Rider to Housing</td>
                        <td style="border:1px solid #000;width:18px;height:18px;"></td>
                        <td width="40%">&nbsp;&nbsp;Handover the Vehicle</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    -->
    <table cellspacing="0" cellpadding="2" style="width: 100%;font-size: 10px;">
		<!-- <tr>
			<td colspan="2" valign="center" style="text-align: left;"></td>
		</tr> -->
		<tr>
			<td style="text-align:center;"><br><br><?php echo $data['issue_date'];?><br>------------------------- <br>Apply Date</td>
			<td style="text-align:center;"><br><br><br>------------------------- <br>Candidate</td>
			<td style="text-align:center;"><br><br><?php echo $interview_detail->added_by_emp_no;?><br>------------------------- <br>Recruitment</td>
			<td style="text-align:center;"><br><br><br>------------------------- <br>Operation</td>
			<td style="text-align:center;"><br><br><br>------------------------- <br>Admin</td>
			<td style="text-align:center;"><br><br><br>------------------------- <br>HR</td>
		</tr>
	</table>
</body>

</html>
