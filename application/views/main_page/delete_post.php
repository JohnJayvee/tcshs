


    <body>
        <?php $img = base_url() . 'cms_uploads/' . $post_image; ?>
        <div class="c_details_img">
        	<div class="jumbotron">
        		<img class="img-fluid" src="<?= $img ?>" alt="">
        	</div>
		</div>


        	<div class="container col-md-12">
        		<div class="row col-md-12">
        	       <section class="col-lg-8">
                        <div class="main_title">
                            <h2><?= $post_title ?></h2>
                            <strong><?= $fullname ?></strong><br>
                            <strong><?= $post_date ?></strong>
                        </div>

                        
                            <p align="justify"><?= $post_content ?></p>
                        
        	       </section>
        			<div class="container col-lg-4">
        				<table class="table-responsive">
                            <?php $delete = base_url() . 'main_controller/delete_post/' .  $post_id . '/1'  ?>
                        <a href="<?= $delete ?>">
                            <button class="genric-btn danger radius col-md-12">
                                Delete
                            </button>
                        </a>&nbsp;<br>
                        <?php $back = base_url() . 'main_controller/manage_content' ?>
                        <a href="<?= $back ?>">
                            <button class="genric-btn primary radius col-md-12">
                                Back
                            </button>
                        </a>

                        </table>
        			</div>
        		</div>
        	</div>
        	
        <!--================End About Area =================-->
        
      