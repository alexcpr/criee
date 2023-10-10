<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle enchère
 */
class Encheres extends CI_Model
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
     * Permet de récupérer les données sur l'enchère actuelle
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @return mixed
     */
    public function getActualEnchere($id, $idBateau, $idDatePeche)
    {
        $search = '
        SELECT 
            (
                SELECT prixEnchere 
                FROM poster 
                WHERE idLot = lot.id
                AND idBateau = lot.idBateau
                AND idDatePeche = lot.idDatePeche
                ORDER BY heureEnchere DESC 
                LIMIT 1
            ) AS "prixEnchere",
            (
                SELECT 
                    CONCAT(acheteur.prenom, " ", LEFT(acheteur.nom, 1), ".") AS "nomAcheteur"
                FROM 
                    poster
                INNER JOIN
                    acheteur ON poster.idAcheteur = acheteur.id
                WHERE 
                    poster.idLot = :id 
                    AND poster.idBateau = :idBateau 
                    AND poster.idDatePeche = :idDatePeche
                ORDER BY 
                    poster.heureEnchere DESC 
                LIMIT 1
            ) AS "dernierEncheri",
            lot.prixPlancher, 
            lot.dateFinEnchere 
        FROM 
            lot 
        WHERE 
            lot.id = :id 
            AND lot.idBateau = :idBateau 
            AND lot.idDatePeche = :idDatePeche
        ';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
        $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Permet d'enchérir
     * @param mixed $userId
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @param mixed $enchereUser
     * @return string
     */
    public function encherir($userId, $id, $idBateau, $idDatePeche, $enchereUser)
    {
        // permet de vérifier que l'enchère est en cours
        if ($this->checkEnchere($id, $idBateau, $idDatePeche)) {
            // on récupère l'enchère actuelle
            $enchere = $this->getActualEnchere($id, $idBateau, $idDatePeche);
            if ((float) $enchereUser > (float) $enchere['prixPlancher'] and (float) $enchereUser > (float) $enchere['prixEnchere']) {
                // si la nouvelle enchère est plus haute que l'enchère actuelle et le prix plancher
                // on enregistre l'enchère
                $search = 'INSERT INTO poster(idDatePeche, idBateau, idLot, idAcheteur, prixEnchere, heureEnchere) VALUES(:idDatePeche, :idBateau, :id, :idAcheteur, :prixEnchere, NOW());';
                $result = $this->db->conn_id->prepare($search);
                $result->bindParam(':idAcheteur', $userId, PDO::PARAM_INT);
                $result->bindParam(':prixEnchere', $enchereUser, PDO::PARAM_STR);
                $result->bindParam(':id', $id, PDO::PARAM_INT);
                $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
                $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
                if ($result->execute()) {
                    // si la requête à réussi
                    return ('
                    <div class="success-msg">
                        <i class="fa-solid fa-check"></i> Succès!
                        <br>
                        Votre enchère a été enregistrée avec succès.
                    </div>');
                } else {
                    // si la requête à échoué
                    return ('
                    <div class="error-msg">
                        <i class="fa-solid fa-x"></i> Erreur!
                        <br>
                        Une erreur inattendue s\'est produite.
                        <br>
                        Veuillez réessayer.
                    </div>');
                }
            } else {
                return ('
                <div class="error-msg">
                    <i class="fa-solid fa-x"></i> Votre enchère est trop basse.
                </div>');
            }
        } else {
            return ('
            <div class="error-msg">
                <i class="fa-solid fa-x"></i> Trop tard!
                <br>
                Cette enchère est terminée.
            </div>');
        }

    }

    /**
     * Permet de vérifier l'état d'une enchère
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @param mixed $flashMsg
     * @return bool
     */
    public function checkEnchere($id, $idBateau, $idDatePeche, $flashMsg = true)
    {
        // on récupère la date de début et de fin de l'enchère
        $search = 'SELECT dateDebutEnchere, dateFinEnchere FROM lot WHERE lot.id = :id AND lot.idBateau = :idBateau AND lot.idDatePeche = :idDatePeche';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
        $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
        $result->execute();
        $enchere = $result->fetch(PDO::FETCH_ASSOC);

        $dateDebutEnchere = strtotime($enchere['dateDebutEnchere']);
        if (time() < $dateDebutEnchere) {
            // l'enchère n'a pas encore commencé
            if ($flashMsg) {
                $this->session->set_flashdata('message', '
                <div class="error-msg">
                    <i class="fa-solid fa-x"></i> Soyez patient!
                    <br>
                    Cette enchère n\'a pas encore commencé.
                </div>');
            }
            return false;
        }

        $dateFinEnchere = strtotime($enchere['dateFinEnchere']);
        if (time() > $dateFinEnchere) {
            // l'enchère est terminée
            if ($flashMsg) {
                $this->session->set_flashdata('message', '
                    <div class="error-msg">
                        <i class="fa-solid fa-x"></i> Trop tard!
                        <br>
                        Cette enchère est terminée.
                    </div>');
            }
            return false;
        }

        // l'enchère est en cours
        return true;
    }

    /**
     * Permet de récupérer le prénom et la première lettre du nom du dernier enchérisseur
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @return mixed
     */
    public function getDernierEncheri($id, $idBateau, $idDatePeche)
    {
        $search = 'SELECT 
                        CONCAT(acheteur.prenom, " ", LEFT(acheteur.nom, 1), ".") AS "nomAcheteur"
                    FROM 
                        poster
                    INNER JOIN
                        acheteur ON poster.idAcheteur = acheteur.id
                    WHERE 
                        poster.idLot = :id 
                        AND poster.idBateau = :idBateau 
                        AND poster.idDatePeche = :idDatePeche
                    ORDER BY 
                        poster.heureEnchere DESC 
                    LIMIT 1';

        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
        $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
        $result->execute();
        $enchere = $result->fetch(PDO::FETCH_ASSOC);

        // on renvoie le prénom et la première lettre du nom du dernier enchérisseur
        return $enchere['nomAcheteur'];
    }

}