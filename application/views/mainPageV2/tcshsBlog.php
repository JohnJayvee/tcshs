<?php $url = base_url() . 'newDesign/' ?>

<body class="stretched">

    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">

      

        <!-- Page Title
        ============================================= -->
        <section id="page-title">

            <div class="container clearfix">
                <h1>TCSHS NEWS</h1>
                <ol class="breadcrumb">
                    <?php $home = base_url() . 'homeController' ?>
                    <li><a href="<?= $home ?>">Home</a></li>
                    <li class="active">TCSHS NEWS</li>
                </ol>
            </div>

        </section><!-- #page-title end -->

        <!-- Content
        ============================================= -->
        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">
                    <?php $image = base_url() . 'cms_uploads/' . $post_image ?>
                    <div class="single-post nobottommargin">

                        <!-- Entry Image
                        ============================================= -->
                        <div class="entry-image bottommargin">
                            <a href="#"><img src="<?= $image ?>" alt="Blog Single"></a>
                        </div><!-- .entry-image end -->

                        <!-- Post Content
                        ============================================= -->
                        <div class="postcontent nobottommargin clearfix">

                            <!-- Single Post
                            ============================================= -->
                            <div class="entry clearfix">

                                <!-- Entry Title
                                ============================================= -->
                                <div class="entry-title">
                                    <h2><?= $post_title; ?></h2>
                                </div><!-- .entry-title end -->
                            <?php $this->load->model('Main_model'); ?>
                                <!-- Entry Meta
                                ============================================= -->
                                <ul class="entry-meta clearfix">
                                    <li><i class="icon-calendar3"></i> <?= $post_date ?></li>
                                    <li><a href="#"><i class="icon-user"></i><?= $this->Main_model->getFullname('faculty', 'account_id', $faculty_id); ?></a></li>
                                    <li><i class="icon-folder-open"></i> <a href="#"></a><?= $postTagName; ?></li>
                                    <li><a href="#"><i class="icon-comments"></i> 43 Comments</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul><!-- .entry-meta end -->

                                <!-- Entry Content
                                ============================================= -->
                                <div class="entry-content notopmargin">

                                    <p align='justify'><?= $post_content; ?></p>
                                    <!-- Post Single - Content End -->

                                    <!-- Tag Cloud
                                    ============================================= -->
                                    <div class="tagcloud clearfix bottommargin">
                                    <?php
                                    foreach ($categoriesTable as $row) {
                                        $categoryId = $row['id'];
                                        $tagName = $row['tag_name'];?>
                                    
                                    <a href="#"><?= $tagName ?></a>

                                    <?php } ?>
                                    </div><!-- .tagcloud end -->

                                    <div class="clear"></div>

                                    <!-- Post Single - Share
                                    ============================================= -->
                                    <div class="si-share noborder clearfix">
                                        <span>Share this Post:</span>
                                        <div>
                                            <a href="#" class="social-icon si-borderless si-facebook">
                                                <i class="icon-facebook"></i>
                                                <i class="icon-facebook"></i>
                                            </a>
                                            <a href="#" class="social-icon si-borderless si-twitter">
                                                <i class="icon-twitter"></i>
                                                <i class="icon-twitter"></i>
                                            </a>
                                            <a href="#" class="social-icon si-borderless si-pinterest">
                                                <i class="icon-pinterest"></i>
                                                <i class="icon-pinterest"></i>
                                            </a>
                                            <a href="#" class="social-icon si-borderless si-gplus">
                                                <i class="icon-gplus"></i>
                                                <i class="icon-gplus"></i>
                                            </a>
                                            <a href="#" class="social-icon si-borderless si-rss">
                                                <i class="icon-rss"></i>
                                                <i class="icon-rss"></i>
                                            </a>
                                            <a href="#" class="social-icon si-borderless si-email3">
                                                <i class="icon-email3"></i>
                                                <i class="icon-email3"></i>
                                            </a>
                                        </div>
                                    </div><!-- Post Single - Share End -->

                                </div>
                            </div><!-- .entry end -->

                            <!-- Post Navigation
                            ============================================= -->
                            

                            

                            

                            

                            <h4>Related Posts:</h4>

                            <div class="related-posts clearfix">

                                <div class="col_half nobottommargin">
                                <?php 
                                    foreach ($firstRow as $row) {
                                        $catPostId = $row['post_id'];
                                        $catPostTitle = $row['post_title'];
                                        $catPostStatus = $row['post_status'];
                                        if ($catPostStatus == 0) {
                                            continue;
                                        }
                                        $catPostTags = $row['post_tags'];
                                        $catPostImage = $row['post_image'];
                                        $catPostContnet = $row['post_content'];
                                        $catFacultyId = $row['faculty_id'];
                                        $catPostDate = $row['post_date'];?>
                                        
                                    <div class="mpost clearfix">
                                        <div class="entry-image">
                                        <?php $picture = base_url() . 'cms_uploads/' . $catPostImage ?>
                                            <a href="#"><img src="<?= $picture ?>" alt="News Picture"></a>
                                        </div>
                                        <div class="entry-c">
                                            <div class="entry-title">
                                                <h4><a href="#"><?= $catPostTitle ?></a></h4>
                                            </div>
                                            <ul class="entry-meta clearfix">
                                                <li><i class="icon-calendar3"></i> <?= $catPostDate ?></li>
                                                <li><a href="#"><i class="icon-comments"></i> 12</a></li>
                                            </ul>
                                            <div class="entry-content">learn more</div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="col_half nobottommargin col_last">
                                <?php 
                                    foreach ($secondRow as $row) {
                                        $catPostId = $row['post_id'];
                                        $catPostTitle = $row['post_title'];
                                        $catPostStatus = $row['post_status'];
                                        if ($catPostStatus == 0) {
                                            continue;
                                        }
                                        $catPostTags = $row['post_tags'];
                                        $catPostImage = $row['post_image'];
                                        $catPostContnet = $row['post_content'];
                                        $catFacultyId = $row['faculty_id'];
                                        $catPostDate = $row['post_date'];?>
                                    <div class="mpost clearfix">
                                        <div class="entry-image">
                                        <?php $picture = base_url() . 'cms_uploads/' . $catPostImage ?>
                                            <a href="#"><img src="<?= $picture ?>" alt="News Picture"></a>
                                        </div>
                                        <div class="entry-c">
                                            <div class="entry-title">
                                                <h4><a href="#"><?= $catPostTitle ?></a></h4>
                                            </div>
                                            <ul class="entry-meta clearfix">
                                                <li><i class="icon-calendar3"></i> <?= $catPostDate ?></li>
                                                <li><a href="#"><i class="icon-comments"></i> 12</a></li>
                                            </ul>
                                            <div class="entry-content">learn more</div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>

                            <!-- Comments
                            ============================================= -->
                            <div id="comments" class="clearfix">

                                <h3 id="comments-title"><span>3</span> Comments</h3>

                                <!-- Comments List
                                ============================================= -->
                                <ol class="commentlist clearfix">

                                    <li class="comment even thread-even depth-1" id="li-comment-1">

                                        <div id="comment-1" class="comment-wrap clearfix">

                                            <div class="comment-meta">

                                                <div class="comment-author vcard">

                                                    <span class="comment-avatar clearfix">
                                                    <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' class='avatar avatar-60 photo avatar-default' height='60' width='60' /></span>

                                                </div>

                                            </div>

                                            <div class="comment-content clearfix">

                                                <div class="comment-author">John Doe<span><a href="#" title="Permalink to this comment">April 24, 2012 at 10:46 am</a></span></div>

                                                <p>Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>

                                                <a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

                                            </div>

                                            <div class="clear"></div>

                                        </div>


                                        <ul class='children'>

                                            <li class="comment byuser comment-author-_smcl_admin odd alt depth-2" id="li-comment-3">

                                                <div id="comment-3" class="comment-wrap clearfix">

                                                    <div class="comment-meta">

                                                        <div class="comment-author vcard">

                                                            <span class="comment-avatar clearfix">
                                                            <img alt='' src='http://1.gravatar.com/avatar/30110f1f3a4238c619bcceb10f4c4484?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G' class='avatar avatar-40 photo' height='40' width='40' /></span>

                                                        </div>

                                                    </div>

                                                    <div class="comment-content clearfix">

                                                        <div class="comment-author"><a href='#' rel='external nofollow' class='url'>SemiColon</a><span><a href="#" title="Permalink to this comment">April 25, 2012 at 1:03 am</a></span></div>

                                                        <p>Nullam id dolor id nibh ultricies vehicula ut id elit.</p>

                                                        <a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

                                                    </div>

                                                    <div class="clear"></div>

                                                </div>

                                            </li>

                                        </ul>

                                    </li>

                                    <li class="comment byuser comment-author-_smcl_admin even thread-odd thread-alt depth-1" id="li-comment-2">

                                        <div id="comment-2" class="comment-wrap clearfix">

                                            <div class="comment-meta">

                                                <div class="comment-author vcard">

                                                    <span class="comment-avatar clearfix">
                                                    <img alt='' src='http://1.gravatar.com/avatar/30110f1f3a4238c619bcceb10f4c4484?s=60&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D60&amp;r=G' class='avatar avatar-60 photo' height='60' width='60' /></span>

                                                </div>

                                            </div>

                                            <div class="comment-content clearfix">

                                                <div class="comment-author"><a href='http://themeforest.net/user/semicolonweb' rel='external nofollow' class='url'>SemiColon</a><span><a href="#" title="Permalink to this comment">April 25, 2012 at 1:03 am</a></span></div>

                                                <p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>

                                                <a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

                                            </div>

                                            <div class="clear"></div>

                                        </div>

                                    </li>

                                </ol><!-- .commentlist end -->

                                <div class="clear"></div>

                                <!-- Comment Form
                                ============================================= -->
                                <div id="respond" class="clearfix">

                                    <h3>Leave a <span>Comment</span></h3>

                                    <form class="clearfix" action="#" method="post" id="commentform">

                                        <div class="col_one_third">
                                            <label for="author">Name</label>
                                            <input type="text" name="author" id="author" value="" size="22" tabindex="1" class="sm-form-control" />
                                        </div>

                                        <div class="col_one_third">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" id="email" value="" size="22" tabindex="2" class="sm-form-control" />
                                        </div>

                                        <div class="col_one_third col_last">
                                            <label for="url">Website</label>
                                            <input type="text" name="url" id="url" value="" size="22" tabindex="3" class="sm-form-control" />
                                        </div>

                                        <div class="clear"></div>

                                        <div class="col_full">
                                            <label for="comment">Comment</label>
                                            <textarea name="comment" cols="58" rows="7" tabindex="4" class="sm-form-control"></textarea>
                                        </div>

                                        <div class="col_full nobottommargin">
                                            <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">Submit Comment</button>
                                        </div>

                                    </form>

                                </div><!-- #respond end -->

                            </div><!-- #comments end -->

                        </div><!-- .postcontent end -->

                        <!-- Sidebar
                        ============================================= -->
                        <div class="sidebar nobottommargin col_last clearfix">
                        <div class="sidebar-widgets-wrap">

                            

                            <div class="widget clearfix">
                                <form action="" method="post">
                                    <div class="form-group col-md-10">
                                        <input type="text" class="form-control" placeholder="Search Title">
                                    </div>
                                    <button class="col-md-2 btn btn-primary"><i class="fas fa-search"></i></button>
                                </form>
                            </div>

                            <div class="widget clearfix">

                                <div class="tabs nobottommargin clearfix" id="sidebar-tabs">

                                    <ul class="tab-nav clearfix">
                                        <li><a href="#tabs-2">Recent</a></li>
                                        <li><a href="#tabs-3"><i class="icon-comments-alt norightmargin"></i></a></li>
                                    </ul>

                                    <div class="tab-container">

                                        <div class="tab-content clearfix" id="tabs-1">
                                            <div id="popular-post-list-sidebar">
                                                <?php 
                                                    foreach ($recentsTable->result_array() as $row) {
                                                        $recentsPostId = $row['post_id'];
                                                        $recentsPostImage = $row['post_image'];
                                                        $recentsPostTitle = $row['post_title'];?>
                                                    
                                                
                                                <div class="spost clearfix">
                                                    <div class="entry-image">
                                                        <?php $image = base_url() . 'cms_uploads/' . $recentsPostImage ?>
                                                        <a href="#" class="nobg"><img class="img-circle" src="<?= $image ?>" alt="Post Image"></a>
                                                    </div>
                                                    <div class="entry-c">
                                                        <div class="entry-title">
                                                            <h4><a href="#"><?= $recentsPostTitle ?></a></h4>
                                                        </div>
                                                        <ul class="entry-meta">
                                                            <li><i class="icon-comments-alt"></i> 35 Comments</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div> <!--recents -->
                                        
                                        <div class="tab-content clearfix" id="tabs-3">
                                            <div id="recent-post-list-sidebar">

                                                <div class="spost clearfix">
                                                    <div class="entry-image">
                                                        <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                                    </div>
                                                    <div class="entry-c">
                                                        <strong>John Doe:</strong> Veritatis recusandae sunt repellat distinctio...
                                                    </div>
                                                </div>

                                                <div class="spost clearfix">
                                                    <div class="entry-image">
                                                        <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                                    </div>
                                                    <div class="entry-c">
                                                        <strong>Mary Jane:</strong> Possimus libero, earum officia architecto maiores....
                                                    </div>
                                                </div>

                                                <div class="spost clearfix">
                                                    <div class="entry-image">
                                                        <a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
                                                    </div>
                                                    <div class="entry-c">
                                                        <strong>Site Admin:</strong> Deleniti magni labore laboriosam odio...
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            

                            <div class="widget clearfix">

                                <h4>Categories</h4>
                                <div class="tagcloud">
                                <?php
                                    foreach ($categoriesTable as $row) {
                                        $categoryId = $row['id'];
                                        $tagName = $row['tag_name'];?>
                                    
                                    <a href="#"><?= $tagName ?></a>

                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div><!-- .sidebar end -->

                    </div>

                </div>

            </div>

        </section><!-- #content end -->

       