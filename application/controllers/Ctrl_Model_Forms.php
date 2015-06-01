<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Model_Forms extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/Vw_Model_Entry_Search_Update');
    }
    public function Model_initialdatas()
    {
        global $timeZoneFormat;
        $this->load->model('Eilib/Common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Allmodels=$this->Common_function->getBankTransferModels();
        $this->load->model('OCBC/Mdl_banktt_model');
        $AllmodelDetails=$this->Mdl_banktt_model->getAllModels_Details($timeZoneFormat);
        $values=array($ErrorMessage,$Allmodels,$AllmodelDetails);
        echo json_encode($values);
    }
    public function ModelnameUpdate()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $modelname=$_POST['Data'];
        $Rowid=$_POST['Rowid'];
        $Option=$_POST['Option'];
        $this->load->model('OCBC/Mdl_banktt_model');
        $Confirmmessage=$this->Mdl_banktt_model->ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option);
        $this->load->model('Eilib/Common_function');
        $Allmodels=$this->Common_function->getBankTransferModels();
        $this->load->model('OCBC/Mdl_banktt_model');
        $Allmodelsdetails=$this->Mdl_banktt_model->getAllModels_Details($timeZoneFormat);
        $returnvalue=array($Allmodels,$Allmodelsdetails);
        echo json_encode($returnvalue);
    }
    public function ModelnameDelete()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $Rowid=$_POST['Data'];
        $this->load->model('OCBC/Mdl_banktt_model');
        $Confirm_message=$this->Mdl_banktt_model->ModelnameDeletion($UserStamp,$Rowid);
        if($Confirm_message!='UPDATED')
        {
            $Allmodels=$this->Mdl_banktt_model->getAllModels_Details($timeZoneFormat);
            $this->load->model('Eilib/Common_function');
            $Create_confirm=$this->Common_function->DeleteRecord(73,$Rowid,$UserStamp);
        }
        else
        {
            $Allmodels=$this->Mdl_banktt_model->getAllModels_Details($timeZoneFormat);
        }
        $values=array($Allmodels,$Confirm_message);
        echo json_encode($values);
    }
    public function ModelnameInsert()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $modelname=$_POST['Data'];
        $this->load->model('OCBC/Mdl_banktt_model');
        $Confirm_message=$this->Mdl_banktt_model->NewModelnameInsert($UserStamp,$modelname);
        $Allmodels=$this->Mdl_banktt_model->getAllModels_Details($timeZoneFormat);
        $Values=array($Confirm_message,$Allmodels);
        echo json_encode($Values);
    }
}