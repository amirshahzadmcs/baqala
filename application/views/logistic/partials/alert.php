<?php if($this->logistic->getInfo()){
$info = explode("--", $this->logistic->getInfo());
$info_type = $info[0];
$msg_data = $info[1];
if($info_type == 2){
?>
<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong><?php echo $msg_data;?></strong>
</div>
<?php } else{?>
    <div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><?php echo $msg_data;?></strong>
    </div>
<?php } ?> <?php } $this->logistic->removeInfo();?>