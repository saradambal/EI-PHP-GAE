<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Banktt_Search_Forms extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/Vw_BankTT_Search_Update');
    }
    public function Banktt_initialdatas()
    {
        $this->load->model('OCBC/Mdl_banktt_entry');
        $Searchoption=$this->Mdl_banktt_entry->Banktt_Search_Option();
        $unit = $this->Mdl_banktt_entry->Banktt_Unit();
        $modelnames=$this->Mdl_banktt_entry->get_ModelNames();
        $this->load->model('Eilib/Common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $values=array($Searchoption,$ErrorMessage,$unit,$modelnames);
        echo json_encode($values);
    }
    public function Banktt_customer()
    {
        $unit=$_POST['Unit'];
        $this->load->model('OCBC/Mdl_banktt_entry');
        $customer=$this->Mdl_banktt_entry->get_Banktt_Csutomer($unit);
        echo json_encode($customer);
    }
    public function Banktt_getAccname()
    {
        $this->load->model('OCBC/Mdl_banktt_entry');
        $accname=$this->Mdl_banktt_entry->get_Accountnames();
        echo json_encode($accname);
    }
    public function Banktt_Search_Details()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $option=$_POST['Option'];
        $unit=$_POST['Unit'];
        $customer=$_POST['Customer'];
        $this->load->model('OCBC/Mdl_banktt_entry');
        $SearchResults=$this->Mdl_banktt_entry->get_SearchResults($option,$UserStamp,$timeZoneFormat,$unit,$customer);
        echo json_encode($SearchResults);
    }
    public function Banktt_Update_Save()
    {
        global $UserStamp;
        $this->load->model('OCBC/Mdl_banktt_entry');
        $Confirm_message=$this->Mdl_banktt_entry->getBanktt_UpdateSave($UserStamp);
        echo json_encode($Confirm_message);
    }
}