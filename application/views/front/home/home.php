<?php $this->load->view("front/common/header");?>
    <section class="top_product_sec">
        <div class="container">
            <hr />
            <p>Welcome To Baqala Station</p>
            <div class="row">
                <?php foreach($result['categories'] as $cat){ ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="product_item">
                        <a href="<?php echo 'categories/'.$cat['id'];?>">
                            <div class="product_img">
                                <img src="<?php echo ($cat["image"] == "" OR !file_exists($cat["image"])) ? 'assets/image/no-image.jpg':$cat["image"]; ?>" alt="<?= $cat['name'];?>" class="img-fluid" />
                            </div>
                        </a>

                        <div class="product_info">
                            <a href="<?php echo 'categories/'.$cat['id'];?>">
                                <h2><?= $cat['name'];?> <span> <?= $cat['arabic_name'];?></span></h2>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php $this->load->view("front/common/footer");?>
