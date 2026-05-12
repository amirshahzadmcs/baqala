<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
.table>:not(caption)>*>* {
    border-bottom-width: 0;
    border-top-width: 0px;
}
.searchResults{
	list-style: none;
    position: absolute;
	left: 33px;
    width: 94%;
    cursor: pointer;
    overflow-y: auto;
    max-height: 420px;
    box-sizing: border-box;
    z-index: 99;
    padding: 12px;
    background-color: #fff;
    box-shadow: 1px 2px 5px #484848;
}
.searchResults .item-list{
	padding: 10px 0px;
    border-bottom: 1px solid #ddd;
}
.searchResults .item-name{
	line-height: 21px !important;
}
.searchResults button{
	float: left;
    margin-top: 7px;
	margin-right: 20px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>SP Requisition Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/requisition/list');?>">Requisition</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/spare-parts/requisition/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-custom-success btn-sm pull-right me-1"><i class="fa fa-save"></i> Save</button>
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
 					<div class="card-body">
					 	<form id="demo-form2" method="post" action="<?php echo base_url('admin/spare-parts/requisition/update')?>" class="form-label-left" data-toggle="validator" role="form">
							<input type="hidden" id="requisition_id" name="requisition_id" value="<?php echo $order->id;?>" required="required">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2" style="border-bottom: 2px solid #f4c53a;">
										<img src="<?php echo base_url('admin_assets/images/header-top.png');?>" style="width:100%;max-width: 100%;" />
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="width: 40%;">
										<strong>Requisition Detail </strong><br /><br/>Requisition No. : <?php echo $order->requisition_no; ?><br/>
										Requisition Type : <?php echo ucfirst($order->requisition_type); ?><br/>
										Requisition Date : <?php echo date("d-m-Y", strtotime($order->requisition_date)); ?><br/>
										
									</td>
									<td valign="top" style="width: 60%; float: right;text-align: right;">
										<strong>Supplier Detail </strong><br /><br/><strong>Supplier Name :</strong> <?php echo $order->vendor_name; ?> <?php echo ($order->vendor_arabic_name !== '') ? '/ '. $order->vendor_arabic_name : ''; ?><br/>
										<strong>Contact Person :</strong> <?php echo $order->contact_person_name; ?><br/>
										<strong>CR No.:</strong> <?php echo $order->cr_no; ?><br />
										<strong>VAT No.:</strong> <?php echo $order->vat_no; ?><br />
									</td>
								</tr>
								
								<tr>
									<td colspan="3">
										<div class="search-bar-container">
											<h5>Search and add spare parts to requisition list</h5>
											<div class="input-group" style="border: 1px solid #ddd;">
												<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Part No. or Name" style="border: none;">
												<span class="input-group-text bg-primary text-dark border-0" id="reset_btn"><i class="mdi mdi-undo"></i> Reset</span>
											</div>
										</div>
										<div class="search-result-container">
											<div id="result_box" class="searchResults d-none"></div>
										</div>
									</td>
								</tr>
							
								<tr>
									<td colspan="3" class="pb-0">
										<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>#</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>Part No.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Make</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Model</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 45%;"><strong>Particular Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Qty.</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php $item_row = 1;if(!empty($items)){ foreach($items as $product){ ?>
												<tr id="item-row<?php echo $item_row;?>">
													<td valign="top"><button type="button" onclick="remove_item(<?php echo $item_row;?>)" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>
													<td valign="top"><input type="text" name="item_code[]" value="<?php echo $product->item_code; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="part_id[]" value="<?php echo $product->part_id; ?>" /></td>
													<td valign="top"><input type="text" name="vehicle_make[]" value="<?php echo $product->make_name; ?>" class="form-control" readonly="readonly" required="required" /></td>
													<td valign="top"><input type="text" name="vehicle_model[]" value="<?php echo $product->vehicle_model; ?>" class="form-control" readonly="readonly" required="required" /></td>
													<td valign="top"><input type="text" name="spare_part_name[]" value="<?php echo $product->part_name_en; ?>" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="spare_part_name_ar[]" value="<?php echo $product->part_name_ar; ?>" /></td>
													<td valign="top"><input type="number" min="0" name="quantity[]" value="<?php echo $product->quantity; ?>" class="form-control item_unit" required="required" /></td>
												</tr>
												<?php $item_row = $item_row + 1;}}?>
												
											</tbody>
										</table>
									</td>
								</tr>
								
							</table>
						</form> 
 					</div>
 				</div>
 			</div> <!-- end col -->
 		</div> <!-- end row -->
 	</div>
 </div>

<?php $this->load->view('admin/home/footer');?>
<script>
	var item_row = <?php echo $item_row;?>;

	function addItem(id,part_name_en,part_name_ar,item_code,vehicle_make,vehicle_model){
		html  = '<tr id="item-row' + id + '">';
		html += '  <td class="text-right"><button type="button" onclick="remove_item(' + id + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += ' <td class="text-left"><input type="text" name="item_code[]" class="form-control" value="' + item_code + '" required readonly /><input type="hidden" name="part_id[]" value="' + id + '" /></td>';
		html += ' <td class="text-left"><input type="text" name="vehicle_make[]" value="' + vehicle_make + '" class="form-control" readonly="readonly" required /></td>';
		html += ' <td class="text-left"><input type="text" name="vehicle_model[]" value="' + vehicle_model + '" class="form-control" readonly="readonly" required /></td>';
		html += ' <td class="text-left"><input type="text" name="spare_part_name[]" value="' + part_name_en + '" class="form-control" readonly="readonly" required /><input type="hidden" name="spare_part_name_ar[]" value="' + part_name_ar + '" /></td>';
		html += '<td class="text-left"><input type="number" min="0" name="quantity[]" class="form-control item_unit" required /></td>';
		html += '</tr>';

		$('#item_table tbody').append(html);
	}

	function remove_item(u){
		$('#item-row'+u).remove();
	}

</script>
<script>
	$(document).ready(function(){
		$("#number").on("keypress",function(e){
			if($(this).val().length<='15'){
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

				$("#errmsg").html("Digits Only").show();
				return false;
				}
			}else{
				$("#errmsg").html("Input Maxium 15 Digits Only").show();
				return false;
			}
		});
    });
	
    function Alpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }
	
    function numerics(key) {
	   //getting key code of pressed key
	   //alert($(this).val());
	   var keycode = (key.which) ? key.which : key.keyCode;
	   //comparing pressed keycodes

	   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
		   alert(" You can enter only characters 0 to 9 ");
		   return false;
	   }
	   else return true;


   }
   
	$(document).ready(function(){
		$('.txt_search_po').on('search', function(evt) {
			$(".searchResults").html('');
		});

		$(".txt_search_po").keyup(function(){
			var search = $(this).val();
			if(search.length > 2){
				$("#result_box").removeClass("d-none");
				$.ajax({
					url: '<?php echo base_url();?>admin/spare-parts/requisition/search-parts',
					type: 'get',
					data: {term:search},
					dataType: 'json',
					success:function(response){
						var len = response['result'].length;
						//console.log(response);
						//alert(response);
						$(".searchResults").empty();
						if(len > 0){
							for( var i = 0; i<len; i++){
								
								var id = response['result'][i]['id'];
								var item_code = response['result'][i]['item_code'];
								var part_name_en = response['result'][i]['part_name_en'];
								if(response['result'][i]['part_name_ar'] == ''){
									var part_name_ar = 'NULL';
								}else{
									var part_name_ar = response['result'][i]['part_name_ar'];
								}
								var vehicle_make = response['result'][i]['vehicle_make'];
								var vehicle_model = response['result'][i]['vehicle_model'];
								var status = response['result'][i]['status'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+part_name_en+'" data-arabic="'+part_name_ar+'" data-id="'+id+'" data-item_code="'+item_code+'" data-vehicle_make="'+vehicle_make+'" data-vehicle_model="'+vehicle_model+'" class="item-button btn btn-primary btn-sm">+</button> <span class="item-name">'+part_name_en+' / '+ part_name_ar +'<br/>Part No. - <span>'+item_code+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var id = $(this).data('id');
								var part_name_en = $(this).data('name');
								var part_name_ar = $(this).data('arabic');
								var item_code = $(this).data('item_code');
								var vehicle_make = $(this).data('vehicle_make');
								var vehicle_model = $(this).data('vehicle_model');
								addItem(id,part_name_en,part_name_ar,item_code,vehicle_make,vehicle_model);
								$(this).prop('disabled', true);
								$("#reset_btn").click();
							});
						}else{
							$('.searchResults').append('<a class="text-dark"><div class="d-flex align-items-center border-bottom p-3"><span class="font-weight-bold">No search result found. Try another keyword.</span></div></a>');
						}
					},
					error: function(data){
						alert(JSON.stringify(data));
					}
				});
			}else{
				$(".searchResults").html('');
				$("#result_box").addClass("d-none");
			}
		});
		
		$("#reset_btn").click(function(){
			$(".searchFormPo").html('');
			$(".searchResults").html('');
			$('#search_input').val('');
			$("#result_box").addClass("d-none");
		});
	});
</script> 
