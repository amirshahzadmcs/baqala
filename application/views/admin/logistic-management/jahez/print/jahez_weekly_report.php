<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Jahez Weekly Performance Report</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
			.remark-good {
				color: green;
			}

			.remark-needs-focus {
				color: #E26310;
			}

			.remark-low-performer {
				color: red;
			}

		</style>
	</head>
	<body>
		
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 100%;">
			<tr>
				<td>
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 10px;">
						<tr>
							<?php
							if($search_start_date !== 'NA' && $search_start_date !== $search_end_date){
								$data_range = $search_start_date .' - '. $search_end_date;
							}elseif ($search_start_date !== 'NA' && $search_start_date == $search_end_date) {
								$data_range = $search_start_date;
							}else{
								$data_range = 'ALL';
							}
							?>
							<td valign="middle" style="text-align:left;color:#000;"><?php echo ($team_name !== '') ? $team_name : 'Team - ALL';?></td>
							<td colspan="4" valign="middle" style="text-align:right;color:#000;">Jahez - Weekly Delivery Report - <?php echo $data_range;?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="3">
						<tr>
							<th width="33px" align="center" style="background-color: #ddd;color:#000">S.No</th>
							<th width="53px" align="center" style="background-color: #ddd;color:#000">Emp ID</th>
							<th width="205px" style="background-color: #ddd;color:#000">Rider Name</th>
							<th width="60px" align="center" style="background-color: #ddd;color:#000">Jahez ID</th>
							<th width="50px" align="center" style="background-color: #ddd;color:#000">Team</th>
							<th width="53px" align="center" style="background-color: #ddd;color:#000">Target Delivery</th>
							<th width="60px" align="center" style="background-color: #ddd;color:#000">Completed Delivery</th>
							<th width="55px" align="center" style="background-color: #ddd;color:#000">Pending Delivery</th>
							<th width="60px" align="center" style="background-color: #ddd;color:#000">Remaining Days</th>
							<th width="75px" style="background-color: #ddd;color:#000">Remark</th>
						</tr>
						<?php if(!empty($weekly_report)) { ?>
							<?php $count=1;foreach ($weekly_report as $row): ?>
							<tr>
								<td align="center"><?php echo $count++; ?></td>
								<td align="center"><?php echo $row['Emp ID']; ?></td>
								<td><?php echo $row['Rider Name']; ?></td>
								<td align="center"><?php echo $row['Jahez ID']; ?></td>
								<td align="center"><?php echo $row['Team Name']; ?></td>
								<td align="center"><?php echo $row['Target Delivery']; ?></td>
								<td align="center"><?php echo $row['Completed Delivery']; ?></td>
								<td align="center"><?php echo $row['Pending Delivery']; ?></td>
								<td align="center"><?php echo $row['Remaining Days']; ?></td>
								<td class="
										<?php
											if ($row['Remark'] === 'Good') {
												echo 'remark-good';
											} elseif ($row['Remark'] === 'Needs Focus') {
												echo 'remark-needs-focus';
											} else {
												echo 'remark-low-performer';
											}
										?>">
										<?php echo $row['Remark']; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						<?php } else { ?>
							<tr>
								<td colspan="10">No data available</td>
							</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
