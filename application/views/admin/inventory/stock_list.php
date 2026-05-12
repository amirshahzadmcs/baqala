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
                    <h4>Inventory Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Inventory List</li>
                    </ol>
                </div>
            </div>
            <?php  $admin_id= $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <button type="button" class="btn btn-custom-white btn-sm waves-effect waves-light me-1" data-bs-toggle="modal" data-bs-target=".exampleModalFullscreen"><i class="dripicons-experiment"></i>Advance Search</button>
                    <a class="btn btn-custom btn-sm me-1" href="<?php echo site_url(); ?>admin/export/allstockexcel" target="_blank"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
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
			<div class="col-xl-3 col-md-4">
				<a href="<?php echo base_url();?>admin/warehouse/inventory/list" target="_blank">
                    <div class="card <?=($this->uri->segment(4) == 'list' ? 'active' : '');?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-primary fw-bold">TOTAL INVENTORY</p>
                                <h5 class="font-size-22"><?php echo $total_inventory; ?></h5>
                            </div>
                        </div>
                    </div>
				</a>
            </div>
            
            <div class="col-xl-3 col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="text-center">
							<p class="text-primary fw-bold">TOTAL INVENTORY VALUE:</p>
							<h5 class="font-size-22"><?php echo $total_value->total_price; ?></h5>
						</div>
					</div>
				</div>
            </div>

            <div class="col-xl-3 col-md-4">
				<a href="<?php echo base_url();?>admin/warehouse/inventory/instock?keyword=instock" target="_blank">
                    <div class="card <?=($this->uri->segment(4) == 'instock' ? 'active' : '');?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-primary fw-bold">IN STOCK</p>
                                <h5 class="font-size-22"><?php echo $total_instock; ?></h5>
                            </div>
                        </div>
                    </div>
				</a>
            </div>

            <div class="col-xl-3 col-md-4">
				<a href="<?php echo base_url();?>admin/warehouse/inventory/outstock?keyword=outstock" target="_blank">
                    <div class="card <?=($this->uri->segment(4) == 'outstock' ? 'active' : '');?>">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-primary fw-bold">OUT OF STOCK</p>
                                <h5 class="font-size-22"><?php echo $total_outstock; ?></h5>
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
                                        <th>CHILD SKU</th>
                                        <th>BARCODE</th>
                                        <th>PRODUCT NAME/ DESCRIPTION</th>
                                        <th>QTY</th>
                                        <th>COST</th>
                                        <th>INVENTORY VALUE</th>
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
<!-- container-fluid -->
<div class="modal fade fixed-left exampleModalFullscreen" aria-labelledby="#exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">Advance Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/warehouse/inventory/list'); ?>" method="get" id="filter_form">
					<div class="row">
						<div class="col-12">
							<div class="form-group mb-3">
								<label>Select Category</label>
								<select class="form-control show-tick select2" name="category_id" id="category_id" data-placeholder="Choose Category...">
									<option value="">Select</option>
									<?php foreach($categories as $category){?>
									<option value="<?php echo $category['id'];?>" <?php echo ($this->input->get('category_id') == $category['id']) ? 'selected':'';?>><?php echo $category['name'];?></option>
									<?php foreach($category['child'] as $child){ ?>
									<option value="<?php echo $child['id'];?>" <?php echo ($this->input->get('category_id') == $child['id']) ? 'selected':'';?>><?php echo $category['name'] . " >" . $child['name'];?></option>
									<?php foreach($child['child'] as $sub){ ?>
									<option value="<?php echo $sub['id'];?>" <?php echo ($this->input->get('category_id') == $sub['id']) ? 'selected':'';?>><?php echo $category['name'] . " >" . $child['name'] . " > " . $sub['name'];?></option>
									<?php }}}?>
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group mb-3">
								<label class="control-label" for="brand">Select brand </label>
								<select style="height:410px;" name="brand" id="brand" class="form-control select2">
									<option value="">Select Brand</option>
									<?php foreach($brand_list as $brand){?>
									<option value="<?php echo $brand->id;?>" <?php echo ($this->input->get('brand') == $brand->id) ? 'selected':'';?>><?php echo $brand->brand_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-12">
							<div class="form-group mb-3">
								<label>From</label>
								<input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
							</div>
						</div>
						<div class="col-12">
							<div class="form-group mb-3">
								<label>To</label>
								<input type="date" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
							</div>
						</div>
						<div class="col-12">
							<div class="form-group mb-2">
								<label class="d-block">Select Status </label>
								<select style="height:410px;" name="status" class="form-control select2 w-100">
									<option value="">Select Status</option>
									<option value="yes" <?php echo ($this->input->get('status') == 'yes') ? 'selected':'';?>>Active</option>
									<option value="no" <?php echo ($this->input->get('status') == 'no') ? 'selected':'';?>>Inactive</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-12" style="padding-top: 15px;">
							<a href="<?php echo base_url(); ?>admin/warehouse/inventory/list" class="btn btn-danger btn-md">Clear Filter</a>
							<button type="submit" class="btn btn-success btn-md">Apply Filter</button>
						</div>
					</div>
				</form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>

<script>
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
				url: "<?php echo base_url()?>admin/inventory/get_list?category_id=<?php echo $this->input->get('category_id');?>&brand=<?php echo $this->input->get('brand')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&status=<?php echo $this->input->get('status')?>",
				type: "POST",
                error: function (request, error) {
                    console.log(" Can't do because: " + JSON.stringify(request));
                },
			},
			
			columnDefs: [
				{
					targets: [1, 2, 3, 4, 5, 6],
					orderable: false,
				},
			],
		});
	});
    /*
	$("#_from").datetimepicker({
		format: "MM/DD/YYYY",
	});
	$("#_to").datetimepicker({
		format: "MM/DD/YYYY",
		useCurrent: false,
	});
    */
</script>
