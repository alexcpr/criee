<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page compte
 * -> modifier mot de passe
 * -> historique des enchères
 */
class Account extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produits');
		$this->load->model('compte');
	}

	/**
	 * Affiche la "page d'accueil" permettant de choisir ce que l'utilisateur souhaite faire
	 * @return void
	 */
	public function index()
	{
		// si l'utilisateur n'est pas connecté, bloquer sa requête en le redirigeant
		if (empty($this->session->user_id)) {
			redirect('/', 'location', 301);
		}

		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('account/index');
		$this->load->view('includes/footer');
	}

	/**
	 * Page historique des enchères auxquelles l'utilisateur a participé
	 * @return void
	 */
	public function history()
	{
		// si l'utilisateur n'est pas connecté, bloquer sa requête en le redirigeant
		if (empty($this->session->user_id)) {
			redirect('/', 'location', 301);
		}

		// récupérer les infos des enchères auxquelles l'utilisateur à participé
		$data['produits'] = $this->produits->getProduitsDe($this->session->user_id);

		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('account/history', $data);
		$this->load->view('includes/footer');
	}

	/**
	 * Page pour que l'utilisateur modifie son mot de passe
	 * @return void
	 */
	public function general()
	{
		// si l'utilisateur n'est pas connecté, bloquer sa requête en le redirigeant
		if (empty($this->session->user_id)) {
			redirect('/', 'location', 301);
		}

		// si l'utilisateur à soumis le formulaire
		if (isset($_POST['changePassword'])) {
			// vérification du captcha
			$recaptcha = new \ReCaptcha\ReCaptcha($this->config->item('recaptcha_secret_key'));
			$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
				->verify($this->input->post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
			// si le captcha est valide
			if ($resp->isSuccess()) {
				// appel du modèle pour traiter le changement de mot de passe avec transmission des données du formulaire
				$this->compte->changerMdp($this->session->user_id, $this->input->post('currentPassword'), $this->input->post('newPassword'), $this->input->post('confirmNewPassword'));
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
		$this->load->view('account/general');
		$this->load->view('includes/footer');
	}

}