<div class="leave-employee-group mt-2">
	<div>
		<div class="mb-2">
			<h6 id="employeeCountInModal"><?php echo count($employees);?> Cv Found</h6>
		</div>
	</div>
	<?php if(count($employees) > 0){ ?>
	<div class="mb-1">
		<input class="checkbox" type="checkbox" name="group_type" id="checkAll">
		<label class="form-check-label" for="checkAll" style="vertical-align: top;">Check All</label>
	</div>
    <ul class="list-group mt-1" id="employeeList">
        <?php foreach($employees as $cv){ ?>
        <li class="list-group-item d-flex align-items-center">
			<div style="width:8%;"><input class="checkbox employee-checkbox" type="checkbox" name="selected_cvs[]" value="<?php echo $cv['id']; ?>"></div>
            <div style="width:72%;">
                <h6 class="mb-0"><?php echo (($cv['first_name'] !=='') ? $cv['first_name'] : ''). (($cv['middle_name'] !=='') ? ' '.$cv['middle_name'] : ''). (($cv['third_name'] !=='') ? ' '.$cv['third_name'] : ''). (($cv['surname'] !=='') ? ' '.$cv['surname'] : ''); ?></h6>
                <small><?php echo $cv['cv_no']; ?> - <?php echo $cv['candidate_arabic_name']; ?></small>
            </div>
			<?php if(!empty($cv['food_allow'])){
					$food_allow = $cv['food_allow'];
					$per_day_allowance = $food_allow / $arrival_month_days;
					if ($current_day <= 15) {
						$remaining_days_in_period = 15 - $current_day + 1;
					} else {
						$remaining_days_in_period = $arrival_month_days - $current_day + 1;
					}
					$remaining_allowance = $per_day_allowance * $remaining_days_in_period;
				}
			?>
			<div style="width:20%;">
				<button type="button" class="btn btn-outline-primary btn-sm" data-emp-id="<?php echo $cv['id']; ?>"><?php echo number_format($remaining_allowance, 2, '.', '');?> SAR</button>
			</div>
        </li>
        <?php } ?>
    </ul>
	<?php } ?>
</div>

<script>
$(document).ready(function() {
    $("#checkAll").click(function() {
        $(".employee-checkbox").prop("checked", this.checked);
    });
});
</script>
