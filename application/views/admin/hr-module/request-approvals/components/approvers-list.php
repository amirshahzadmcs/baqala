<?php
    $approverList = getRequestedApprover($request_info['id']);
    //print_r($approverList);
    if (!empty($approverList)) {
        foreach ($approverList as $approver) {
?>
<div class="d-flex align-items-center">
    <div class="col-md-1 text-center pe-2">
        <?php if (!empty($approver['employee_pic']) && $approver['employee_pic'] !== '') { ?>
            <img src="<?= base_url($approver['employee_pic']); ?>" class="rounded-circle" alt="<?= $approver['full_name']; ?>" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
        <?php } else { ?>
            <img src="<?= base_url('images/user-img.png'); ?>" class="rounded-circle" alt="<?= $approver['full_name']; ?>" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
        <?php } ?>
    </div>
    <div class="col-md-7">
        <h5 class="font-size-12 mb-0"><?= $approver['full_name']; ?></h5>
        <p class="font-size-12 mb-0"><?= $approver['emp_no']; ?> - <?= $approver['employee_arabic_name']; ?></p>
    </div>
    <div class="col-md-4 text-end font-size-12">
        <?php if($approver['approve_status'] == '0'){ ?>
        <?= date('d M, Y', strtotime($approver['created_at'])); ?><br>
        <?= date('h:i A', strtotime($approver['created_at'])); ?>
        <?php }else{ ?>
        <?= date('d M, Y', strtotime($approver['updated_at'])); ?><br>
        <?= date('h:i A', strtotime($approver['updated_at'])); ?>
        <?php } ?>
    </div>
</div>
<div class="row my-2">
    <?php $approver_status = $statusMapping[$approver['approve_status']] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info']; ?>
    <div class="col-md-6 ms-4"><span class="badge rounded-pill <?= $approver_status['badgeClass'] ?> px-2 py-1 font-size-12"><?= $approver_status['label'] ?></span></div>
</div>
<?php
        }
    }
?>