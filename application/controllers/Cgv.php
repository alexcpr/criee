<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page conditions générales de vente
 */
class Cgv extends CI_Controller
{

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche les conditions générales de vente
     * @return void
     */
    public function index()
    {
        $path = base_url('app/resources/cgv.pdf');

        $data = file_get_contents($path);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="Conditions générales de ventes"');
        echo $data;
    }
}