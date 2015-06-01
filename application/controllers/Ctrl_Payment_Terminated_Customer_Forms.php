<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Payment_Terminated_Customer_Forms extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/Vw_Payment_Terminated_Customer');
    }
    public function PaymentInitialDatas()
    {
        global $UserStamp;
        $this->load->model('Eilib/Common_function');
        $paymenttype=$this->Common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/Mdl_financeterminated_customermodel');
        $unit = $this->Mdl_financeterminated_customermodel->FIN_payment_Customer($UserStamp);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
    }
    public function Term_PaymentEntry_Save()
    {
        global $UserStamp;
        $this->load->model('FINANCE/Mdl_financeterminated_customermodel');
        $Confirm_Mesaage = $this->Mdl_financeterminated_customermodel->FIN_Payment_EntrySave($UserStamp);
        echo json_encode($Confirm_Mesaage);
    }
}