<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Cost Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Cost Center</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end cost_mainin d-sm-block">
                    <span class="dropdown">
                        <a target="_blank" href="javascript:;" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-chart-pie"></i> <i class="fas fa-caret-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/costcenterreport'); ?>">Cost Center Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithoutcostcenter'); ?>">Accounts without Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/accountwithcostcenter'); ?>">Accounts with Cost Center</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/accounting/costcenters/alltransaction'); ?>">All transactions</a></li>
                        </ul>
                    </span>
					&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" data-bs-toggle="modal" data-bs-target="#addcostcenterheadmodel" >
                        <i class="fa fa-plus"></i> Add Cost Center</a>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?> <?php }
							$this->admin->removeInfo(); ?>
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
					<div class="card-body p-0">
						
						<div class="chart__of__accounts__container">
							<div class="row chart-of-accounts-row">
								<div class="chart-of-accounts-col col-md-4 border chart-of-accounts-col-3 px-0">
									<div class="chart-account-search">
										<div class="col-lg-12">
											<div class="mb-0">
												<select class="form-control select2" data-placeholder="Search...">
													<option>Search</option>
													<optgroup>
														<option value="CA">No Result</option>
													</optgroup>
												</select>
											</div>
										</div>
									</div>
									<div class="chart-of-accounts-col-3-body-container">
										<?php foreach($chart_list as $clist){ ?>
										<ul class="myFolderUL">
											<?php if($clist['is_parent'] == '1'){ ?>
											<li>
												<span class="caret" onclick="quickSidebar(this)" data-id="<?php echo $clist['id'];?>"><a href="<?php echo base_url('admin/cost-center/cats/'.$clist['id']); ?>"><?php echo $clist['name'];?></a></span>
												<ul class="nested" id="list_<?php echo $clist['id'];?>" style="margin-left: 10px;">
													
												</ul>
											</li>
											<?php }else{ ?>
											<li><span class="file-type"><?php echo $clist['name'];?></span></li>
											<?php } ?>
										</ul>
										<?php } ?>
										
									</div>
									
								</div>
								<div class="chart-of-accounts-col col-md-8 chart-of-accounts-col-9 px-0">
									<div id="chart-of-accounts-child-board" class="chart-of-accounts-col-9-body-container">
										<div style="position: relative;">
											<table class="list-table table table-hover not-clickable chart-of-accounts-col-9-body-container-table">
												<tbody>
													<?php foreach($chart_list as $clist){ 
														if($clist['is_parent'] == '1'){
														?>
														<tr class="chart-of-accounts-col-9-body-container-table-row">
															<td class="border-0">
																<a href="<?php echo base_url('admin/cost-center/cats/'.$clist['id']); ?>">
																	<div class="chart-of-accounts-col-9-body-container-table-item">
																		<div class="item-container d-flex">
																			<i class="icon fas fa-folder mr-3"></i>
																			<div class="details">
																				<p class="name"><?php echo $clist['name'];?></p>
																				<p class="id">#<?php echo $clist['code'];?></p>
																			</div>
																		</div>
																	</div>
																</a>
															</td>
															<td class="border-0 text-right">
																<a href="<?php echo base_url('admin/accounting/costcenter/list'); ?>">
																	<div class="credit-wrap text-right">
																		<div class="credit-container">
																			<p class="cost">0</p>
																			
																		</div>
																	</div>
																</a>
															</td>
															<td class="border-0 text-right" width="50">
																<div class="dropdown">
																	<a class="btn btn-sm btn-secondary dropdown-toggle" href="javscript:;" role="button" data-bs-toggle="dropdown"><i class="mdi mdi-dots-horizontal"></i></a>
																	<div class="dropdown-menu dropdown-menu-end">
																	
                                                                		<a href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>" class="edit-action dropdown-item">
																		<i class="mdi mdi-open-in-new text-info mr-2"></i> Open</a>
																		<a type="button" onclick="editAccount(this)" data-id="<?php echo $clist['id'];?>" class="edit-action dropdown-item">
																		<i class="mdi mdi-circle-edit-outline text-info mr-2"></i>Edit</a>
																		<a href="<?php echo base_url('admin/cost-center/delete/'.$clist['id']); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="edit-action dropdown-item">
																		<i class="mdi mdi-delete-outline text-danger mr-2"></i>Delete</a>
																	</div>
																</div>
															</td>
														</tr>
														<?php }else{ ?>
															<tr class="chart-of-accounts-col-9-body-container-table-row">
															<td class="border-0">
																<a href="<?php echo base_url('admin/cost-center/cats/'.$clist['id']); ?>">
																	<div class="chart-of-accounts-col-9-body-container-table-item">
																		<div class="item-container d-flex">
																			<i class="icon far fa-file mr-3"></i>
																			<div class="details">
																				<p class="name"><?php echo $clist['branch_name'];?></p>
																				<p class="id">#<?php echo $clist['code'];?></p>
																			</div>
																		</div>
																	</div>
																</a>
															</td>
															<td class="border-0 text-right">
																<a href="<?php echo base_url('admin/accounting/costcenter/list'); ?>">
																	<div class="credit-wrap text-right">
																		<div class="credit-container">
																			<p class="cost">0</p>
																			<p class="type"><?php echo strtoupper($clist['is_parent']);?></p>
																		</div>
																	</div>
																</a>
															</td>
															<td class="border-0 text-right" width="50">
																<div class="dropdown">
																	<a class="btn btn-sm btn-secondary dropdown-toggle" href="javscript:;" role="button" data-bs-toggle="dropdown"><i class="mdi mdi-dots-horizontal"></i></a>
																	<div class="dropdown-menu dropdown-menu-end">
																		<i class="mdi mdi-open-in-new text-info"></i> Open</a>
                                                                		<a href="<?php echo base_url('admin/accounting/costcenters/costcenterview'); ?>" class="edit-action dropdown-item">
																		<a type="button" onclick="editAccount(this)" data-id="<?php echo $clist['id'];?>" class="edit-action dropdown-item">
																		<i class="mdi mdi-circle-edit-outline text-info mr-2"></i>Edit</a>
																		<a href="<?php echo base_url('admin/cost-center/delete/'.$clist['id']); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="edit-action dropdown-item">
																		<i class="mdi mdi-delete-outline text-danger mr-2"></i>Delete</a>
																	</div>
																</div>
															</td>
														</tr>
													<?php }} ?>
												</tbody>
											</table>
										</div>
										<a type="button" onclick="addAccount(this)" data-folderid="0" class="add-account font-weight-bold">
											<i class="fas fa-plus-circle"></i><span>Add Cost Center</span>
										</a>
										<div class="pagination-items"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade add-account-modal" role="dialog" aria-labelledby="ModalAccountLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="ModalAccountLabel">Add Account</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="account_body_modal">
                <p class="text-center">Loading...</p>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected category?") == true) {
				changeActionAndSubmit('admin/category/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}
	
	function addAccount(identifier) {
		$('.add-account-modal').modal('show');
		$('.add-account-modal .modal-title').html('Add Cost Center');
		let folderid = $(identifier).data('folderid');
		if(folderid !== ''){
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/cost-center/add-account-form');?>",
				data: {'parent_id': folderid},
				dataType: "json",
				success: function (response) {
					console.log(response);
					if(response.type == 'success'){
						$('#account_body_modal').html(response.message);
					}else{
						$('#account_body_modal').html('<h5 class="text-danger">'+response.message+'</h5>');
					}
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#account_body_modal').after(JSON.stringify(request));
				},
			});
		}else{
			$('#account_body_modal').html('<h5 class="text-danger">Invalid request id!</h5>');
		}
	}

	function editAccount(identifier) {
		$('.add-account-modal').modal('show');
		$('.add-account-modal .modal-title').html('Edit Account');
		let id = $(identifier).data('id');
		if(id !== ''){
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/cost-center/edit-account-form');?>",
				data: {'id': id},
				dataType: "json",
				success: function (response) {
					//console.log(response);
					if(response.type == 'success'){
						$('#account_body_modal').html(response.message);
					}else{
						$('#account_body_modal').html('<h5 class="text-danger">'+response.message+'</h5>');
					}
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#account_body_modal').after(JSON.stringify(request));
				},
			});
		}else{
			$('#account_body_modal').html('<h5 class="text-danger">Invalid request id!</h5>');
		}
	}

	var toggler = document.getElementsByClassName("caret");
	var i;

	for (i = 0; i < toggler.length; i++) {
		toggler[i].addEventListener("click", function() {
			this.parentElement.querySelector(".nested").classList.toggle("active");
			this.classList.toggle("caret-down");
		});
	}

	function quickSidebar(identifier){
		let id = $(identifier).data('id');
		//alert(id);
		if(id > 0){
			$.ajax({
				type: "post",
				url: "<?php echo base_url();?>admin/chart-of-accounts/get-sidebar-cat",
				data: {'id': id},
				beforeSend: function() {
					$('#list_'+id).html('<li class="loader"><i class="fa fa-spinner spin"></i></li>');
				},
				dataType: "json",
				success: function (response) {
					console.log(response.message);
					$('#list_'+id).html(response.message);
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
				complete: function() {
					$('#list_'+id+' .loader').remove();
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}
</script>
