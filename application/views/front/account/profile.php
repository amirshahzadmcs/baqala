<?php $this->load->view("front/common/header");?>
<section class="order-table mb-5">
    <div class="container">
        <hr />

        <h4>Profile</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="account-setting">
                    <div class="row">
						<div class="col-md-4 mb-3">
                            <label>Company Name</label>
                            <input type="text" class="form-control" value="<?= $result->company_name; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>Corporate ID</label>
                            <input type="text" class="form-control" value="<?= $result->parent_username; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>Customer Name</label>
                            <input type="text" class="form-control" value="<?= $result->display_name; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>Customer Username</label>
                            <input type="text" class="form-control" value="<?= $result->username; ?>" disabled />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="<?= $result->login_email; ?>" disabled />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" value="<?= $result->login_phone; ?>" disabled />
                        </div>
						<!--
                        <div class="col-md-4 mb-3">
                            <label>VAT or Sales Tax Number (if applicable)</label>
                            <input type="text" class="form-control" value="<?= $result->vat_no; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>CR Number</label>
                            <input type="text" class="form-control" value="<?= $result->cr_no; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>VAT Expiry</label>
                            <input type="text" class="form-control" value="<?= $result->vat_expiry; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>CR Expiry</label>
                            <input type="text" class="form-control" value="<?= $result->cr_expiry; ?>" disabled />
                        </div>
						<div class="col-md-4 mb-3">
                            <label>Agrement Expiry</label>
                            <input type="text" class="form-control" value="<?= $result->agrement_expiry; ?>" disabled />
                        </div>
						-->
					</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
	$this->load->view("front/common/footer");
?>
