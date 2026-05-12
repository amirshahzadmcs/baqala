<?php $this->load->view('admin/home/header');?>

<style>
th{
	width: 97px;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Journal Entries</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list">Journal Entries</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a href="<?php echo base_url(); ?>admin/accounting/journal/journallogs" class="btn btn-custom-success btn-sm pull-right me-1" title="Journal Logs">
                    <i class="mdi mdi-radiology-box-outline"></i> Journal Logs</a>
										&nbsp;
					<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/accounting/journal/create')?>">
                        <i class="fa fa-plus"></i> Add Journal Entries</a>
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
					</div>
				</div>
			</div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body mainnewbody">
                        <div class="index table_mainlist entry-content overflow-autopc">
                            <ul class="day-view-entry-list">
							
										
                                <li>
                                    <table cellspacing="0" cellpadding="0" >
										<thead>
											<tr>
											<th>Name</th>
											<th>Next Date</th>
											<th>End Date</th>
											<th>Frequency</th>
											<th>Status</th>
											<th>Amount</th>
											<th><a type="button" class="dropdown-toggle" data-bs-toggle="dropdown">Sort By <i class="fas fa-sort"></i></a></th>
											</tr>
										</thead>
                                        <tbody>
											<?php 
											if(isset($profiles))
											{
												foreach($profiles as $value)
												{
													?>
											
                                            <tr class="day-view-entry entrylist day-view-entry-label">
                                               <td><?php echo $value->name;  ?></td>
                                               <td><?php echo $value->start_date;  ?></td>
                                               <td><?php echo $value->end_date;  ?></td>
                                               <td><?php echo $value->frequency;  ?></td>
                                               <td><?php echo $value->profile_status;  ?></td>
                                               <td><?php echo $value->debit_total;  ?></td>
                                               


                                                <td class="entry-button " width="10%">
                                                <div class="dropdown mobile-options mainresulttitle">
                                                   
                                                    <button class="btn btn-lg btn-default dropdown-toggle " type="button"
                                                    data-bs-toggle="dropdown">
                                                    <span class="fa fa-ellipsis-h"></span></button>
                                                    <ul class="dropdown-menu  dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="<?php echo base_url()?>/admin/accounting/recurring/profile-detail/<?php echo $value->id;  ?>">
                                                            <i class="far fa-eye text-success"></i> View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="<?php echo base_url()?>/admin/accounting/recurring/edit/<?php echo $value->id; ?>"> 
                                                            <i class="far fa-edit text-primary"></i> Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="<?php echo base_url()?>/admin/accounting/journal/delete/">
                                                            <i class="fas fa-trash-alt text-danger"></i> Delete</a>
                                                        </li>
                                                    </ul>
                                                    </div>
                                                   
                                                </td>
                                            </tr>
											<?php  } }  ?>
										
                                        </tbody>
                                    </table>
                                </li>
								
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>

