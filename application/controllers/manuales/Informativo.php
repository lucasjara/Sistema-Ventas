<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 27-01-2018
 * Time: 11:55
 */

class Informativo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout("plantilla");
        $this->load->library('form_validation');
    }
    function index(){
        $this->layout->view('vista');
    }
}