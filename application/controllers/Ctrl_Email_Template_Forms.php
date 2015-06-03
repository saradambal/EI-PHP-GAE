<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Email_Template_Forms extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/EMAIL/Vw_Email_Template_Forms');
    }
    //FUNCTION FOR SCRIPT LOADING
    public function ET_SRC_UPD_DEL_script_name(){
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $query = $this->Mdl_email_template->getscriptname();
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $this->load->model('Eilib/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    // fetch data
    public function fetchdata()
    {
        $scriptid=$_POST['scriptnameid'];
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $data=$this->Mdl_email_template->fetch_data($scriptid);
        echo json_encode($data);
    }
    //FUNCTIONFOR UPDATE PART
    public function subupdatefunction()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $result = $this->Mdl_email_template->update_subdata($USERSTAMP,$this->input->post('id'),$this->input->post('subjectvalue')) ;
        echo JSON_encode($result);
    }
//FUNCTIONFOR UPDATE PART
    public function bdyupdatefunction()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $result = $this->Mdl_email_template->update_bdydata($USERSTAMP,$this->input->post('id'),$this->input->post('bodyvalue')) ;
        echo JSON_encode($result);
    }
    //SAVE PART
    public function login()
    {
        global $USERSTAMP;
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $data['final_array'] = $this->Mdl_email_template->login_models($this->input->post('scriptnme'),$this->input->post('sub'),$this->input->post('bdy'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function scriptname_exists()
    {
        $this->load->model('CONFIGURATION/EMAIL/Mdl_email_template');
        $data['script_name_already_exits_array'] = $this->Mdl_email_template->script_name_exists($this->input->post('scriptnme'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
