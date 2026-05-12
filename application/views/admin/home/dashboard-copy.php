<?php $this->load->view('admin/home/header');?>
<style>
.tile-stats h3 {
    font-weight:700;
}
.table-box{
	border-top: 3px solid #00c0ef;
    box-shadow: 0px 2px 5px #ddd;
        margin: 10px;
}
</style>
    <div class="page-title">
        <div class="title_left">
            <h3>Dashboard</h3>
        </div>
    </div>
	<?php //print_r($total_users[0]['total']);exit();?>
    <?php  $admin_id= $this->session->userdata('admin_id'); ?>
	<?php if ($this->admin->hasPrivilege('dashboard')) { ?>
    <div class="clearfix"></div>
    <div>
        <div class="x_panel">
            <div class="x_content">
                <div class="row top_tiles">
                    <?php if ($this->admin->hasPrivilege('product')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-green">
							<a href="<?php echo base_url();?>admin/category" class="white">
                            <div class="icon white"><i class="fa fa-sitemap"></i></div>
                            <div class="count">Category</div>
                            <h3 class="white"><?php echo $total_category[0]['total']; ?></h3>
							<p></p>
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($this->admin->hasPrivilege('orders')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-blue">
							<a href="<?php echo base_url();?>admin/order_process" class="white">
                            <div class="icon white"><i class="fa fa-shopping-cart"></i></div>
                            <div class="count">Orders</div>
                            <h3 class="white"><?php echo $total_orders[0]['total']; ?></h3>
                            <p></p>
							</a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($this->admin->hasPrivilege('product')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-purple">
							<a href="<?php echo base_url();?>admin/product" class="white">
                            <div class="icon white"><i class="fa fa-gift"></i></div>
                            <div class="count">Products</div>
                            <h3 class="white"><?php echo $total_product[0]['total']; ?></h3>
                            <p></p>
							</a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($this->admin->hasPrivilege('users')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-red">
							<a href="<?php echo base_url();?>admin/user" class="white">
                            <div class="icon white"><i class="fa fa-users"></i></div>
                            <div class="count">Users</div>
                            <h3 class="white"><?php echo $total_users[0]['total']; ?></h3>
                            <p></p>
							</a>
                        </div>
                    </div>
                    <?php } ?>
					<?php if ($this->admin->hasPrivilege('delivery')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-orange">
							<a href="<?php echo base_url();?>admin/partner" class="white">
                            <div class="icon white"><i class="fa fa-truck"></i></div>
                            <div class="count">Partners</div>
                            <h3 class="white"><?php echo $total_partner[0]['total']; ?></h3>
                            <p></p>
							</a>
                        </div>
                    </div>
                    <?php } ?>
					<?php if ($this->admin->hasPrivilege('users')) { ?>
                    <div class="animated flipInY col-lg-4">
                        <div class="tile-stats bg-blue-sky">
							<a href="<?php echo base_url();?>admin/Credit_account" class="white">
                            <div class="icon white"><i class="fa fa-bank"></i></div>
                            <div class="count">Credit Accounts</div>
                            <h3 class="white"><?php echo $total_credit_ac[0]['total']; ?></h3>
                            <p></p>
							</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
				<?php if ($this->admin->hasPrivilege('orders')) { ?>
				<div class="row">
					<div class="table-box col-md-6">
						<div class="box-header">
							<h4 class="box-title">New Orders <a href="<?php echo base_url();?>admin/order_process" class="btn btn-primary btn-xs pull-right">View all</a></h4>
						</div>
						<!-- /.box-header -->
						<div class="box-body no-padding">
							<table class="table table-striped">
								<tr>
									<th style="width: 10px;">#</th>
									<th>Order Id</th>
									<th>Customer Name</th>
									<th>Total Price</th>
									<th>Payment Method</th>
									<th style="width: 40px;">Status</th>
								</tr>
								<?php if(count($new_orders) > 0){?>
								<?php $o_count = 1;foreach($new_orders as $neworder){?>
								<tr>
									<td><?php echo $o_count;?></td>
									<td><?php echo $neworder->id;?></td>
									<td><?php echo $neworder->name;?></td>
									<td><?php echo $neworder->order_total;?></td>
									<td><?php echo $neworder->payment_method;?></td>
									<td>
										<?php if($neworder->order_status_id == '0'){
											echo '<div class="label label-info">Payment Pending</div>';
										}
										if($neworder->order_status_id == '1'){
											echo '<div class="label bg-blue">Recieved</div>';
										}

										if($neworder->order_status_id == '2'){
											echo '<div class="label label-primary">Accepted</div>';
										}
										if($neworder->order_status_id == '3'){
											echo '<div class="label label-danger">Cancel By Admin</div>';
										}
										if($neworder->order_status_id == '4'){
											echo '<div class="label label-primary">Van Assigned</div>';
										}
										if($neworder->order_status_id == '5'){
											echo '<div class="label bg-purple">Dispatched</div>';
										}

										if($neworder->order_status_id == '6'){
											echo '<div class="label label-success">Delivered</div>';
										}

										if($neworder->order_status_id == '7'){
											echo '<div class="label label-warning">Cancel On Delivery</div>';
										}

										if($neworder->order_status_id == '8'){
											echo '<div class="label label-warning">Refund</div>';
										}

										if($neworder->order_status_id == '9'){
											echo '<div class="label label-danger">Cancel By Customer</div>';
										}

										?>
									</td>
								</tr>
								<?php $o_count++;}}else{ ?>
									<tr><td colspan="6" align="center">No new orders</td></tr>
								<?php } ?>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->


				</div>
				<?php } ?>
            </div>
        </div>
    </div>
	<?php } ?>
<?php $this->load->view('admin/home/footer');?>
