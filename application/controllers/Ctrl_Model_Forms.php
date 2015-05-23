<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Model_Forms extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/MODEL_ENTRY_SEARCH_UPDATE');
    }
    public function Model_initialdatas()
    {
        global $timeZoneFormat;
        $this->load->model('Eilib/Common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Allmodels=$this->Common_function->getBankTransferModels();
        $this->load->model('Banktt_model');
        $AllmodelDetails=$this->Banktt_model->getAllModels_Details($timeZoneFormat);
        $values=array($ErrorMessage,$Allmodels,$AllmodelDetails);
        echo json_encode($values);
    }
    public function ModelnameUpdate()
    {
        global $UserStamp;
        $modelname=$_POST['Data'];
        $Rowid=$_POST['Rowid'];
        $Option=$_POST['Option'];
        $this->load->model('Banktt_model');
        $Confirmmessage=$this->Banktt_model->ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option);
        $this->load->model('Eilib/Common_function');
        $Allmodels=$this->Common_function->getBankTransferModels();
        echo json_encode($Allmodels);
    }
    public function ModelnameDelete()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $Rowid=$_POST['Data'];
        $this->load->model('Banktt_model');
        $Confirm_message=$this->Banktt_model->ModelnameDeletion($UserStamp,$Rowid);
        if($Confirm_message!='UPDATED')
        {
            $Allmodels=$this->Banktt_model->getAllModels_Details($timeZoneFormat);
            $this->load->model('Eilib/Common_function');
            $Create_confirm=$this->Common_function->DeleteRecord(73,$Rowid,$UserStamp);
        }
        else
        {
            $Allmodels=$this->Banktt_model->getAllModels_Details($timeZoneFormat);
        }
        $values=array($Allmodels,$Confirm_message);
        echo json_encode($values);
    }
    public function ModelnameInsert()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $modelname=$_POST['Data'];
        $this->load->model('Banktt_model');
        $Confirm_message=$this->Banktt_model->NewModelnameInsert($UserStamp,$modelname);
        $Allmodels=$this->Banktt_model->getAllModels_Details($timeZoneFormat);
        $Values=array($Confirm_message,$Allmodels);
        echo json_encode($Values);
    }
}