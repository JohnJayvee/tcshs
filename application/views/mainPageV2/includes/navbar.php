<?php $url = base_url() . 'newDesign/'; ?>

<!-- Header
		============================================= -->
		<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<?php $logo = base_url() . 'newDesign/images/tcshsImages/realNaReal.png'; ?>
						<a href="index.html" class="standard-logo" data-dark-logo="<?= $url ?>images/tcshsLogo.png"><img src="<?= $logo ?>" alt="TugScie Logo"></a>
						
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="dark">

						<ul>
							
								
									<?php
										$mainPage = base_url() . 'homeController';
										$schoolNews = base_url()  . 'homeController/schoolNews';
									?>
									<li><a href="<?= $schoolNews ?>"><div>School News</div></a></li>
									<li><a href="<?= $mainPage ?>"><div>Main Page</div></a></li>
								
							
							<?php
								$login = base_url() . 'login';
							?>
							<li><a href="<?= $login ?>">login</a></li>
							<li><a href="">About</a></li>
							<li><a href="">Contact Us</a></li>
						</ul>

						<!-- Top Cart
						============================================= -->
						<div id="top-cart">
							
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<div class="top-cart-items">
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Blue Round-Neck Tshirt</a>
											<span class="top-cart-item-price">$19.99</span>
											<span class="top-cart-item-quantity">x 2</span>
										</div>
									</div>
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Light Blue Denim Dress</a>
											<span class="top-cart-item-price">$24.99</span>
											<span class="top-cart-item-quantity">x 3</span>
										</div>
									</div>
								</div>
								<div class="top-cart-action clearfix">
									<span class="fleft top-checkout-price">$114.95</span>
									<button class="button button-3d button-small nomargin fright">View Cart</button>
								</div>
							</div>
						</div><!-- #top-cart end -->

						<!-- Top Search
						============================================= -->
						<div id="top-search">
							
							<form action="search.html" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
							</form>
						</div><!-- #top-search end -->

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->
