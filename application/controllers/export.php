<?php

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('user');
        $this->load->helper('url');
        $this->load->model('supporter');

        if ( ! $this->user->isLoggedIn()) {
            redirect('login');
        }

    }



    public function current_members() {

        $members = $this->supporter->getCurrentMembers();
        $data = array(
            'members' => $members
        );
        $this->output->set_content_type('text/csv');
        $this->output->set_header('Content-disposition: filename="members.csv"');
        $this->load->view('csv', $data);
    }

    public function expired_members() {

        $members = $this->supporter->getExpiredMembers();
        $data = array(
            'members' => $members
        );
        $this->output->set_content_type('text/csv');
        $this->output->set_header('Content-disposition: filename="members.csv"');
        $this->load->view('csv', $data);
    }
}

