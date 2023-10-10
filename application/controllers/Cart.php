<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page panier
 * -> consulter les enchères gagnées
 * -> se désister d'une ou de plusieurs enchères gagnées
 * -> passer à la caisse
 */
class Cart extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('panier');
	}

	/**
	 * Affiche la page panier 
	 * @return void
	 */
	public function index()
	{
		// si l'utilisateur n'est pas connecté, bloquer sa requête en le redirigeant
		if (empty($this->session->user_id)) {
			redirect('/', 'location', 301);
		}

		// si l'utilisateur souhaite se désister
		if (isset($_POST['desister'])) {
			// 
		}
		// récupérer le nombre de lots dans le panier de l'utilisateur et le transmettre à l'en-tête
		$header['panier'] = $this->panier->getCountPanier($this->session->user_id);
		// si le panier est pas vide, récupérer les infos des enchères que l'utilisateur a gagnées
		$data['lignesPanier'] = $header['panier']['countPanier'] == '0' ? null : $this->panier->getContenuPanier($this->session->user_id);
		$this->load->view('includes/header', $header);
		$this->load->view('cart', $data);
		$this->load->view('includes/footer');
	}

}