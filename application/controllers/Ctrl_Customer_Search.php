<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Search extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/VW_Customer_Search_Update');
    }
    public function CC_SRC_InitialDataLoad()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $SearchOption=$this->Mdl_customersearch->getSearchOption();
        $this->load->model('Eilib/Common_function');
        $nationality = $this->Common_function->getNationality();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $units = $this->Common_function->getAllUnits();
        $Timelist=$this->Common_function->getTimeList();
        $formname=$_REQUEST['Formname'];
        $EmailList= $this->Common_function->getEmailId($formname);
        $Option= $this->Common_function->getOption();
        $proratedlabel=$this->Common_function->CUST_getProratedWaivedValue();
        $values=array($SearchOption,$nationality,$ErrorMessage,$units,$Timelist,$EmailList,$Option,$proratedlabel);
        echo json_encode($values);
    }
    public function CustomerName()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Customername=$this->Mdl_customersearch->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerCompnameName()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Customercompanyname=$this->Mdl_customersearch->getCustomerCompanyNames();
        echo json_encode($Customercompanyname);
    }
    public function CustomerCardNos()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $CustomerCard=$this->Mdl_customersearch->getCustomerCardNos();
        echo json_encode($CustomerCard);
    }
    public function AllUnits()
    {
        $this->load->model('Eilib/Common_function');
        $units = $this->Common_function->getAllUnits();
        echo json_encode($units);
    }
    public function AllRoomtype()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Roomtype = $this->Mdl_customersearch->getAllRoomtypes();
        echo json_encode($Roomtype);
    }
    public function AllEmails()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Email = $this->Mdl_customersearch->getAllEmail();
        echo json_encode($Email);
    }
    public function AllEPNumbers()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Epnumber = $this->Mdl_customersearch->getAllEPnumbers();
        echo json_encode($Epnumber);
    }
    public function AllPassPortNumbers()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Passport = $this->Mdl_customersearch->getAllPassPortnumbers();
        echo json_encode($Passport);
    }
    public function AllMobileNumbers()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Mobile = $this->Mdl_customersearch->getAllMobileNumbers();
        echo json_encode($Mobile);
    }
    public function AllIntMobileNumbers()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $IntlMobile = $this->Mdl_customersearch->getAllIntlMobileNumbers();
        echo json_encode($IntlMobile);
    }
    public function AllOfficeNumbers()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $OfficeMobile = $this->Mdl_customersearch->getAllOfficeNumbers();
        echo json_encode($OfficeMobile);
    }
    public function AllComments()
    {
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $OfficeMobile = $this->Mdl_customersearch->getAllComments();
        echo json_encode($OfficeMobile);
    }
    public function SearchDataResults()
    {
        global $UserStamp;
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $searchoption=$_POST['SearchOption'];
        $data1=$_POST['data1'];
        $data2=$_POST['data2'];
        $Resultset=$this->Mdl_customersearch->getSearchResults($searchoption,$data1,$data2,$UserStamp);
        echo json_encode($Resultset);
    }
    public function SelectCustomerResults()
    {
        $customerid=$_POST['customerid'];
        $leaseperiod=$_POST['LP'];
        $unit=$_POST['Unit'];
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $RecverDetails=$this->Mdl_customersearch->getSearchRecverdetails($unit,$customerid,$leaseperiod);
        $Resultset=$this->Mdl_customersearch->SelectCustomerResults($customerid,$leaseperiod);
        $this->load->model('Eilib/Common_function');
        $RoomType=$this->Common_function->getUnitRoomType($unit);
        $UnitDates=$this->Common_function->getUnit_Start_EndDate($unit);
        $unit = $this->Common_function->getAllActiveUnits();
        $CustomerStartDate=$this->Common_function->getCustomerStartDate();
        $ReturnValues=array($Resultset,$RoomType,$RecverDetails,$UnitDates,$unit,$CustomerStartDate);
        echo json_encode($ReturnValues);
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
    public function CustomerDetailsUpdate()
    {
        global $UserStamp;
        $this->load->model('Eilib/Common_function');
        $Startdate=$_POST['CCRE_SRC_Startdate'];
        $Enddate=$_POST['CCRE_SRC_Enddate'];
        $Leaseperiod=$this->Common_function->getLeasePeriod($Startdate,$Enddate);
        $Quoters=$this->Common_function->quarterCalc(new DateTime(date('Y-m-d',strtotime($Startdate))), new DateTime(date('Y-m-d',strtotime($Enddate))));
        $this->load->model('CUSTOMER/Mdl_customersearch');
        $Create_confirm=$this->Mdl_customersearch->Customer_Search_Update($UserStamp,$Leaseperiod,$Quoters);
        print_r($Create_confirm);
    }
}