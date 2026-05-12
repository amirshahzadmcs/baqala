<div class="row">
    <div id="ajax_message"></div>
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-body pb-2">
                <div class="col-12 table-responsive">
                    <table align="left" class="table table-bordered border-dark mb-2">
                        <tr><td colspan="2" align="center"><b>Summary Overview</b></td></tr>
                        <tr>
                            <td><b>Driver's ID</b> : <?= $other_info['driver_id'];?></td>
                            <td><b>Driver Name</b> : <?= $other_info['driver_name'];?></td>
                        </tr>
                        <tr>
                            <td><b>Company Name</b> : <?= $other_info['company_name'];?></td>
                            <td><b>Date</b> : <?= formatedDate($entry_date);?></td>
                        </tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark mb-0">
                        <?php
                            $count_orders = $other_info['orders'];
                        ?>
                        <tr class="text-white h6" style="background-color: #026902cc!important"><td align="center">Order List (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <form id="detail_form" method="POST">
                        <table align="left" class="table table-bordered border-dark">
                            <tbody>
                                <tr class="thead-caption">
                                    <td align="center" style="line-height:20px;"><b>Sr. No</b></td>
                                    <td align="center" style="line-height:20px;"><b>Ref. ID</b></td>
                                    <td align="center" style="line-height:20px;"><b>Collection Amt.</b></td>
                                    <td align="center" style="line-height:20px;"><b>Delivery Price</b></td>
                                    <td align="center" style="line-height:20px;"><b>Free Order Count</b></td>
                                    <td align="center" style="line-height:20px;"><b>Driver Credit</b></td>
                                    <td align="center" style="line-height:20px;"><b>Driver Debit</b></td>
                                    <td align="center" style="line-height:20px;"><b>Service Deduction</b></td>
                                    <td align="center" style="line-height:20px;"><b>Driver Tips</b></td>
                                    <td align="center" style="line-height:20px;"><b>Settled By</b></td>
                                </tr>
                                
                                <?php $count_i = 1; for($i=0; $i < $count_orders; $i++) {  ?>
                                <tr class="result-tr">
                                    <td align="center"><input type="hidden" class="form-control" name="entry_date" value="<?= $entry_date;?>" required><input type="hidden" class="form-control" name="fdco_id" value="<?= $other_info['id'];?>" required><?= $count_i++; ?></td>
                                    <td align="center"><input type="text" class="form-control" name="ref_id[]" required></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="collection_amt[]" required></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="delivery_price[]" required></td>
                                    <td align="center"><input type="number" min="0" max="99" class="form-control" name="free_order_count[]" required style="width: 130px;"></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_credit[]" required></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_debit[]" required></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="service_deduction[]" required></td>
                                    <td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_tips[]" required></td>
                                    <td align="center" style="width: 100px;">
                                        <select name="settled_by[]" class="form-control w-100" data-placeholder="Choose Method..." required>
                                            <option value="">Select</option>
                                            <option value="cash">Cash</option>
                                            <option value="wallet">Wallet</option>
                                            <option value="stcpay_p">STCPayP</option>
                                            <option value="stcpay_m">STCPayM</option>
                                            <option value="pos">POS</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php } ?>  
                                <tr>
                                    <td colspan="10">
                                        <button type="button" class="btn btn-secondary waves-effect me-2" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success waves-effect float-end">Save Summary</button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<script>
    $(document).ready(function(){$(".input-mask").inputmask()});

    $('#detail_form').on('submit', (function(e) {
		e.preventDefault();
		$.ajax({
			url: "<?php echo base_url('admin/daily-delivery-summary/add-detail');?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
            //dataType: "json",
			success: 
			//showResponse,
			function(response){
                //console.log(response);
                var result = JSON.parse(response);
                if(result['success'] == '1'){
                    $("#ajax_message").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
                }
                if(result['success'] == '0'){
                    $("#ajax_message").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
                }
			},
			error: function(response){
				//$('#ajax_message').html(JSON.stringify(request));
                var result = JSON.parse(response);
                if(result['success'] == '1'){
                    $("#ajax_message").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
                }
                if(result['success'] == '0'){
                    $("#ajax_message").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
                }
			}
		});
	}));
</script>