<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page de déconnexion
 */
class Logout extends CI_Controller
{

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Déconnecte et supprime toutes les données de session + redirige l'utilisateur vers la page de connexion
	 * @return never
	 */
	public function index()
	{

		// suppression des données de session
		unset($_SESSION['user_id']);
		unset($_SESSION['user_nom']);
		unset($_SESSION['user_prenom']);
		unset($_SESSION['user_email']);
		unset($_SESSION['admin']);

		// message
		$this->session->set_flashdata('message', '
		<div class="info-msg">
			<i class="fa-solid fa-circle-info"></i> Vous avez été déconnecté avec succès.
		</div>');
		// redirection
		redirect(base_url('login'), 'location', 301);

		// fin du script
		exit;
	}
}