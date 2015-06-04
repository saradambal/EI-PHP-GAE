<?php

/*********************************************GLOBAL DECLARATION******************************************-->
//*********************************************************************************************************/
//*******************************************FILE DESCRIPTION*********************************************//
//****************************************USER SEARCH DETAILS*************************************************//
//DONE BY:safi
//VER 0.01-INITIAL VERSION,SD:19/05/2015 ED:19/05/2015
//******************************************************************************************************
class Ctrl_Access_Rights_User_Search_Details extends  CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ACCESS RIGHTS/Mdl_access_rights_user_search_details');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('ACCESS RIGHTS/Vw_Access_Rights_User_Search_Details');
    }
    public function USD_SRC_flextable_getdatas(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $final_value=$this->Mdl_access_rights_user_search_details->USD_SRC_flextable_getdatas($timeZoneFormat);
        echo json_encode($final_value);
    }
    public function User_Details_pdf(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('pdf');
        $pdfresult='';
        $pdfresult=$this->Mdl_access_rights_user_search_details->User_Details_pdf($timeZoneFormat);
        $pdfheader='USER SEARCH DETAILS';
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
} 