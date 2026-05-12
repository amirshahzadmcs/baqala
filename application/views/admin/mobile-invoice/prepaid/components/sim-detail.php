<div class="sim-detail-ajax">
	<h6>Sim Detail:</h6>
	<p><strong>SIM No : <?php echo $sim_detail->sim_no;?></strong></p>
	<p><strong>Service Provider : <?php echo $sim_detail->network_name;?></strong></p>
	<p><strong>Service Type : <?php echo ucfirst($sim_detail->sim_type);?></strong></p>
	<p><strong>Plan : <?php echo $sim_detail->plan_name;?></strong></p>
	<p><strong>Employee ID : <?php echo $sim_detail->emp_no;?></strong></p>
	<p><strong>Employee Name : <?php echo $sim_detail->emp_full_name;?></strong></p>
	<p><strong>Last Recharge Date : <?php echo (isset($last_recharge_detail->recharge_date)) ? $days : 'NA';?></strong></p>
	<p><strong>Last Recharge Amount : <?php echo (isset($last_recharge_detail->total_amount)) ? $days : 'NA';?></strong></p>
	<?php 
	if(isset($sim_detail->recharge_date)){
		$datetime1 = strtotime(date('Y-m-d'));
		$datetime2 = strtotime($sim_detail->recharge_date);
		$secs = $datetime1 - $datetime2;// == return sec in difference
		$days = $secs / 86400;
	}else{
		$days = '0';
	}
	?>
	<p><strong>Days : <?php echo (isset($sim_detail->recharge_date)) ? $days : 'NA';?></strong></p>
</div>