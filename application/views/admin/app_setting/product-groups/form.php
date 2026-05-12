<?php $this->load->view('admin/home/header');?>
<style>
    fieldset {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        padding-block-start: 0.35em;
        padding-inline-start: 0.75em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        min-inline-size: min-content;
        border-width: 1px;
        border-style: solid;
        border-color: rgb(211 211 211);
        border-image: initial;
        border-radius: 5px;
    }
    legend {
        display: block;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
        background: #fff0;
        margin-top: -26px;
    }
    legend span{
        padding: 0px 15px;
        font-size: 17px;
        font-weight: 700;
        background: #fff;
    }
	.d-none{
		display:none;
	}
	.searchResults{
		list-style: none;
		position: absolute;
		left: 13px;
		width: 97%;
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
					<h4>Home Page Product Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app-setting/dasboard');?>">App Setting</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app/product-groups/list');?>">Home Page Product</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/app/product-groups/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="bannerForm" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else{?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
						<?php echo form_open("admin/app/product-groups/save", array("id"=>"bannerForm", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
						<fieldset>
                            <legend><span>Basic Info:</span></legend>	
							<div class="row">
								<div class="col-md-6 mb-3 form-group">
									<label for="group_name">Group Name<span class="text-danger">*</span> (English)</label>
									<input type="text" class="form-control" id="group_name" name="group_name" maxlength="255" required />
								</div>

								<div class="col-md-6 mb-3 form-group">
									<label for="group_name_arabic" class="float-end">Group Name (Arabic)</label>
									<input type="text" class="form-control rtl-input" id="group_name_arabic" name="group_name_arabic" maxlength="255" />
								</div>

								<div class="col-md-6 mb-3 form-group">
									<label for="group_title">Group Name Title<span class="text-danger">*</span> (English)</label>
									<input type="text" class="form-control" id="group_title" name="group_title" maxlength="255" required />
								</div>

								<div class="col-md-6 mb-3 form-group">
									<label for="group_title_arabic" class="float-end">Group Name Title (Arabic)</label>
									<input type="text" class="form-control rtl-input" id="group_title_arabic" name="group_title_arabic" maxlength="255" />
								</div>

								<div class="col-md-6 mb-3 form-group">
									<label for="group_url">Group Url<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="group_url" name="group_url" maxlength="99" onBlur="checkDuplicateUrl()" required />
									<p class="mt-1 mb-0 res-msg"></p>
								</div>
								<div class="col-md-6 mb-3 form-group">
									<label for="sort_order">Sort Order <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="sort_order" name="sort_order" onkeypress="return numerics(event);" required maxlength="5" />
								</div>
								
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="_status">Status<span class="text-danger">*</span></label>
									<select name="status" class="form-select" required>
										<option value="active">Active</option>
										<option value="inactive">Inactive</option>
									</select>
								</div>
							</div>
						</fieldset>
						<fieldset class="my-3" style="min-height: 400px;">
                            <legend><span>Add Products:</span></legend>
							<div class="row mb-3">
								<div class="search-bar-container">
									<h6 class="text-dark">Search and add product to group</h6>
									<div class="input-group" style="border: 1px solid #ddd;">
										<input type="search" name="term" id="search_input" class="form-control txt_search_po" placeholder="Search by Product SKU or Name" style="border: none;">
										<span class="input-group-text bg-primary text-dark border-0" id="reset_btn"><i class="mdi mdi-undo"></i> Reset</span>
									</div>
								</div>
								<div class="search-result-container">
									<div id="result_box" class="searchResults d-none"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
										<thead>
											<tr>
												<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong><i class="fa fa-plus"></i></strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 6%;"><strong>IMAGE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 12%;"><strong>SKU</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 15%;"><strong>BARCODE</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 52%;"><strong>DESCRIPTION</strong></td>
												<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Sort Order</strong></td>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
								</div>
							</div>
						</fieldset>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		 </div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script>

	function checkDuplicateUrl() {
		var group_url = $("#group_url").val();
		if (group_url !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/app/product-groups/ajax-check-url",
				type: "GET",
				data: "group_url=" + $("#group_url").val(),
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-msg").html(data.msg);
					}else{
						$("#group_url").val('');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#group_url").val('');
					return false;
				},
			});
		} else {
			checkField("group_url");
		}
	}

	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}

	var item_row = 1;

	function addItem(id,name,sku,arabic_name,barcode,image,prod_id){
		html  = '<tr id="item-row' + id + '">';
		html += '  <td class="text-right"><button type="button" onclick="remove_item(' + id + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += ' <td class="text-left"><img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" /></td>';
		html += ' <td class="text-left"><input type="hidden" name="products[size_id][]" value="' + id + '" required /><input type="hidden" name="products[prod_id][]" value="' + prod_id + '" required /><input type="text" name="products[item_sku][]" class="form-control" value="' + sku + '" readonly="readonly" /></td>';
		html += ' <td class="text-left"><input type="text" name="products[barcode][]" class="form-control" value="' + barcode + '" readonly="readonly" /></td>';
		html += ' <td class="text-left"><input type="text" name="products[item_description][]" id="item-list" value="' + name + '" class="form-control" readonly="readonly" /></td>';
		html += '<td class="text-left"><input type="number" min="1" max="1000" name="products[sort_order][]" class="form-control" /></td>';
		html += '</tr>';

		$('#item_table tbody').append(html);
	}

	function remove_item(u){
		$('#item-row'+u).remove();
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
					url: '<?php echo base_url();?>admin/app/product-groups/product-search',
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
								var prod_id = response['result'][i]['prod_id'];
								var name = response['result'][i]['name'];
								var arabic_name = response['result'][i]['name_arabic'];
								var sku = response['result'][i]['parent_sku'] +'-'+ response['result'][i]['sku'];
								var barcode = response['result'][i]['barcode'];
								var image = (response['result'][i]['image'] == "") ? "images/image-not-available.jpg" : response['result'][i]['image'];
								$('.searchResults').append('<div class="item-list"><button type="button" data-name="'+name+'" data-arabic="'+arabic_name+'" data-id="'+id+'" data-prod_id="'+prod_id+'" data-sku="'+sku+'" data-barcode="'+barcode+'" data-image="'+image+'" class="item-button btn btn-primary btn-sm">+</button> <img src="<?php echo base_url();?>'+image+'" class="img-fluid rounded shadow-sm mr-3" width="40px" style="margin-right: 10px;float: left;min-height: 35px;" /><span class="item-name">'+name+'<br/>SKU - <span>'+sku+'</span></span></div>');

							}
							$('.item-list').on('click', '.item-button', function() {
								var p_name = $(this).data('name');
								var size_id = $(this).data('id');
								var prod_id = $(this).data('prod_id');
								var p_sku = $(this).data('sku');
								var arabic_name = $(this).data('arabic');
								var barcode = $(this).data('barcode');
								var image = $(this).data('image');
								addItem(size_id,p_name,p_sku,arabic_name,barcode,image,prod_id);
								$(this).prop('disabled', true);
							});
						}else{
							$('.searchResults').append('<a class="text-dark"><div class="d-flex align-items-center border-bottom p-3"><span class="font-weight-bold">No search result found. Try another keyword.</span></div></a>');
						}
					},
					error: function(data){
						//console.log(data);
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
			$("#result_box").addClass("d-none");
		});
	});
</script>
