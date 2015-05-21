<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Email_Profile_Forms extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('Vw_email_profile_forms.php');
    }
    public function EMAIL_ENTRY_script_name(){
        $this->load->model('Mdl_email_profile_forms');
        $query = $this->Mdl_email_profile_forms->getprofilename($this->input->post('EMAIL_ENTRY_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    // fetch data
    public function fetchdata()
    {
        $scriptid=$_POST['scriptnameid'];
        $this->load->model('Mdl_email_profile_forms');
        $data=$this->Mdl_email_profile_forms->fetch_data($scriptid);
        echo json_encode($data);
    }
    //FUNCTIONFOR UPDATE PART
    public function emailupdate()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_email_profile_forms');
        $result = $this->Mdl_email_profile_forms->email_update($USERSTAMP,$this->input->post('rowid'),$this->input->post('profileid')) ;
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
        $this->load->model('Mdl_email_profile_forms');
        $data['script_name_already_exits_array'] = $this->Mdl_email_profile_forms->email_name_exists($this->input->post('EP_ENTRY_emailid'),$this->input->post('EP_ENTRY_listboxname'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //SAVE PART
    public function save()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_email_profile_forms');
        $data['final_array'] = $this->Mdl_email_profile_forms->save_models($this->input->post('EP_ENTRY_profilenameid'),$this->input->post('EP_ENTRY_emailid'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        global $USERSTAMP;
        $this->load->model('Mdl_email_profile_forms');
        $result = $this->Mdl_email_profile_forms->DeleteRecord($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function upddata_exists()
    {
        $this->load->model('Mdl_email_profile_forms');
        $data['emailid_already_exits_array'] = $this->Mdl_email_profile_forms->updemail_name_exists($this->input->post('EP_SRC_UPD_DEL_updemailid'),$this->input->post('EP_ENTRY_listboxname'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}