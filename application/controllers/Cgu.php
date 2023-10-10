<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page conditions générales d'utilisation
 */
class Cgu extends CI_Controller
{

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche les conditions générales d'utilisation
     * @return void
     */
    public function index()
    {
        $path = base_url('app/resources/cgu.pdf');

        $data = file_get_contents($path);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="Conditions générales d\'utilisation"');
        echo $data;
    }
}