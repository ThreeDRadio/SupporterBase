<?php

class Import extends CI_Controller {

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


	public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data = array();
		$this->load->view('header');
		$this->load->view('import_form', $data);
		$this->load->view('footer');
	}


}
