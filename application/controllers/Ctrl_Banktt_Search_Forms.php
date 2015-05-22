<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Banktt_Search_Forms extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/BANKTT_SEARCH_UPDATE');
    }
    public function Banktt_initialdatas()
    {
        $this->load->model('Banktt_entry_model');
        $Searchoption=$this->Banktt_entry_model->Banktt_Search_Option();
        $unit = $this->Banktt_entry_model->Banktt_Unit();
        $modelnames=$this->Banktt_entry_model->get_ModelNames();
        $this->load->model('Eilib/Common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $values=array($Searchoption,$ErrorMessage,$unit,$modelnames);
        echo json_encode($values);
    }
    public function Banktt_customer()
    {
        $unit=$_POST['Unit'];
        $this->load->model('Banktt_entry_model');
        $customer=$this->Banktt_entry_model->get_Banktt_Csutomer($unit);
        echo json_encode($customer);
    }
    public function Banktt_getAccname()
    {
        $this->load->model('Banktt_entry_model');
        $accname=$this->Banktt_entry_model->get_Accountnames();
        echo json_encode($accname);
    }
    public function Banktt_Search_Details()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $option=$_POST['Option'];
        $unit=$_POST['Unit'];
        $customer=$_POST['Customer'];
        $this->load->model('Banktt_entry_model');
        $SearchResults=$this->Banktt_entry_model->get_SearchResults($option,$UserStamp,$timeZoneFormat,$unit,$customer);
        echo json_encode($SearchResults);
    }
    public function Banktt_Update_Save()
    {
        global $UserStamp;
        $this->load->model('Banktt_entry_model');
        $Confirm_message=$this->Banktt_entry_model->getBanktt_UpdateSave($UserStamp);
        echo json_encode($Confirm_message);
    }
}