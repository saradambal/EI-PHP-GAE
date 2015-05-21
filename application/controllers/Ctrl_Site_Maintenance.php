<?php
include 'GET_USERSTAMP.php';
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 19/5/15
 * Time: 12:32 PM
 */

class Ctrl_Site_Maintenance extends CI_Controller{


    public function index(){

        $this->load->view('ACCESS RIGHTS/Vw_Site_Maintenance');
    }

    public function USR_SITE_getintialvalue(){
      global $UserStamp;

       $this->load->model('ACCESS RIGHTS/Mdl_site_maintenance');
        $final_values=$this->Mdl_site_maintenance->USR_SITE_getintialvalue();
        echo json_encode($final_values);


    }
    public function USR_SITE_update(){

        global $UserStamp;
        $mainmenu=$this->input->post('menu');
        $Sub_menu1=$this->input->post('Sub_menu1');
        $Sub_menu=$this->input->post('Sub_menu');
        $this->load->model('ACCESS RIGHTS/Mdl_site_maintenance');
        $final_values=$this->Mdl_site_maintenance->USR_SITE_update($mainmenu,$Sub_menu,$Sub_menu1);
        echo ($final_values);



    }


} 