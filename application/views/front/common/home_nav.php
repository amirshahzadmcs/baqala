<header class="header header-8" style="position:fixed;z-index: 99;box-shadow: 1px 2px 3px #ddd;">
	<div class="header-middle sticky-header">
		<div class="container">
			<div class="header-left">
				<button class="mobile-menu-toggler">
					<span class="sr-only">Toggle mobile menu</span>
					<i class="icon-bars"></i>
				</button>

				<a href="index.html" class="logo">
					<img src="assets/images/demos/demo-10/logo.png" alt="Bakala Station" width="120" height="120" />
				</a>
			</div>
			<!-- End .header-left -->

			<div class="header-right">

				<div class="header-search">
					<a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
					<form action="#" method="get">
						<div class="header-search-wrapper">
							<label for="q" class="sr-only">Search</label>
							<input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required />
						</div>
						<!-- End .header-search-wrapper -->
					</form>
				</div>
				<!-- End .header-search -->

				<div>
					<a href="cart" role="button" aria-haspopup="true" aria-expanded="false" data-display="static">
						<i class="icon-shopping-cart fa-3x" style="color: #dc3545 !important;"></i>
						<span class="cart-count"><span id="cart_number" class="badge badge-success cart-badge-green"><?php echo $this->customer->inCart();?></span></span>
					</a>
					<!-- End .dropdown-menu -->
				</div>
				<!-- End .cart-dropdown -->
			</div>
			<!-- End .header-right -->
		</div>
		<!-- End .container -->
	</div>
	<!-- End .header-middle -->
</header>