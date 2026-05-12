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
                    <td>Vehicle No</td>
                    <td> : </td>
                    <td><?php echo $vehicle_detail->vehicle_no;?> / <?php echo $vehicle_detail->vehicle_model;?> / <?php echo $vehicle_detail->make_name;?> <?php echo ($vehicle_detail->vehicle_type == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';?></td>
                </tr>
            </table>
            <!-- <div class="button mt-2 d-flex flex-row align-items-center">
                <button class="btn btn-sm btn-outline-primary w-100">Chat</button>
                <button class="btn btn-sm btn-primary w-100 ml-2">Follow</button>
            </div> -->
        </div>
    </div>
</div>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Fill Appointment Status Form</div>
	<form action="<?php echo base_url('admin/dl-transaction/submit'); ?>" method="POST" id="dl_form">
		<input type="hidden" name="current_status" value="<?php echo $dl_detail->trans_status; ?>">
		<div class="row p-2">
			<div class="col-md-6 form-group mb-3">
				<input type="hidden" name="request_id" value="<?php echo $dl_detail->id;?>" required />
				<label for="trans_id">DL Request No. <span class="text-danger">*</span></label>
				<input type="text" name="trans_id" id="trans_id" class="form-control" value="<?php echo $dl_detail->request_no;?>" readonly />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label for="dl_type">DL Type <span class="text-danger">*</span></label>
				<input type="text" name="dl_type" id="dl_type" class="form-control" value="<?php echo ucfirst($dl_detail->dl_type);?>" readonly />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label for="dl_request_type">DL Request Type <span class="text-danger">*</span></label>
				<input type="text" name="dl_request_type" id="dl_request_type" class="form-control" value="<?php echo ucfirst($dl_detail->dl_request_type);?>" readonly />
			</div>
			<div class="col-md-6 form-group mb-3">
				<label for="transaction_type">Appointment Type <span class="text-danger">*</span></label>
				<select name="transaction_type" id="transaction_type" class="form-select" required>
                    <?php if($dl_detail->dl_request_type == 'Direct') { ?>
                    <option value="">-- Select Status --</option>
                    <option value="10" data-next="0" <?php echo ($dl_detail->trans_status == '10') ? 'selected' : ''; ?>>DL Requested</option>
                    <option value="0" value="0" data-next="9" <?php echo ($dl_detail->trans_status == '0') ? 'selected' : ''; ?>>DL Appointment</option>
                    <option value="9" value="9" data-next="" <?php echo ($dl_detail->trans_status == '9') ? 'selected' : ''; ?>>DL Issued</option>
                    <?php }else{ ?>
					<option value="10" data-next="0" <?php echo ($dl_detail->trans_status == '10') ? 'selected' : ''; ?>>DL Requested</option>
					<option value="0" data-next="1" <?php echo ($dl_detail->trans_status == '0') ? 'selected' : ''; ?>>DL Appointment</option>
					<option value="1" data-next="2" <?php echo ($dl_detail->trans_status == '1') ? 'selected' : ''; ?>>DL File</option>
					<option value="2" data-next="3" <?php echo ($dl_detail->trans_status == '2') ? 'selected' : ''; ?>>DL Class 1</option>
					<option value="3" data-next="4" <?php echo ($dl_detail->trans_status == '3') ? 'selected' : ''; ?>>DL Class 2</option>
					<option value="4" data-next="5" <?php echo ($dl_detail->trans_status == '4') ? 'selected' : ''; ?>>DL Computer Exam</option>
					<option value="5" data-next="7" <?php echo ($dl_detail->trans_status == '5') ? 'selected' : ''; ?>>DL Final Test</option> <!-- skip 6 -->
					<option value="6" data-next="7" <?php echo ($dl_detail->trans_status == '6') ? 'selected' : ''; ?>>DL Repeat Exam</option>
					<option value="7" data-next="8" <?php echo ($dl_detail->trans_status == '7') ? 'selected' : ''; ?>>DL Medical</option>
					<option value="8" data-next="9" <?php echo ($dl_detail->trans_status == '8') ? 'selected' : ''; ?>>DL Basma</option>
					<option value="9" data-next="" <?php echo ($dl_detail->trans_status == '9') ? 'selected' : ''; ?>>DL Issued</option>
                    <?php } ?>
				</select>
			</div>

			<div class="col-md-6 form-group mb-3">
				<label for="trans_date">Transaction Date <span class="text-danger">*</span></label>
				<?php $two_days_ago = date('Y-m-d', strtotime('-2 days'));?>
                <?php
                    $last_trans_date = !empty($last_transaction_detail) ? $last_transaction_detail->trans_date : '';
                ?>
				<input type="date" name="trans_date" id="trans_date" class="form-control" min="<?php echo $last_trans_date; ?>" required />
			</div>
			
			<div class="col-md-12 mb-3" id="costContainer">
				<div class="row justify-content-between size-inner-section mx-0 py-2">
					<div class="col align-self-start"><i class="mdi mdi-cash-multiple font-size-24 me-2"></i> <b>Cost Involve</b></div>
					<div class="col align-self-end"><input type="checkbox" id="cost_involve" switch="bool" name="cost_involve"><label for="cost_involve" data-on-label="Yes" data-off-label="No" style="float: right;margin-bottom: 0.4rem;"></label></div>
				</div>
			</div>

		</div>
	</form>
</div>

<script> 
$(document).ready(function() {
    // Trigger the change event initially to set the default state
    $('#cost_involve').trigger('change');
    
    $('#cost_involve').change(function(e) {
        e.preventDefault();
        $(".costChild").remove();
        var cost_involve = $(this).prop('checked'); // Get the checked state
        // Instead of checking for 'on', check if the switch is checked or not
        var cost_input = '';
        if(cost_involve){
            cost_input = `<div class="col-md-12 form-group mb-3 costChild">
				<label for="trans_amount">Transaction Amount <span class="text-danger">*</span> <span class="text-info">(Note: Enter 0 for no transaction amt.)</span></label>
				<div class="input-group">
					<input id="trans_amount" name="trans_amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
					<span class="input-group-text">SAR</span>
				</div>
				<small class="hint">Enter Transaction Amount in SAR</small>
			</div>`;
        }
        $("#costContainer").after(cost_input);
    });
});
</script>
<script>
    const select = document.getElementById('transaction_type');
    let dl_request_type = "<?php echo $dl_detail->dl_request_type; ?>";

    function updateOptions() {

        // RESET styles
        Array.from(select.options).forEach(o => {
            o.style.color = '';
            o.style.fontWeight = '';
            o.disabled = false;
        });

        // =========================
        // DIRECT REQUEST HANDLING
        // =========================
        if (dl_request_type === 'Direct') {

            Array.from(select.options).forEach(o => {
                if (o.value !== '0' && o.value !== '9') {
                    o.disabled = true;
                }
            });

            // Highlight current
            const currentOption = select.querySelector(`option[value="${select.value}"]`);
            if (currentOption) {
                currentOption.style.fontWeight = 'bold';
                currentOption.style.color = 'green';
            }

            return; // STOP here for Direct
        }

        // =========================
        // NORMAL FLOW HANDLING
        // =========================
        const currentValue = select.value;

        // disable all
        Array.from(select.options).forEach(o => o.disabled = true);

        // enable current
        const currentOption = select.querySelector(`option[value="${currentValue}"]`);
        if (currentOption) {
            currentOption.disabled = false;
            currentOption.style.fontWeight = 'bold';
        }

        // enable next
        const nextValue = currentOption?.dataset.next;
        if (nextValue) {
            const nextOption = select.querySelector(`option[value="${nextValue}"]`);
            if (nextOption) {
                nextOption.disabled = false;
                nextOption.style.color = 'green';
                nextOption.style.fontWeight = 'bold';
            }
        }
    }

    // INIT
    updateOptions();
    select.addEventListener('change', updateOptions);
</script>
