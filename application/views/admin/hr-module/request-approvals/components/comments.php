<?php if (!empty($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="row justify-content-between font-size-12">
            <div class="col-md-1 text-center pe-0"><i class="mdi mdi-account-circle-outline font-size-24 text-muted"></i></div>
            <div class="col-md-7 text-muted">
                <b><?= htmlspecialchars($comment['emp_no']); ?> - <?= htmlspecialchars($comment['employee_name']); ?></b><br>
                <?= htmlspecialchars($comment['employee_arabic_name']); ?>
            </div>
            <div class="col-md-4 text-end text-muted">
                <?= date('d M, Y', strtotime($comment['created_at'])); ?><br>
                <?= date('h:i A', strtotime($comment['created_at'])); ?>
            </div>
            <div class="col-md-12 my-2">
                <p class="font-size-13 text-muted mb-0"><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <?php if (!empty($comment['attachment'])) : ?>
                    <a class="font-size-12 text-info me-2" href="<?= base_url($comment['attachment']); ?>" target="_blank">
                        <i class="dripicons-paperclip align-middle"></i> <?= basename($comment['attachment']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row border-top my-2"></div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="row justify-content-between font-size-12">
        <div class="col-md-12 text-center text-muted">
            No comments found.
        </div>
    </div>
<?php endif; ?>
