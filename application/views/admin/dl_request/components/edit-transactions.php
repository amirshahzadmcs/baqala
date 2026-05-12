<style> 
.loader-icon,
.save-icon {
    display: inline-block;
    min-width: 1em; /* or match spinner width */
    vertical-align: middle;
}

.loader-icon {
    display: none;
}

.save-icon {
    display: block;
}
</style>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Employee Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="image">
			<?php if(!empty($dl_detail->employee_pic) && $dl_detail->employee_pic !== ''){ ?>
				<img src="<?php echo $dl_detail->employee_pic;?>" class="rounded" width="140">
			<?php }else{ ?>
				<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
			<?php } ?>
        </div>
        <div class="p-3 w-100">
            <h5 class="mb-0 mt-0"> <?php echo $dl_detail->full_name;?> / <?php echo $dl_detail->employee_arabic_name;?> </h5>
            <span><?php echo $dl_detail->designation_name;?> | <?php echo $dl_detail->department_name;?></span>
            <hr class="my-1">
            <table>
                <tr>
                    <td>Emp No.</td>
                    <td> : </td>
                    <td><?php echo $dl_detail->emp_no;?></td>
                </tr>
                <tr>
                    <td>Iqama No</td>
                    <td> : </td>
                    <td><?php echo $dl_detail->iqama_no;?></td>
                </tr>
                <tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td><?php echo $dl_detail->nationality_name;?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td><?php echo $dl_detail->mobile;?></td>
                </tr>
                <tr>
                    <td>Request No.</td>
                    <td> : </td>
                    <td><mark>#<?php echo $dl_detail->request_no;?></mark> (<?php echo ucfirst($dl_detail->dl_type);?>)</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Update Amount of Transactions</div>
	<form action="<?php echo base_url('admin/dl-transaction/submit'); ?>" method="POST" id="transaction_form">
		<div class="row p-2">
            <input type="hidden" name="request_id" value="<?php echo $dl_detail->id;?>" required />
			<div class="col-md-12 form-group mb-3">
                <?php
                $transaction_types = [
                    '0' => 'DL Appointment',
                    '1' => 'DL File',
                    '2' => 'DL Class 1',
                    '3' => 'DL Class 2',
                    '4' => 'DL Computer Exam',
                    '5' => 'DL Final Test',
                    '6' => 'DL Repeat Exam',
                    '7' => 'DL Medical',
                    '8' => 'DL Basma',
                    '9' => 'DL Issued',
                ];
                ?>

                <table class="table table-bordered mt-2" style="vertical-align: middle;">
                    <thead>
                        <tr>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaction_list)) : ?>
                            <?php foreach ($transaction_list as $trans): ?>
                                <tr>
                                    <td><?= $transaction_types[$trans['transaction_type']] ?? 'Unknown' ?></td>
                                    <td>
                                        <input type="text" class="form-control trans-amount" 
                                            data-id="<?= $trans['id'] ?>" 
                                            value="<?= htmlspecialchars($trans['trans_amount']) ?>">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btn-save" data-id="<?= $trans['id'] ?>">
                                            <span class="save-icon" data-id="<?= $trans['id'] ?>">✔️</span>
                                            <span class="spinner-border spinner-border-sm loader-icon" role="status" data-id="<?= $trans['id'] ?>"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="2" class="text-center">No transactions found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

			</div>
		</div>
	</form>
</div>
<script>
$(document).ready(function() {
    $('.btn-save').on('click', function() {
        var id = $(this).data('id');
        var $btn = $(this);
        var $input = $('.trans-amount[data-id="' + id + '"]');
        var $loader = $('.loader-icon[data-id="' + id + '"]');
        var $tick = $('.save-icon[data-id="' + id + '"]');
        var amount = $input.val();

        // Toggle visibility instead of display
        $tick.css('display', 'none');
        $loader.css('display', 'block');

        $.ajax({
            url: '<?= base_url('admin/dl-request/update-transaction-amount') ?>',
            type: 'POST',
            data: {
                id: id,
                trans_amount: amount
            },
            dataType: 'json',
            success: function(response) {
                $loader.css('display', 'none');
                $tick.css('display', 'block');

                if (response.status === 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message || 'Update failed.');
                }
            },
            error: function() {
                $loader.css('display', 'none');
                $tick.css('display', 'block');
                toastr.error('An error occurred while updating the transaction amount.');
            }
        });
    });
});

</script>