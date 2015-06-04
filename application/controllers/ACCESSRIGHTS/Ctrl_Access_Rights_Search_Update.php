<?php

class Ctrl_Access_Rights_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('ACCESS RIGHTS/Vw_Access_Rights_Search_Update');
    }
    public function Loadinitialdata(){
        global $UserStamp;
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $query= $this->Mdl_access_rights_search_update->URSRC_loadintialvalue($UserStamp);
        $final_value=array($query);
        echo json_encode($final_value);
    }
    public function URSRC_check_customrole(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $URSRC_already_exist_flag=$this->Mdl_access_rights_search_update->URSRC_check_role($this->input->post('URSRC_roleidval'));
        echo $URSRC_already_exist_flag;
    }
    public  function URSRC_check_basicrolemenu(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $URSRC_check_basicrole_menu=$this->Mdl_access_rights_search_update->URSRC_check_basicrolemenu($this->input->post('URSRC_basicradio_value'));
        echo $URSRC_check_basicrole_menu;
    }
    public function URSRC_check_loginid(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_check_loginid($this->input->post('URSRC_login_id'));
        echo json_encode($final_value);

    }
    //FUNCTION TO LOAD LOGIN ID
    public function URSRC_get_loginid(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_get_loginid();
        echo json_encode($final_value);
    }
    public function URSRC_get_logindetails(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_get_logindetails($this->input->post('URSRC_login_id'));
        echo json_encode($final_value);
    }
    public function URSRC_getmenu_folder(){
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_getmenu_folder($this->input->post('radio_value'),$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);
    }
    public function URSRC_role_creation_save(){
        global $UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $URSRC_mainradiobutton=$this->input->post('URSRC_mainradiobutton');
        $mainmenu=$this->input->post('menu');
        $Sub_menu1=$this->input->post('Sub_menu1');
        $Sub_menu=$this->input->post('Sub_menu');
        $basicroles=$this->input->post('basicroles');
        $customrole=$this->input->post('URSRC_tb_customrole');
        $customerrole_upd=$this->input->post('URSRC_lb_rolename');
        $URSRC_radio_basicroles=$this->input->post('URSRC_radio_basicroles1');
        $URSRC_cb_basicroles=$this->input->post('URSRC_cb_basicroles1');
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_role_creation_save($URSRC_mainradiobutton,$mainmenu,$Sub_menu,$Sub_menu1,$basicroles,$customrole,$customerrole_upd,$URSRC_radio_basicroles,$URSRC_cb_basicroles,$UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);
    }
    public function URSRC_login_creation_save(){
        global $UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $URSRC_mainradiobutton=$this->input->post('URSRC_mainradiobutton');
        $URSRC_tb_joindate=$this->input->post('URSRC_tb_joindate');
        $URSRC_custom_role=$this->input->post('roles1');
        $URSRC_tb_loginid=$this->input->post('URSRC_tb_loginid');
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_login_creation_save($URSRC_mainradiobutton,$URSRC_tb_joindate,$URSRC_custom_role,$URSRC_tb_loginid,$UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);
    }
    public function URSRC_get_roledetails(){
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_get_roledetails($this->input->post('role'),$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);
    }
    public function URSRC_get_customrole(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_get_customrole();
        echo json_encode($final_value);
    }
    public  function URSRC_loadbasicrole_menu(){
       global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
       $this->load->library('Google');
       $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
       $final_value=$this->Mdl_access_rights_search_update->URSRC_loadbasicrole_menu($this->input->post('URSRC_basicradio_value'),$this->input->post('role'),$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
       echo json_encode($final_value);
    }
    public function URSRC_getmenubasic_folder1(){
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_search_update');
        $final_value=$this->Mdl_access_rights_search_update->URSRC_getmenubasic_folder1();
        $final_value=array($final_value);
        echo json_encode($final_value);
    }
}