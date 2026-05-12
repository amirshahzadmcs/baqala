<?php $this->load->view("front/common/header");?>
<section class="order-table mb-5">
    <div class="container">
        <hr />
		<div class="row">
			<div class="btn-group btn-group-toggle" data-toggle="buttons">
				<button class="btn btn-success border-green" onclick="window.location.href='<?= base_url().'quotation-history'?>'">Quotation List</button>
				<button class="btn btn-light border" onclick="window.location.href='<?= base_url().'order-history'?>'">Order List</button>
			</div>
		</div>
        <div class="py-3 d-flex justify-content-between">
            <h4>Quotations</h4>
            <div class="file-actions text-end">
                <ul>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="order-pg-table table-responsive">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Q. No.</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Created By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($quotations) > 0){ ?>
                    <?php $count = 1; foreach($quotations as $quotation){ ?>
                    <tr>
                        <td><?= $count++;?></td>
                        <td><a href="<?= base_url('quotation-detail/'.$quotation['id']);?>" class="text-decoration-underline" target="_blank"><?= $quotation['invoice_prefix'];?>-<?= $quotation['quotation_no'];?> </a></td>
                        <td><?= $quotation['s_person_name'];?></td>
                        <td><?= $this->customer->formatedDate($quotation['date_added']);?></td>
                        <td><?php if($quotation['quotation_status'] == 'pending'){ echo 'N/A';}else{ $net_payble_amt = $quotation['net_payble_amt']; echo sprintf("%.2f",$net_payble_amt) .' SAR';}?></td>
                        <td><span title="<?= $quotation['staff_display_name']; ?>"><?= $quotation['staff_username'];?></span></td>
						<?php
							if($quotation['quotation_status'] == 'pending'){
								$status_message = '<span class="badge badge-pill bg-secondary"> Pending</span>';
							}
							elseif($quotation['quotation_status'] == 'review'){
								$status_message = '<span class="badge badge-pill bg-info"> In Review</span>';
							}elseif($quotation['quotation_status'] == 'reject'){
								$status_message = '<span class="badge badge-pill bg-danger">Rejected</span>';
							}elseif($quotation['quotation_status'] == 'approved'){
								$status_message = '<span class="badge badge-pill bg-success">Approved</span>';
							}elseif($quotation['quotation_status'] == 'accept'){
								$status_message = '<span class="badge badge-pill bg-primary">Accepted</span>';
							}elseif($quotation['quotation_status'] == 'pending' && $current_date > $exp_date){
								$status_message = '<span class="badge badge-pill bg-warning">Expired</span>';
							}elseif($quotation['quotation_status'] == 'converted'){
								$status_message = '<span class="badge badge-pill bg-success">Converted</span>';
							}
						?>
                        <td class="order-preorder"><a href="<?= base_url('quotation-detail/'.$quotation['id']);?>" target="_blank"><?= $status_message; ?></a></td>
                    </tr>
                    <?php }}else{ ?>
                    <tr><td colspan="7" align="center">No Quotation Found</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php $this->load->view("front/common/footer");?>
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
