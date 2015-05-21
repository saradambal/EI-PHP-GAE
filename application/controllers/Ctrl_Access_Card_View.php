<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Access_Card_View extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/Vw_Access_Card_View');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);

        $this->load->model('Mdl_access_card_view');
        $query=$this->Mdl_access_card_view->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Cardnodetails(){
        global $USERSTAMP;
        $unitno= $this->input->post('unitno');
        $cardno= $this->input->post('cardno');
        $option= $this->input->post('option');
        $this->load->model('Mdl_access_card_view');
        $cardquery=$this->Mdl_access_card_view->Cardno_details($unitno,$cardno,$option,$USERSTAMP);
        echo json_encode($cardquery);
    }
    public function Customerid(){
        $custname= $this->input->post('CV_name');
        $this->load->model('Mdl_access_card_view');
        $custquery=$this->Mdl_access_card_view->Customer_id($custname);
        echo json_encode($custquery);
    }
    public function Customervalues(){
        global $USERSTAMP;
        $custid= $this->input->post('CV_cid');
        $this->load->model('Mdl_access_card_view');
        $custdtlquery=$this->Mdl_access_card_view->Customer_values($custid,$USERSTAMP);
        echo json_encode($custdtlquery);
    }
    public function Pdfcreation(){
        global $USERSTAMP;
        $this->load->library('pdf');
        $pdfresult='';
        $custname= $this->input->get('custname');
        $custid= $this->input->get('custnameid');
        $unitno= $this->input->get('unitno');
        $cardno= $this->input->get('cardno');
        $option= $this->input->get('option');
        $this->load->model('Mdl_access_card_view');
        $pdfresult=$this->Mdl_access_card_view->Pdf_creation($custid,$unitno,$cardno,$option,$USERSTAMP);
        $pdfheader='';
        if($option==18){$pdfheader='DETAIL FOR CARD NO '.$cardno;}
        else if($option==21){$pdfheader='DETAIL FOR CUSTOMER '.$custname;}
        else if($option==31){$pdfheader='DETAILS FOR THE UNIT NUMBER '.$unitno;}
        else if($option==40){$pdfheader='DETAILS FOR ALL UNITS';}
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}