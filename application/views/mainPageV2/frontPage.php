<?php $this->Main_model->academicYearSetter(); ?>

<body class="stretched">
<?php $url = base_url() . 'newDesign/' ?>
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<!-- Header
		============================================= -->
		<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						
						<a class="standard-logo" data-dark-logo="<?= $url ?>images/tcshsImages/realNaReal.png"><img src="<?= $url ?>images/tcshsLogo.png" alt="TugScie Logo"></a>
						
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


		
		<section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">

			<div class="swiper-container swiper-parent">
				<div class="swiper-wrapper">
					<div class="swiper-slide dark" style="background-image: url('<?= $url ?>images/tcshsImages/tugScieFront.png');">
						<div class="container clearfix">
							<div class="slider-caption slider-caption-center">
								<h2 data-caption-animate="fadeInUp">Tuguegarao City Science Highschool</h2>
								<p data-caption-animate="fadeInUp" data-caption-delay="200">Scientia Ad Veritatem
										 (Science Towards Truth)</p>
							</div>
						</div>
					</div>
					
					<div class="swiper-slide" style="background-image: url('images/slider/swiper/3.jpg'); background-position: center top;">
						<div class="container clearfix">
							<div class="slider-caption">
								<h2 data-caption-animate="fadeInUp">Great Performance</h2>
								<p data-caption-animate="fadeInUp" data-caption-delay="200">You'll be surprised to see the Final Results of your Creation &amp; would crave for more.</p>
							</div>
						</div>
					</div>
				</div>
				<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
				<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
			</div>

			<script>
				jQuery(document).ready(function($){
					var swiperSlider = new Swiper('.swiper-parent',{
						paginationClickable: false,
						slidesPerView: 1,
						grabCursor: true,
						loop: true,
						onSwiperCreated: function(swiper){
							$('[data-caption-animate]').each(function(){
								var $toAnimateElement = $(this);
								var toAnimateDelay = $(this).attr('data-caption-delay');
								var toAnimateDelayTime = 0;
								if( toAnimateDelay ) { toAnimateDelayTime = Number( toAnimateDelay ) + 750; } else { toAnimateDelayTime = 750; }
								if( !$toAnimateElement.hasClass('animated') ) {
									$toAnimateElement.addClass('not-animated');
									var elementAnimation = $toAnimateElement.attr('data-caption-animate');
									setTimeout(function() {
										$toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
									}, toAnimateDelayTime);
								}
							});
							SEMICOLON.slider.swiperSliderMenu();
						},
						onSlideChangeStart: function(swiper){
							$('[data-caption-animate]').each(function(){
								var $toAnimateElement = $(this);
								var elementAnimation = $toAnimateElement.attr('data-caption-animate');
								$toAnimateElement.removeClass('animated').removeClass(elementAnimation).addClass('not-animated');
							});
							SEMICOLON.slider.swiperSliderMenu();
						},
						onSlideChangeEnd: function(swiper){
							$('#slider').find('.swiper-slide').each(function(){
								if($(this).find('video').length > 0) { $(this).find('video').get(0).pause(); }
								if($(this).find('.yt-bg-player').length > 0) { $(this).find('.yt-bg-player').pauseYTP(); }
							});
							$('#slider').find('.swiper-slide:not(".swiper-slide-active")').each(function(){
								if($(this).find('video').length > 0) {
									if($(this).find('video').get(0).currentTime != 0 ) $(this).find('video').get(0).currentTime = 0;
								}
								if($(this).find('.yt-bg-player').length > 0) {
									$(this).find('.yt-bg-player').getPlayer().seekTo( $(this).find('.yt-bg-player').attr('data-start') );
								}
							});
							if( $('#slider').find('.swiper-slide.swiper-slide-active').find('video').length > 0 ) { $('#slider').find('.swiper-slide.swiper-slide-active').find('video').get(0).play(); }
							if( $('#slider').find('.swiper-slide.swiper-slide-active').find('.yt-bg-player').length > 0 ) { $('#slider').find('.swiper-slide.swiper-slide-active').find('.yt-bg-player').playYTP(); }

							$('#slider .swiper-slide.swiper-slide-active [data-caption-animate]').each(function(){
								var $toAnimateElement = $(this);
								var toAnimateDelay = $(this).attr('data-caption-delay');
								var toAnimateDelayTime = 0;
								if( toAnimateDelay ) { toAnimateDelayTime = Number( toAnimateDelay ) + 300; } else { toAnimateDelayTime = 300; }
								if( !$toAnimateElement.hasClass('animated') ) {
									$toAnimateElement.addClass('not-animated');
									var elementAnimation = $toAnimateElement.attr('data-caption-animate');
									setTimeout(function() {
										$toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
									}, toAnimateDelayTime);
								}
							});
						}
					});

					$('#slider-arrow-left').on('click', function(e){
						e.preventDefault();
						swiperSlider.swipePrev();
					});

					$('#slider-arrow-right').on('click', function(e){
						e.preventDefault();
						swiperSlider.swipeNext();
					});
				});
			</script>

			<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

		</section>

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
					<div class="row clearfix">

						<div class="col-lg-5">
							<div class="heading-block topmargin">
								<h1>Welcome to Tuguegarao City <br>Science Highschool.</h1>
							</div>
							<p class="lead">Tuguegarao City Science High School has a specialized system of public secondary schools in the Philippines It is operated and supervised by the Department of Education. <strong>with a curriculum heavily focusing on math and science</strong></p>
						</div>

						<div class="col-lg-7">

							<div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-lg="800" data-height-md="800" data-height-sm="800" data-height-xs="800" data-height-xxs="800">
								<img src="<?= $url ?>images/tcshsImages/tugScieLogo.png" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
								
							</div>

						</div>

					</div>
				</div>

				

				

				<div class="row clearfix common-height">

					<div class="col-md-6 center col-padding" style="background: url('<?= $url ?>images/tcshsImages/threeAwardee.jpg') center center no-repeat; background-size: cover;">
						<div>&nbsp;</div>
					</div>

					<div class="col-md-6 center col-padding" style="background-color: #F5F5F5;">
						<div>
							<div class="heading-block nobottomborder">
								<span class="before-heading color">Tuguegarao City Science Highschool</span>
								<h3>Science Towards Truth</h3>
							</div>

							<div class="center bottommargin">
								<a href="<?= $url ?>videos/tcshsVideo.mp4" data-lightbox="iframe" style="position: relative;">
									<img src="<?= $url ?>videos/tcshsPng.png" alt="Video">
									<span class="i-overlay nobg"><img src="<?= $url ?>images/icons/video-play.png" alt="Play"></span>
								</a>
							</div>
							<p class="lead nobottommargin">Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, voluptatem repellendus in beatae unde, officiis mollitia consectetur atque ipsum quis delectus fuga optio illo eveniet aspernatur itaque, ipsa obcaecati ipsam.</p>
						</div>
					</div>

				</div>

				<div class="row clearfix bottommargin-lg common-height">

					<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #515875;">
						<div>
							<i class="fas fa-user i-plain i-xlarge divcenter"></i>
							<div class="counter counter-lined"><span data-from="100" data-to="651" data-refresh-interval="50" data-speed="2000"></span>K</div>
							<h5>Students</h5>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #576F9E;">
						<div>
							<i class="fas fa-trophy i-plain i-xlarge divcenter"></i>
							<div class="counter counter-lined"><span data-from="3000" data-to="21500" data-refresh-interval="100" data-speed="2500"></span></div>
							<h5>Achievements</h5>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #6697B9;">
						<div>
							<i class="fas fa-award i-plain i-xlarge divcenter"></i>
							<div class="counter counter-lined"><span data-from="10" data-to="408" data-refresh-interval="25" data-speed="3500"></span></div>
							<h5>Certificates</h5>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #88C3D8;">
						<div>
							<i class="i-plain i-xlarge divcenter icon-line2-clock"></i>
							<div class="counter counter-lined"><span data-from="60" data-to="1400" data-refresh-interval="30" data-speed="2700"></span></div>
							<h5>Years of excellence</h5>
						</div>
					</div>

				</div>

				

				


				<script type="text/javascript">

					jQuery(window).load(function(){

						var $container = $('#portfolio');

						$container.isotope({
							transitionDuration: '0.65s',
							masonry: {
								columnWidth: $container.find('.portfolio-item:not(.wide)')[0]
							}
						});

						$('#page-menu a').click(function(){
							$('#page-menu li').removeClass('current');
							$(this).parent('li').addClass('current');
							var selector = $(this).attr('data-filter');
							$container.isotope({ filter: selector });
							return false;
						});

						$(window).resize(function() {
							$container.isotope('layout');
						});

					});

				</script>

				

				

				

				

				

				<div class="container clear-bottommargin clearfix">
					<div class="row">

						<div class="col-md-3 col-sm-6 bottommargin">
							<div class="ipost clearfix">
								<div class="entry-image">
									<a href="#"><img class="image_fade" src="<?= $url ?>images/magazine/thumb/1.jpg" alt="Image"></a>
								</div>
								<div class="entry-title">
									<h3><a href="blog-single.html">Bloomberg smart cities; change-makers economic security</a></h3>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> 13th Jun 2014</li>
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 53</a></li>
								</ul>
								<div class="entry-content">
									<p>Prevention effect, advocate dialogue rural development lifting people up community civil society. Catalyst, grantees leverage.</p>
								</div>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin">
							<div class="ipost clearfix">
								<div class="entry-image">
									<a href="#"><img class="image_fade" src="<?= $url ?>images/magazine/thumb/2.jpg" alt="Image"></a>
								</div>
								<div class="entry-title">
									<h3><a href="blog-single.html">Medicine new approaches communities, outcomes partnership</a></h3>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> 24th Feb 2014</li>
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 17</a></li>
								</ul>
								<div class="entry-content">
									<p>Cross-agency coordination clean water rural, promising development turmoil inclusive education transformative community.</p>
								</div>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin">
							<div class="ipost clearfix">
								<div class="entry-image">
									<a href="#"><img class="image_fade" src="<?= $url ?>images/magazine/thumb/3.jpg" alt="Image"></a>
								</div>
								<div class="entry-title">
									<h3><a href="blog-single.html">Significant altruism planned giving insurmountable challenges liberal</a></h3>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> 30th Dec 2014</li>
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
								</ul>
								<div class="entry-content">
									<p>Micro-finance; vaccines peaceful contribution citizens of change generosity. Measures design thinking accelerate progress medical initiative.</p>
								</div>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin">
							<div class="ipost clearfix">
								<div class="entry-image">
									<a href="#"><img class="image_fade" src="<?= $url ?>images/magazine/thumb/4.jpg" alt="Image"></a>
								</div>
								<div class="entry-title">
									<h3><a href="blog-single.html">Compassion conflict resolution, progressive; tackle</a></h3>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> 15th Jan 2014</li>
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 54</a></li>
								</ul>
								<div class="entry-content">
									<p>Community health workers best practices, effectiveness meaningful work The Elders fairness. Our ambitions local solutions globalization.</p>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="section">
					<div class="container clearfix">

						<div class="row topmargin-sm">

							<div class="heading-block center">
								<h3>Meet Our Team</h3>
							</div>

							<div class="col-md-3 col-sm-6 bottommargin">

								<div class="team">
									<div class="team-image">
										<img src="<?= $url ?>images/team/3.jpg" alt="John Doe">
									</div>
									<div class="team-desc team-desc-bg">
										<div class="team-title"><h4>John Doe</h4><span>CEO</span></div>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
											<i class="icon-facebook"></i>
											<i class="icon-facebook"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
											<i class="icon-twitter"></i>
											<i class="icon-twitter"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
											<i class="icon-gplus"></i>
											<i class="icon-gplus"></i>
										</a>
									</div>
								</div>

							</div>

							<div class="col-md-3 col-sm-6 bottommargin">

								<div class="team">
									<div class="team-image">
										<img src="<?= $url ?>images/team/2.jpg" alt="Josh Clark">
									</div>
									<div class="team-desc team-desc-bg">
										<div class="team-title"><h4>Josh Clark</h4><span>Co-Founder</span></div>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
											<i class="icon-facebook"></i>
											<i class="icon-facebook"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
											<i class="icon-twitter"></i>
											<i class="icon-twitter"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
											<i class="icon-gplus"></i>
											<i class="icon-gplus"></i>
										</a>
									</div>
								</div>

							</div>

							<div class="col-md-3 col-sm-6 bottommargin">

								<div class="team">
									<div class="team-image">
										<img src="<?= $url ?>images/team/8.jpg" alt="Mary Jane">
									</div>
									<div class="team-desc team-desc-bg">
										<div class="team-title"><h4>Mary Jane</h4><span>Sales</span></div>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
											<i class="icon-facebook"></i>
											<i class="icon-facebook"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
											<i class="icon-twitter"></i>
											<i class="icon-twitter"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
											<i class="icon-gplus"></i>
											<i class="icon-gplus"></i>
										</a>
									</div>
								</div>

							</div>

							<div class="col-md-3 col-sm-6 bottommargin">

								<div class="team">
									<div class="team-image">
										<img src="<?= $url ?>images/team/4.jpg" alt="Nix Maxwell">
									</div>
									<div class="team-desc team-desc-bg">
										<div class="team-title"><h4>Nix Maxwell</h4><span>Support</span></div>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
											<i class="icon-facebook"></i>
											<i class="icon-facebook"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
											<i class="icon-twitter"></i>
											<i class="icon-twitter"></i>
										</a>
										<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
											<i class="icon-gplus"></i>
											<i class="icon-gplus"></i>
										</a>
									</div>
								</div>

							</div>

						</div>

					</div>
				</div>

				<div class="container clearfix">

					<div id="oc-clients" class="owl-carousel image-carousel">

						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/1.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/2.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/3.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/4.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/5.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/6.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/7.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/8.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/9.png" alt="Clients"></a></div>
						<div class="oc-item"><a href="#"><img src="<?= $url ?>images/clients/10.png" alt="Clients"></a></div>

					</div>

					<script type="text/javascript">

						jQuery(document).ready(function($) {

							var ocClients = $("#oc-clients");

							ocClients.owlCarousel({
								margin: 60,
								loop: true,
								nav: false,
								autoplay: true,
								dots: false,
								autoplayHoverPause: true,
								responsive:{
									0:{ items:2 },
									480:{ items:3 },
									768:{ items:4 },
									992:{ items:5 },
									1200:{ items:6 }
								}
							});

						});

					</script>

				</div>

			</div>

		</section><!-- #content end -->

		