<?php 
class Export extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		$this->Main_model->accessGranted();
	}
	public function index()
	{
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_csv/main_page');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	public function excel()
	{

	}

	public function csv($value='')
	{

	}

	public function text($value='')
	{

	}
	
}