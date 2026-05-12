<div class="list-group">
    <?php 
        $current_url = current_url();
    ?>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/assets')) ? 'active' : '' ?>">Assets</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/business-trip')) ? 'active' : '' ?>">Business Trip</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/correction-request')) ? 'active' : '' ?>">Correction Request</a>
	<a href="<?= base_url('admin/hr-module/request/change-profession'); ?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/change-profession')) ? 'active' : '' ?>">Change Profession</a>
	<a href="<?= base_url('admin/hr-module/request/disputes');?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/disputes')) ? 'active' : '' ?>">Disputes</a>
	<a href="<?= base_url('admin/hr-module/request/driving-licence');?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/driving-licence')) ? 'active' : '' ?>">DL Request</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/excuse')) ? 'active' : '' ?>">Excuse</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/exit-re-entry')) ? 'active' : '' ?>">Exit Re-entery</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/expense-claim')) ? 'active' : '' ?>">Expense Claim</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/final-settlement')) ? 'active' : '' ?>">Final settlement</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/hiring')) ? 'active' : '' ?>">Hiring</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/info-change')) ? 'active' : '' ?>">Info change</a>
    <a href="<?= base_url('admin/hr-module/request/leave'); ?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/leave')) ? 'active' : '' ?>">Leave</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/letter')) ? 'active' : '' ?>">Letter</a>
    <a href="<?= base_url('admin/hr-module/request/loans'); ?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/loans')) ? 'active' : '' ?>">Loan</a>
	<a href="<?= base_url('admin/hr-module/request/notice-warning'); ?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/notice-warning')) ? 'active' : '' ?>">Employee Notices/Warnings</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/overtime')) ? 'active' : '' ?>">Overtime</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/payroll-review')) ? 'active' : '' ?>">Payroll review</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/resignation')) ? 'active' : '' ?>">Resignation</a>
	<a href="<?= base_url('admin/hr-module/request/transfer');?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/transfer')) ? 'active' : '' ?>">Transfer Request</a>
    <a href="#" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/vacation-settlement')) ? 'active' : '' ?>">Vacation settlement</a>
	<a href="<?= base_url('admin/hr-module/request/vehicle-allotment');?>" class="list-group-item list-group-item-action <?= ($current_url == base_url('admin/hr-module/request/vehicle-allotment')) ? 'active' : '' ?>">Vehicle Allotment</a>
</div>