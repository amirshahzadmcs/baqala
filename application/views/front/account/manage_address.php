<?php $this->load->view("front/common/header");?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVhkcGXDTwxKB39VeBZZ5eIqa5TxEGPhU" defer></script>
<style>
#map{
    height: 50vh;
    margin-bottom: 10px;
    display: none;
}

#locationList{
    display: none;
}

.btn i{
  font-size: 1rem;
  margin-right: 2px;
}

.btn-map{
	font-size: 15px;
    font-weight: 600;
    color: #fff;
}
#toast-container{position:sticky;z-index:1055;top:0}#toast-wrapper{position:absolute;top:0;right:0;margin:5px}#toast-container>#toast-wrapper>.toast{min-width:150px}#toast-container>#toast-wrapper>.toast>.toast-header strong{padding-right:20px}
</style>
<div class="osahan-my_address">
   <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
	  <div class="d-flex align-items-center">
		 <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)">
		 <i class="icofont-rounded-left back-page"></i></a>
		 <h5 class="font-weight-bold m-0 ml-3"><?php echo $this->lang->line('msg_my_address') ?></h5>
		 <button type="button" class="btn btn-outline-success ml-auto" data-toggle="modal" data-target="#addressModal"><?php echo $this->lang->line('msg_add') ?></button>
		 <a class="toggle ml-3" href="#"><i class="icofont-navigation-menu"></i></a>
	  </div>
   </div>
   <div class="p-3" id="address_checkout_ajax" style="margin-top:4rem">
		<?php
		$i = 1;
		if($addresses->num_rows()){
		echo '<p class="bg-white p-2 font-weight-bold">'. $this->lang->line('msg_sel_address') .': </p>';
		foreach($addresses->result() as $address){?>
			<div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
				<input type="hidden" id="delvadd" value="<?php echo $this->session->userdata('delievery_id'); ?>" />
				<input type="radio" id="customRadioInline<?php echo $i; ?>" name="customRadioInline1" class="custom-control-input" onclick="set_delievery('<?php echo $address->id;?>')" <?php if($this->session->userdata('delievery_id') == $address->id){ echo 'checked'; }?> />
				<label class="custom-control-label w-100" for="customRadioInline<?php echo $i; ?>">
					<div>
						<div class="p-3 bg-white rounded shadow-sm w-100">
							<div class="d-flex align-items-center mb-2">
								<p class="mb-0 h6"><?php echo $address->address_type; ?></p>
								<?php if($this->session->userdata('delievery_id') == $address->id){ ?>
								<p class="mb-0 badge badge-success ml-auto"><?php echo $this->lang->line('msg_selected') ?></p>
								<?php } ?>
							</div>
							<p class="small text-muted m-0"><b><?php echo $address->name; ?></b></p>
							<p class="small text-muted m-0"><?php echo $address->complete_address; ?></p>
							<p class="pt-2 m-0 text-right">
								<span class="small">
								<button type="button" class="btn btn-outline-warning btn-sm ml-auto" onclick="edit_address('<?php echo $address->id;?>')"><?php echo $this->lang->line('msg_edit') ?></button>
								<button type="button" class="btn btn-outline-danger btn-sm ml-auto" onclick="delete_address('<?php echo $address->id;?>')"><?php echo $this->lang->line('msg_delete') ?></button>
								</span>
							</p>
						</div>
					</div>
				</label>
			</div>
		<?php $i++;} } else{ ?>
			<div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
				No address added, Please add address to continue...
			</div>
		<?php } ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm modal-dialog-centered">
	  <div class="modal-content">
		 <div class="modal-header">
			<h5 class="modal-title" id="DeleteModalLabel">Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		 </div>
		 <div class="modal-body text-center d-flex align-items-center">
			<div class="w-100 px-3">
			   <i class="icofont-trash text-danger display-1 mb-5"></i>
			   <h6>Are you sure you want to delete this?</h6>
			   <p class="small text-muted m-0">1001 Veterans Blvd</p>
			   <p class="small text-muted m-0">Redwood City, CA 94063</p>
			</div>
		 </div>
		 <div class="modal-footer p-0 border-0">
			<div class="col-6 m-0 p-0">
			   <button type="button" class="btn border-top btn-lg btn-block" data-dismiss="modal">Close</button>
			</div>
			<div class="col-6 m-0 p-0">
			   <button type="button" class="btn btn-danger btn-lg btn-block">Delete</button>
			</div>
		 </div>
	  </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('msg_add_delv_address') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

			<div class="modal-body">
				<div id="map"></div>
				<div class="justify-content-center">
					<button id="showMe" class="btn btn-block center-align my-2 bg-danger btn-map">
						<i class="icofont-pin"></i>
						<?php echo $this->lang->line('msg_use_curr_loc'); ?>
					</button>
				</div>
				<p class="text-center"><?php echo $this->lang->line('msg_or'); ?></p>
				<div class="justify-content-center">
					<button onclick="window.location.href='<?php echo base_url('order/search_address');?>'" class="btn btn-block center-align my-2 bg-info btn-map">
						<i class="icofont-pin"></i>
						<?php echo $this->lang->line('msg_search_by_loc'); ?>
					</button>
				</div>
				<div id="locationList" class="my-3">
					<div class="p-3 rounded bg-success text-white shadow-sm w-100">
						<div class="d-flex align-items-center mb-2">
							<p class="mb-0 h6"><?php echo $this->lang->line('msg_your_address'); ?></p>
						</div>
						<p class="small m-0" id="formated_addr"></p>
					</div>
				</div>
				<?php echo form_open("account/add_address", array("id"=>"address_form"));?>
					<div class="form-row">
						<input type="hidden" id="address_id" name="id" value="" />
						<input type="hidden" id="house_no" name="house_no" value="" />
						<input type="hidden" id="street" name="street" value="" required />
						<input type="hidden" id="sector" name="sector" value="" />
						<input type="hidden" id="locality" name="locality" value="" />
						<input type="hidden" id="city" name="city" value="" required />
						<input type="hidden" id="state" name="state" value="" required />
						<input type="hidden" id="country" name="country" value="" required />
						<input type="hidden" id="postal_code" name="postal_code" value="" required />
						<input type="hidden" id="lat" name="lat" value="" required />
						<input type="hidden" id="lng" name="lng" value="" required />
						<input type="hidden" id="place_id" name="place_id" value="" required />
						<input type="hidden" id="complete_address" name="complete_address" value="" required />
						<div class="col-md-12 form-group">
							<label class="form-label"><?php echo $this->lang->line('msg_person_name'); ?></label>
							<input name="name" id="name" type="text" class="form-control" required />
						</div>
						<div class="col-md-12 form-group">
							<label class="form-label"><?php echo $this->lang->line('msg_mobile'); ?></label>
							<input name="mobile" id="mobile" type="text" class="form-control" required />
						</div>
						<div class="col-md-12 form-group">
							<label class="form-label"><?php echo $this->lang->line('msg_sel_add_type'); ?></label><br/>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="house_type" id="house_type1" value="1">
								<label class="form-check-label" for="house_type1"><?php echo $this->lang->line('msg_villa'); ?></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="house_type" id="house_type2" value="2">
								<label class="form-check-label" for="house_type2"><?php echo $this->lang->line('msg_building'); ?></label>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<label class="form-label" id="villa_label"><?php echo $this->lang->line('msg_villa_no'); ?></label>
							<input name="villa_building" type="text" class="form-control" required />
						</div>
						<div class="col-md-12 form-group">
							<label class="form-label"><?php echo $this->lang->line('msg_delev_inst'); ?></label>
							<input id="instruction" name="instruction" type="text" class="form-control" />
						</div>
						<div class="mb-0 col-md-12 form-group">
							<label class="form-label"><?php echo $this->lang->line('msg_save_as'); ?></label>
							<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
								<label class="btn btn-outline-secondary radio-label active"> <input type="radio" value="Home" name="address_type" id="option1" checked /> Home </label>
								<label class="btn btn-outline-secondary radio-label"> <input type="radio" value="Work" name="address_type" id="option2" /> Work </label>
								<label class="btn btn-outline-secondary radio-label"> <input type="radio" value="Other" name="address_type" id="option3" /> Other </label>
							</div>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer p-0 border-0">
				<div class="col-6 m-0 p-0">
					<button type="reset" class="btn border-top btn-lg btn-block" data-dismiss="modal"><?php echo $this->lang->line('msg_close'); ?></button>
				</div>
				<div class="col-6 m-0 p-0">
					<button form="address_form" type="submit" class="btn btn-success btn-lg btn-block" id="submit_address"><?php echo $this->lang->line('msg_save_change'); ?></button>
				</div>
			</div>

        </div>
    </div>
</div>
<?php
    $this->load->view("front/common/footer-nav");
    $this->load->view("front/common/footer");
?>
<script>
$(".zip-error").hide();
$(".zip-error1").hide();

$(document).ready(function(e) {

	function is_int(value){
	  if ((parseFloat(value) == parseInt(value)) && !isNaN(value)) {
		return true;
	  } else {
		return false;
	  }
	}

	$('input:radio[name="house_type"]').change(function() {
			if ($(this).val() == '1') {
					$('#villa_label').html('<?php echo $this->lang->line('msg_villa_no'); ?>');
			} else {
					$('#villa_label').html('<?php echo $this->lang->line('msg_floor_flat_no'); ?>');
			}
	});

	$("#newpostal").keyup(function() {
		var el = $(this);
		if ((el.val().length == 6) && (is_int(el.val()))) {
			//alert(el.val());
			$.ajax({
			url: "<?php echo base_url();?>home/check_delivery",
			cache: false,
			dataType: "json",
			type: "POST",
			data: "pin_code=" + el.val(),
			success: function(result, success) {
				//console.log(result.result['area']);
				if(result['success'] > 0){
					$(".zip-error1").hide(); /* In case they failed once before */
					$("#new_area").val(result.result['area_name']);
					$("#new_city").val(result.result['city']);
					$("#new_state").val(result.result['state']);
					$("#new_region").val(result.result['region']);
					$("#new_area1").val(result.result['area']);
					$("#new_svc").val(result.result['svc']);
					$("#new_edp").val(result.result['edp']);
					$('#form_1_submit').removeAttr("disabled");
				}else{
					$("#form_1_submit").prop("disabled", true);
					$(".zip-error1").show();
					$('#zip-error1').html(result['message']);
				}
			},
			error: function(result, success) {
				$("#form_1_submit").prop("disabled", true);
				$(".zip-error1").show();
				$('#zip-error1').html(result['message']);
			}

		});
		}
	});

	$("#proceed_slot").on('click', function(){
		var seladd = $('#delvadd').val();
		//var orderConfirm = confirm("Want to proceed the order?");
		if(seladd > 0) {
			location.href = "<?php echo base_url('delivery-slots');?>";
		}else{
			alert('Please select shipping address.');
			return false;
		}
	});

	$('#address_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
        $.ajax({
			url: '<?php echo base_url();?>account/add_address',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success:
			//showResponse,
			function(data){
				get_address_ajax();
				$("#addressModal").modal('hide');
				show_snack('success','Address added successfully')
			},
			error: function(data){
				alert(data);
			}
        });
	}));

	$("#number").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#errmsg").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg").html("Input  14 Digits Only").show();
			return false;
		}
	});

	$("#form_mobile").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 12 Digits Only").show();
			return false;
		}
	});

	$("#postal").on("keypress",function(e){
		if($(this).val().length<='6'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

				$("#errpost").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errpost").html("Maximum input 6 Digits Only").show();
			return false;
		}
	});
});

var get_address_ajax = function(){
	$.ajax({
	url: '<?php echo base_url();?>order/get_address_ajax',
	type: "GET",
	success:
	function(data){
		$('#address_checkout_ajax').html(data);
	},
	error: function(data){alert('Something went wrong !');}
	});
}

var set_delievery = function(shipping){
	//alert(shipping);
	$.ajax({
		url: '<?php echo base_url();?>order/set_delievery_address',
		type: "POST",
		data: {'ship_id':shipping},
		success:
		//showResponse,
		function(data){
			get_address_ajax();
		},
		error: function(data){
			alert(data);
		}
	});
}

var edit_address = function(u){
	$.ajax({
	url: '<?php echo base_url();?>account/get_address',
	type: "POST",
	data: {'id':u},
	success: function(data){
		//alert(data);
		var result = JSON.parse(data);
		$("#address_id").val(result['id']);
		$("#name").val(result['name']);
		$("#mobile").val(result['mobile']);
		$('#house_no').val(result['house_no']);
		$('#street').val(result['street']);
		$('#sector').val(result['sector']);
		$('#locality').val(result['locality']);
		$('#city').val(result['city']);
		$('#state').val(result['state']);
		$('#country').val(result['country']);
		$('#postal_code').val(result['postal_code']);
		$('#lat').val(result['lat']);
		$('#lng').val(result['lng']);
		$('#place_id').val(result['place_id']);
		$('#complete_address').val(result['complete_address']);
		$('#instruction').val(result['instruction']);
		$("#locationList").css("display", "block");
		$('#formated_addr').html(result['complete_address']);
		var add_type = result['address_type'];
		$('.radio-label').removeClass('active');
		if(add_type == 'Home'){
			$("#option1").attr('checked', 'checked');
			$("#option1").closest('label').addClass('active');
		}else if(add_type == 'Work'){
			$("#option2").attr('checked', 'checked');
			$("#option2").closest('label').addClass('active');
		}else{
			$("#option3").attr('checked', 'checked');
			$("#option3").closest('label').addClass('active');
		}

		$("#addressModal").modal("show");
	},
	error: function(data){
		//alert(json.Stringfy(data));
		console.log(data);
	}
	});
}

var delete_address = function(u){
	var msg = confirm("Are you sure want to delete?");
    if(msg == true){
        $.ajax({
			url: '<?php echo base_url();?>account/delete_address',
			type: "POST",
			data: {'id':u},
			success: function(data){
				location.reload();
			},
			error: function(){}
		});
    }
}

function goBack() {
	window.history.back();
}

</script>
<script src="assets/js/map.js"></script>
