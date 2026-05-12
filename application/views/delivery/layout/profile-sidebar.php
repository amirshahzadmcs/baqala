<div class="card">
    <style>
        .profile-usermenu ul li{
            display: block;
            padding: 10px;
        }
    </style>
    <div class="card-body">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic text-center px-5">
                <img src="<?= base_url('store_assets/images/users/avatar.png'); ?>"
                    class="img-responsive border border-success" alt="" style="width: 100%;">
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle pt-3">
                <div class="profile-usertitle-name text-center">
                    <?= ($result->name !== '') ? $result->name : 'N/A';?><br>
                </div>
                <div class="profile-usertitle-job text-center">
                    <?= $result->email;?>
                </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li class="<?= ($this->uri->segment(2) == 'profile') ? 'active':'';?>">
                        <a href="<?= base_url('delivery-partner/profile'); ?>"><i class="glyphicon glyphicon-home"></i> Profile </a>
                    </li>
                    <li class="<?= ($this->uri->segment(2) == 'change-password') ? 'active':'';?>">
                        <a href="<?= base_url('delivery-partner/change-password'); ?>"><i class="glyphicon glyphicon-user"></i>Account Settings </a>
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
