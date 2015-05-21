<?php

include "GET_USERSTAMP.php";

class Ctrl_User_Search_Details extends  CI_Controller{


public function index(){


    $this->load->view('ACCESS RIGHTS/Vw_User_Search_Details');
}
    public function USD_SRC_flextable_getdatas(){

             global $UserStamp;
              global $timeZoneFormat;

        $this->load->model('ACCESS RIGHTS/Mdl_user_search_details');
        $final_value=$this->Mdl_user_search_details->USD_SRC_flextable_getdatas($timeZoneFormat);
        echo json_encode($final_value);

    }
    public function User_Details_pdf(){
        global $UserStamp;
        global $timeZoneFormat;
        $this->load->library('pdf');
        $pdfresult='';
        $this->load->model('ACCESS RIGHTS/Mdl_user_search_details');
        $pdfresult=$this->Mdl_user_search_details->User_Details_pdf($timeZoneFormat);
        $pdfheader='USER SEARCH DETAILS';
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }


} 