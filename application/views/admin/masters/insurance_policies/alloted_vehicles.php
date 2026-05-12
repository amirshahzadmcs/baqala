<div class="modal-header">
	<h5 class="modal-title mt-0">Policy Allotments - #<?= $detail->policy_number;?></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<!-- Search Bar -->
<div class="p-2">
    <input type="search" id="searchAllotments" class="form-control" placeholder="Search by vehicle number..." onkeyup="filterAllotments()">
</div>
<div class="modal-body">
    <div id="allotmentsList">
        <?php foreach($allotments_list as $alloted_to){ ?>
        <div class="allotment-item d-flex align-items-center border-bottom pb-2 mb-2">
            <div class="col-md-7">
                <h5 class="font-size-12 mb-0">Vehicle No. - <span class="vehicle-no"><?= $alloted_to['vehicle_no']; ?></span></h5>
                <p class="font-size-12 mb-0 vehicle-info"><?= ucfirst($alloted_to['vehicle_type']); ?> - <?= $alloted_to['vehicle_model']; ?> (<?= $alloted_to['make_name']; ?>)</p>
            </div>
            <div class="col-md-5 text-end font-size-12">
                Issue Date: <?= date('d M, Y', strtotime($alloted_to['insurance_issue_date'])); ?><br>
                <?php
                $expiry_date = strtotime($alloted_to['insurance_expiry']);
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
	<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
</div>

<!-- JavaScript for Filtering -->
<script>
function filterAllotments() {
    var input = document.getElementById("searchAllotments");
    var filter = input.value.toLowerCase();
    var items = document.getElementsByClassName("allotment-item");
    for (var i = 0; i < items.length; i++) {
        var vehicleName = items[i].querySelector(".vehicle-no").textContent.toLowerCase();
        var empNo = items[i].querySelector(".vehicle-info").textContent.toLowerCase();
        //console.log(vehicleName, empNo);
        if (vehicleName.includes(filter) || empNo.includes(filter)) {
            items[i].style.display = "";
        } else {
            items[i].setAttribute("style", "display: none !important;");
        }
    }
}
</script>
