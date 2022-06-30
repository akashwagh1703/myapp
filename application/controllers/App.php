<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
        if (!$this->session->userdata['user_logged'] == TRUE)
        {
            redirect('auth/login'); //if session is not there, redirect to login page
        }
    }

    public function index()
	{
        $con['conditions'] = array(
            'users_id' => $this->session->userdata('id'),
            'status' => 1
        );
        $data['document'] = $this->user->getRows($con, 'document');
        $this->load->view('header');
        $this->load->view('index', $data);
        $this->load->view('footer');
	}

    public function upload_document()
	{
        echo'upload_document';
	}

    public function delete($id)
	{
        $this->user->delete($id, 'document');
        redirect(base_url());
	}
}

?>