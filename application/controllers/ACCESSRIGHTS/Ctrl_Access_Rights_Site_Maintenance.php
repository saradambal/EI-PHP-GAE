<?php

/**
//*******************************************FILE DESCRIPTION*********************************************/
//*******************************************SITE MAINTENANCE*********************************************//
//DONE BY:safi

//VER 0.01-INITIAL VERSION, SD:19/05/2015 ED:19/05/2015
//*********************************************************************************************************


class Ctrl_Access_Rights_Site_Maintenance extends CI_Controller{


    function __construct() {
        parent::__construct();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_site_maintenance');
    }
    public function index(){
        $this->load->view('ACCESS RIGHTS/Vw_Access_Rights_Site_Maintenance');
    }
    public function USR_SITE_getintialvalue(){
        global $UserStamp;
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_site_maintenance');
        $final_values=$this->Mdl_access_rights_site_maintenance->USR_SITE_getintialvalue();
        echo json_encode($final_values);
    }
    public function USR_SITE_update(){
        $mainmenu=$this->input->post('menu');
        $Sub_menu1=$this->input->post('Sub_menu1');
        $Sub_menu=$this->input->post('Sub_menu');
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_site_maintenance');
        $final_values=$this->Mdl_access_rights_site_maintenance->USR_SITE_update($mainmenu,$Sub_menu,$Sub_menu1);
        echo ($final_values);
    }


} 