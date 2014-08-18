<?php

class Users extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('user');
    }

    /**
     * Displays the add user form...
     */
    public function add() {
        $this->load->library('session');
        $this->load->model('user');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Add a user';
        $this->load->view('header');

        $this->form_validation->set_rules('username', 'Username', 'required|callback_usernameCheck');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('users/add');
        }
        else
        {
           $this->user->addUser($this->input->post('username'), $this->input->post('password'));
           $this->load->view('users/user_added');
        }
        $this->load->view('footer');
    }

    public function usernameCheck($username) {
        if ($this->user->isUsernameTaken($username)) {
            $this->form_validation->set_message('usernameCheck', 'Username already taken!');
            return FALSE;
        }
        return TRUE;
    }

}

?>
