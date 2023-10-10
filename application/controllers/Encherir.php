<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page enchérir
 * -> dernier enchérisseur
 * -> enchère actuelle
 * -> compte à rebours jusqu'à la fin de l'enchère
 * -> enchérir
 * -> enchère synchrone
 */
class Encherir extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('encheres');
		$this->load->model('panier');
	}

	/**
	 * Affiche le formulaire pour enchérir
	 * @return void
	 */
	public function index()
	{

		// si l'utilisateur n'est pas connecté, on l'informe qu'il doit l'être pour pouvoir enchérir et on le redirige
		if (empty($this->session->user_id)) {
			$this->session->set_flashdata('message', '
			<div class="error-msg">
				<i class="fa-solid fa-x"></i> Pour enchérir, vous devez être connecté.
				<br>
				Veuillez vous connecter <a class="msg-link-error" href="' . base_url('/login') . '">ici</a>.
          	</div>');
			redirect(base_url('products'), 'location', 301);
		}

		// on vérifie que l'enchère est en cours, sinon on le redirige
		if (!$this->encheres->checkEnchere($this->input->post('id'), $this->input->post('idBateau'), $this->input->post('idDatePeche'))) {
			redirect(base_url('products'), 'location', 301);
		}

		// on récupère les données sur l'enchère
		$data['enchere'] = $this->encheres->getActualEnchere($this->input->post('id'), $this->input->post('idBateau'), $this->input->post('idDatePeche'));

		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('encherir', $data);
		$this->load->view('includes/footer');
	}

}