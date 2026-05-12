<div class="modal-header">
    <h5 class="modal-title mt-0">Policy Allotments - #<?= $detail->policy_number;?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<!-- Search Bar -->
<div class="p-2">
    <input type="search" id="searchAllotments" class="form-control" placeholder="Search by name or employee number..." onkeyup="filterAllotments()">
</div>

<div class="modal-body">
    <div id="allotmentsList">
        <?php foreach($allotments_list as $alloted_to){ ?>
        <div class="allotment-item d-flex align-items-center border-bottom pb-2 mb-2">
            <div class="col-md-1 text-center pe-2">
                <?php if (!empty($alloted_to['employee_pic']) && $alloted_to['employee_pic'] !== '') { ?>
                    <img src="<?= base_url($alloted_to['employee_pic']); ?>" class="rounded-circle" alt="<?= $alloted_to['full_name']; ?>" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
                <?php } else { ?>
                    <img src="<?= base_url('images/user-img.png'); ?>" class="rounded-circle" alt="<?= $alloted_to['full_name']; ?>" height="23" width="23" style="z-index: 1;position: relative;background: #fff;">
                <?php } ?>
            </div>
            <div class="col-md-7">
                <h5 class="font-size-12 mb-0"><?= $alloted_to['full_name']; ?></h5>
                <p class="font-size-12 mb-0"><?= $alloted_to['emp_no']; ?> - <?= $alloted_to['employee_arabic_name']; ?></p>
            </div>
            <div class="col-md-4 text-end font-size-12">
                Issue Date: <?= date('d M, Y', strtotime($alloted_to['insurance_issue_date'])); ?><br>
                <?php
                $expiry_date = strtotime($alloted_to['insurance_end_date']);
                $formatted_date = date('d M, Y', $expiry_date);
                $today = strtotime(date('Y-m-d'));

                $color = ($expiry_date < $today) ? 'red' : 'black';
                ?>
                Expiry Date: <span style="color: <?= $color; ?>;"><?= $formatted_date; ?></span>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
</div>

<!-- JavaScript for Filtering -->
<script>
function filterAllotments() {
    var input = document.getElementById("searchAllotments");
    var filter = input.value.toLowerCase();
    var items = document.getElementsByClassName("allotment-item");
    for (var i = 0; i < items.length; i++) {
        var name = items[i].getElementsByTagName("h5")[0].innerText.toLowerCase();
        var empNo = items[i].getElementsByTagName("p")[0].innerText.toLowerCase();
        
        if (name.includes(filter) || empNo.includes(filter)) {
            items[i].style.display = "";
        } else {
            items[i].setAttribute("style", "display: none !important;");
        }
    }
}
</script>

