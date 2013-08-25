<?php

class Supporters extends CI_Controller {

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


    public function ajaxFindSupporterByLastName($partialName = "") {
        if (!empty($partialName)) {
            $matches = $this->supporter->findSupporterByLastName($partialName);
            $data = array(
                'matches' => $matches
            );
        }
        else {
            $data = array(
                'matches' =>  array()
            );
        }
        $this->load->view('ajax/matching_supporters.php', $data);
    }

    public function find() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('supporters/add');
    }

    public function add() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first', 'First Name', 'required|alpha_dash');
        $this->form_validation->set_rules('last', 'Last Name', 'required|alpha_dash');

        $this->form_validation->set_rules('address1', 'Address Line 1', 'required');

        $this->form_validation->set_rules('town', 'Town/Suburb', 'required|alpha');
        $this->form_validation->set_rules('state', 'State', 'required|alpha|min_length[2]|max_length[3]');
        $this->form_validation->set_rules('postcode', 'Postcode', 'required|integer|exact_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('supporters/add');
        }
        else {
            $data = array(
                'first_name' => $this->input->post('first'),
                'last_name' => $this->input->post('last'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'town' => $this->input->post('town'),
                'state' => $this->input->post('state'),
                'postcode' => $this->input->post('postcode'),
                'country' => $this->input->post('country'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email')
            );

            $this->supporter->addSupporter($data);
            $this->load->view('supporters/supporter_added');
        }
    }
}

