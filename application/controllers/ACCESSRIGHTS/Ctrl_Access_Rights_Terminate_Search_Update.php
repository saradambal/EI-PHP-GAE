<?php

/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 15/5/15
 * Time: 10:42 AM
 */

class Ctrl_Access_Rights_Terminate_Search_Update extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('ACCESS RIGHTS/Vw_Access_Rights_Terminate_Search_Update');
    }
    function URT_SRC_errormsg_loginid(){

        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_errormsg_loginid($this->input->post('URT_SRC_source'));
        echo json_encode($final_value);

    }
    public function URT_SRC_func_enddate(){

        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_func_enddate($this->input->post('login_id'),$this->input->post('URT_SRC_recdver'),$this->input->post('URT_SRC_check_enddate'),$this->input->post('URT_SRC_recvrsion_one'));
        echo json_encode($final_value);
    }
    public function URT_SRC_func_recordversion(){

        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_func_recordversion($this->input->post('login_id'),$this->input->post('URT_SRC_flag_recver'),$this->input->post('URT_SRC_recvrsion_one'));
        echo json_encode($final_value);
    }
    public function URT_SRC_func_update(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_func_update($this->input->post('login_id'),$this->input->post('URT_SRC_recdver'),$this->input->post('URT_SRC_upd_enddate'),$this->input->post('reason'),$this->input->post('URT_SRC_flag_updation'),$UserStamp);
        echo json_encode($final_value);
    }

    public function URT_SRC_func_terminate(){
        $this->load->library('Google');
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $service = $this->Mdl_eilib_common_function->get_service_document();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_func_terminate($this->input->post('login_id'),$this->input->post('terminate_date'),$this->input->post('terminate_reason'),$this->input->post('URT_SRC_flag_terminate'),$UserStamp,$service);
        echo json_encode($final_value);

    }
    public function URT_SRC_func_rejoin(){
        $this->load->library('Google');
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $service = $this->Mdl_eilib_common_function->get_service_document();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_terminate_search_update');
        $final_value=$this->Mdl_access_rights_terminate_search_update->URT_SRC_func_rejoin($this->input->post('login_id'),$this->input->post('rejoin_date'),$this->input->post('role'),$this->input->post('URT_SRC_flag_rejoin'),$UserStamp,$service);
        echo json_encode($final_value);
    }


} 