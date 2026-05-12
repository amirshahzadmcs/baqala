<?php if (!empty($corrections)) : ?>
    <?php foreach ($corrections as $correction) : ?>
        <div class="d-flex align-items-center correction-comment">
            <div class="col-md-8">
                <p class="font-size-10 mb-0">Returned for correction by <span class="text-info"><?= htmlspecialchars($correction['employee_name']); ?></span></p>
                <h5 class="font-size-12 mb-0">"<?= nl2br(htmlspecialchars($correction['comment'])); ?>"</h5>
            </div>
            <div class="col-md-4 text-end font-size-12">
                <?= date('d M, Y', strtotime($correction['created_at'])); ?><br>
                <?= date('h:i A', strtotime($correction['created_at'])); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>