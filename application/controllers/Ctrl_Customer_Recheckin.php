<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Recheckin extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Recheckin');
    }
    public function Customer_Initaildatas()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $EmailList= $this->Mdl_eilib_common_function->getEmailId($formname);
        $Option= $this->Mdl_eilib_common_function->getOption();
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Mdl_eilib_common_function->getTimeList();
        $proratedlabel=$this->Mdl_eilib_common_function->CUST_getProratedWaivedValue();
        $AllUnit =$this->Mdl_eilib_common_function->getRecheckinCustomerUnit();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel,$AllUnit);
        echo json_encode($Values);
    }
    public function CustomerRoomTypeLoad()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Mdl_eilib_common_function->getUnitRoomType($unit);
        $UnitDates=$this->Mdl_eilib_common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Mdl_eilib_common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function UnitCardNumbers()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit=$_REQUEST['Unit'];
        $CardNumbers=$this->Mdl_eilib_common_function->CUST_getunitCardNo($unit);
        echo json_encode($CardNumbers);
    }
    public function Recheckin_Customer()
    {
        $unit=$_REQUEST['Unit'];
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_creation');
        $customername=$this->Mdl_customer_creation->getRecheckinCustomer($unit);
        echo json_encode($customername);
    }
    public function Recheckin_Customer_PersonalDetails()
    {
        $customerid=$_REQUEST['Customerid'];
        $Recver=$_REQUEST['Recver'];
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_creation');
        $CustomerPersonalDetails=$this->Mdl_customer_creation->getRecheckinCustomer_PersonalDetails($customerid,$Recver);
        $CustomerEnddate=$this->Mdl_customer_creation->getRecheckin_Enddates($customerid,$Recver);
        $ReturnValue=array($CustomerPersonalDetails,$CustomerEnddate);
        echo json_encode($ReturnValue);
    }
    public function CustomerRecheckinSave()
    {
        global $UserStamp;
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $AllUnit =$this->Mdl_eilib_common_function->getRecheckinCustomerUnit();
        $Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($Startdate,$Enddate);
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_creation');
        $Create_confirm=$this->Mdl_customer_creation->Customer_Recheckin_Save($UserStamp,$Leaseperiod);
        if($Create_confirm[0]==1)
        {
            $this->load->library('Google');
            $this->load->model('EILIB/Mdl_eilib_calender');
            $cal= $this->Mdl_eilib_calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
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