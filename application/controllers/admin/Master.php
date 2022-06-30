<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
        if (!$this->session->userdata['master_logged'] == TRUE)
        {
            redirect('auth/login'); //if session is not there, redirect to login page
        }
    }

    public function index()
	{
        $con['conditions'] = array(
            'role' => 2,
            'status' => 1
        );

        $data['users'] = $this->user->getRows($con);

        // echo'<pre>';print_r($data);exit;

        $this->load->view('header');
        $this->load->view('admin/index', $data);
        $this->load->view('footer');
	}

    public function getUserById()
	{
        echo'upload_document';
	}

    public function delete($id)
	{
        $this->user->delete($id, 'users');
        redirect(base_url().'admin/master');
	}
}

?>