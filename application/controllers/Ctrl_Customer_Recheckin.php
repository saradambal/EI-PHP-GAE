<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Recheckin extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/Vw_Customer_Recheckin');
    }
    public function Customer_Initaildatas()
    {
        $this->load->model('EILIB/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $unit = $this->Common_function->getAllActiveUnits();
        $nationality = $this->Common_function->getNationality();
        $EmailList= $this->Common_function->getEmailId($formname);
        $Option= $this->Common_function->getOption();
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Common_function->getTimeList();
        $proratedlabel=$this->Common_function->CUST_getProratedWaivedValue();
        $AllUnit =$this->Common_function->getRecheckinCustomerUnit();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel,$AllUnit);
        echo json_encode($Values);
    }
    public function CustomerRoomTypeLoad()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Common_function->getUnitRoomType($unit);
        $UnitDates=$this->Common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function UnitCardNumbers()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_REQUEST['Unit'];
        $CardNumbers=$this->Common_function->CUST_getunitCardNo($unit);
        echo json_encode($CardNumbers);
    }
    public function Recheckin_Customer()
    {
        $unit=$_REQUEST['Unit'];
        $this->load->model('CUSTOMER/Mdl_customercreation');
        $customername=$this->Mdl_customercreation->getRecheckinCustomer($unit);
        echo json_encode($customername);
    }
    public function Recheckin_Customer_PersonalDetails()
    {
        $customerid=$_REQUEST['Customerid'];
        $Recver=$_REQUEST['Recver'];
        $this->load->model('CUSTOMER/Mdl_customercreation');
        $CustomerPersonalDetails=$this->Mdl_customercreation->getRecheckinCustomer_PersonalDetails($customerid,$Recver);
        $CustomerEnddate=$this->Mdl_customercreation->getRecheckin_Enddates($customerid,$Recver);
        $ReturnValue=array($CustomerPersonalDetails,$CustomerEnddate);
        echo json_encode($ReturnValue);
    }
    public function CustomerRecheckinSave()
    {
        global $UserStamp;
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $this->load->model('EILIB/Common_function');
        $AllUnit =$this->Common_function->getRecheckinCustomerUnit();
        $Leaseperiod=$this->Common_function->getLeasePeriod($Startdate,$Enddate);
        $this->load->model('CUSTOMER/Mdl_customercreation');
        $Create_confirm=$this->Mdl_customercreation->Customer_Recheckin_Save($UserStamp,$Leaseperiod);
        if($Create_confirm[0]==1)
        {
            $this->load->library('Google');
            $this->load->model('EILIB/Calender');
            $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
            $this->Calender->CUST_customercalendercreation($cal,$Create_confirm[1],$Create_confirm[2],$Create_confirm[3],$Create_confirm[4],$Create_confirm[5],$Create_confirm[6],$Create_confirm[7],$Create_confirm[8],$Create_confirm[9],$Create_confirm[10],$Create_confirm[11],$Create_confirm[12],$Create_confirm[13],$Create_confirm[14],$Create_confirm[15],'');
            $message=$Create_confirm[0];
        }
        else
         {
            $message=$Create_confirm;
         }
        $Returnvalue=array($message,$AllUnit);
        echo json_encode($Returnvalue);
    }
}