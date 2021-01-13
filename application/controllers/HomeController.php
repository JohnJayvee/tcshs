<?php

class HomeController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    function index()
 	{
         
        $data['categories'] = $this->Main_model->just_get_everything('post_tags');
        
        $data['posts'] = $this->Main_model->get_where('post','post_status', 1);


 		$this->load->view('mainPageV2/includes/header');
        $this->load->view('mainPageV2/frontPage',$data);
        $this->load->view('mainPageV2/includes/footer');
 		


 	}

    public function categories()
    {
        $category_id = $this->uri->segment(3);
        

        $this->load->model('Main_model');

        $array['post_tags'] = $category_id;
        $array['post_status'] = '1';

        $data['category_table'] = $this->Main_model->multiple_where('post', $array);
        
       
        $data['tags_table'] = $this->Main_model->get('post_tags','id');
       
        $number_of_rows = $data['category_table']->num_rows();

        
        
        if ($number_of_rows > 0) {
           $this->load->view('includes/main_page/header');
           $this->load->view('main_page/find_categories', $data);
           $this->load->view('includes/main_page/footer'); 
        }else{
            redirect('main_controller/categories_empty');
        }
    }

    function categories_empty()
    {
        $this->load->model('Main_model');
        $data['tags_table'] = $this->Main_model->get('post_tags','id');
        $this->load->view('includes/main_page/header');
        $this->load->view('main_page/categories_empty',$data);
        $this->load->view('includes/main_page/footer'); 
    }

    function noContentAvailable()
    {
        $this->load->view('mainPageV2/includes/header');
        $this->load->view('mainPageV2/includes/navbar');
        $this->load->view('mainPageV2/noContentAvailable');

    }

    function schoolNews()
    {
        $postTableSingle = $this->Main_model->get_random_page('post', 'post_id');

        //kapag wala pang laman dapat merong error message na mag papakita muna
        if (count($postTableSingle->result_array()) == 0) {
            redirect('homeController/nocontentavailable');
        }

        foreach ($postTableSingle->result_array() as $row) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_status = $row['post_status'];
            if ($post_status == 0) {
                continue;
            }
            $post_tags = $row['post_tags'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $faculty_id = $row['faculty_id'];
            $post_date = $row['post_date'];
        }
        $postTable = $this->Main_model->get_where('post_tags','id', $post_tags);
        foreach ($postTable->result_array() as $row) {
            $post_tag_name = $row['tag_name'];
        }
        $data['postTagName'] = $post_tag_name;
        

        $data['post_id'] = $post_id;
        $data['post_title'] = $post_title;
        
        $data['post_tags'] = $post_tags;
        $data['post_image'] = $post_image;
        $data['post_content'] = $post_content;
        $data['faculty_id'] = $faculty_id;
        $data['post_date'] = $post_date;

        $categoriesTable = $this->Main_model->get('post_tags','id');
        $data['categoriesTable'] = $categoriesTable->result_array();

        $relatedPost = $this->Main_model->get_where_limit('post' ,4, 'post_tags', $post_tags);
        // $data['relatedPostPartTwo'] = $this->Main_model->get_where_limit('post' ,2, 'post_tags', $post_tags);
        
        
        $newArray1 = [];
        $newArray2 = [];
        $arrayCount = 0;
        foreach ($relatedPost->result_array() as $row) {
            if($arrayCount%2 == 0){
                array_push($newArray1, $row);
            }else{
                array_push($newArray2,$row);
            }
            $arrayCount++;
        }
        $data['firstRow'] = $newArray1;
        $data['secondRow'] = $newArray2;

        $data['recentsTable'] = $this->Main_model->orderByDescLimit('post', 'post_id', 5); 

        $this->load->view('mainPageV2/includes/header');
        $this->load->view('mainPageV2/includes/navbar');
        $this->load->view('mainPageV2/tcshsBlog', $data);
        $this->load->view('mainPageV2/includes/footer');
    }
} //class 
