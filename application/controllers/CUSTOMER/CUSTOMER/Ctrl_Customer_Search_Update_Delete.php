<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Search_Update_Delete extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Search_Update_Delete');
    }
    public function CC_SRC_InitialDataLoad()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $SearchOption=$this->Mdl_customer_search_update_delete->getSearchOption();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $units = $this->Mdl_eilib_common_function->getAllUnits();
        $Timelist=$this->Mdl_eilib_common_function->getTimeList();
        $formname=$_REQUEST['Formname'];
        $EmailList= $this->Mdl_eilib_common_function->getEmailId($formname);
        $Option= $this->Mdl_eilib_common_function->getOption();
        $proratedlabel=$this->Mdl_eilib_common_function->CUST_getProratedWaivedValue();
        $values=array($SearchOption,$nationality,$ErrorMessage,$units,$Timelist,$EmailList,$Option,$proratedlabel);
        echo json_encode($values);
    }
    public function CustomerName()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Customername=$this->Mdl_customer_search_update_delete->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerCompnameName()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Customercompanyname=$this->Mdl_customer_search_update_delete->getCustomerCompanyNames();
        echo json_encode($Customercompanyname);
    }
    public function CustomerCardNos()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $CustomerCard=$this->Mdl_customer_search_update_delete->getCustomerCardNos();
        echo json_encode($CustomerCard);
    }
    public function AllUnits()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $units = $this->Mdl_eilib_common_function->getAllUnits();
        echo json_encode($units);
    }
    public function AllRoomtype()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Roomtype = $this->Mdl_customer_search_update_delete->getAllRoomtypes();
        echo json_encode($Roomtype);
    }
    public function AllEmails()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Email = $this->Mdl_customer_search_update_delete->getAllEmail();
        echo json_encode($Email);
    }
    public function AllEPNumbers()
    {
        $this->load->model(CUSTOMER/'CUSTOMER/Mdl_customer_search_update_delete');
        $Epnumber = $this->Mdl_customer_search_update_delete->getAllEPnumbers();
        echo json_encode($Epnumber);
    }
    public function AllPassPortNumbers()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Passport = $this->Mdl_customer_search_update_delete->getAllPassPortnumbers();
        echo json_encode($Passport);
    }
    public function AllMobileNumbers()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Mobile = $this->Mdl_customer_search_update_delete->getAllMobileNumbers();
        echo json_encode($Mobile);
    }
    public function AllIntMobileNumbers()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $IntlMobile = $this->Mdl_customer_search_update_delete->getAllIntlMobileNumbers();
        echo json_encode($IntlMobile);
    }
    public function AllOfficeNumbers()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $OfficeMobile = $this->Mdl_customer_search_update_delete->getAllOfficeNumbers();
        echo json_encode($OfficeMobile);
    }
    public function AllComments()
    {
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $OfficeMobile = $this->Mdl_customer_search_update_delete->getAllComments();
        echo json_encode($OfficeMobile);
    }
    public function SearchDataResults()
    {
        global $UserStamp;
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $searchoption=$_POST['SearchOption'];
        $data1=$_POST['data1'];
        $data2=$_POST['data2'];
        $Resultset=$this->Mdl_customer_search_update_delete->getSearchResults($searchoption,$data1,$data2,$UserStamp);
        echo json_encode($Resultset);
    }
    public function SelectCustomerResults()
    {
        $customerid=$_POST['customerid'];
        $leaseperiod=$_POST['LP'];
        $unit=$_POST['Unit'];
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $RecverDetails=$this->Mdl_customer_search_update_delete->getSearchRecverdetails($unit,$customerid,$leaseperiod);
        $Resultset=$this->Mdl_customer_search_update_delete->SelectCustomerResults($customerid,$leaseperiod);
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $RoomType=$this->Mdl_eilib_common_function->getUnitRoomType($unit);
        $UnitDates=$this->Mdl_eilib_common_function->getUnit_Start_EndDate($unit);
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $CustomerStartDate=$this->Mdl_eilib_common_function->getCustomerStartDate();
        $ReturnValues=array($Resultset,$RoomType,$RecverDetails,$UnitDates,$unit,$CustomerStartDate);
        echo json_encode($ReturnValues);
    }
    public function CustomerRoomTypeLoad()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Mdl_eilib_common_function->getUnitRoomType($unit);
        $UnitDates=$this->Mdl_eilib_common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Mdl_eilib_common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function CustomerDetailsUpdate()
    {
        global $UserStamp;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Startdate=$_POST['CCRE_SRC_Startdate'];
        $Enddate=$_POST['CCRE_SRC_Enddate'];
        $Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($Startdate,$Enddate);
        $Quoters=$this->Mdl_eilib_common_function->quarterCalc(new DateTime(date('Y-m-d',strtotime($Startdate))), new DateTime(date('Y-m-d',strtotime($Enddate))));
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $Create_confirm=$this->Mdl_customer_search_update_delete->Customer_Search_Update($UserStamp,$Leaseperiod,$Quoters);
        print_r($Create_confirm);
    }
}