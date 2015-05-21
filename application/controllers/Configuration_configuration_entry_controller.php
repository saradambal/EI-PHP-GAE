<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Configuration_configuration_entry_controller extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/FORM_CONFIGURATION_CONFIGURATION_ENTRY');
    }
    public function CONF_ENTRY_script_name(){
//        $this->load->model('DB_EMAIL_TEMPLATE_SEARCH_UPDATE');
//        $query=$this->DB_EMAIL_TEMPLATE_SEARCH_UPDATE->ET_SRC_UPD_DEL_scriptname();
//        echo json_encode($query);

        $this->load->model('Db_configuration_configuration_entry');
        $query = $this->Db_configuration_configuration_entry->getscriptname($this->input->post('CONFIG_ENTRY_searchby'));
//        $paymenttype=$this->DB_EMAIL_TEMPLATE_SEARCH_UPDATE->getPaymenttype();
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR type NAME
    public function CONF_ENTRY_type_name(){
        $this->load->model('Db_configuration_configuration_entry');
        $data =  $this->Db_configuration_configuration_entry->gettypename($this->input->post('CONFIG_ENTRY_data'),$this->input->post('CONFIG_ENTRY_searchby'));
        echo JSON_encode($data);
//        exit;
//        echo $data['CGN_TYPE'];
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));
//        $query = $this->Db_configuration_configuration_entry->gettypename();
//        $Values=array($query);
//        echo json_encode($Values);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_save_data()
    {
        global $USERSTAMP;
        $this->load->model('Db_configuration_configuration_entry');
        $result = $this->Db_configuration_configuration_entry->configentrydatainsert($USERSTAMP) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_flex_data()
    {
        global $USERSTAMP;
        $this->load->model('Db_configuration_configuration_entry');
        $result = $this->Db_configuration_configuration_entry->config_flexdata($USERSTAMP) ;
        echo JSON_encode($result);
    }
}