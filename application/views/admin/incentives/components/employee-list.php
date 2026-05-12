<style>
.hide-important {
    display: none !important;
}
.show-important {
    display: flex !important;
}
#employeeList {
    margin-top: 75px;
}
</style>
<div class="employee-selection-body">
    <div class="leave-employee-group mt-2">
        <div
            style="position: fixed;width: 94%;z-index: 99;background: #fff;top: 59px;padding-top: 10px;border-bottom: 1px solid #eaedf1;">
            <div class="d-flex justify-content-between">
                <div class="input-group mb-2">
                    <input type="text" id="searchEmployees" class="form-control" placeholder="Search Riders"
                        aria-label="Search employees" autocomplete="off">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="mb-2">
                <h6 id="employeeCountInModal"><?= isset($employees_list) ? count($employees_list) : 0;?> Riders Found in <span class="text-primary"><?= $incentive_info->incentive_name;?></span></h6>
            </div>
        </div>

        <ul class="list-group mt-3" id="employeeList" style="margin-top: 69px!important;">
            <?php foreach ($employees_list as $employee) : ?>
            <li class="list-group-item d-flex align-items-center">
                <div class="text-center pe-2">
                    <?php if (!empty($employee['employee_pic']) && $employee['employee_pic'] !== '') { ?>
                        <img src="<?= base_url($employee['employee_pic']); ?>" class="rounded-circle border" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
                    <?php } else { ?>
                        <img src="<?= base_url('images/user-img.png'); ?>" class="rounded-circle border" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
                    <?php } ?>
                </div>
                <div>
                    <h6 class="mb-0"><?= ucfirst($employee['full_name']);?></h6>
                    <small><?= $employee['emp_no'];?> - <?= $employee['employee_arabic_name'];?></small>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#searchEmployees').on('keyup', function() {
            var searchQuery = $(this).val().toLowerCase();
            $('#employeeList .list-group-item').each(function() {
                var approverName = $(this).find('h6.mb-0').text().toLowerCase();
                var approverID = $(this).find('small').text().toLowerCase();
                var isVisible = approverName.includes(searchQuery) || approverID.includes(searchQuery);
                
                if (isVisible) {
                    $(this).addClass('show-important').removeClass('hide-important');
                } else {
                    $(this).addClass('hide-important').removeClass('show-important');
                }
            });
        });
    });
</script>