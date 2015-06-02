<?php
class Ctrl_Error_Page extends CI_Controller{

    public function index()
    {
//        $this->load->helper('form');
//        $this->load->view('FORM_MENU');
       $this->load->view('Vw_Error_Page');
    }
}