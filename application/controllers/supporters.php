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
            $matches = $this->supporter->findSupporterByLastName(urldecode($partialName));
            foreach ($matches as &$match) {
                $time = time();
                if ($match['expiration_date'] < $time) {
                    $match['status'] = 'Expired!';
                }
                else {
                    $match['status'] = 'Expires on ' . strftime('%d/%m/%y', $match['expiration_date']);
                }
            }
            $data = array(
                'matches' => $matches
            );
        }
        else {
            $data = array(
                'matches' =>  array()
            );
        }
        $this->load->view('ajax/matching_supporters', $data);
    }

    public function find() {
        $this->load->view('header');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('supporters/find');
        $this->load->view('footer');
    }

    public function giveEveryone2012() {
        $date = strtotime("August 31 2012");
        $members = $this->supporter->getSupporters();
        foreach ($members as $member) {
            $this->supporter->addTransaction($this->session->userdata('user_id'), $member['supporter_id'], $date, 'member');
        }
    }

    public function renew($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('expiration_year', 'Expiration Year', 'required|integer|exact_length[4]');
        $this->form_validation->set_rules('expiration_day', 'Expiration Day', 'required|integer');
        $this->form_validation->set_rules('expiration_month', 'Expiration Month', 'required|integer');
        $this->form_validation->set_rules('payment_processed', 'Payment Processed', 'integer');

        $match = $this->supporter->getSupporter($id);
	$match = $match[0];
        if (empty($match['expiration_date'])) {
            $year = strftime("%Y");

	    $newExpiryYear = strftime("%Y") +1;
	    $expirationMonth = strftime("%m");
	    $expirationDay = strftime("%d");
        }
	else {
		$newExpiryYear = strftime("%Y", $match['expiration_date']) +1;
		$expirationMonth = strftime("%m", $match['expiration_date']);
		$expirationDay = strftime("%d", $match['expiration_date']);
	}



        $data = array(
            'supporter_info' => $match,
            'new_expiration_year' => $newExpiryYear,
            'new_expiration_month' => $expirationMonth,
            'new_expiration_day' => $expirationDay,
            'note' => $this->input->post('note'),
	    'payment_processed' => $this->input->post('payment_processed')
        );

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header');
            $this->load->view('supporters/renew', $data);
            $this->load->view('footer');
        }
        else {
            $date = strtotime($this->input->post('expiration_year') . "-" .
                              $this->input->post('expiration_month') . "-" .
                              $this->input->post('expiration_day'));

            $this->supporter->addTransaction($this->session->userdata('user_id'), $id, $date, $this->input->post('type'), $this->input->post('note'), $this->input->post('payment_processed'));
            $this->load->view('header');
            $this->load->view('supporters/supporter_renewed', $data);
            $this->load->view('footer');
        }

    }


    public function browse($kind, $status="") {

        if ($kind == "subscribers" && $status == "current") {
            $supporters = $this->supporter->getCurrentSubscribers();
        }
        else if ($kind == "subscribers" && $status == "expired") {
            $supporters = $this->supporter->getExpiredSubscribers();
        }
        else if ($kind == "members" && $status == "current") {
            $supporters = $this->supporter->getCurrentMembers();
        }
        else if ($kind == "members" && $status == "expired") {
            $supporters = $this->supporter->getExpiredMembers();
        }
        else if ($kind == "mystery") {
            $supporters = $this->supporter->getMysterySupporters();
        }

        $data = array(
            'supporters' => $supporters
        );
        $this->load->view('header');
        $this->load->view('supporters/browse', $data);
        $this->load->view('footer');
    }

    public function add_note($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('header');

        $this->form_validation->set_rules('note', 'note', 'required');
        if ($this->form_validation->run() === FALSE) {
            redirect('supporters/edit/'. $id);
        }
        else {
            $data = array(
                'time' => time(),
                'user_id' => $this->session->userdata('user_id'),
                'note' => $this->input->post('note'),
                'supporter_id' => $id
            );
            $this->supporter->addNote($data);
            redirect('supporters/edit/'. $id);
        }

    } 

    public function add() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('header');
        $this->load->helper('url');

        $this->form_validation->set_rules('first', 'First Name', 'alpha_dash');
        $this->form_validation->set_rules('last', 'Last Name', 'required');

        $this->form_validation->set_rules('address1', 'Address Line 1', 'required');

        $this->form_validation->set_rules('town', 'Town/Suburb', 'required');
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
                'phone_mobile' => $this->input->post('phone'),
                'email' => $this->input->post('email')
            );

            $id = $this->supporter->addSupporter($data);

            $page_data = array(
                'supporter_id' => $id,
                'first_name' => $this->input->post('first'),
                'last_name' => $this->input->post('last'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'town' => $this->input->post('town'),
                'state' => $this->input->post('state'),
                'postcode' => $this->input->post('postcode'),
                'country' => $this->input->post('country'),
                'phone_mobile' => $this->input->post('phone'),
                'email' => $this->input->post('email')
            );
            $this->load->view('supporters/supporter_added', $page_data);
        }
        $this->load->view('footer');
    }

    public function edit($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('header');
        $this->load->helper('url');

        $this->form_validation->set_rules('first', 'First Name', 'alpha_dash');
        $this->form_validation->set_rules('last', 'Last Name', 'required');

        $this->form_validation->set_rules('address1', 'Address Line 1', 'required');

        $this->form_validation->set_rules('town', 'Town/Suburb', 'required');
        $this->form_validation->set_rules('state', 'State', 'required|alpha|min_length[2]|max_length[3]');
        $this->form_validation->set_rules('postcode', 'Postcode', 'required|integer|exact_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        $match = $this->supporter->getSupporter($id);
	$match = $match[0];
        $data = array(
            'supporter_id' => $id,
            'supporter_info' => $match,
            'notes' => $this->supporter->getSupporterNotes($id),
            'subscriptions' => $this->supporter->getSubscriptions($id)
        );


        if ($this->form_validation->run() === FALSE) {
            $this->load->view('supporters/edit', $data);
        }
        else {
            $data = array(
                'first_name' => $this->input->post('first'),
                'supporter_id' => $id,
                'last_name' => $this->input->post('last'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'town' => $this->input->post('town'),
                'state' => $this->input->post('state'),
                'postcode' => $this->input->post('postcode'),
                'country' => $this->input->post('country'),
                'phone_mobile' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'excluded' => $this->input->post('excluded'),
            );

            $this->supporter->updateSupporter($id, $data);


            $this->load->view('supporters/supporter_updated', $data);
        }
        $this->load->view('footer');
    }
}

