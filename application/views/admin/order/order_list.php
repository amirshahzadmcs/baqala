<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}

.modal .modal-dialog-aside{
	width: 350px;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}


.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }

.stockModalFullscreen .table thead tr{
	background: #c8f5c9;
    color: #000;
    font-size: 11px;
    font-weight: 600;
}
.stockModalFullscreen .table>:not(caption)>*>* {
    padding: 0.4rem 0.5rem;
	font-size: 13px;
}

/*---- Timeline ----*/
.history-tl-container {
    margin: auto;
    display: block;
    position: relative;
}
.history-tl-container ul.tl {
    margin: 20px 0;
    padding: 0;
    display: inline-block;
}
.history-tl-container ul.tl li {
    list-style: none;
    margin: auto;
    margin-left: 150px;
    min-height: 50px;
    /*background: rgba(255,255,0,0.1);*/
    border-left: 1px dashed #86d6ff;
    padding: 0 0 50px 30px;
    position: relative;
}
.history-tl-container ul.tl li:last-child {
    border-left: 0;
}
.history-tl-container ul.tl li:last-child::before {
	animation: pulseshodow 2s infinite;
    border-radius: 99px!important;
    background-size: 100% 100%;
    background-image: linear-gradient(to top,#03a9f4 50%,transparent 50%);
    -webkit-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -webkit-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -ms-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    -o-transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
    transition: background-position 300ms,color 300ms ease,border-color 300ms ease!important;
}
@-webkit-keyframes pulseshodow{0%{-webkit-box-shadow:0 0 0 0 rgb(64 196 255)}70%{-webkit-box-shadow:0 0 0 20px rgba(204,169,44,0)}100%{-webkit-box-shadow:0 0 0 0 rgba(204,169,44,0)}}@keyframes pulseshodow{0%{-moz-box-shadow:0 0 0 0 rgb(3,169,244);box-shadow:0 0 0 0 rgb(3,169,244)}70%{-moz-box-shadow:0 0 0 20px rgba(204,169,44,0);box-shadow:0 0 0 20px rgba(204,169,44,0)}100%{-moz-box-shadow:0 0 0 0 rgba(204,169,44,0);box-shadow:0 0 0 0 rgba(204,169,44,0)}}

.history-tl-container ul.tl li::before {
    position: absolute;
    left: -10px;
    top: -5px;
    content: " ";
    border: 8px solid rgba(255, 255, 255, 0.74);
    border-radius: 500%;
    background: #258cc7;
    height: 20px;
    width: 20px;
    transition: all 500ms ease-in-out;
}
.history-tl-container ul.tl li:hover::before {
    border-color: #258cc7;
    transition: all 1000ms ease-in-out;
}

ul.tl li .item-detail {
    color: #000;
    font-size: 12px;
}
ul.tl li .timestamp {
    color: #8d8d8d;
    position: absolute;
    width: 100px;
    left: -125px;
    text-align: right;
    font-size: 12px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #ffc107;
    color: #000000;
}
.table-bordered {
    border: 1px solid #cdcdcd;
}
.active-tr{
	background-color: #edffee;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Order List</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Order</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<!--
					<button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i></button>
					-->
					<?php } ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php } else{?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>
			</div>
		</div>
	</div>
</div>
 <!-- end page title -->

<div class="container-fluid">
 	<div class="page-content-wrapper">
 		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/order/list'); ?>" method="get" id="filter_form">
							<div class="row p-2">
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label>Select Store</label>
										<select class="form-control show-tick select2" name="store_id" data-placeholder="Choose Store...">
											<option value="">Select</option>
											
										</select>
									</div>
								</div>
								
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label>Order Number</label>
										<div class="input-group">
											<span class="input-group-text">ORN-</span>
											<input type="number" id="_order_number" name="order_no" value="<?php echo $this->input->get('order_no') ? $this->input->get('order_no') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-4 px-1">
									<div class="form-group mb-2">
										<label class="d-block">Select Status </label>
										<select style="height:410px;" name="status" class="form-control select2 w-100">
											<option value="">All Status</option>
											<option value="1" <?php echo ($this->input->get('status') == '1') ? 'selected':'';?>>Received</option>
											<option value="2" <?php echo ($this->input->get('status') == '2') ? 'selected':'';?>>Accepted</option>
											<option value="3" <?php echo ($this->input->get('status') == '3') ? 'selected':'';?>>Deny</option>
											<option value="4" <?php echo ($this->input->get('status') == '4') ? 'selected':'';?>>Assigned</option>
											<option value="5" <?php echo ($this->input->get('status') == '5') ? 'selected':'';?>>Dispatched</option>
											<option value="6" <?php echo ($this->input->get('status') == '6') ? 'selected':'';?>>Delivered</option>
											<option value="7" <?php echo ($this->input->get('status') == '7') ? 'selected':'';?>>Cancel on Delivery</option>
											<option value="8" <?php echo ($this->input->get('status') == '8') ? 'selected':'';?>>Refund</option>
											<option value="9" <?php echo ($this->input->get('status') == '9') ? 'selected':'';?>>Cancel by Customer</option>
										</select>
									</div>
								</div>
								<?php
									$adv_show = false;
									if(!empty($this->input->get('min_price')) || !empty($this->input->get('max_price')) || !empty($this->input->get('from')) || !empty($this->input->get('to')) || !empty($this->input->get('slotFilter')) || !empty($this->input->get('delivery_id'))){
										$adv_show = true;
									}
								?>
								<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
									<div class="row">
										<div class="col-md-4 px-1">
											<div class="form-group mb-2">
												<label>Total Price Between (Min and Max)</label>
												<div class="input-group">
													<input type="number" id="_more_than" name="min_price" min="0" placeholder="Min Price" value="<?php echo $this->input->get('min_price') ? $this->input->get('min_price') : ''; ?>" autocomplete="off" class="form-control">
													<input type="number" id="_less_than" name="max_price" min="1" placeholder="Max Price" value="<?php echo $this->input->get('max_price') ? $this->input->get('max_price') : ''; ?>" autocomplete="off" class="form-control">
												</div>
											</div>
										</div>
										<div class="col-md-4 px-1">
											<div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>
										<div class="col-md-4 px-1">
											<div class="form-group mb-2">
												<label for="slotFilter">Slots: </label>
												<select class="form-control" id="slotFilter" name="slotFilter">
													<option value="">--- Select Slot ---</option>
													<option value="60 - 120 min" <?php if($this->input->get('slotFilter') == '60 - 120 min'){ echo 'selected'; }?>>60 - 120 min (ED)</option>
													
													<?php foreach($slots as $slot){ ?>
													<?php $tslot = date("h:i A", strtotime($slot->time_from)) .' - '. date("h:i A", strtotime($slot->time_to));?>
													<option value="<?php echo $tslot;?>" <?php if($this->input->get('slotFilter') == $tslot){ echo 'selected'; }?>><?php echo $slot->short_name .' ('. $slot->name .')' ; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-4 px-1">
											<div class="form-group mb-2">
												<label>Delivery Person</label>
												<select class="form-control select2" id="delivery_id" name="delivery_id">
													<option value="">--- All ---</option>
													<?php foreach(deliveryBoyList() as $dboy){ ?>
													<option value="<?php echo $dboy->id; ?>" <?php echo ($this->input->get('delivery_id') == $dboy->id) ? 'selected':'';?>><?php echo $dboy->name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/order/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
 			<div class="col-12">
 				<div class="card">
 					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
		 					<table id="vendor-table" class="table table-bordered jambo_table bulk_action" style="width:100%">
		 						<thead>
		 							<tr>					  
									 	<th>#</th>
										<th>ORDER ID</th>			  
										<th>WAREHOUSE/STORE</th>			  
										<th>STATUS</th>			  
										<th>PLACED AT</th>				  
										<th style="width: 50px;">TIME LEFT</th>				  
										<th>CUSTOMER</th>
										<th>PICKER</th>							
										<th>PAYMENT METHOD</th>
										<th>ORIGINAL AMT.</th>
										<th>FINAL AMT.</th>
										<th>ACTION</th>
									</tr>
		 						</thead>
								<tbody>
									<?php $sno = 1;
									// echo '<pre>';print_r($result->result());exit();
									foreach($result->result() as $result){?>
									<tr id="tr_<?= $sno;?>">
										<td><?php echo $sno;?></td>
										<td>
											<a href="<?php echo base_url()?>admin/order/detail?id=<?php echo $result->id;?>" target="_blank" style="border-bottom: 1px dashed;font-weight:600;">
											<?php echo $result->invoice_prefix .'-'. $result->order_no; ?><br/>
											</a><br>
											<?php if($result->shipping_type == '1'){
												echo '<span class="badge badge-pill badge-soft-danger font-size-13">Express</span>';
											} ?>
										</td>
										<td>Warehouse</td>
										<td>
											<?php if($result->order_status_id == '0'){
												echo '<div class="badge badge-pill badge-soft-secondary font-size-13">Payment Pending</div>';
											}
											if($result->order_status_id == '1'){
												echo '<span class="badge badge-pill badge-soft-info font-size-13">Recieved</span>';
											}
											
											if($result->order_status_id == '2'){
												echo '<span class="badge badge-pill badge-soft-primary font-size-13">Accepted</span>';
											}
											if($result->order_status_id == '3'){
												echo '<span class="badge badge-pill badge-soft-danger font-size-13">Cancel By Admin</span>';
											}
											if($result->order_status_id == '4'){
												echo '<span class="badge badge-pill badge-soft-primary font-size-13">Van Assigned</span>';
											}
											if($result->order_status_id == '5'){
												echo '<span class="badge badge-pill badge-soft-info font-size-13">Dispatched</span>';
											}
											
											if($result->order_status_id == '6'){
												echo '<span class="badge badge-pill badge-soft-success font-size-13">Delivered</span>';
											}
											
											if($result->order_status_id == '7'){
												echo '<span class="badge badge-pill badge-soft-warning font-size-13">Cancel On Delivery</span>';
											}
											
											if($result->order_status_id == '8'){
												echo '<span class="badge badge-pill badge-soft-warning font-size-13">Refund</span>';
											}
											
											if($result->order_status_id == '9'){
												echo '<span class="badge badge-pill badge-soft-danger font-size-13">Cancel By Customer</span>';
											}
											?>
										</td>
										<td><?php echo date('d-m-Y h:i A', strtotime($result->date_added)); ?></td>
										<td>
										    <?php if($result->c_role == '2'){ ?>
										    <span>N/A</span>
										    <?php }else{ ?>
										    <span id="time_<?= $sno;?>" data-id="time_<?= $sno;?>" data-time="00:00:00" data-date="<?php echo $result->shipping_date_slot;?>" data-datetime="<?php echo $result->shipping_date_slot;?> 00:00:00"></span>
										    <?php } ?>
										</td>
										<td>
											<?php echo $result->name;?><br/>
											<?php 
												if($result->c_role == '2'){
													echo '<span class="badge badge-pill badge-soft-danger font-size-13">Business</span>';
												}
											?>
										</td>
										<td>N/A</td>
										<td><?php echo $result->payment_method;?></td>
										<td><?php echo $result->order_total;?></td>
										<td><?php echo $result->net_payble_amt;?></td>
										<td id="td_<?= $result->id;?>"><button type="button" class="btn btn-primary btn-sm" onclick="quickView('<?= $result->id;?>','tr_<?= $sno;?>')"><i class="mdi mdi-eye font-size-16"></i></button></td>
									</tr>
									<?php $sno++;} ?>
								</tbody>
		 					</table>
		 				</form>
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
</div>

<div class="modal fade stockModalFullscreen" tabindex="-1" aria-labelledby="#stockModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="stockModalFullscreenLabel">STOCK TRANSFER REQUEST</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest'"></button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" onclick="window.location.href='<?php echo base_url(); ?>admin/stockrequest'" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#vendor-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "copy",
				className: "btn-md"
			},
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			/*
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},*/
		],
		"responsive": false,
		//"processing":true,
		//"serverSide":true,
		fixedHeader: true,
		"order":[],
		/*
		"ajax":{
				url:"<?php echo base_url();?>admin/stockrequest/get_list",
				type:"POST"
			},
		*/
		"columnDefs":[
			{
			"targets":[0,1,2,3,4,5,6,7,8,9,10,11],
			"orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};

function quickView(id,req_tr){
	if(id > 0){
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/order/quick-view",
			data: {'id': id},
			//dataType: "json",
			success: function (response) {
				//console.log(response);
				$(".close-tr").click();
				$('tr').removeClass(' active-tr');
				$('#'+req_tr).addClass(' active-tr');
				$('#'+req_tr).after(response);
				$('#td_'+id).html('<button type="button" class="btn btn-danger btn-sm close-tr" onclick="closeView(\''+ req_tr +'\', \''+ id +'\')"><i class="mdi mdi-eye-off font-size-16"></i></button>');
				$('html, body').animate({
					scrollTop: eval($('#td_'+id).offset().top - 80)
				}, 500, 'linear');
			},
			error: function (request, error) {
				//console.log(" Can't do because: " + JSON.stringify(request));
				$('#'+req_tr).after(JSON.stringify(request));
			},
		});
	}else{
		alert('Invalid request id!');
	}
}

function closeView(req_tr,id){
	if(id > 0){
		$('#trclone_'+id).remove();
		//$('#'+req_tr).after(response);
		$('#td_'+id).html('<button type="button" class="btn btn-primary btn-sm" onclick="quickView(\''+ id +'\', \'' + req_tr +'\')"><i class="mdi mdi-eye font-size-16"></i></button>');
	}else{
		alert('Invalid request id!');
	}
}
</script>

<script>
	/*
	$(document).ready(function(){
		var rowCount = $('#vendor-table tbody tr').length;
		for (let si = 1; si <= rowCount; si++) {
			var sid = $("#time_"+si).attr('data-id');
			//var stime = $("#time_"+si).attr('data-time');
			//var sdate = $("#time_"+si).attr('data-date');
			var sdatetime = $("#time_"+si).attr('data-datetime');
			//let newDate = new Date(sdatetime);
			//let newDate1 = newDate.toDateString();
			startTimer(sid,sdatetime);
		}
	});
	
	function startTimer(sid,sdatetime) {
		// Set the date we're counting down to
		var countDownDate = new Date(sdatetime).getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();
			
		// Find the distance between now and the count down date
		var distance = countDownDate - now;
			
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
		// Output the result in an element with id="demo"
		document.getElementById(sid).innerHTML = days + "d " + hours + "h "
		+ minutes + "m " + seconds + "s ";
			
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById(sid).innerHTML = "EXPIRED";
		}
		}, 1000);
	}*/
</script>
