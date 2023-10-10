<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Modèle panier
 */
class Panier extends CI_Model
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
     * Permet de récupérer le nombre de lots dans le panier de l'utilisateur
     * @param mixed $user_id
     * @return mixed
     */
    public function getCountPanier($user_id)
    {
        $search = 'SELECT COUNT(id) AS countPanier FROM lot WHERE idAcheteur = :id;';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $user_id, PDO::PARAM_INT);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Permet de récupérer tout les lots que l'utilisateur à dans son panier
     * @param mixed $user_id
     * @return mixed
     */
    public function getContenuPanier($user_id)
    {
        $search = '
      SELECT 
            lot.*,
            espece.nom AS "nomEspece", 
            bateau.nom AS "nomBateau", 
            taille.specification AS "taille", 
            presentation.libelle AS "presentation", 
            qualite.libelle AS "qualite", 
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
        WHERE
            idAcheteur = :id
      ';
        $result = $this->db->conn_id->prepare($search);
        $result->bindParam(':id', $user_id, PDO::PARAM_INT);
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}