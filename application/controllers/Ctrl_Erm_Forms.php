<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
$UserStamp=$UserStamp;
$timeZoneFormat=$timeZoneFormat;
Class Ctrl_Erm_Forms extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/Vw_Erm_Entry_Search_Update');
    }
    public function ERM_InitialDataLoad()
    {
        $this->load->model('EILIB/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $nationality = $this->Common_function->getNationality();
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Occupation= $this->Common_function->getOccupationList();
        $values=array($nationality,$ErrorMessage,$Occupation);
        echo json_encode($values);
    }
    public function ERM_Entry_Save()
    {
        global $UserStamp;
        $this->load->model('EILIB/Common_function');
        $displayname=$this->Common_function->Get_MailDisplayName('ERM');
        $Emailtemplate=$this->Common_function->getProfileEmailId('ERM');
        $splitMailid=explode('@',$Emailtemplate[0]);
        $username=strtoupper($splitMailid[0]);
        $this->load->model('CUSTOMER/Mdl_erm');
        $Create_confirm=$this->Mdl_erm->ERM_EntrySave($UserStamp,$username);
        $mydate=getdate(date("U"));
        $sysdate="$mydate[month] $mydate[mday], $mydate[year]";
        $emailsubject="NEW ERM LEED -".$sysdate;
        if($Create_confirm[1]==1)
        {
            $message1 = new Message();
            $message1->setSender($displayname.'<'.$UserStamp.'>');
//            $message1->setSender($UserStamp);
            $message1->addTo($Emailtemplate[0]);
            $message1->addCc($Emailtemplate[1]);
            $message1->setSubject($emailsubject);
            $message1->setHtmlBody($Create_confirm[0]);
            $message1->send();
        }
        echo json_encode($Create_confirm[1]);
    }
    public function ERM_SRC_InitialDataLoad()
    {
        $this->load->model('CUSTOMER/Mdl_erm');
        $SearchOption=$this->Mdl_erm->getSearchOption();
        $this->load->model('Common');
        $nationality = $this->Common->getNationality();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        $Occupation= $this->Common->getOccupationList();
        $values=array($SearchOption,$nationality,$ErrorMessage,$Occupation);
        echo json_encode($values);
    }
    public function ERM_Entry_Update()
    {
        $this->load->model('CUSTOMER/Mdl_erm');
        $Create_confirm=$this->Mdl_erm->ERM_EntrySave();
        echo json_encode($Create_confirm);
    }
    public function CustomerName()
    {
        $this->load->model('CUSTOMER/Mdl_erm');
        $Customername=$this->Mdl_erm->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerContact()
    {
        $this->load->model('CUSTOMER/Mdl_erm');
        $Contactno=$this->Mdl_erm->getCustomerContact();
        echo json_encode($Contactno);
    }
    public function Userstamp()
    {
        $this->load->model('CUSTOMER/Mdl_erm');
        $UserStamp=$this->Mdl_erm->getUserstamp();
        echo json_encode($UserStamp);
    }
    public function ERM_SearchOption()
    {
        $Option=$_POST['Option'];
        $Data1=$_POST['Data1'];
        $Data2=$_POST['Data2'];
        $this->load->model('CUSTOMER/Mdl_erm');
        $UserStamp=$this->Mdl_erm->getAllDatas($Option,$Data1,$Data2);
        echo json_encode($UserStamp);
    }
    public function ERM_Deletion_Details()
    {
        global $UserStamp;
        $this->load->model('EILIB/Common_function');
        $Rowid=$_POST['Rowid'];
        $Create_confirm=$this->Common_function->DeleteRecord(80,$Rowid,$UserStamp);
        print_r($Create_confirm);
    }
    public function ERM_Updation_Details()
    {
        global $UserStamp;
        global $timeZoneFormat;
        $this->load->model('CUSTOMER/Mdl_erm');
        $Rowid=$_POST['RowId'];
        $Name=$_POST['Name'];
        $Rent=$_POST['Rent'];
        $Movedate=$_POST['Movingdate'];
        $Min_stay=$_POST['Minstay'];
        $Occupation=$_POST['Occupation'];
        $Nation=$_POST['Nation'];
        $Guests=$_POST['Guests'];
        $age=$_POST['Age'];
        $Contactno=$_POST['Contactno'];
        $Emailid=$_POST['Emailid'];
        $Comments=$_POST['Comments'];
        $this->load->model('EILIB/Common_function');
        $displayname=$this->Common_function->Get_MailDisplayName('ERM');
        $Emailtemplate=$this->Common_function->getProfileEmailId('ERM');
        $splitMailid=explode('@',$Emailtemplate[0]);
        $username=strtoupper($splitMailid[0]);
        $Create_confirm=$this->Mdl_erm->ERM_Update_Record($Rowid,$Name,$Rent,$Movedate,$Min_stay,$Occupation,$Nation,$Guests,$age,$Contactno,$Emailid,$Comments,$UserStamp,$timeZoneFormat,$username);
        $Returnvalues=array($Create_confirm[0],$Create_confirm[1],$Create_confirm[2]);
        $message=$Create_confirm[3];
        $mydate=getdate(date("U"));
        $sysdate="$mydate[month] $mydate[mday], $mydate[year]";
        $emailsubject="NEW ERM LEED -".$sysdate;
        if($Create_confirm[0]==1)
        {
            $message1 = new Message();
            $message1->setSender($displayname.'<'.$UserStamp.'>');
            $message1->addTo($Emailtemplate[0]);
            $message1->addCc($Emailtemplate[1]);
            $message1->setSubject($emailsubject);
            $message1->setHtmlBody($message);
            $message1->send();
        }
        echo json_encode($Returnvalues);
    }
}