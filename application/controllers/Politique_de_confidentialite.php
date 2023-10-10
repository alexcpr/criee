<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page politique de confidentalité
 */
class Politique_de_confidentialite extends CI_Controller
{

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche la politique de confidentialité
     * @return void
     */
    public function index()
    {
        $path = base_url('app/resources/politique_de_confidentialite.pdf');

        $data = file_get_contents($path);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="Politique de confidentialité"');
        echo $data;
    }
}