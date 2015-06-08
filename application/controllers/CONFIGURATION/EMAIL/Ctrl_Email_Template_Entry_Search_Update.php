<?php
class Ctrl_Email_Template_Entry_Search_Update extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template_entry_search_update');
    }
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/EMAIL/Vw_Email_Template_Entry_Search_Update');
    }
    //FUNCTION FOR SCRIPT LOADING
    public function ET_SRC_UPD_DEL_script_name(){
        $query = $this->Mdl_email_template_entry_search_update->getscriptname();
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    // fetch data
    public function fetchdata()
    {
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $scriptid=$_POST['scriptnameid'];
        $data=$this->Mdl_email_template_entry_search_update->fetch_data($scriptid,$timeZoneFormat);
        echo json_encode($data);
    }
    //FUNCTIONFOR UPDATE PART
    public function subupdatefunction()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
      $result = $this->Mdl_email_template_entry_search_update->update_subdata($USERSTAMP,$this->input->post('id'),$this->input->post('subjectvalue')) ;
        echo JSON_encode($result);
    }
//FUNCTIONFOR UPDATE PART
    public function bdyupdatefunction()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_email_template_entry_search_update->update_bdydata($USERSTAMP,$this->input->post('id'),$this->input->post('bodyvalue')) ;
        echo JSON_encode($result);
    }
    //SAVE PART
    public function login()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $data['final_array'] = $this->Mdl_email_template_entry_search_update->login_models($this->input->post('scriptnme'),$this->input->post('sub'),$this->input->post('bdy'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function scriptname_exists()
    {
        $data['script_name_already_exits_array'] = $this->Mdl_email_template_entry_search_update->script_name_exists($this->input->post('scriptnme'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
