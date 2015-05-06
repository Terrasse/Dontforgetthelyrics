<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connection extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Mes vues FIXES
		$this->load->library('layout');
		
		// Chargement du modele login
		$this->load->model('connection_class');
		
		//	Chargement de la bibliothèque
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if($this->session->userdata('connected'))
			redirect();
		else
			$this->layout->view('connection/connection');
	}
	
	public function login()
	{
		$this->form_validation->set_rules('username', '"Aka"', 'trim|required|min_length[5]|max_length[52]|alpha_dash|encode_php_tags|xss_clean');
		$this->form_validation->set_rules('password',    '"Password"',       'trim|required|min_length[5]|max_length[52]|alpha_dash|encode_php_tags|xss_clean');
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if($this->form_validation->run())
		{
			//	Le formulaire est valide
			$result = $this->connection_class->connection($username,$password);
			
			if(empty($result))
			{
				$this->session->set_flashdata('unconnected', 'Username and password don\'t match');
				redirect('/connection');
			}
			else
			{
			   $this->session->set_userdata('id_player', $result[0]->id_player);
			   $this->session->set_userdata('connected', true);
			   redirect();
			}
		}
		else
		{
			//	Le formulaire est invalide ou vide
			$this->layout->view('connection/connection');
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
}

?>