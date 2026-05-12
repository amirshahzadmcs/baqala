		<div class="copy_right text-center">
            <div class="container">
                <div class="row">
                    <div class="footer-logo">
                        <a href="<?= base_url();?>"><img alt="logo" src="assets/image/ft-logo.png" /></a>
                    </div>
                    <div class="footer-link">
                        <ul>
                            <li>
                                <a href="<?= base_url();?>">Home <span>مسكن</span> </a> |
                            </li>
                            <li>
                                <a href="<?= base_url();?>"> Products <span>منتجات</span> </a> |
                            </li>
                            <li>
                                <a href="<?= base_url('contact-us');?>"> Contact Us <span>اتصل بنا </span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <div class="mini_footer mt-2">
                            <p>©2023, All Rights Reserved By: Baqala-Station</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal mobile-search-bar fade mt-10" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" style="top:35px;">
            <div class="modal-dialog modal-dialog modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="searchModalToggleLabel">Search Products</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMobSearch()"></button>
                    </div>
                    <div class="modal-body" id="m-search-modal">
                        <?php echo form_open('search', array("method"=>"get","id"=>"searchFormMob")); ?>
                        <div class="input-group">
                            <input class="form-control border txt_search_mob" type="search" name="term" autocomplete="off" placeholder="<?php echo $this->lang->line('msg_search_placeholder') ?>.." />
                            <span class="input-group-append">
                                <button class="btn btn-outline-secondary bg-white border ms-n5" type="submit">
                                    <i class="fal fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <?php echo form_close();?>
                        <div class="searchResultMob"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="zeynep">
            <ul>
                <li>
		            <a href="javascript:;" style="background: #000 !important; color: #fff;">Menu</a>
		        </li>
                <li>
                    <a href="<?= base_url();?>">Home</a>
                </li>
				<?php foreach($this->customer->getCategoryTree() as $category){ ?>
				<?php if(count($category['children']) > 0){ ?>
					<li class="has-submenu">
						<a href="<?php echo 'categories/'.$category['id']; ?>" data-submenu="categories"><?php echo $category['name'];?></a>

						<div id="categories" class="submenu">
							<div class="submenu-header">
								<a href="#" data-submenu-close="categories"> Back</a>
							</div>

							<ul>
								<?php foreach($category['children'] as $child){?>
								<?php if(count($child['children']) > 0){ ?>
								<li class="has-submenu">
									<a href="<?php echo 'categories/'.$child['id']; ?>" data-submenu="electronics"><?php echo $child['name'];?></a>

									<div id="electronics" class="submenu">
										<div class="submenu-header">
											<a href="#" data-submenu-close="electronics"> Back</a>
										</div>

										<ul>
											<?php foreach($child['children'] as $subchild){?>
											<li>
												<a href="<?php echo 'categories/'.$subchild['id']; ?>"><?php echo $subchild['name'];?></a>
											</li>
											<?php } ?>
										</ul>
									</div>
								</li>
								<?php }else{ ?>
								<li>
									<a href="<?php echo 'categories/'.$child['id']; ?>"><?php echo $child['name'];?></a>
								</li>
								<?php } } ?>
							</ul>
						</div>
					</li>
				<?php }else{ ?>
					<li><a href="<?php echo 'categories/'.$category['id']; ?>"><?php echo $category['name'];?></a></li>
				<?php }} ?>
            </ul>
        </div>
        <div class="zeynep-overlay"></div>
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/main.js');?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js');?>"></script>
    </body>
</html>