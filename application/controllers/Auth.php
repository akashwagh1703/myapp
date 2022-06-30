<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
    }

    public function login()
	{
        if ($this->session->userdata['user_logged'] == TRUE)
        {
            redirect(base_url());
        }
        else if ($this->session->userdata['master_logged'] == TRUE)
        {
            redirect('admin/master');
        }
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
	}

    public function register()
	{
        echo'Login';
	}

    public function logout()
	{
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

?>