<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;

/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 26/5/15
 * Time: 4:30 PM
 */

class Ctrl_Customer_Expiry_List extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_expiry_list');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public  function index(){
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Expiry_List');
    }
    public function CEXP_get_initial_values(){
        $final_value=$this->Mdl_customer_expiry_list->CEXP_get_initial_values();
        echo json_encode($final_value);
    }
    public function CEXP_get_customer_details(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $final_value=$this->Mdl_customer_expiry_list->CEXP_get_customer_details($this->input->post('CEXP_fromdate'),$this->input->post('CEXP_todate'),$this->input->post('CEXP_radio_button_select_value'),$UserStamp,$timeZoneFormat);
        echo json_encode($final_value);
    }
    public function CWEXP_get_customerdetails(){

        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $CWEXP_weekBefore=$_POST["CWEXP_TB_weekBefore"];
        $CWEXP_email_id=$_POST["CWEXP_email"];
        $final_value=$this->Mdl_customer_expiry_list->CWEXP_get_customerdetails($CWEXP_weekBefore,$CWEXP_email_id,$UserStamp,$timeZoneFormat);
        if($final_value[0]==1) {
            $displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('CUSTOMER_EXPIRY');
            $message1 = new Message();
            $message1->setSender($displayname.'<'.$UserStamp.'>');
            $message1->addTo($CWEXP_email_id);
            $message1->setSubject($final_value[2]);
            $message1->setHtmlBody($final_value[1]);
            $message1->send();
            $CWEXP_check_weekly_expiry_list='true';
            echo ($CWEXP_check_weekly_expiry_list);
        }
        else{
            $CWEXP_check_weekly_expiry_list='false';
            echo ($CWEXP_check_weekly_expiry_list);
        }
    }
    public function Customer_Expiry_List_pdf(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('pdf');
        $pdfresult='';
        $CEXP_fromdate=$this->input->get('CEXP_fromdate');
        $CEXP_todate=$this->input->get('CEXP_todate');
        $CEXP_radio_button_select_value=$this->input->get('CEXP_radio_button_select_value');
        $header=$this->input->get('header');
        $pdfresult=$this->Mdl_customer_expiry_list->Customer_Expiry_List_pdf($CEXP_fromdate,$CEXP_todate,$CEXP_radio_button_select_value,$UserStamp,$timeZoneFormat);
        $pdfheader='CUSTOMER EXPIRY LIST - '.$header;
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4-L');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }



} 