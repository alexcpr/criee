<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle admin
 */
class Admin extends CI_Model
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
     * Traitement de la connexion admin
     * @param mixed $mdp
     * @return void
     */
    public function connexion($mdp)
    {
        // on récupère le mdp admin haché
        $search = 'SELECT pbq3kv7aDaR6sBdEC2Xm5plI1nwSg347 FROM acheteur WHERE id = :id';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);
        // si le mot de passe est correcte
        if (password_verify($mdp, $result['pbq3kv7aDaR6sBdEC2Xm5plI1nwSg347'])) {
            // on stocke dans la session qu'il est connecté en tant qu'admin
            $this->session->admin = true;
            $this->session->set_flashdata('message', '<div class="success-msg">
              <i class="fa-solid fa-check"></i> Succès!
              <br>
              Vous avez été connecté avec succès.
            </div>');
            redirect(base_url('VmkOcB8uM3vitpE2MIojw8PZr08BfvKU'), 'location', 301);
        }
    }

    /**
     * Permet d'ajouter un lot dans la base de données
     * @param mixed $idDatePeche
     * @param mixed $idBateau
     * @param mixed $id
     * @param mixed $espece
     * @param mixed $taille
     * @param mixed $presentation
     * @param mixed $qualite
     * @param mixed $bac
     * @param mixed $poids
     * @param mixed $dateDebut
     * @param mixed $dateFin
     * @param mixed $prixPlancher
     * @param mixed $prixDepart
     * @return void
     */
    public function ajouterLot($idDatePeche, $idBateau, $id, $espece, $taille, $presentation, $qualite, $bac, $poids, $dateDebut, $dateFin, $prixPlancher, $prixDepart)
    {
        // vérification que tout les paramètres sont définies
        if (!empty($idDatePeche) && !empty($idBateau) && !empty($id) && !empty($espece) && !empty($taille) && !empty($presentation) && !empty($qualite) && !empty($bac) && !empty($poids) && !empty($dateDebut) && !empty($dateFin) && !empty($prixPlancher) && !empty($prixDepart)) {
            // vérification que la date de début est inférieur à la date de fin de l'enchère
            if (strtotime($dateDebut) < strtotime($dateFin)) {

                $dateDebut = date('Y-m-d H:i:s', strtotime($dateDebut));
                $dateFin = date('Y-m-d H:i:s', strtotime($dateFin));

                // insertion dans la base de données
                $search = "INSERT INTO lot(idDatePeche, idBateau, id, idEspece, idTaille, idPresentation, idQualite, idBac, poidsBrutLot, dateDebutEnchere, dateFinEnchere, prixPlancher, prixDepart) VALUES(:idDatePeche, :idBateau, :id, :espece, :taille, :presentation, :qualite, :bac, :poids, :dateDebut, :dateFin, :prixPlancher, :prixDepart)";

                $result = $this->db->conn_id->prepare($search);
                $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
                $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
                $result->bindParam(':id', $id, PDO::PARAM_INT);
                $result->bindParam(':espece', $espece, PDO::PARAM_STR);
                $result->bindParam(':taille', $taille, PDO::PARAM_STR);
                $result->bindParam(':presentation', $presentation, PDO::PARAM_STR);
                $result->bindParam(':qualite', $qualite, PDO::PARAM_STR);
                $result->bindParam(':bac', $bac, PDO::PARAM_STR);
                $result->bindParam(':poids', $poids, PDO::PARAM_STR);
                $result->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
                $result->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
                $result->bindParam(':prixPlancher', $prixPlancher, PDO::PARAM_INT);
                $result->bindParam(':prixDepart', $prixDepart, PDO::PARAM_INT);

                if ($result->execute()) {
                    // si l'insertion à réussi
                    $this->session->set_flashdata('message', '<div class="success-msg">
                        <i class="fa-solid fa-check"></i> Succès!
                        <br>
                        Le lot a été ajouté avec succès.
                    </div>');
                    redirect(base_url('VmkOcB8uM3vitpE2MIojw8PZr08BfvKU/products'), 'location', 301);
                } else {
                    // si l'insertion à échoué
                    $this->session->set_flashdata('message', '<div class="error-msg">
                        <i class="fa-solid fa-x"></i> Erreur!
                        <br>
                        Une erreur inattendue s\'est produite lors de l\'ajout du lot.
                        <br>
                        Veuillez réessayer.
                    </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="error-msg">
                    <i class="fa-solid fa-x"></i> Erreur!
                    <br>
                    La date de début de l\'enchère ne peut être supérieur à celle de fin.
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


    /**
     * Récupère toutes les date pêches
     * @return mixed
     */
    public function getOptionsIdDatePeche()
    {
        $sql = "SELECT datePeche FROM peche";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère tout les bateau avec leurs nom
     * @return mixed
     */
    public function getOptionsIdBateau()
    {
        $sql = "SELECT id, Nom FROM bateau";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère toutes les espèces avec leurs nom
     * @return mixed
     */
    public function getOptionsEspece()
    {
        $sql = "SELECT id, nom FROM espece";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère toutes les tailles avec leurs spécification
     * @return mixed
     */
    public function getOptionsTaille()
    {
        $sql = "SELECT id, specification FROM taille";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère toutes les présentations avec leur libellé
     * @return mixed
     */
    public function getOptionsPresentation()
    {
        $sql = "SELECT id, libelle FROM presentation";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère toutes les qualités avec leur libellé
     * @return mixed
     */
    public function getOptionsQualite()
    {
        $sql = "SELECT id, libelle FROM qualite";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

    /**
     * Récupère tous les bac avec leur tare
     * @return mixed
     */
    public function getOptionsBac()
    {
        $sql = "SELECT id, tare FROM bac";
        $query = $this->db->query($sql);
        $results = $query->result_array();
        return $results;
    }

}