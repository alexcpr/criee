<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle inscription
 */
class Inscription extends CI_Model
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
     * Permet à l'utilisateur de s'inscrire
     * @param mixed $nom
     * @param mixed $prenom
     * @param mixed $email
     * @param mixed $mdp
     * @param mixed $mdp2
     * @param mixed $numRue
     * @param mixed $voie
     * @param mixed $cp
     * @param mixed $ville
     * @return void
     */
    public function nouvelUtilisateur($nom, $prenom, $email, $mdp, $mdp2, $numRue, $voie, $cp, $ville)
    {
        // on vérifie que toutes les données sont définies
        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp) && !empty($mdp2) && !empty($numRue) && !empty($voie) && !empty($cp) && !empty($ville)) {
            // on vérifie que l'email est valide
            if (preg_match("/(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}/", $email)) {
                // on vérifie que le numéro de rue et le code postale sont bien composées de chiffres
                if (is_numeric($numRue) && is_numeric($cp)) {
                    // on vérifie que le mot de passe et le mot de passe de confirmation correspondent
                    if ($mdp == $mdp2) {
                        $search = 'SELECT COUNT(id) as "verifEmail" FROM acheteur WHERE login = :email';
                        $result = $this->db->conn_id->prepare($search);
                        $result->bindParam(':email', $email, PDO::PARAM_STR);
                        $result->execute();
                        $result = $result->fetch(PDO::FETCH_ASSOC);
                        // on vérifie que l'email n'est pas déjà utilisé
                        if ($result['verifEmail'] == 0) {
                            $search = 'SELECT COUNT(id) as "verifCompte" FROM users WHERE nom = :nom AND prenom = :prenom';
                            $result = $this->db->conn_id->prepare($search);
                            $result->bindParam(':nom', $nom, PDO::PARAM_STR);
                            $result->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                            $result->execute();
                            $result = $result->fetch(PDO::FETCH_ASSOC);
                            // on vérifie que le nom et prénom ne sont pas déjà utilisé
                            if ($result['verifCompte'] == 0) {
                                $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
                                $search = "INSERT INTO acheteur(nom, prenom, login, pwd, numRue, voie, cp, ville) VALUES(:nom, :prenom, :login, :pwd, :numRue, :voie, :cp, :ville)";
                                $result = $this->db->conn_id->prepare($search);
                                $result->bindParam(':nom', $nom, PDO::PARAM_STR);
                                $result->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                                $result->bindParam(':login', $email, PDO::PARAM_STR);
                                $result->bindParam(':pwd', $mdp_hash, PDO::PARAM_STR);
                                $result->bindParam(':numRue', $numRue, PDO::PARAM_INT);
                                $result->bindParam(':voie', $voie, PDO::PARAM_STR);
                                $result->bindParam(':cp', $cp, PDO::PARAM_STR);
                                $result->bindParam(':ville', $ville, PDO::PARAM_STR);
                                if ($result->execute()) {
                                    // l'inscription à réussi
                                    $this->session->set_flashdata('message', '<div class="success-msg">
                                    <i class="fa-solid fa-check"></i> Succès!
                                    <br>
                                    Vous avez été enregistré avec succès.
                                  </div>');
                                } else {
                                    // la requête à echoué
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
            Un compte sous ce nom existe déjà.
          </div>');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            Cette adresse e-mail est déjà utilisée.
          </div>');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            Les mots de passe ne correspondent pas.
          </div>');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            Veuillez saisir un numéro de rue et/ou un code postal valide.
          </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            Veuillez saisir une adresse e-mail valide.
          </div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="error-msg">
            <i class="fa-solid fa-x"></i> Erreur!
            <br>
            Veuillez remplir tous les champs.
          </div>');
        }
    }
}