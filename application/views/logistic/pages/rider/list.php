<?php $this->load->view('logistic/layout/header');?>
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

</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<div class="main-content">
    <div class="page-content">
		<!-- start page title -->
		<div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Rider Management</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="javascript:;">Rider</a></li>
								<li class="breadcrumb-item active">List</li>
							</ol>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="float-end d-sm-block">
							
							<a href="<?php echo base_url('logistic-partner/rider/form');?>" type="button" class="btn btn-custom-success btn-sm pull-right" title="Add"><i class="fa fa-plus"></i> Add New Rider</a>
							
						</div>
						<?php $this->load->view('logistic/partials/alert');?>
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
								<table id="vendorTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>					  
											<th>#</th>
											<th>D. ID</th>
											<th>Name</th>						  
											<th>Mobile</th>					  
											<th>Iqama No.</th>  					  
											<th>Bike No.</th>
											<th>Logistic Partner</th>		  					  
											<th>Lifetime Earning</th>		  					  
											<th>Current Month Earn.</th>		  					  
											<th>Last Online</th>		  					  
											<th>Reg. Date</th>	  					  
											<th>Status</th>			  					  
											<th>Appl. Status</th>			  					  
											<th>Tools</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('logistic/layout/footer');?>
<script>
$(document).ready(function() {
	$('#vendorTable').dataTable({
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
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],
		"responsive": true,
		"processing":true,
		"serverSide":true,
		fixedHeader: true,
		"order":[],
		"ajax":{
				url:"<?php echo base_url();?>logistic-partner/rider/ajax-list",
				type:"POST"
			},
			"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13],
			 "orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	
</script>
