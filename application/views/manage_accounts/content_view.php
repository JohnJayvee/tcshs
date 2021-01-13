<?php 
		
		$result = $this->Main_model->get_where('post','post_id', $post_id);

    		

		foreach ($result->result_array() as $row) {
			$result_id = $row['post_id'];
			$post_title = $row['post_title'];
			$post_status = $row['post_status'];
			$post_tags = $row['post_tags'];
			$post_image = $row['post_image'];
			$post_content = $row['post_content'];
			$faculty_id = $row['faculty_id'];
			$post_date = $row['post_date'];
		}

        

		$uploader = $this->Main_model->get_where('faculty','account_id', $faculty_id);

		foreach ($uploader->result_array() as $row) {
			$account_id = $row['account_id'];
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
		}

		$fullname = $firstname . ' ' . $middlename . ' ' . $lastname;
		$back = base_url() . 'manage_user_accounts/approve_content';
        $activate = base_url() . 'manage_user_accounts/post_activate/' . $result_id;
        $deactivate = base_url() . 'manage_user_accounts/post_deactivate/' . $result_id;
 ?>


    <body>
        <?php $img = base_url() . 'cms_uploads/' . $post_image; ?>
        <div class="c_details_img" align="center">
        	<div class="jumbotron">
        		<img class="img-fluid" src="<?= $img ?>" alt="" height="300" width="720">
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
                            <a href="<?= $activate ?>">
                            <button class="genric-btn info radius col-md-12">
                                Activate
                            </button>
                        </a>&nbsp;<br>
                        <a href="<?= $deactivate ?>">
                            <button class="genric-btn primary radius col-md-12">
                                Deactive
                            </button>
                        </a>&nbsp;<br>
                        <?php $remove = base_url() . 'manage_user_accounts/remove/' . $result_id . '/' . 0?>
                        <a href="<?= $remove ?>">
                            <button class="genric-btn danger radius col-md-12">
                                Remove
                            </button>
                        </a>&nbsp;<br>
                        <a href="<?= $back ?>">
                            <button class="genric-btn success radius col-md-12">
                                Back
                            </button>
                        </a>&nbsp;<br>
                        </table>
        			</div>
        		</div>
        	</div>
        	
        <!--================End About Area =================-->
        
      