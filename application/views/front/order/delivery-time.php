<?php $this->load->view("front/common/header");?>
<div class="osahan-order_address bg-white">
    <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
        <div class="d-flex align-items-center">
            <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"> <i class="icofont-rounded-left back-page"></i></a>
            <h6 class="font-weight-bold m-0 ml-3"><?php echo $this->lang->line('msg_sch_delv_time') ?></h6>
            <a class="toggle ml-auto" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
    <div class="text-center mb-4 pt-4" style="margin-top:3.5rem">
        <p class="display-2"><i class="icofont-ui-calendar text-success"></i></p>
        <p class="mb-1"><?php echo $this->lang->line('msg_your_current_slot') ?></p>
        <h6 class="font-weight-bold text-dark" id="current_slot"></h6>
    </div>
    <div class="schedule">
        <div class="btn-group bakala-radio btn-group-toggle" data-toggle="buttons" style="margin: auto;display: table;">
			<label class="btn btn-secondary btn-sm" active>
				<input type="radio" name="options" class="date_slot" id="day0" value="<?php echo date("Y-m-d"); ?>" />
				<?php
					$day = date("l");
					echo '<p class="mb-0 font-weight-bold">'. substr($day, 0,3) .'</p>';
					echo '<p class="mb-0">'. date("M d") .'</p>'
				?>
			</label>
			<?php for($i=1;$i<=2;$i++){ ?>
				<label for="day<?php echo $i;?>" class="btn btn-secondary btn-sm">
					<input type="radio" name="options" class="date_slot" id="day<?php echo $i;?>" value="<?php echo date("Y-m-d", strtotime("+$i day")); ?>" />
					<?php
						$day = date("l",strtotime("+$i day"));
						echo '<p class="mb-0 font-weight-bold">'. substr($day, 0,3) .'</p>';
						echo '<p class="mb-0">'. date("M d", strtotime("+$i day")) .'</p>'
					?>
				</label>
			<?php } ?>
		</div>

        <div class="tab-content filter bg-white" id="myTabContent">
            <div class="tab-pane fade show active" id="day" role="tabpanel" aria-labelledby="day-tab">
				<div id="express_delivery">
					<div><img src="images/quick-delivery.png" class="mx-3 pt-2" style="max-width: 120px;" /></div><div class="custom-control border-bottom px-0 custom-radio"><input class="custom-control-input time_slot" type="radio" name="slotRadios" id="slot1" value="60 - 120 min" data-shortname="E" /><label class="custom-control-label py-3 w-100 px-3 font-weight-bold" for="slot1"> <?php echo $this->lang->line('msg_delv_60_20_min') ?> <span style="float:right;margin-right:30px;">SAR <?php echo $this->customer->getExpressCharge(); ?></span></label></div>
				</div>
				<div class="mx-3 pt-2"><h6 class="mb-0"><?php echo $this->lang->line('msg_available_sch_delv') ?></h6></div>
				<div id="time_slot_loop">

				</div>
            </div>
        </div>
    </div>
</div>
<div class="fixed-bottom">
    <a id="proceed_payment" href="javascript:void(0)" class="btn btn-success btn-lg btn-block"><?php echo $this->lang->line('msg_schedule_delv') ?></a>
</div>
<div id="h-dtime">
<input type="hidden" id="delvdateslot" value="<?php echo $this->session->userdata("delv_date"); ?>" />
<input type="hidden" id="delvtimeslot" value="<?php echo $this->session->userdata("delv_time"); ?>" />
</div>
<?php $this->load->view("front/common/footer");?>
<script>
/*
$(document).ready(function(){
  onloadSetDate();
});

function onloadSetDate(){
	var todays_slot = $("input[name='options']:checked").val();
	var d1 = new Date().toISOString().slice(0, 10);
	if(todays_slot !== d1){
		$('#slot1').prop('checked', false);
		$('#express_delivery').hide();
		//document.getElementById("express_delivery").disabled = true;
	}else{
		$('#express_delivery').show();
		//document.getElementById("slot1").disabled = false;
	}

	$("#current_slot").html(todays_slot + '<br/>' + 'Select Time');
	set_delivery_date_slot(todays_slot);
	get_delivery_time_slots(todays_slot);
}
*/
$(document).on('change', '.date_slot', function(){
	var todays_slot = $("input[name='options']:checked").val();
	var d1 = new Date().toISOString().slice(0, 10);
	$("input[name='slotRadios']").prop('checked', false);
	//alert(t1_new);
	if(todays_slot !== d1){
		//document.getElementById("slot1").disabled = true;
		$('#express_delivery').hide();
	}else{
		$('#express_delivery').show();
		//document.getElementById("slot1").disabled = false;
	}

	$("#current_slot").html(todays_slot + '<br/>' + 'Select Time');
	set_delivery_date_slot(todays_slot);
	get_delivery_time_slots(todays_slot);
});

$(document).on('change', '.time_slot', function(){
	var todays_slot = $("input[name='options']:checked").val();
	var d1 = new Date().toISOString().slice(0, 10);
	if(todays_slot !== d1){
		$('#express_delivery').hide();
		//document.getElementById("slot1").disabled = true;
	}else{
		$('#express_delivery').show();
		//document.getElementById("slot1").disabled = false;
	}
	var time_slot = $("input[name='slotRadios']:checked").val();
	var shortname = $("input[name='slotRadios']:checked").data('shortname');
	$("#current_slot").html(todays_slot + '<br/>' + time_slot);
	set_delivery_time_slot(time_slot,shortname);
});

function get_delivery_time_slots(todays_slot){
    $.ajax({
        url: '<?php echo base_url();?>order/delivery_slot_ajax',
		type: "POST",
		data: {'delv_date':todays_slot},
        success: function (data){
          //alert(data);
           $("#time_slot_loop").html(data);
        },
        error: function (xhr, ajaxOptions, thrownError){
			alert(JSON.stringify(xhr));
        }
    });
    return false;
}

var set_delivery_date_slot = function(todays_slot){
	//alert(todays_slot);
	var d1 = new Date().toISOString().slice(0, 10);
	$.ajax({
		url: '<?php echo base_url();?>order/set_delivery_date_slot',
		type: "POST",
		data: {'delv_date':todays_slot},
		success:
		//showResponse,
		function(data){
			cuteAlert({
				type: "success",
				title: "<?php echo $this->lang->line('msg_success') ?>",
				message: "<?php echo $this->lang->line('msg_time_slot_sel') ?>",
				buttonText: "<?php echo $this->lang->line('msg_okay') ?>"
			});
			$("#h-dtime").load(location.href + " #h-dtime>*","");
			//show_snack('success','Date Slot Selected');
		},
		error: function(data){
			cuteAlert({
				type: "error",
				title: "<?php echo $this->lang->line('msg_error') ?>",
				message: "<?php echo $this->lang->line('msg_went_wrong') ?>",
				buttonText: "<?php echo $this->lang->line('msg_okay') ?>"
			});
			//show_snack('danger','Something went wrong, Try again.');
		}
	});
}

function set_delivery_time_slot(time_slot,shortname){
	//alert(time_slot);
	$.ajax({
		url: '<?php echo base_url();?>order/set_delivery_time_slot',
		type: "POST",
		data: {'delv_time':time_slot, 'shortname':shortname},
		success:
		//showResponse,
		function(data){
			cuteAlert({
				type: "success",
				title: "<?php echo $this->lang->line('msg_success') ?>",
				message: "<?php echo $this->lang->line('msg_time_slot_sel') ?>",
				buttonText: "<?php echo $this->lang->line('msg_okay') ?>"
			});
			$("#h-dtime").load(location.href + " #h-dtime>*","");
		},
		error: function(data){
			cuteAlert({
				type: "error",
				title: "<?php echo $this->lang->line('msg_error') ?>",
				message: "<?php echo $this->lang->line('msg_went_wrong') ?>",
				buttonText: "<?php echo $this->lang->line('msg_okay') ?>"
			});
		}
	});
}

$("#proceed_payment").on('click', function(){
	var selected_date_slot = $('#delvdateslot').val();
	var selected_time_slot = $('#delvtimeslot').val();
	//var orderConfirm = confirm("Want to proceed the order?");
	//console.log(selected_time_slot);
	if(selected_date_slot !== '' && selected_time_slot !== '') {
		location.href = "<?php echo base_url('checkout');?>";
	}else{
		cuteAlert({
			type: "warning",
			title: "<?php echo $this->lang->line('msg_warning') ?>",
			message: "<?php echo $this->lang->line('msg_please_sel_delv_slot') ?>",
			buttonText: "<?php echo $this->lang->line('msg_okay') ?>"
		});
		return false;
	}
});

function goBack(){
	window.history.back();
}
</script>
