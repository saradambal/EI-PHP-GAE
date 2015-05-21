<?php
Class Finance_Controller extends CI_Controller
{
    public function Active_Customer_Entry()
    {
        $this->load->view('FORM_FINANCE_ENTRY.php');
    }
    public function All_Active_Unit()
    {
        $this->load->model('Financemodel');
        $query = $this->Financemodel->getAllActiveUnits();
        $paymenttype=$this->Financemodel->getPaymenttype();
        $Values=array($query,$paymenttype);
        echo json_encode($Values);
    }
    public function Active_Customer()
    {
        $unit=$_REQUEST['UNIT'];
        $this->load->model('Financemodel');
        $Customer = $this->Financemodel->getActive_Customer($unit);
        echo json_encode($Customer);
    }
    public function Active_Customer_LP()
    {
        $unit=$_REQUEST['UNIT'];
        $customer=$_REQUEST['CUSTOMERID'];
        $this->load->model('Financemodel');
        $Customer_lp = $this->Financemodel->getActive_Customer_LP($unit,$customer);
        echo json_encode($Customer_lp);
    }
    public function CustomerName()
    {
        $customer=$_REQUEST['CUSTOMERID'];
        $this->load->model('Financemodel');
        $CustomerName = $this->Financemodel->getCustomer_Name($customer);
        echo json_encode($CustomerName);
    }
    public function Active_Customer_EntrySave()
    {
        $this->load->model('Financemodel');
        $unit=$_REQUEST['unit'];
        $customer=$_REQUEST['customer'];
        $lp=$_REQUEST['lp'];
        $payment=$_REQUEST['payment'];
        $amount=$_REQUEST['amount'];
        $period=$_REQUEST['period'];
        $paiddate=$_REQUEST['paiddate'];
        $comments=$_REQUEST['comments'];
        $query = $this->Financemodel->Save($unit,$customer,$lp,$payment,$amount,$period,$paiddate,$comments);
        echo $query;
    }
}
