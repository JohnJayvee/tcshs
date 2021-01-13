<?php

class Main_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        // $this->Main_model->accessGranted();
    }

    function hashdis()
    {
        echo $this->Main_model->passwordEncryptor('potpot');
    }




    function sandbox()
    {
        $textMe = base_url() . "main_controller/sandbox?textMe=1";
        if (isset($_GET['textMe'])) {
            $this->Main_model->itexmo('09657943410','tae kana please');
        }


        //notifications
        $this->Main_model->alertPromt('All passwords turned into potpot', 'potpotPassword');

        $url = base_url() . "main_controller/sandbox?dod=1";
        $password = base_url() . "main_controller/sandbox?password=1";
        $potpotPassword = "7m16xm!_442a8,f-17f07c372ce3e737569198d73e4999fa733e440c1ab6d3da68bf8479de9cba11e7689319197947e5b4008d6a032f0bea82c81d6dd4f5fac4b21dd6832a939cb6e4sg6e_1kjf/";

        if (isset($_GET['dod'])) {
            $this->Main_model->turnicateTable('adviser_section', 'adviser_id');
            $this->Main_model->turnicateTable('attendance', 'attendance_id');
            $this->Main_model->turnicateTable('call_parent', 'call_parent_id');
            $this->Main_model->turnicateTable('adviser_section', 'adviser_id');
            $this->Main_model->turnicateTable('class', 'class_id');
            $this->Main_model->turnicateTable('class_section', 'class_section_id');
            $this->Main_model->turnicateTable('credentials', 'credentials_id');
            $this->Main_model->turnicateTable('excuse_attendance', 'excuse_attendance_id');
            $this->Main_model->turnicateTable('faculty', 'account_id');
            $this->Main_model->turnicateTable('parent', 'account_id');
            $this->Main_model->turnicateTable('parent_attendance', 'parent_attendance_id');
            $this->Main_model->turnicateTable('sh_student', 'account_id');
            $this->Main_model->turnicateTable('student_grades', 'student_grades_id');
            $this->Main_model->turnicateTable('student_profile', 'account_id');
            $this->Main_model->turnicateTable('student_section_reassignment', 'ssr_id');
            $this->Main_model->turnicateTable('teacher_load', 'teacher_load_id');
            $this->Main_model->turnicateTable('post', 'post_id');

            session_destroy();
            $this->session->set_userdata('dod', 1);
            
            redirect("main_controller/sandbox");
        }

        if (isset($_GET['password'])) {
            $this->Main_model-> makePasswordsPotpot($potpotPassword);
            $this->session->set_userdata('potpotPassword', 1);
            redirect('main_controller/sandbox');
        }
        $this->Main_model->alertPromt('accounts have been deleted', 'dod');
        echo "<a href='" . $textMe . "'><button type='button'>Text me</button></a>";
        echo "<a href='" . $url . "'><button type='button'>Remove all accounts</button></a>";        
        echo "<a href='" . $password . "'><button type='button'>Make all passwords potpot</button></a>";

        echo "<pre style='font-size:20px;font-weight:bold;'>";
        print_r($this->session->userdata);
        echo "</pre>";
        
    }



    function cms_add()
    {

        $data['tags'] = $this->Main_model->just_get_everything('post_tags');
        $data['error'] = ' ';

        $this->load->view('includes/main_page/admin_cms/header.php');
        $this->load->view('main_page/cms_add', $data);
        $this->load->view('includes/main_page/admin_cms/footer.php');
       
    }

    function do_upload()
    {
        $permission = $this->Main_model->access_granted();

        if ($permission == 1) {

            $config['upload_path']          = './cms_uploads/';
            $config['allowed_types']        = 'gif|jpg|png|JPEG';
            $this->load->library('upload', $config);
            $this->upload->do_upload('userfile');
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name'];


            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['file_name']             = $file_name;
            $config['overwrite']            = True;
            $config['remove_spaces']          = True;




            $data['post_title'] = $this->input->post('post_title');
            $data['post_tags'] = $this->input->post('post_tags');
            $data['post_image'] = $file_name;
            $data['post_content'] = $this->input->post('post_content');
            $data['faculty_id'] = $this->session->userdata('faculty_account_id');
            $data['post_date'] = $this->input->post('post_date');

            if ($_SESSION['credentials_id'] == 4) {
                $data['post_status'] = 1;
            } else {
                $data['post_status'] = 0;
            }





            $this->Main_model->_insert('post', $data);

            $notif_table_content = $this->Main_model->get_where('sbar_notif', 'notif_id', 1);

            foreach ($notif_table_content->result_array() as $row) {
                $notif_id = $row['notif_id'];
                $approve_content = $row['approve_content'];
                $no_new_items = $row['no_new_items'];
                // use this to add to the current number
            }

            $update['no_new_items'] = $no_new_items + 1;
            if ($_SESSION['credentials_id'] != 4) {
                $this->Main_model->_update('sbar_notif', 'notif_id', '1', $update);
            }

            redirect('main_controller/cms_upload_success');





            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('includes/main_page/admin_cms/header.php');
                $this->load->view('main_page/cms_add', $error);
                $this->load->view('includes/main_page/admin_cms/footer.php');
            }

        } else {
            redirect('main_controller/login');
        }
    }

    function fileAsynchronous()
    {
        //for asynchronous file upload
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $destination ="./temp_upload/" . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                echo $file['name'];

                //temp manager recorder
                $facultyAccountId = $_SESSION['faculty_account_id'];
                $insert['faculty_account_id'] = $facultyAccountId;
                $insert['file_name'] = $file['name'];

                $this->Main_model->_insert('temp_upload_manager', $insert);                
            }
            
        }
    }

    function jhsEditContent()
    {
        //to use directory map
        $this->load->helper('directory');

        $postId = $this->uri->segment(3);
        $postTable = $this->Main_model->get_where('post', 'post_id', $postId);
        $oldImageName = $this->Main_model->getImageName($postId);

        $data['error'] = ' ';
        $data['tags'] = $this->Main_model->just_get_everything('post_tags');
        $data['postId'] = $postId;
        $data['postTable'] = $postTable->result_array();

        $this->form_validation->set_rules('post_title','Title','required');
        $this->form_validation->set_rules('post_tags','Tags','required');
        $this->form_validation->set_rules('post_content','Content','required');
        $this->form_validation->set_rules('post_date','Date','required');
        if ($this->form_validation->run()) {
            $post_title = $this->input->post('post_title');
            $post_tags = $this->input->post('post_tags');
            $post_content = $this->input->post('post_content');
            $post_date = $this->input->post('post_date');
        
            //get the file information
            $config['upload_path']          = './cms_uploads/';
            $config['allowed_types']        = 'gif|jpg|png|JPEG';
            $this->load->library('upload', $config);
            $this->upload->do_upload('userfile');
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name'];
            $client_name = $upload_data['client_name'];


            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['file_name']             = $file_name;
            $config['overwrite']            = True;
            $config['remove_spaces']          = True;

           
           
           //if failed upload
           if (!$this->upload->do_upload('userfile')) {
                $data['error'] = $this->upload->display_errors();
            }           
            
            if ($file_name == "") {
                //ibigsabihin nito hindi siya nag palit ng picture
                $file_name = $oldImageName;
            }else{
                //nag palit siya ng picture. 
                // remove image duplications. 
                $cmsDir = directory_map("./cms_uploads/");
                $needle = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
               
                if (in_array($needle, $cmsDir)) {
                    unlink("./cms_uploads/$needle");
                }

                //remove the old image in the DIR
                unlink("./cms_uploads/$oldImageName");
            }

            
            //update the post table
            $update['post_title'] = $post_title;
            $update['post_tags'] = $post_tags;
            $update['post_content'] = $post_content;
            //kapag pareho yung file name na galing sa input wag kang mag uupdate kasi wala siyang i uupdate
            if ($oldImageName != $file_name) {
                //pareho sila eh kaya dapat hindi ka mag update
                $update['post_image'] = $file_name;
            }
            $update['post_date'] = $post_date;
            
            $this->Main_model->_update('post', 'post_id', $postId, $update);

            $this->session->set_userdata('contentUpdated', 1);
            redirect("main_controller/manage_content");
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $this->load->view('includes/main_page/admin_cms/header.php');
        $this->load->view('main_page/editContentJhs', $data);
        $this->load->view('includes/main_page/admin_cms/footer.php');
    }

    function cms_upload_success()
    {
        $permission = $this->Main_model->access_granted();

        if ($permission == 1) {

            $this->load->view('includes/main_page/admin_cms/header.php');
            $this->load->view('manage_accounts/cms_upload_success');
            $this->load->view('includes/main_page/admin_cms/footer.php');
        } else {

            redirect('main_controller/login');
        }
    }

    function manage_content()
    {
    
        $account_id = $_SESSION['faculty_account_id'];

        $data['facultyName'] = $this->Main_model->getFullNameWithId('faculty', 'account_id', $account_id);
        $data['my_post'] = $this->Main_model->get_where('post', 'faculty_id', $account_id);

        $this->load->view('includes/main_page/admin_cms/header.php');
        $this->load->view('main_page/manage_content', $data);
        $this->load->view('includes/main_page/admin_cms/footer.php');
       
    }

    function content_view()
    {
        $permission = $this->Main_model->access_granted();

        if ($permission == 1) {
            $data['post_id'] = $this->uri->segment(3);

            $this->load->view('includes/main_page/admin_cms/header.php');
            $this->load->view('includes/old_css/header');
            $this->load->view('main_page/content_view', $data);

            $this->load->view('includes/main_page/admin_cms/footer.php');
        } else {
            redirect('main_controller/login');
        }
    }

    function delete_post()
    {
        $post_id = $this->uri->segment(3);
        $classifier = $this->uri->segment(4);

        if ($classifier == 0) {

            $post_table = $this->Main_model->get_where('post', 'post_id', $post_id);

            foreach ($post_table->result_array() as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $faculty_id = $row['faculty_id'];
                $post_date = $row['post_date'];
            }


            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);

            foreach ($faculty_table->result_array() as $row) {
                $account_id = $row['account_id'];
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];
            }
            $fullname = "$firstname $middlename $lastname";

            $data['post_id'] = $post_id;
            $data['post_title'] = $post_title;
            $data['post_status'] = $post_status;
            $data['post_tags'] = $post_tags;
            $data['post_image'] = $post_image;
            $data['post_content'] = $post_content;
            $data['fullname'] = $fullname;
            $data['post_date'] = $post_date;


            $this->load->view('includes/main_page/admin_cms/header.php');
            $this->load->view('includes/old_css/header');
            $this->load->view('main_page/delete_post', $data);
            $this->load->view('includes/main_page/admin_cms/footer.php');
        } elseif ($classifier == 1) {

            $post_table = $this->Main_model->get_where('post', 'post_id', $post_id);

            foreach ($post_table->result_array() as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $faculty_id = $row['faculty_id'];
                $post_date = $row['post_date'];
            }

            // syntax for deleting a picture in the folder. 

            // unlink("name_of_folder", $NameOfPicture);

            $this->Main_model->_delete('post', 'post_id', $post_id);
            unlink('cms_uploads/' . $post_image);

            redirect('main_controller/manage_content');
        }
    }
}
  

  // end ng class
