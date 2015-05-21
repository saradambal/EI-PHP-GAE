<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Configuration_Forms extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('FORM_CONFIGURATION_CONFIGURATION_ENTRY.php');
    }
    public function CONF_ENTRY_script_name(){
        $this->load->model('Db_configuration_configuration_entry');
        $query = $this->Db_configuration_configuration_entry->getscriptname($this->input->post('CONFIG_ENTRY_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR type NAME
    public function CONF_ENTRY_type_name(){
        $this->load->model('Db_configuration_configuration_entry');
        $data =  $this->Db_configuration_configuration_entry->gettypename($this->input->post('CONFIG_ENTRY_data'),$this->input->post('CONFIG_ENTRY_searchby'));
        echo JSON_encode($data);
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
        $result = $this->Db_configuration_configuration_entry->config_flexdata($USERSTAMP,$this->input->post('module'),$this->input->post('type')) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR UPDATE PART
    public function dataupdate()
    {
        global $USERSTAMP;
        $this->load->model('Db_configuration_configuration_entry');
        $result = $this->Db_configuration_configuration_entry->dataupdate($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //DELETE OPTION
    public function deleteoption(){
        global $USERSTAMP;
        $this->load->model('Db_configuration_configuration_entry');
        $result = $this->Db_configuration_configuration_entry->deleteoption($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $this->load->model('Common');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //ALREADY EXIT FUNCTION
    public function data_exists()
    {
        $this->load->model('Db_configuration_configuration_entry');
        $data['script_name_already_exits_array'] = $this->Db_configuration_configuration_entry->data_name_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function subdata_exists()
    {
        $this->load->model('Db_configuration_configuration_entry');
        $data['subtype_name_already_exits_array'] = $this->Db_configuration_configuration_entry->sub_data_exists($this->input->post('sub_type_data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        global $USERSTAMP;
        $this->load->model('Db_configuration_configuration_entry');
        $result = $this->Db_configuration_configuration_entry->DeleteRecord($USERSTAMP,$this->input->post('rowid'),$this->input->post('module'),$this->input->post('type'),$this->input->post('data')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function dataupd_exists()
    {
        $this->load->model('Db_configuration_configuration_entry');
        $data['script_name_already_exits_array'] = $this->Db_configuration_configuration_entry->data_name_exists($this->input->post('module'),$this->input->post('type'),$this->input->post('data'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}