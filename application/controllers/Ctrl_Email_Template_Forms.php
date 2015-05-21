<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Email_Template_Forms extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('Configuration_email_template_search_update_view.php');
    }
    //FUNCTION FOR SCRIPT LOADING
    public function ET_SRC_UPD_DEL_script_name(){
        $this->load->model('Configuration_email_template_search_update_model');
        $query = $this->Configuration_email_template_search_update_model->getscriptname();
        $Values=array($query);
        echo json_encode($Values);
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
    // fetch data
    public function fetchdata()
    {
        $scriptid=$_POST['scriptnameid'];
        $this->load->model('Configuration_email_template_search_update_model');
        $data=$this->Configuration_email_template_search_update_model->fetch_data($scriptid);
        echo json_encode($data);
    }
    //FUNCTIONFOR UPDATE PART
    public function subupdatefunction()
    {
        global $USERSTAMP;
        $this->load->model('Configuration_email_template_search_update_model');
        $result = $this->Configuration_email_template_search_update_model->update_subdata($USERSTAMP,$this->input->post('id'),$this->input->post('subjectvalue')) ;
        echo JSON_encode($result);
    }
//FUNCTIONFOR UPDATE PART
    public function bdyupdatefunction()
    {
        global $USERSTAMP;
        $this->load->model('Configuration_email_template_search_update_model');
        $result = $this->Configuration_email_template_search_update_model->update_bdydata($USERSTAMP,$this->input->post('id'),$this->input->post('bodyvalue')) ;
        echo JSON_encode($result);
    }
    //SAVE PART
    public function login()
    {
        global $USERSTAMP;
        $this->load->model('Configuration_email_template_search_update_model');
        $data['final_array'] = $this->Configuration_email_template_search_update_model->login_models($this->input->post('scriptnme'),$this->input->post('sub'),$this->input->post('bdy'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function scriptname_exists()
    {
        $this->load->model('Configuration_email_template_search_update_model');
        $data['script_name_already_exits_array'] = $this->Configuration_email_template_search_update_model->script_name_exists($this->input->post('scriptnme'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

}
