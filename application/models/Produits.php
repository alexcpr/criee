<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle produits
 */
class Produits extends CI_Model
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
     * Permet de récupérer tout les lots
     * @return mixed
     */
    public function getProduits()
    {
        $search = '
        SELECT 
            lot.*,
            espece.nom AS "nomEspece", 
            bateau.nom AS "nomBateau", 
            taille.specification AS "taille", 
            presentation.libelle AS "presentation", 
            qualite.libelle AS "qualite", 
            acheteur.prenom AS "acheteur",
            (
                SELECT prixEnchere 
                FROM poster 
                WHERE idLot = lot.id
                AND idBateau = lot.idBateau
                AND idDatePeche = lot.idDatePeche
                ORDER BY heureEnchere DESC 
                LIMIT 1
            ) AS "prixEnchere"
        FROM 
            lot 
            INNER JOIN espece ON lot.idEspece = espece.id 
            INNER JOIN bateau ON lot.idBateau = bateau.id 
            INNER JOIN taille ON lot.idTaille = taille.id 
            INNER JOIN presentation ON lot.idPresentation = presentation.id 
            INNER JOIN qualite ON lot.idQualite = qualite.id 
            LEFT OUTER JOIN acheteur ON lot.idAcheteur = acheteur.id
        ORDER BY 
            CASE 
                WHEN dateFinEnchere > CURDATE() THEN 1
                WHEN dateDebutEnchere > CURDATE() THEN 2
                ELSE 3
            END, 
            dateFinEnchere ASC;
        ';
        $result = $this->db->conn_id->prepare($search);
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Permet de récupérer un lot précis
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @return mixed
     */
    public function getProduit($id, $idBateau, $idDatePeche)
    {
        $search = '
        SELECT 
            lot.*,
            espece.nomCourt AS "nomEspece", 
            bateau.nom AS "nomBateau", 
            taille.specification AS "taille", 
            presentation.libelle AS "presentation", 
            qualite.libelle AS "qualite", 
            acheteur.prenom AS "acheteur" 
        FROM 
            lot 
            INNER JOIN espece ON lot.idEspece = espece.id 
            INNER JOIN bateau ON lot.idBateau = bateau.id 
            INNER JOIN taille ON lot.idTaille = taille.id 
            INNER JOIN presentation ON lot.idPresentation = presentation.id 
            INNER JOIN qualite ON lot.idQualite = qualite.id 
            LEFT OUTER JOIN acheteur ON lot.idAcheteur = acheteur.id
        WHERE
            lot.id = :id
        AND
            lot.idBateau = :idBateau
        AND
            lot.idDatePeche = :idDatePeche
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
     * Permet de supprimer un lot
     * @param mixed $id
     * @param mixed $idBateau
     * @param mixed $idDatePeche
     * @return void
     */
    public function supprimerProduit($id, $idBateau, $idDatePeche)
    {
        $search = 'DELETE FROM lot WHERE id = :id AND idBateau = :idBateau AND idDatePeche = :idDatePeche';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':idBateau', $idBateau, PDO::PARAM_INT);
        $result->bindParam(':idDatePeche', $idDatePeche, PDO::PARAM_STR);
        if ($result->execute() && $result->rowCount() > 0) {
            $this->session->set_flashdata('message', '<div class="success-msg">
                <i class="fa-solid fa-check"></i> Succès!
                <br>
                Le lot a été supprimé avec succès.
            </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="error-msg">
                <i class="fa-solid fa-x"></i> Erreur!
                <br>
                Une erreur inattendue s\'est produite lors de la tentative de suppression du lot.
                <br>
                Veuillez réessayer.
            </div>');
        }
    }

    /**
     * Permet de récupérer les lots qu'un utilisateur à remporté
     * @param mixed $user_id
     * @return mixed
     */
    public function getProduitsDe($user_id)
    {
        $search = '
        SELECT 
            lot.*,
            espece.nom AS "nomEspece", 
            bateau.nom AS "nomBateau", 
            taille.specification AS "taille", 
            presentation.libelle AS "presentation", 
            qualite.libelle AS "qualite", 
            acheteur.prenom AS "acheteur",
            (
                SELECT prixEnchere 
                FROM poster 
                WHERE idLot = lot.id
                AND idBateau = lot.idBateau
                AND idDatePeche = lot.idDatePeche
                ORDER BY heureEnchere DESC 
                LIMIT 1
            ) AS "prixEnchere"
        FROM 
            lot 
            INNER JOIN espece ON lot.idEspece = espece.id 
            INNER JOIN bateau ON lot.idBateau = bateau.id 
            INNER JOIN taille ON lot.idTaille = taille.id 
            INNER JOIN presentation ON lot.idPresentation = presentation.id 
            INNER JOIN qualite ON lot.idQualite = qualite.id 
            LEFT OUTER JOIN acheteur ON lot.idAcheteur = acheteur.id
        WHERE
            (lot.idDatePeche, lot.idBateau, lot.id) IN (
                SELECT DISTINCT idDatePeche, idBateau, idLot
                FROM poster
                WHERE idAcheteur = :user_id
            )
        ORDER BY 
            CASE 
                WHEN dateFinEnchere > CURDATE() THEN 1
                WHEN dateDebutEnchere > CURDATE() THEN 2
                ELSE 3
            END, 
            dateFinEnchere ASC;
        ';

        $result = $this->db->conn_id->prepare($search);
        $result->execute([':user_id' => $user_id]);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}