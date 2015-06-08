<?php
class Ctrl_Email_Profile_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_profile_entry_search_update_delete');
    }
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/EMAIL/Vw_Email_Profile_Entry_Search_Update_Delete');
    }
    public function EMAIL_ENTRY_script_name(){
        $query = $this->Mdl_email_profile_entry_search_update_delete->getprofilename($this->input->post('EMAIL_ENTRY_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    // fetch data
    public function fetchdata()
    {
        $scriptid=$_POST['scriptnameid'];
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $data=$this->Mdl_email_profile_entry_search_update_delete->fetch_data($scriptid,$timeZoneFormat);
        echo json_encode($data);
    }
    //FUNCTIONFOR UPDATE PART
    public function emailupdate()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_email_profile_entry_search_update_delete->email_update($USERSTAMP,$this->input->post('rowid'),$this->input->post('profileid')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //ALREADY EXIT FUNCTION
    public function data_exists()
    {
        $data['script_name_already_exits_array'] = $this->Mdl_email_profile_entry_search_update_delete->email_name_exists($this->input->post('EP_ENTRY_emailid'),$this->input->post('EP_ENTRY_listboxname'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //SAVE PART
    public function save()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $data['final_array'] = $this->Mdl_email_profile_entry_search_update_delete->save_models($this->input->post('EP_ENTRY_profilenameid'),$this->input->post('EP_ENTRY_emailid'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_email_profile_entry_search_update_delete->DeleteRecord($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function upddata_exists()
    {
        $data['emailid_already_exits_array'] = $this->Mdl_email_profile_entry_search_update_delete->updemail_name_exists($this->input->post('EP_SRC_UPD_DEL_updemailid'),$this->input->post('EP_ENTRY_listboxname'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}