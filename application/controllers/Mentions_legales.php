<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Page mentions légales
 */
class Mentions_legales extends CI_Controller
{

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche les mentions légales
     * @return void
     */
    public function index()
    {
        $path = base_url('app/resources/mentions_legales.pdf');

        $data = file_get_contents($path);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="Mentions légales"');
        echo $data;
    }
}