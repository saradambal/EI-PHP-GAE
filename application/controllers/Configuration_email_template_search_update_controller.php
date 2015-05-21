<?php

class Configuration_email_template_search_update_controller extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('CONFIGURATION/Configuration_email_template_search_update_view.php');
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
    //FUNCTION FOR UPDATE PART
    public function updatefunction(){
        $id= $this->input->post('id');
        $data = array(
            'ETD_EMAIL_SUBJECT' => $this->input->post('ET_SRC_UPD_DEL_ta_updsubject'),
            'ETD_EMAIL_BODY'=>$this->input->post('ET_SRC_UPD_DEL_ta_updbody'),
        );
        $this->load->model('Configuration_email_template_search_update_model');
        $result=$this->Configuration_email_template_search_update_model->update_data($id,$data);
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //FUNCTION FOR SUB UPDATE PART
    public function subupdatefunction(){
        $id= $this->input->post('id');
        $subjectvalue= $this->input->post('subjectvalue');
        $data = array(
            'ETD_EMAIL_SUBJECT'=>$subjectvalue
        );
        $this->load->model('Configuration_email_template_search_update_model');
        $result=$this->Configuration_email_template_search_update_model->update_subdata($id,$data);
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //FUNCTION FOR BDY UPDATE PART
    public function bdyupdatefunction(){
        $id= $this->input->post('id');
        $bodyvalue= $this->input->post('bodyvalue');
        $data = array(
            'ETD_EMAIL_BODY'=>$bodyvalue
        );
        $this->load->model('Configuration_email_template_search_update_model');
        $result=$this->Configuration_email_template_search_update_model->update_bdydata($id,$data);
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
}
