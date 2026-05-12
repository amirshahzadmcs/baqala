<style> 
#vehicle_form .form-group p{
	background: #ededed;
    padding-top: 10px;
}
.accordion-button:not(.collapsed) {
    color: #052738;
    background-color: #eaedf1;
}
</style>
<div>
    <input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicle_detail['id'];?>" required />
    <!---- Vehicle Detail ----->
    <div class="accordion m-2 rounded-3" id="accidentVehicleAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header m-2 rounded" id="accidentVehicleHeading">
            <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentVehicleCollapse" aria-expanded="true" aria-controls="accidentVehicleCollapse">
                Vehicle Information
            </button>
            </h2>
            <div id="accidentVehicleCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentVehicleHeading" data-bs-parent="#accidentVehicleAccordion">
                <div class="accordion-body">
                    <div class="row">
                        <?php if(!empty($vehicle_detail)){ ?>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_no">Vehicle Plate No :</label>
                            <p class="form-control" readonly><b><?php echo $vehicle_detail['vehicle_no'];?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_name_en">Vehicle Make :</label>
                            <p class="form-control" readonly><b><?php echo $vehicle_detail['make_name'];?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_name_ar">Vehicle Model :</label>
                            <p class="form-control" readonly><b><?php echo $vehicle_detail['vehicle_model'];?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_issue_date">Vehicle Year :</label>
                            <p class="form-control" readonly><b><?php echo $vehicle_detail['vehicle_year'];?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_issue_date">Vehicle Ownership :</label>
                            <p class="form-control" readonly><b><?php echo $vehicle_detail['vehicle_ownership'];?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="iqama_issue_date">Gasoline Chip :</label>
                            <p class="form-control" readonly>
                                <b><?php echo ($vehicle_detail['gasoline_chip_status'] == 'on') ? 'Yes' : 'No';?></b>
                            </p>
                        </div>
                        <?php }else{ ?>
                            <div class="col-md-12">No vehicle data found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($vehicle_detail['gasoline_chip_status'] !== 'on'){ ?>
	<div class="accordion m-2 rounded-3" id="accidentReportAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header m-2 rounded" id="accidentReportHeading">
            <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#accidentReportCollapse" aria-expanded="true" aria-controls="accidentReportCollapse">
                Update Gasoline Chip Information
            </button>
            </h2>
            <div id="accidentReportCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="accidentReportHeading" data-bs-parent="#accidentReportAccordion">
                <div class="accordion-body">
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3 form-group">
                            <label class="d-block">Gasoline Chip</label>
                            <input type="checkbox" id="switch4" switch="bool" name="gasoline_chip_status" />
                            <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
                        </div>

                        <div class="col-md-6 col-sm-12 form-group mb-2">
                            <label for="gasoline_installation_date">Installation Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="gasoline_installation_date" name="gasoline_installation_date" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
