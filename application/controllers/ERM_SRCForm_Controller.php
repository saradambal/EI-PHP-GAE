<?php
Class ERM_SRCForm_Controller extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/FORM_ERM_SEARCH_UPDATE');
    }
    public function ERM_SRC_InitialDataLoad()
    {
        $this->load->model('ERMmodel');
        $SearchOption=$this->ERMmodel->getSearchOption();
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
        $this->load->model('ERMmodel');
        $Create_confirm=$this->ERMmodel->ERM_EntrySave();
        echo json_encode($Create_confirm);
    }
    public function CustomerName()
    {
        $this->load->model('ERMmodel');
        $Customername=$this->ERMmodel->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerContact()
    {
        $this->load->model('ERMmodel');
        $Contactno=$this->ERMmodel->getCustomerContact();
        echo json_encode($Contactno);
    }
    public function Userstamp()
    {
        $this->load->model('ERMmodel');
        $UserStamp=$this->ERMmodel->getUserstamp();
        echo json_encode($UserStamp);
    }
    public function ERM_SearchOption()
    {
    $Option=$_POST['Option'];
    $Data1=$_POST['Data1'];
    $Data2=$_POST['Data2'];
    $this->load->model('ERMmodel');
    $UserStamp=$this->ERMmodel->getAllDatas($Option,$Data1,$Data2);
    echo json_encode($UserStamp);
    }
}