<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page admin
 * -> consulter les lots
 * -> modifier un lot
 * -> supprimer un lot
 * -> ajouter un lot
 */
class VmkOcB8uM3vitpE2MIojw8PZr08BfvKU extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin');
		$this->load->model('produits');
	}

	/**
	 * Page d'accueil du panel admin
	 * @return void
	 */
	public function index()
	{
		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		// si l'utilisateur n'est pas connecté en tant qu'admin on affiche le formulaire de connexion
		if (!isset($_SESSION['admin'])) {
			// l'utilisateur soumet le formulaire de connexion admin
			if (isset($_POST['login'])) {
				// vérification du captcha
				$recaptcha = new \ReCaptcha\ReCaptcha($this->config->item('recaptcha_secret_key'));
				$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
					->verify($this->input->post('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
				// si le captcha est valide
				if ($resp->isSuccess()) {
					// appel du modèle pour traiter la tentative de connexion admin avec transmission des données du formulaire
					$this->admin->connexion($this->input->post('password'));
				}
			}
			$this->load->view('/admin/login');
		} else {
			// si l'utilisateur est connecté en tant qu'admin, on lui affiche la page d'accueil
			$this->load->view('/admin/index');
		}
		$this->load->view('includes/footer');
	}

	/**
	 * Page de consultation des lots
	 * @param mixed $action
	 * @return void
	 */
	public function products($action = null)
	{
		// s'il n'est pas connecté en tant qu'admin on le redirige sur le formulaire de connexion
		if (!isset($_SESSION['admin'])) {
			redirect(base_url('VmkOcB8uM3vitpE2MIojw8PZr08BfvKU'), 'location', 301);
		} else {

			// s'il souhaite ajouter un lot
			if ($action == 'add') {

				// si l'admin soumet le formulaire d'ajout de lot
				if (isset($_POST['addLot'])) {
					// appel du modèle pour traiter la tentative d'ajout du lot avec transmission des données du formulaire
					$this->admin->ajouterLot($this->input->post('idDatePeche'), $this->input->post('idBateau'), $this->input->post('id'), $this->input->post('espece'), $this->input->post('taille'), $this->input->post('presentation'), $this->input->post('qualite'), $this->input->post('bac'), $this->input->post('poids'), $this->input->post('dateDebut'), $this->input->post('dateFin'), $this->input->post('prixPlancher'), $this->input->post('prixDepart'));
				}

				// récupération des différentes options via la bdd
				$optionsIdDatePeche = $this->admin->getOptionsIdDatePeche();
				$optionsIdBateau = $this->admin->getOptionsIdBateau();
				$optionsEspece = $this->admin->getOptionsEspece();
				$optionsTaille = $this->admin->getOptionsTaille();
				$optionsPresentation = $this->admin->getOptionsPresentation();
				$optionsQualite = $this->admin->getOptionsQualite();
				$optionsBac = $this->admin->getOptionsBac();

				$data['optionsIdDatePeche'] = $optionsIdDatePeche;
				$data['optionsIdBateau'] = $optionsIdBateau;
				$data['optionsEspece'] = $optionsEspece;
				$data['optionsTaille'] = $optionsTaille;
				$data['optionsPresentation'] = $optionsPresentation;
				$data['optionsQualite'] = $optionsQualite;
				$data['optionsBac'] = $optionsBac;

				// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
				$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
				$this->load->view('includes/header', $header);
				$this->load->view('/admin/add', $data);
				$this->load->view('includes/footer');
			} else {
				// si l'admin souhaite supprimer un lot
				if (isset($_POST['supprimerLot'])) {
					// appel du modèle pour traiter la tentative de suppresion du lot avec transmission des données du formulaire
					$this->produits->supprimerProduit($this->input->post('id'), $this->input->post('idBateau'), $this->input->post('idDatePeche'));
				}
				$data['produits'] = $this->produits->getProduits();
				// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
				$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
				$this->load->view('includes/header', $header);
				$this->load->view('/admin/products', $data);
				$this->load->view('includes/footer');
			}

		}
	}

}