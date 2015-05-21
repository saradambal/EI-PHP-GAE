<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Customer_Recheckin extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/FORM_CUSTOMER_RECHECKIN');
    }
    public function Customer_Initaildatas()
    {
        $this->load->model('Eilib/Common_function');
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
        $this->load->model('Eilib/Common_function');
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Common_function->getUnitRoomType($unit);
        $UnitDates=$this->Common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function UnitCardNumbers()
    {
        $this->load->model('Eilib/Common_function');
        $unit=$_REQUEST['Unit'];
        $CardNumbers=$this->Common_function->CUST_getunitCardNo($unit);
        echo json_encode($CardNumbers);
    }
    public function Recheckin_Customer()
    {
        $unit=$_REQUEST['Unit'];
        $this->load->model('Customercreation');
        $customername=$this->Customercreation->getRecheckinCustomer($unit);
        echo json_encode($customername);
    }
    public function Recheckin_Customer_PersonalDetails()
    {
        $customerid=$_REQUEST['Customerid'];
        $Recver=$_REQUEST['Recver'];
        $this->load->model('Customercreation');
        $CustomerPersonalDetails=$this->Customercreation->getRecheckinCustomer_PersonalDetails($customerid,$Recver);
        $CustomerEnddate=$this->Customercreation->getRecheckin_Enddates($customerid,$Recver);
        $ReturnValue=array($CustomerPersonalDetails,$CustomerEnddate);
        echo json_encode($ReturnValue);
    }
    public function CustomerRecheckinSave()
    {
        global $UserStamp;
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $this->load->model('Eilib/Common_function');
        $AllUnit =$this->Common_function->getRecheckinCustomerUnit();
        $Leaseperiod=$this->Common_function->getLeasePeriod($Startdate,$Enddate);
        $this->load->model('Customercreation');
        $Create_confirm=$this->Customercreation->Customer_Recheckin_Save($UserStamp,$Leaseperiod);
        $Returnvalue=array($Create_confirm,$AllUnit);
        echo json_encode($Returnvalue);
    }
}