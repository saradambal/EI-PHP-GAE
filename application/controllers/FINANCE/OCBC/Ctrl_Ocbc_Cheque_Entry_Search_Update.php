<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
Class Ctrl_Ocbc_Cheque_Entry_Search_Update extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Cheque_Entry_Search_Update');
    }
    public function Cheque_Entry_InitialDataLoad()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    public function Cheque_Entry_Save()
    {
        global $UserStamp;
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $ConfirmMessage= $this->Mdl_ocbc_cheque_entry_search_update->Cheque_Entry_FormData_Save($UserStamp);
        echo json_encode($ConfirmMessage);
    }
    public  function Cheque_Search_InitialDataLoad()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $Searchoption= $this->Mdl_ocbc_cheque_entry_search_update->getSearchOption();
        $Chequestatus=$this->Mdl_ocbc_cheque_entry_search_update->getChequeStatus();
        $returnvalues=array($ErrorMessage,$Searchoption,$Chequestatus);
        echo json_encode($returnvalues);
    }
    public function Cheque_SearchOption()
    {
        global $timeZoneFormat;
        $Option=$_POST['Option'];
        $Data1=$_POST['Data1'];
        $Data2=$_POST['Data2'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $Allrecords=$this->Mdl_ocbc_cheque_entry_search_update->getAllDatas($Option,$Data1,$Data2,$timeZoneFormat);
        echo json_encode($Allrecords);
    }
    public function ChequeNo()
    {
        $this->load->model('OCBC/Mdl_ocbc_cheque_entry_search_update');
        $AllChequeno=$this->Mdl_ocbc_cheque_entry_search_update->getChequeNo();
        echo json_encode($AllChequeno);
    }
    public function ChequeUnit()
    {
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $AllChequeunit=$this->Mdl_ocbc_cheque_entry_search_update->getChequeUnit();
        echo json_encode($AllChequeunit);
    }
    public function Cheque_Updation_Details()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $chequedate=$_POST['cheque_date'];
        $chequeno=$_POST['cheque_no'];
        $chequeto=$_POST['cheque_to'];
        $chequefor=$_POST['check_for'];
        $checkamount=$_POST['check_amount'];
        $checkunit=$_POST['unit'];
        $checkstatus=$_POST['status'];
        $checquedebiteddate=$_POST['debiteddate'];
        $comments=$_POST['comments'];
        $Rowid=$_POST['ID'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $confirmmessage=$this->Mdl_ocbc_cheque_entry_search_update->getUpdation_Details($Rowid,$chequedate,$chequeno,$chequeto,$chequefor,$checkamount,$checkunit,$checkstatus,$checquedebiteddate,$comments,$UserStamp,$timeZoneFormat);
        echo json_encode($confirmmessage);
    }
}