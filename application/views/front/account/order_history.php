<?php $this->load->view("front/common/header");?>
<section class="order-table mb-5">
    <div class="container">
        <hr />
		<div class="row">
			<div class="btn-group btn-group-toggle" data-toggle="buttons">
				<button class="btn btn-light border" onclick="window.location.href='<?= base_url().'quotation-history'?>'">Quotation List</button>
				<button class="btn btn-success border-green" onclick="window.location.href='<?= base_url().'order-history'?>'">Order List</button>
			</div>
		</div>
        <div class="py-3 d-flex justify-content-between">
            <h4>Orders</h4>
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
                        <th>Order ID</th>
						<th>Quote No.</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Total</th>
						<th>Created By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($orders) > 0){ ?>
                    <?php $count = 1; foreach($orders as $order){ ?>
                    <tr>
                        <td><?= $count++;?></td>
                        <td><a href="<?= base_url('order-detail/'.$order['id']);?>" class="text-decoration-underline" target="_blank"><?= $order['invoice_prefix'] .'-'. $order['order_no'];?> </a></td>
                        <td><a href="<?= base_url('quotation-detail/'.$order['id']);?>" class="text-decoration-underline" target="_blank"><?= 'QTN-'. $this->customer->invoiceNmFormat($order['quotation_no']);?> </a></td>
                        <td><?= $order['shipping_person_name'];?></td>
                        <td><?= $this->customer->formatedDate($order['date_added']);?></td>
                        <td><?= $order['order_total'];?></td>
						<td><span title="<?= $order['staff_display_name']; ?>"><?= $order['staff_username'];?></span></td>
						<?php
							if($order['order_status_id'] < 2){
								$status = 'New';
							}else{
								$status = 'Preorder';
							}
						?>
                        <td class="order-preorder">
							<a href="<?= base_url('order-detail/'.$order['id']);?>" target="_blank" class="bg-white">
								<?php if($order['order_status_id'] == '1'){ echo '<span class="bg-warning text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_pending') .'</span>'; }
									elseif($order['order_status_id'] == '2'){ echo '<span class="bg-info text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_accepted') .'</span>'; }
									elseif($order['order_status_id'] == '3'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_order_denied') .'</span>'; }
									elseif($order['order_status_id'] == '4'){ echo '<span class="bg-primary text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_ready_to_dispatched') .'</span>'; }
									elseif($order['order_status_id'] == '5'){ echo '<span class="bg-success text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_dispatched') .'</span>'; }
									elseif($order['order_status_id'] == '6'){ echo '<span class="bg-success text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_delivered') .'</span>'; }
									elseif($order['order_status_id'] == '7'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_order_denied') .'</span>'; }
									elseif($order['order_status_id'] == '8'){ echo '<span class="bg-success text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_refund_success') .'</span>'; }
									elseif($order['order_status_id'] == '9'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_cancel_by_cust') .'</span>'; }
									else{ 'Lost'; }
								?>
							</a>
						</td>
                    </tr>
                    <?php }}else{ ?>
                    <tr><td colspan="8" align="center">No Order Found</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php $this->load->view("front/common/footer");?>
