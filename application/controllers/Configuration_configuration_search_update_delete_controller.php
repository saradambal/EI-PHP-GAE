<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Configuration_configuration_search_update_delete_controller extends CI_Controller{
    //LOADING MENU ND FORM
    public function index()
    {
        $this->load->helper('form');
        $this->load->view('CONFIGURATION/Configuration_configuration_search_update_delete_view');

    }
    //FUNCTION FOR MODULE NAME
    public function CONF_ENTRY_module_name(){
        $this->load->model('Configuration_configuration_search_update_delete_model');
        $query = $this->Configuration_configuration_search_update_delete_model->getmodulename();
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR type NAME
    public function CONF_ENTRY_type_name(){
        $this->load->model('Configuration_configuration_search_update_delete_model');
        $data =  $this->Configuration_configuration_search_update_delete_model->gettypename($this->input->post('CONFIG_SRCH_UPD_mod'));
        echo JSON_encode($data);
    }
}