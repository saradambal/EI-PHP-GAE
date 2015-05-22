<?php
include "GET_USERSTAMP.php";
include "GET_CONFIG.php";
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 15/5/15
 * Time: 10:42 AM
 */

class Ctrl_Terminate_Search_Update extends CI_Controller {

    public function index(){

        $this->load->view('ACCESS RIGHTS/Vw_Terminate_Search_update');

    }
    function URT_SRC_errormsg_loginid(){

        global $UserStamp;
        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');

        $final_value=$this->Mdl_terminate_search_update->URT_SRC_errormsg_loginid($this->input->post('URT_SRC_source'));
        echo json_encode($final_value);

    }
    public function URT_SRC_func_enddate(){

        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');
        $final_value=$this->Mdl_terminate_search_update->URT_SRC_func_enddate($this->input->post('login_id'),$this->input->post('URT_SRC_recdver'),$this->input->post('URT_SRC_check_enddate'),$this->input->post('URT_SRC_recvrsion_one'));

        echo json_encode($final_value);
    }
    public function URT_SRC_func_recordversion(){

        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');
        $final_value=$this->Mdl_terminate_search_update->URT_SRC_func_recordversion($this->input->post('login_id'),$this->input->post('URT_SRC_flag_recver'),$this->input->post('URT_SRC_recvrsion_one'));
        echo json_encode($final_value);


    }
    public function URT_SRC_func_update(){
        global $UserStamp;
        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');
        $final_value=$this->Mdl_terminate_search_update->URT_SRC_func_update($this->input->post('login_id'),$this->input->post('URT_SRC_recdver'),$this->input->post('URT_SRC_upd_enddate'),$this->input->post('reason'),$this->input->post('URT_SRC_flag_updation'),$UserStamp);
        echo json_encode($final_value);
    }

    public function URT_SRC_func_terminate(){
        global $UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');
        $final_value=$this->Mdl_terminate_search_update->URT_SRC_func_terminate($this->input->post('login_id'),$this->input->post('terminate_date'),$this->input->post('terminate_reason'),$this->input->post('URT_SRC_flag_terminate'),$UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);

    }
    public function URT_SRC_func_rejoin(){
        global $UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $this->load->model('ACCESS RIGHTS/Mdl_terminate_search_update');
        $final_value=$this->Mdl_terminate_search_update->URT_SRC_func_rejoin($this->input->post('login_id'),$this->input->post('rejoin_date'),$this->input->post('role'),$this->input->post('URT_SRC_flag_rejoin'),$UserStamp,$ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        echo json_encode($final_value);


    }

} 