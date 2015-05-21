<?php
Class Ctrl_Customer_Search extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/FORM_CUSTOMER_SERACH_UPDATE');
    }
    public function CC_SRC_InitialDataLoad()
    {
        $this->load->model('Customersearch');
        $SearchOption=$this->Customersearch->getSearchOption();
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
        $this->load->model('Customersearch');
        $Customername=$this->Customersearch->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerCompnameName()
    {
        $this->load->model('Customersearch');
        $Customercompanyname=$this->Customersearch->getCustomerCompanyNames();
        echo json_encode($Customercompanyname);
    }
    public function CustomerCardNos()
    {
        $this->load->model('Customersearch');
        $CustomerCard=$this->Customersearch->getCustomerCardNos();
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
        $this->load->model('Customersearch');
        $Roomtype = $this->Customersearch->getAllRoomtypes();
        echo json_encode($Roomtype);
    }
    public function AllEmails()
    {
        $this->load->model('Customersearch');
        $Email = $this->Customersearch->getAllEmail();
        echo json_encode($Email);
    }
    public function AllEPNumbers()
    {
        $this->load->model('Customersearch');
        $Epnumber = $this->Customersearch->getAllEPnumbers();
        echo json_encode($Epnumber);
    }
    public function AllPassPortNumbers()
    {
        $this->load->model('Customersearch');
        $Passport = $this->Customersearch->getAllPassPortnumbers();
        echo json_encode($Passport);
    }
    public function AllMobileNumbers()
    {
        $this->load->model('Customersearch');
        $Mobile = $this->Customersearch->getAllMobileNumbers();
        echo json_encode($Mobile);
    }
    public function AllIntMobileNumbers()
    {
        $this->load->model('Customersearch');
        $IntlMobile = $this->Customersearch->getAllIntlMobileNumbers();
        echo json_encode($IntlMobile);
    }
    public function AllOfficeNumbers()
    {
        $this->load->model('Customersearch');
        $OfficeMobile = $this->Customersearch->getAllOfficeNumbers();
        echo json_encode($OfficeMobile);
    }
    public function AllComments()
    {
        $this->load->model('Customersearch');
        $OfficeMobile = $this->Customersearch->getAllComments();
        echo json_encode($OfficeMobile);
    }
    public function SearchDataResults()
    {
        $this->load->model('Customersearch');
        $searchoption=$_POST['SearchOption'];
        $data1=$_POST['data1'];
        $data2=$_POST['data2'];
        $Resultset=$this->Customersearch->getSearchResults($searchoption,$data1,$data2);
        echo json_encode($Resultset);
    }
    public function SelectCustomerResults()
    {
        $customerid=$_POST['customerid'];
        $leaseperiod=$_POST['LP'];
        $unit=$_POST['Unit'];
        $this->load->model('Customersearch');
        $RecverDetails=$this->Customersearch->getSearchRecverdetails($unit,$customerid,$leaseperiod);
        $Resultset=$this->Customersearch->SelectCustomerResults($customerid,$leaseperiod);
        $this->load->model('Eilib/Common_function');
        $RoomType=$this->Common_function->getUnitRoomType($unit);
        $UnitDates=$this->Common_function->getUnit_Start_EndDate($unit);
        $unit = $this->Common_function->getAllActiveUnits();
        $ReturnValues=array($Resultset,$RoomType,$RecverDetails,$UnitDates,$unit);
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
        $this->load->model('Customersearch');
        $Create_confirm=$this->Customersearch->Customer_Search_Update();
        print_r($Create_confirm);
    }
}