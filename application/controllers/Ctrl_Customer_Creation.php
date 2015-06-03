<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Creation extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Creation');
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
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel);
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
    public function CustomerCreationSave()
    {
        global $UserStamp;
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($Startdate,$Enddate);
        $Quoters=0.31;//$this->Common_function->quarterCalc(date('Y-m-d',strtotime($Startdate)), date('Y-m-d',strtotime($Enddate)));
        $service=$this->Mdl_eilib_common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        $cal= $this->Mdl_eilib_calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_creation');
        $Create_confirm=$this->Mdl_customer_creation->Customer_Creation_Save($UserStamp,$Leaseperiod,$Quoters,$service,$cal);
        print_r($Create_confirm);
    }

    public function Prorated_check()
    {
        $Startdate=$_POST['SD'];
        $Enddate=$_POST['ED'];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Prorated=$this->Mdl_eilib_common_function->CUST_chkProrated($Startdate,$Enddate);
        echo $Prorated;
    }

}