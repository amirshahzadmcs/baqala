<div class="leave-employee-group mt-2">
	<div style="position: fixed;width: 94%;z-index: 99;background: #fff;top: 59px;padding-top: 10px;border-bottom: 1px solid #eaedf1;">
		<div class="d-flex justify-content-between">
			<div class="input-group mb-2">
				<input type="text" id="searchEmployees" class="form-control" placeholder="Search employees" aria-label="Search employees" autocomplete="off">
				<span class="input-group-text">
					<i class="fas fa-search"></i>
				</span>
			</div>
			<!-- <button class="btn btn-outline-secondary" type="button" id="filterButton">Filters</button> -->
		</div>
		<div class="mb-2">
			<h6 id="employeeCountInModal">0 Employees</h6>
		</div>
	</div>
    
    <ul class="list-group mt-3" id="employeeList" style="margin-top: 69px!important;">
        <?php foreach($employees as $emp){ ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0"><?php echo $emp->full_name; ?></h6>
                <small><?php echo $emp->emp_no; ?> - <?php echo $emp->employee_arabic_name; ?></small>
            </div>
            <?php
                $selectedEmployees = json_decode($selected_emp, true); // Decode JSON array
                $isSelected = in_array($emp->id, $selectedEmployees);
            ?>
            <button type="button" class="btn <?php echo ($isSelected) ? 'btn-outline-danger' : 'btn-outline-primary'; ?> btn-sm addEmployee" data-emp-id="<?php echo $emp->id; ?>">
                <?php echo ($isSelected) ? '- Remove' : '+ Add'; ?>
            </button>
        </li>
        <?php } ?>
    </ul>
</div>
