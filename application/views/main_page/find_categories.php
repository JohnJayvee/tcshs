

<body>
<div class="mask-l" style="background-color: #fff; width: 100%; height: 100%; position: fixed; top: 0; left:0; z-index: 9999999;"></div> <!--removed by integration-->
<header>
  <div class="container b-header__box b-relative">
    <div class="b-header-r b-right b-header-r--icon">
      <div class="b-top-nav-show-slide f-top-nav-show-slide b-right j-top-nav-show-slide"><i class="fa fa-align-justify"></i></div>
      <nav class="b-top-nav f-top-nav b-right j-top-nav">
          <ul class="b-top-nav__1level_wrap">
            <?php $home = base_url() . 'main_controller/index' ?>
    <li class="b-top-nav__1level f-top-nav__1level is-active-top-nav__1level f-primary-b"><a href="<?= $home ?>"><i class="fa fa-home b-menu-1level-ico"></i>Home <span class="b-ico-dropdown"><i class="fa fa-arrow-circle-down"></i></span></a>
    </li>
    <?php $login = base_url() . 'main_controller/login' ?>
    <li class="b-top-nav__1level f-top-nav__1level f-primary-b">
        <a href="<?= $login ?>">Login</a>
    </li>
     <li class="b-top-nav__1level f-top-nav__1level f-primary-b">
        <a href="shop_listing_col.html">About</a>
    </li>
     <li class="b-top-nav__1level f-top-nav__1level f-primary-b">
        <a href="shop_listing_col.html">Contact Us</a>
    </li>
    
   
</ul>

      </nav>
    </div>
  </div>
</header>
<div class="j-menu-container"></div>

<div class="b-inner-page-header f-inner-page-header b-bg-header-inner-page">
  <div class="b-inner-page-header__content">
    <div class="container">
      <h1 class="f-primary-l c-default">Tuguegarao City Sciene High School</h1>
    </div>
  </div>
</div>
<div class="l-main-container">

    <div class="b-breadcrumbs f-breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li><i class="fa fa-angle-right"></i><a href="#">Blog</a></li>
                <li><i class="fa fa-angle-right"></i><span>Listing Left Sidebar</span></li>
            </ul>
        </div>
    </div>

    <div class="l-inner-page-container">
        <div class="container">
            <div class="row">
            <div class="col-md-9 col-md-push-3">
                    <div class="b-blog-listing__block">

                           <?php  

                foreach ($category_table->result_array() as $row) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_status = $row['post_status'];
                    $post_tags = $row['post_tags'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_faculty_id = $row['faculty_id'];
                    $post_date = $row['post_date'];


                    $this->load->model('Main_model');
                    $table = $this->Main_model->get_where('faculty','account_id', $post_faculty_id);

                if ($post_status == 1) {
                    
                
                    foreach ($table->result_array() as $row) {
                        $firstname = $row['firstname'];
                        $middlename = $row['middlename'];
                        $lastname = $row['lastname'];
                    }


                    $uploader = "$firstname $middlename $lastname";

                    $tags = $this->Main_model->get_where('post_tags','id', $post_tags);

                    foreach ($tags->result_array() as $row) {
                       $category = $row['tag_name'];
                    }


                    ?>

                        <div class="b-blog-listing__block-top">
                            <div class=" view view-sixth">
        <?php $picture = base_url() . 'cms_uploads/' . $post_image; ?>
    <img data-retina="" src="<?= $picture ?>" alt="posts">
</div>
                        </div> <!-- insert here -->
            
                        <div class="b-infoblock-with-icon b-blog-listing__infoblock">
                            
                            <div class="b-infoblock-with-icon__info f-infoblock-with-icon__info">
                                <h4 class="f-primary-l c-default">
                                    <?= $post_title ?>
                                </h4>
                                <div class="f-infoblock-with-icon__info_text b-infoblock-with-icon__info_text f-primary-b b-blog-listing__pretitle">
                                    By: &nbsp; <?= $uploader ?><a href="" class="f-more"></a> In <a href="" class="f-more"><?= $category ?></a> Posted <?= $post_date ?>
                                    
                                </div>
                                <div class="f-infoblock-with-icon__info_text b-infoblock-with-icon__info_text c-primary b-blog-listing__text">
                                   <?= $post_content ?>
                                </div>
                                <div class="f-infoblock-with-icon__info_text b-infoblock-with-icon__info_text">
                                    <a href="blog_detail_left_slidebar.html" class="f-more f-primary-b">Read more</a>
                                </div>
                            </div>
                        </div> <!-- end here -->
                        <?php 


                    }else{
                        redirect('main_controller/categories_empty');
                    }
                } ?>

                    </div>
                    
                    
                    <div class="b-pagination f-pagination">
    <ul>
        <li><a href="#">First</a></li>
        <li><a class="prev" href="#"><i class="fa fa-angle-left"></i></a></li>
        <li class="is-active-pagination"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a class="next" href="#"><i class="fa fa-angle-right"></i></a></li>
        <li><a href="#">Last</a></li>
    </ul>
</div>
                </div>


                
             

                
                <div class="visible-xs-block visible-sm-block b-hr"></div>
                <div class="col-md-3 col-md-pull-9">
                    
<div class="row b-col-default-indent">
    <div class="col-md-12">
        <div class="b-categories-filter">
            <h4 class="f-primary-b b-h4-special f-h4-special--gray f-h4-special"> Categories</h4>
            <ul>

        <?php 
        foreach ($tags_table->result_array() as $row) {
            $tag_name = $row['tag_name'];
            $id = $row['id'];
            $categories = base_url() . 'main_controller/categories/' . $id;
            ?>
            
            <li>
                <a class="f-categories-filter_name" href="<?= $categories ?>"><i class="fa fa-plus"></i> <?= $tag_name ?></a>
            </li>
 
        <?php } ?>

   
    
   
   
</ul>
        </div>
    </div>
   
    <div class="col-md-12">
        <h4 class="f-primary-b b-h4-special f-h4-special--gray f-h4-special">tags cloud</h4>
        <div>
    <a class="f-tag b-tag" href="#">Dress</a>
    <a class="f-tag b-tag" href="#">Mini</a>
    <a class="f-tag b-tag" href="#">Skate animal</a>
    <a class="f-tag b-tag" href="#">Lorem ipsum</a>
    <a class="f-tag b-tag" href="#">literature</a>
    <a class="f-tag b-tag" href="#">Baroque</a>
    <a class="f-tag b-tag" href="#">Dress</a>
    <a class="f-tag b-tag" href="#">Mini</a>
    <a class="f-tag b-tag" href="#">Skate animal</a>
    <a class="f-tag b-tag" href="#">Lorem ipsum</a>
    <a class="f-tag b-tag" href="#">literature</a>
    <a class="f-tag b-tag" href="#">Baroque</a>
</div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>



</div>

