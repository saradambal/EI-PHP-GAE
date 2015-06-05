<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Configuration_Forms extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/Vw_Configuration_Forms.php');
    }
    public function CONF_ENTRY_script_name(){
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $query = $this->Mdl_configuration->getscriptname($this->input->post('CONFIG_ENTRY_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR type NAME
    public function CONF_ENTRY_type_name(){
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $data =  $this->Mdl_configuration->gettypename($this->input->post('CONFIG_ENTRY_data'),$this->input->post('CONFIG_ENTRY_searchby'));
        echo JSON_encode($data);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_save_data()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $result = $this->Mdl_configuration->configentrydatainsert($USERSTAMP) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR SAVE PART
    public function CONF_ENTRY_flex_data()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $result = $this->Mdl_configuration->config_flexdata($USERSTAMP,$this->input->post('module'),$this->input->post('type')) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR UPDATE PART
    public function dataupdate()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $result = $this->Mdl_configuration->dataupdate($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data'),$this->input->post('CONFIG_SEARCH_subdata'),$this->input->post('subdatamount_value')) ;
        echo JSON_encode($result);
    }
    //DELETE OPTION
    public function deleteoption(){
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $result = $this->Mdl_configuration->deleteoption($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $this->load->model('EILIB/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //ALREADY EXIT FUNCTION
    public function data_exists()
    {
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $data['script_name_already_exits_array'] = $this->Mdl_configuration->data_name_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function subdata_exists()
    {
        $this->load->model('Mdl_configuration');
        $data['subtype_name_already_exits_array'] = $this->Mdl_configuration->sub_data_exists($this->input->post('sub_type_data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $result = $this->Mdl_configuration->DeleteRecord($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function dataupd_exists()
    {
        $this->load->model('CONFIGURATION/Mdl_configuration');
        $data['script_name_already_exits_array'] = $this->Mdl_configuration->data_updname_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'),$this->input->post('CONFIG_SEARCH_subtype'),$this->input->post('subdatamount_value'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}