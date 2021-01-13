<?php $this->Main_model->academicYearSetter(); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
	============================================= -->
	<?php $url = base_url() . 'newDesign/' ?> 
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>style.css" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>css/dark.css" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?= $url ?>css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="<?= $url ?>css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="<?= $url ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?= $url ?>js/plugins.js"></script>

    <!-- Document Title
    ============================================= -->
    <title>TCSHS Login</title>

</head>

<body class="stretched">

    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
<!-- 
    
    -Joel John Centeno Made this website as a thesis during his 4th year college in information technology
    -------------------- HIHIIHI I LOVE YOU SO MUCH ELISA MENDOZA BACUD ----------------------
    ----------------------------   WILL YOU MARRY MEEE ---------------------------------------
    ------------------------------------------------------------------------------------------
    -------------------------------- FEBRUARY 29 2020 ----------------------------------------

-->

        <!-- Content
        ============================================= -->
        <section id="content">
		<?php $main_page = base_url() . 'homeController' ?>
            <div class="content-wrap nopadding">

			<div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('<?= $url ?>images/tcshsImages/loginBackground.jpg') center center no-repeat; background-size: cover;"></div>

                <div class="section nobg full-screen nopadding nomargin">
                    <div class="container vertical-middle divcenter clearfix">

                        <div class="row center">
                            <a href="<?= $main_page ?>"><img src="<?= $url ?>images/tcshsLogo.png" height="150px;" alt="TCSHS Logo"></a>
                        </div>

                        <div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
							<div class="panel-body" style="padding: 40px;">
							<?php 

								if (isset($_SESSION['account_deactivated'])) {
									echo "<p class='alert alert-warning p-2 m-3'>Account Deactivated</p>";
									unset($_SESSION['account_deactivated']);
								}

								if (isset($_SESSION['pass_wrong'])) {
									echo "<p class='alert alert-danger p-2 m-3'>Wrong Username or Password</p>";
									unset($_SESSION['pass_wrong']);
								}


								validation_errors("<p class='alert alert-danger'>");
							?>
							<?php $post_submit = base_url() . 'login' ?>
                                <form id="login-form" name="login-form" class="nobottommargin" action="<?= $post_submit ?>" method="post">
                                    <h3>Login to your Account</h3>

                                    <div class="col_full">
                                        <label for="login-form-username">Username:</label>
                                        <input autocomplete='off' autofocus="on" type="text" id="login-form-username" name="username" placeholder='Username' class="form-control not-dark" />
                                    </div>

                                    <div class="col_full">
                                        <label for="login-form-password">Password:</label>
                                        <input autocomplete='off' type="password" id="login-form-password" name="password" placeholder='password'  class="form-control not-dark" />
                                    </div>
                                    <?php $brandNewStart = base_url() . "login/brandNewStart" ?>
                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <?php 
                                            if ($this->Main_model->checkIfThereIsNoPrincipal()) { ?>
                                                <a href="<?= $brandNewStart ?>"><button class="button button-3d button-green margin " type="button">Brand new start</button></a>
                                           <?php } ?>
                                        
                                    </div>
                                </form>

                                <div class="line line-sm"></div>

                                
                            </div>
                        </div>

                        <div class="row center dark"><small>Copyrights &copy; All Rights Reserved by Joel John Centeno</small></div>

                    </div>
                </div>

            </div>

        </section><!-- #content end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- Footer Scripts
    ============================================= -->
    <script type="text/javascript" src="<?= $url ?>js/functions.js"></script>

</body>
</html>