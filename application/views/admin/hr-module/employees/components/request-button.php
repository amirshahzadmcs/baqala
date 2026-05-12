<style>
	/*---- Sidebar ----*/
	.modal .modal-dialog-aside {
		width: 30%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal .modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}

	@media (max-width: 600px) {
		.modal .modal-dialog-aside {
			width: 100%;
			max-width: 100%;
		}
	}
</style>
<div class="btn-group pull-right">
	<button type="button" class="btn btn-custom-success btn-sm waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
		New Request <i class="mdi mdi-chevron-down ms-1"></i>
	</button>
	<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">
		<?php if ($emp_detail->status == 'Absconded') { ?>
			<a class="dropdown-item" href="<?php echo base_url('admin/hr/employees/print-absence-notification?id=' . $emp_detail->id); ?>" target="_blank">Absence Notifiction</a>
		<?php } ?>
		<a class="dropdown-item" href="javascript:;" data-requesttype="New Asset request" data-empid="<?php echo $emp_detail->id; ?>">New Asset Request</a>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'add_request_form')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Asset request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Asset Request</a>
		<?php endif;
		if (check_action_permission(get_user_role(), 'view_employees', 'clinical_visit_request')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Clinical visit request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Clinical Visit Request</a>
		<?php endif; ?>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'change_profession_request')): ?>
		<a class="dropdown-item" href="javascript:;" data-requesttype="Change profession request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Change Profession Request</a>
		<?php endif; ?>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'dl_request')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Driving license request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Driving License Request</a>
		<?php endif;
		if (check_action_permission(get_user_role(), 'view_employees', 'employee_notices')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Employee notices and warnings" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Employee Notices/Warnings</a>
		<?php endif; ?>
		<a class="dropdown-item" href="javascript:;">Exit Reentry Visa Request</a>

		<a class="dropdown-item" href="javascript:;">Expenses Claim Request</a>
		<a class="dropdown-item" href="javascript:;">Hiring Request</a>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'leave_request')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Leave request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Leave Request</a>
		<?php endif;
		if (check_action_permission(get_user_role(), 'view_employees', 'loan_request')): ?>
			<a class="dropdown-item" href="javascript:;" data-requesttype="Loan request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Loan request</a>
		<?php endif; ?>
		<a class="dropdown-item" href="javascript:;">Mobile Recharge Request</a>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'print_reporting_absconded')): ?>
			<a class="dropdown-item" href="<?php echo base_url('admin/hr/employees/print-reporting-absconded?id=' . $emp_detail->id); ?>" target="_blank">Reporting Absconded</a>
		<?php endif; ?>
		<a class="dropdown-item" href="javascript:;">Resignation Request</a>
		<a class="dropdown-item" href="javascript:;">Salary Certificate Request</a>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'transfer_request')): ?>
		<a class="dropdown-item" href="javascript:;" data-requesttype="Transfer request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Transfer Request</a>
		<?php endif; ?>
		<?php if (check_action_permission(get_user_role(), 'view_employees', 'vehicle_allotment_request')): ?>
		<a class="dropdown-item" href="javascript:;" data-requesttype="Vehicle allotment request" data-empid="<?php echo $emp_detail->id; ?>" onclick="addRequestForm(this)">Vehicle Allotment Request</a>
		<?php endif; ?>
		<a class="dropdown-item" href="javascript:;">Vehicle Repair Request</a>
	</div>
</div>