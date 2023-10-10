<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page produits
 */
class Products extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produits');
	}

	/**
	 * Affiche tout les produits (lots)
	 * @return void
	 */
	public function index()
	{

		// récupère tout les lots
		$data['produits'] = $this->produits->getProduits();

		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('products', $data);
		$this->load->view('includes/footer');
	}

}