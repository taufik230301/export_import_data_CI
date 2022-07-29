<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_karyawan extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function view_karyawan(){
        $this->load->view('view_karyawan_page');
    }

}