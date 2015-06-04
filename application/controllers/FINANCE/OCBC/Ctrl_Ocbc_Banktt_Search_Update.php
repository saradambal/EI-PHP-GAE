<?php
include 'GET_USERSTAMP.php';
//require_once 'google/appengine/api/mail/Message.php';
//use google\appengine\api\mail\Message;
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
class Ctrl_Ocbc_Banktt_Search_Update extends CI_Controller
{
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Banktt_Search_Update');
    }
    public function Banktt_initialdatas()
    {
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $Searchoption=$this->Mdl_ocbc_banktt_entry->Banktt_Search_Option();
        $unit = $this->Mdl_ocbc_banktt_entry->Banktt_Unit();
        $modelnames=$this->Mdl_ocbc_banktt_entry->get_ModelNames();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $values=array($Searchoption,$ErrorMessage,$unit,$modelnames);
        echo json_encode($values);
    }
    public function Banktt_customer()
    {
        $unit=$_POST['Unit'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $customer=$this->Mdl_ocbc_banktt_entry->get_Banktt_Csutomer($unit);
        echo json_encode($customer);
    }
    public function Banktt_getAccname()
    {
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $accname=$this->Mdl_ocbc_banktt_entry->get_Accountnames();
        echo json_encode($accname);
    }
    public function Banktt_Search_Details()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $option=$_POST['Option'];
        $unit=$_POST['Unit'];
        $customer=$_POST['Customer'];
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $SearchResults=$this->Mdl_ocbc_banktt_entry->get_SearchResults($option,$UserStamp,$timeZoneFormat,$unit,$customer);
        echo json_encode($SearchResults);
    }
    public function Banktt_Update_Save()
    {
        global $UserStamp;
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $Confirm_message=$this->Mdl_ocbc_banktt_entry->getBanktt_UpdateSave($UserStamp);
        if($Confirm_message[0]==1)
        {
            $message1 = new Message();
            $message1->setSender($Confirm_message[3].'<'.$UserStamp.'>');
            $message1->addTo($Confirm_message[4][0]);
            $message1->addCc($Confirm_message[4][1]);
            $message1->setSubject($Confirm_message[1]);
            $message1->setHtmlBody($Confirm_message[2]);
            $message1->send();
        }
        echo json_encode($Confirm_message[0]);
    }
}