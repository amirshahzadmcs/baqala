<div class="card">
    <div class="card-body">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic text-center">
                <img src="<?= base_url('store_assets/images/users/avatar.png'); ?>"
                    class="img-responsive border border-success w-100" alt="">
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <?= $result->store_name;?><br>
                    <?= $result->store_name_arabic;?>
                </div>
                <div class="profile-usertitle-job">
                                <?= $result->store_id;?>
                </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li class="<?= ($this->uri->segment(2) == 'profile') ? 'active':'';?>">
                        <a href="<?= base_url('store/profile'); ?>"><i class="glyphicon glyphicon-home"></i> Profile </a>
                    </li>
                    <li class="<?= ($this->uri->segment(2) == 'change-password') ? 'active':'';?>">
                        <a href="<?= base_url('store/change-password'); ?>"><i class="glyphicon glyphicon-user"></i>Account Settings </a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="glyphicon glyphicon-flag"></i> Help </a>
                    </li>
                </ul>
            </div>
            <!-- END MENU -->
        </div>
    </div>
</div>
