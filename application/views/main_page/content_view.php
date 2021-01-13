<?php 
		



		$this->load->model('Main_model');
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
		$back = base_url() . 'main_controller/manage_content';
        $edit = base_url() . 'manage_user_account';
        
 ?>


    <body>
        <?php $img = base_url() . 'cms_uploads/' . $post_image; ?>
        <div class="c_details_img" align="center">
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
                            
                        <a href="<?= $edit ?>">
                            <button class="genric-btn primary radius col-md-12">
                                Edit
                            </button>
                        </a>&nbsp;<br>
                        <a href="">
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
        
      