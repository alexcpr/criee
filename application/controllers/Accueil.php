<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page d'accueil du site (index)
 */
class Accueil extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Affiche la page d'accueil
	 * @return void
	 */
	public function index()
	{
		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('accueil');
		$this->load->view('includes/footer');
	}

}