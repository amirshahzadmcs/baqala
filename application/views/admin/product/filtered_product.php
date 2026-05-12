<?php $this->load->view('admin/home/header');?>
<style>
    .tile-stats .count {
        font-size: 27px;
        font-weight: 700;
        line-height: 1;
    }
    @media only screen and (max-width: 1296px) {
        p.text-primary.fw-bold {
            font-size: 13px !important;
        }
    }
    @media only screen and (max-width: 1252px) {
        p.text-primary.fw-bold {
            font-size: 12px !important;
        }
    }
	.product-desc{
		/*width: 300px;*/
		white-space: break-spaces;
		display: flex;
	}
	.card.active{
	    background-color: currentColor;
	}
	.card.active p{
	   color: #fff !important;
	}
	.card.active h5{
	    color: #fdce43;
	}
</style>
<style type="text/css">

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

</style>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>
            </div>
            <?php  $admin_id= $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<div class="btn-group me-1">
						<button class="btn btn-custom-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Bulk Action <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" onclick="deleteAction()" href="javascript:;">Delete Product</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" onclick="EnableStatus()" href="javascript:;">Enable Product</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" onclick="DisableStatus()" href="javascript:;">Disable Product</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url()?>admin/product/add_bulk_product">Add Bulk Products</a>
						</div>
					</div>
                    <?php } ?>
                    <?php if($this->input->get('keyword')=='status' && $this->input->get('value')=='1'){ ?>
					<a class="btn btn-custom-white btn-sm me-1" href="<?php echo site_url(); ?>admin/export/allActiveProductExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
                    <?php } ?>
					<?php if($this->input->get('keyword')=='status' && $this->input->get('value')=='0'){ ?>
					<a class="btn btn-custom-white btn-sm me-1" href="<?php echo site_url(); ?>admin/export/allDeactiveProductExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
                    <?php } ?>
					<?php if($this->input->get('keyword')=='image' && $this->input->get('value')==''){ ?>
					<a class="btn btn-custom-white btn-sm me-1" href="<?php echo site_url(); ?>admin/export/imageMissingProductExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
                    <?php } ?>
					<?php if($this->input->get('keyword')=='name_ar' && $this->input->get('value')==''){ ?>
					<a class="btn btn-custom-white btn-sm me-1" href="<?php echo site_url(); ?>admin/export/arabicMissingProductExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
                    <?php } ?>
					<?php if($this->input->get('keyword')=='parent_sku' && $this->input->get('value')==''){ ?>
					<a class="btn btn-custom-white btn-sm me-1" href="<?php echo site_url(); ?>admin/export/skuMissingProductExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
                    <?php } ?>
                    <a class="btn btn-custom-success btn-sm pull-right" title="Add" href="<?php echo base_url()?>admin/product/create_product"><i class="fa fa-plus"></i> Add Product</a>
                </div>
                <?php if($this->admin->getInfo()){ 
				$info = explode("--", $this->admin->getInfo()); 
				$info_type = $info[0]; $msg_data = $info[1]; 
				if($info_type == 2){ ?>
                <div class="alert alert-danger alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } else{?>
                <div class="alert alert-info alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } ?>
                <?php } $this->admin->removeInfo();?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product" target="_blank">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">Total Products</p>
                                <h5 class="font-size-22"><?php echo $total_products[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product/filtered_product?keyword=status&value=1" target="_blank">
                    <div class="card <?php echo ($this->input->get('keyword')=='status' && $this->input->get('value')=='1') ? 'active' : ''; ?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">Active</p>
                                <h5 class="font-size-22"><?php echo $active_products[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product/filtered_product?keyword=status&value=0" target="_blank">
                    <div class="card <?php echo ($this->input->get('keyword')=='status' && $this->input->get('value')=='0') ? 'active' : ''; ?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">Disabled</p>
                                <h5 class="font-size-22"><?php echo $disable_products[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product/filtered_product?keyword=image&value=" target="_blank">
                    <div class="card <?php echo ($this->input->get('keyword')=='image') ? 'active' : ''; ?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">Image Missing</p>
                                <h5 class="font-size-22"><?php echo $image_missing[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product/filtered_product?keyword=name_ar&value=" target="_blank">
                    <div class="card <?php echo ($this->input->get('keyword')=='name_ar') ? 'active' : ''; ?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">Arabic Missing</p>
                                <h5 class="font-size-22"><?php echo $arabic_missing[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-md-4">
                <a href="<?php echo base_url();?>admin/product/filtered_product?keyword=parent_sku&value=" target="_blank">
                    <div class="card <?php echo ($this->input->get('keyword')=='parent_sku') ? 'active' : ''; ?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-success fw-bold">SKU Missing</p>
                                <h5 class="font-size-22"><?php echo $sku_missing[0]['total']; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myform" name="myform" method="post" action="">
                            <table id="example" class="table table-centered table-nowrap mb-0 table-striped table-bordered jambo_table bulk_action" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width:30px">S.No.</th>
                                        <th style="width:30px">#</th>
                                        <th>Sku</th>
                                        <th>Product</th>
                                        <th>COD</th>
										<th>B2B</th>
                                        <th>Status</th>
                                        <th style="width:50px">Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</div>

<div class="modal fade stockModalFullscreen" tabindex="-1" aria-labelledby="#stockModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="stockModalFullscreenLabel">UPDATE PRODUCT SIZE</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo base_url(); ?>admin/product'"></button>
			</div>
			<div class="modal-body">
				
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
	$(document).ready(function () {
		$("#parent").on("change", function (e) {
			$("#p_id").val($("#parent").val());
			location.href = "<?php echo base_url();?>admin/product?id=" + $("#parent").val();
		});
	});

	$(document).ready(function () {
		$("#example").dataTable({
			lengthMenu: [
				[25, 50, 100, 500],
				[25, 50, 100, 500],
			],
			//order: [[0, "DESC"]],
			dom: "Blfrtip",
			buttons: [
				{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			processing: true,
			serverSide: true,
			responsive: true,
			fixedHeader: true,
			ajax: {
				url: "<?php echo base_url()?>admin/product/get_product_list?keyword=<?php echo $this->input->get('keyword');?>&value=<?php echo $this->input->get('value');?>",
				type: "POST",
				error: function (request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
			},
			columnDefs: [
				{
					targets: [0, 1, 2, 3, 4, 5, 6, 7],
					orderable: false,
				},
			],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected product?") == true) {
				changeActionAndSubmit("admin/product/delete");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}
	
	var switchStatus = false;
	function changeStatus(pid,sid) {
		product_id = pid;
		input_id = 'switchs'+sid;
		//var value = $('#'+input_id).val();
		if ($('#'+input_id).is(':checked')) {
			switchStatus = $('#'+input_id).is(':checked');
		}else{
			switchStatus = $('#'+input_id).is(':checked');
		}
		if(pid !== "" || switchStatus !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url();?>admin/product/setStatus",
				type: "POST",
				data: {"id" : product_id, "status" : switchStatus},
				success: function (response) {
					alert(response);
					location.reload();
				},
				error: function (response) {
					alert(response);
					location.reload();
				},
			});
		}else {
			return false;
		}
	}
	
	var switchCod = false;
	function changeCod(pid,sid) {
		product_id = pid;
		input_id = 'switchc'+sid;
		if ($('#'+input_id).is(':checked')) {
			switchCod = $('#'+input_id).is(':checked');
		}else{
			switchCod = $('#'+input_id).is(':checked');
		}
		if(pid !== "" || switchCod !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url();?>admin/product/setCod",
				type: "POST",
				data: {"id" : product_id, "cod" : switchCod},
				success: function (response) {
					alert(response);
					location.reload();
				},
				error: function (response) {
					alert(response);
					location.reload();
				},
			});
		}else {
			return false;
		}
	}
	
	var switchB2B = false;
	function changeB2b(pid,sid) {
		product_id = pid;
		input_id = 'switchb'+sid;
		if ($('#'+input_id).is(':checked')) {
			switchB2B = $('#'+input_id).is(':checked');
		}else{
			switchB2B = $('#'+input_id).is(':checked');
		}
		if(pid !== "" || switchB2B !== "") {
			//alert(switchStatus);
			$.ajax({
				url: "<?php echo base_url();?>admin/product/setB2B",
				type: "POST",
				data: {"id" : product_id, "b2b" : switchB2B},
				success: function (response) {
					alert(response);
					location.reload();
				},
				error: function (response) {
					alert(response);
					location.reload();
				},
			});
		}else {
			return false;
		}
	}

	var EnableStatus = function () {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to enable selected product?") == true) {
				changeActionAndSubmit("admin/product/setStatusEnable");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	};

	function DisableStatus() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to disable selected product?") == true) {
				changeActionAndSubmit("admin/product/setStatusDisable");
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert("Plese select check box first");
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById("myform").action = action;
		document.getElementById("myform").submit();
	}

	$("#_from").datetimepicker({
		format: "MM/DD/YYYY",
	});
	$("#_to").datetimepicker({
		format: "MM/DD/YYYY",
		useCurrent: false,
	});
	$("#_from").on("dp.change", function (e) {
		$("#_to").data("DateTimePicker").minDate(e.date);
	});
	$("#_to").on("dp.change", function (e) {
		$("#from").data("DateTimePicker").maxDate(e.date);
	});

</script>
<script>
function quickView(prod_id){
	if(prod_id > 0){
		//alert(req_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/product/quick_view",
			data: {'id': prod_id},
			//dataType: "json",
			success: function (response) {
				console.log(response);
				$('.stockModalFullscreen .modal-body').html(response);
				$(".stockModalFullscreen").modal('show');
			},
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				$('.stockModalFullscreen .modal-body').html(JSON.stringify(request));
				$(".stockModalFullscreen").modal('show');
			},
		});
	}else{
		alert('Invalid product id!');
	}
}

/*----------- Rack and Shelf ------------*/
$(document).ready(function() {
	//getShelf();
});

function rackChange(sel){
	var selectedRack = sel.value;
	var rack_id = $(sel).attr("id");
	//alert( rack_id );
	$.ajax({
		url: "<?php echo base_url()?>admin/Product/getShelf",
		data: { "id": selectedRack },
		//dataType:"html",
		type: "post",
		success: function(data){
			var prod_shelf = rack_id.replace('prod_rack','prod_shelf');
			//alert('#'+prod_shelf);
			$('#'+prod_shelf).html(data);
		}
	});
}

</script>