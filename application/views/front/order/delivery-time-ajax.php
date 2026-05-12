<?php 
	if(count($time_slots)){
	foreach($time_slots as $time_slot){?>
	<div class="custom-control border-bottom px-0 custom-radio">
		<input class="custom-control-input time_slot" type="radio" name="slotRadios" id="slot<?php echo $time_slot->id;?>" value="<?php echo date("h:i A", strtotime($time_slot->time_from));?> - <?php echo date("h:i A", strtotime($time_slot->time_to));?>" data-shortname="<?php echo $time_slot->short_name;?>" />
		<label class="custom-control-label py-3 w-100 px-3 font-weight-bold" for="slot<?php echo $time_slot->id;?>"> <i class="icofont-clock-time mr-2"></i> <?php echo $time_slot->name;?> <span style="float:right;margin-right:30px;">SAR <?php echo $shipping_charge; ?></span></label>
	</div>
<?php }}else{ ?>
	<div class="p-3"><p><?php echo $this->lang->line('msg_no_slot_available') ?></p></div>
<?php } ?>