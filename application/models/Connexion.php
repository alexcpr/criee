<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle connexion
 */
class Connexion extends CI_Model
{

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Europe/Paris');
    }

    /**
     * Permet à l'utilisateur de se connecter
     * @param mixed $email
     * @param mixed $mdp
     * @return void
     */
    public function connexion($email, $mdp)
    {
        // on récupère le mot de passe, nom, prenom et email de l'utilisateur
        $search = 'SELECT id, pwd, nom, prenom FROM acheteur WHERE login = :login';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':login', $email, PDO::PARAM_STR);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);

        // si le mot de passe est bon
        if (password_verify($mdp, $result['pwd'])) {
            // on lui met en session son id, nom, prenom et email
            $this->session->user_id = $result['id'];
            $this->session->user_nom = $result['nom'];
            $this->session->user_prenom = $result['prenom'];
            $this->session->user_email = $email;

            $this->session->set_flashdata('message', '<div class="success-msg">
              <i class="fa-solid fa-check"></i> Succès!
              <br>
              Vous avez été connecté avec succès.
            </div>');
            redirect(base_url('products'), 'location', 301);
        } else {
            $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            E-mail ou mot de passe incorrect.
            <br>
            Veuillez réessayer.
          </div>');
        }

    }

}