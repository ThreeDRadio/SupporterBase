<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('session');
    }


	public function index()
	{
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->user->isLoggedIn()) {
            redirect('welcome');
        }
        else {
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('users/login');
            }
            else
            {
                if ($this->user->login($this->input->post('username'), $this->input->post('password'))) {
                    redirect('welcome');
                }
                else {
                    $this->form_validation->set_message('usernameCheck', 'Username or password incorrect!');
                    $this->load->view('users/login');
                }
            }
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

