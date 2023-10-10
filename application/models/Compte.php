<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle compte
 */
class Compte extends CI_Model
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
     * Permet à l'utilisateur de modifier son mot de passe
     * @param mixed $user_id
     * @param mixed $mdpActuel
     * @param mixed $nvMdp
     * @param mixed $confirmNvMdp
     * @return void
     */
    public function changerMdp($user_id, $mdpActuel, $nvMdp, $confirmNvMdp)
    {
        // on récupère le mot de passe actuelle
        $search = 'SELECT pwd FROM acheteur WHERE id = :id';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $user_id, PDO::PARAM_INT);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);
        // si le mot de passe actuelle correspond au mot de passe actuelle saisie
        if (password_verify($mdpActuel, $result['pwd'])) {
            // et que le nouveau mot de passe et la confirmation du nouveau mot de passe correspondent
            if ($nvMdp == $confirmNvMdp) {
                // on hache le nouveau mot de passe
                $hashNvMdp = password_hash($nvMdp, PASSWORD_DEFAULT);
                // et on met à jour le mot de passe dans la base de données
                $search = "UPDATE acheteur SET pwd = :pwd WHERE id = :id";
                $result = $this->db->conn_id->prepare($search);
                $result->bindParam(':id', $user_id, PDO::PARAM_INT);
                $result->bindParam(':pwd', $hashNvMdp, PDO::PARAM_STR);
                if ($result->execute()) {
                    // si la requête à réussi
                    $this->session->set_flashdata('message', '<div class="success-msg">
                        <i class="fa-solid fa-check"></i> Succès!
                        <br>
                        Mot de passe modifié avec succès.
                    </div>');
                    redirect(base_url('account'), 'location', 301);
                } else {
                    // si la requête à échoué
                    $this->session->set_flashdata('message', '<div class="error-msg">
                        <i class="fa-solid fa-x"></i> Erreur!
                        <br>
                        Une erreur inattendue s\'est produite.
                        <br>
                        Veuillez réessayer.
                    </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="error-msg">
                    <i class="fa-solid fa-x"></i> Erreur!
                    <br>
                    Les nouveaux mots de passe saisis ne correspondent pas.
                    <br>
                    Veuillez réessayer.
                </div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="error-msg">
                <i class="fa-solid fa-x"></i> Erreur!
                <br>
                Mot de passe actuel incorrect.
                <br>
                Veuillez réessayer.
            </div>');
        }
    }

}