<?php $this->load->view('stores/layout/header');?>
<style>
.searchResults{
	list-style: none;
    position: absolute;
    width: 96.5%;
    cursor: pointer;
    overflow-y: auto;
    max-height: 250px;
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
	float: right;
    margin-top: -20px;
}
.search-box .form-control {
    border: 1px solid #ababab;
}
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Stock Transfer Request</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Stock Transfer Request</a></li>
								<li class="breadcrumb-item active"> Form</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<!--
							<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this request?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
							-->
							<a class="btn btn-custom-white btn-sm pull-right" title="Add" href="<?php echo base_url('store/warehouse/stock-request')?>"><i class="fa fa-reply"></i> Back</a>
							<button type="submit" form="request_form" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
						</div>
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
								<h4 class="header-title">Search and add product to stock request list</h4>
								<div class="chat-search-box">
									<div class="position-relative">
										<div class="input-group" style="border: 1px solid #ddd;">
											<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Product SKU or Name" style="border: none;">
											<span class="input-group-text bg-primary text-dark border-0" id="reset_btn"><i class="mdi mdi-undo"></i> Reset</span>
										</div>
									</div>
								</div>
								<div class="search-result-container">
									<div id="result_box" class="searchResults d-none"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div>
									<?php if($this->customer->getInfo()){ 
									$info = explode("--", $this->customer->getInfo());
									$info_type = $info[0];
									$msg_data = $info[1];
									if($info_type == 2){
									?>  
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Error!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } else{?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Success!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } } $this->customer->removeInfo();?>
								</div>
								<?php echo form_open('store/warehouse/stock-save', array("id"=>"request_form"));?>
									<div class="row mb-2">
										<div class="col-md-3 offset-6">
											<label class="control-label" for="target_store">Select Warehouse</label>
												<select class="form-control select2" name="target_store_id" id="target_store" data-placeholder="Select Warehouse..." required>
													<option value="">Select</option>
													<?php foreach($warehouse_info as $warehouse){?>
													<option value="<?php echo $warehouse->id;?>"><?php echo $warehouse->name_english;?></option>
													<?php }?>
											</select>
										</div>
										<div class="col-md-3">
											<label>Expected Delivery Date:</label>
											<input type="date" name="expected_date" class="form-control" required />
										</div>
									</div>
									<table class="table table-bordered" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong><i class="fa fa-plus"></i></strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>PARENT SKU</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>SKU</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 40%;"><strong>DESCRIPTION</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>SIZE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>UNIT/QTY</strong></td>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
								<?= form_close(); ?>
							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('stores/layout/footer');?>
<script>
var item_row = 1;

function addItem(id,name,parent_sku,sku,arabic_name,sizeid,size){
	html  = '<tr id="item-row' + sizeid + '">';
	html += '  <td class="text-right"><button type="button" onclick="remove_item(' + sizeid + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
	html += '<td class="text-left"><input type="hidden" name="size_id[]" value="' + sizeid + '" /><input type="text" name="item_parentsku[]" value="' + parent_sku + '" class="form-control" readonly="readonly" required="required" /></td>';
	html += ' <td class="text-left"><input type="text" name="item_sku[]" class="form-control" value="' + sku + '" readonly="readonly" required="required" /></td>';
	html += ' <td class="text-left"><input type="text" name="item_description[]" value="' + name + '" class="form-control" readonly="readonly" required="required" /><input type="hidden" name="item_desc_arabic[]" value="' + arabic_name + '" /></td>';
	html += ' <td class="text-left"><input type="text" name="item_size[]" class="form-control" value="' + size + '" readonly="readonly" required="required" /></td>';
	html += '<td class="text-left"><input type="number" min="0" max="1000" name="item_unit[]" class="form-control"  required="required" /></td>';
	html += '</tr>';

	$('#item_table tbody').append(html);
}

function remove_item(u){
	$('#item-row'+u).remove();
	calc();
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
				url: '<?php echo base_url();?>store/stock-request/product-list',
				type: 'GET',
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
							var name = response['result'][i]['name'];
							var arabic_name = response['result'][i]['name_arabic'];
							var parent_sku = response['result'][i]['parent_sku'];
							var sku = response['result'][i]['sku'];
							var barcode = response['result'][i]['barcode'];
							var size_id = response['result'][i]['size_id'];
							var size = response['result'][i]['size'];
							var unit = response['result'][i]['unit_name'];
							var image = (response['result'][i]['image'] == "") ? "images/image-not-available.jpg" : response['result'][i]['image'];
							$('.searchResults').append('<div class="item-list"><img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" style="margin-right: 10px;float: left;min-height: 35px;" /><span class="item-name">'+name+' ('+ size +' '+ unit+')<br/>Parent SKU - <span>'+parent_sku+'</span> | Product SKU - <span>'+parent_sku+'-'+sku+'</span></span> <button type="button" data-name="'+name+'" data-arabic="'+arabic_name+'" data-id="'+id+'" data-psku="'+parent_sku+'" data-sku="'+sku+'" data-barcode="'+barcode+'" data-sizeid="'+size_id+'" data-size="'+size+ ' '+unit+'" class="item-button btn btn-primary btn-sm">+</button></div>');
						}
						$('.item-list').on('click', '.item-button', function() {
							var p_name = $(this).data('name');
							var p_id = $(this).data('id');
							var p_sku = $(this).data('sku');
							var parent_sku = $(this).data('psku');
							var arabic_name = $(this).data('arabic');
							var sizeid = $(this).data('sizeid');
							var size = $(this).data('size');
							addItem(p_id,p_name,parent_sku,p_sku,arabic_name,sizeid,size);
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
