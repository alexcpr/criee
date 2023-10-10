<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page de connexion
 */
class Login extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('connexion');
	}

	/**
	 * Affiche le formulaire de connexion
	 * @return void
	 */
	public function index()
	{
		// si l'utilisateur est déjà connecté, on le redirige
		if (!empty($this->session->user_id)) {
			redirect('/', 'location', 301);
		}

		// si l'utilisateur soumet le formulaire de connexion
		if (isset($_POST['login'])) {
			// vérification du captcha
			$recaptcha = new \ReCaptcha\ReCaptcha($this->config->item('recaptcha_secret_key'));
			$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
				->verify($this->input->post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
			// si le captcha est valide
			if ($resp->isSuccess()) {
				// appel du modèle pour traiter la tentative de connexion avec transmission des données du formulaire
				$this->connexion->connexion($this->input->post('email'), $this->input->post('password'));
			} else {
				$this->session->set_flashdata('message', '
				<div class="warning-msg">
					<i class="fa-solid fa-triangle-exclamation"></i> Captcha incorrect.
			  	</div>');
			}
		}

		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('login');
		$this->load->view('includes/footer');
	}

}