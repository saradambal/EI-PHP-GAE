<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Configuration_Email_Template_Entry_Search_Update extends CI_Controller{
    //LOADING MENU ND FORM
    public function index()
    {
        $this->load->helper('form');
        $this->load->view('CONFIGURATION/Configuration_email_template_entry_view');
    }
    //LOADING ERR MSGS
    public function Initaildatas()
    {
        $this->load->model('Common');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //SAVE PART
    public function login()
    {
        global $USERSTAMP;
        $this->load->model('Configuration_email_template_entry_model');
        $data['final_array'] = $this->Configuration_email_template_entry_model->login_models($this->input->post('scriptnme'),$this->input->post('sub'),$this->input->post('bdy'),$USERSTAMP);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //ALREADY EXIT FUNCTION
    public function scriptname_exists()
    {
        $this->load->model('Configuration_email_template_entry_model');
        $data['script_name_already_exits_array'] = $this->Configuration_email_template_entry_model->script_name_exists($this->input->post('scriptnme'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}