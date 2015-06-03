<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Ocbc_Model_Entry_Search_Update extends CI_Controller
{
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Model_Entry_Search_Update');
    }
    public function Model_initialdatas()
    {
        global $timeZoneFormat;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Allmodels=$this->Mdl_eilib_common_function->getBankTransferModels();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $AllmodelDetails=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
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
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $Confirmmessage=$this->Mdl_ocbc_model_entry_search_update->ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option);
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Allmodels=$this->Mdl_eilib_common_function->getBankTransferModels();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $Allmodelsdetails=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        $returnvalue=array($Allmodels,$Allmodelsdetails);
        echo json_encode($returnvalue);
    }
    public function ModelnameDelete()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $Rowid=$_POST['Data'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $Confirm_message=$this->Mdl_ocbc_model_entry_search_update->ModelnameDeletion($UserStamp,$Rowid);
        if($Confirm_message!='UPDATED')
        {
            $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $Create_confirm=$this->Mdl_eilib_common_function->DeleteRecord(73,$Rowid,$UserStamp);
        }
        else
        {
            $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        }
        $values=array($Allmodels,$Confirm_message);
        echo json_encode($values);
    }
    public function ModelnameInsert()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $modelname=$_POST['Data'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $Confirm_message=$this->Mdl_ocbc_model_entry_search_update->NewModelnameInsert($UserStamp,$modelname);
        $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        $Values=array($Confirm_message,$Allmodels);
        echo json_encode($Values);
    }
}