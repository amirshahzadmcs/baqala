<?php $this->load->view("front/common/header");?>
<section class="product-details">
	<?php if(isset($result['sizes'])){ ?>
   <div class="container">
      	<hr />
	  	<nav aria-label="breadcrumb">
			<ol class="breadcrumb px-2">
				<li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
				<?php foreach($result['categories'] as $breadcrumb){ ?>
				<li class="breadcrumb-item"><a href="<?= base_url('categories/'.$breadcrumb['category_id']);?>"><?= $breadcrumb['name']; ?></a></li>
				<?php } ?>
				<li class="breadcrumb-item active" aria-current="page"><?= $result['name']; ?></li>
			</ol>
		</nav>
      <div class="single_product mt-3">
         <div class="row">
            <div class="col-md-12">
               	<div class="product_single_img mb-visible">
					<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="<?php echo ($result['image'] == "" OR !file_exists($result['image'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['image'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php if(!empty($result['images']['other_img1'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img1'] == '' OR !file_exists($result['images']['other_img1'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img1'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img2'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img2'] == '' OR !file_exists($result['images']['other_img2'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img2'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img3'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img3'] == '' OR !file_exists($result['images']['other_img3'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img3'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img4'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img4'] == '' OR !file_exists($result['images']['other_img4'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img4'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
						</button>
					</div>
               	</div>
            </div>
            <div class="col-md-8">
               <div class="product-dis">
                  <h4><?= $result['name'];?> <span> <?= $result['name_ar'];?></span></h4>
                  <p><b>Brand</b> - <?= $result['brand_name'];?> </p>
                  <table class="table table-bordered item_table">
                     <thead>
                        <tr>
                           <th scope="col" width="60%">Code</th>
                           <th scope="col" class="text-center" width="15%">Size</th>
                           <th scope="col" class="text-center" width="10%">Qty.</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><?= $result['parent_sku'];?>-<?= $result['sizes']['product_sku'];?> <span class="sku-divider">/</span> <?= $result['sizes']['barcode'];?></td>
                           <td class="text-center"><?= $result['sizes']['size'];?> <?= $result['sizes']['unit_name'];?></td>
                           <td class="qty-title text-center">    
						   <input type="number" min="1" id="s_<?= $result['sizes']['id'];?>" maxlength="3" name="quantity" value="<?= $result['sizes']['cart_quantity'];?>" class="form-control qty" data-size="<?= $result['sizes']['id'];?>" data-product="<?= $result['sizes']['product_id'];?>" onKeyUp="return addtocart('s_<?= $result['sizes']['id'];?>');" style="width:50px" />
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="col-md-4">
               	<div class="product_single_img mb-hidden">
				   <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="<?php echo ($result['image'] == "" OR !file_exists($result['image'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['image'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php if(!empty($result['images']['other_img1'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img1'] == '' OR !file_exists($result['images']['other_img1'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img1'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img2'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img2'] == '' OR !file_exists($result['images']['other_img2'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img2'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img3'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img3'] == '' OR !file_exists($result['images']['other_img3'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img3'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
							<?php if(!empty($result['images']['other_img4'])){?>
							<div class="carousel-item">
								<img src="<?php echo ($result['images']['other_img4'] == '' OR !file_exists($result['images']['other_img4'])) ? 'assets/image/no-image.jpg':$this->customer->getResizeImage($result['images']['other_img4'],200,200); ?>" class="d-block w-100" alt="<?php echo $result['name']; ?>">
							</div>
							<?php } ?>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
						</button>
					</div>
               	</div>
            </div>
         </div>
      </div>
   </div>
   <?php }else{ ?>
	<div class="container border-top">
		<div class="row py-5">
			<div class="col-md-12">
				<h4 class="text-center">Product not available.</h4>
			</div>
		</div>
	</div>
	<?php } ?>
</section>
<?php
	$this->load->view("front/common/footer");
?>
