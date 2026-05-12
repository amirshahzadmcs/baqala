<div class="card">
    <div class="card-body">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic text-center">
                <img src="<?= base_url('store_assets/images/users/avatar.png'); ?>"
                    class="img-responsive" alt="user" style="width: 100px;">
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <h5 class="text-center mt-3"><?= ($result->full_name !== '') ? $result->full_name : 'N/A';?></h5>
                </div>
                <div class="profile-usertitle-job">
                    <h6 class="text-center"><?= $result->emp_no;?></h6>
                </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            
        </div>
    </div>
</div>
