<?php
include "GET_USERSTAMP.php";
include 'GET_CONFIG.php';
$USERSTAMP=$UserStamp;
class Ctrl_Biz_Detail_Entry_Search_Update_Delete extends CI_Controller{
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/Vw_Biz_Detail_Entry_Search_Update_Delete');
    }
    public function BDTL_INPUT_expense_err_invoice(){
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_expense_err_invoice() ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_all_exp_types_unitno(){
        $BDTL_INPUT_all_expense_types=$this->input->post('BDTL_INPUT_all_expense_types');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_get_SDate_EDate()
    {
        $unitselectedlist=$this->input->post('unitselectedlist');
         $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_get_SDate_EDate($unitselectedlist) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_airconservicedby_check()
    {
        $BDTL_INPUT_newaircon=$this->input->post('BDTL_INPUT_newaircon');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_airconservicedby_check($BDTL_INPUT_newaircon) ;
        echo ($result);
    }
    public function Cal_service(){
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Calender');
        // FUNCTION TO CALL AND GET THE CALENDAR SERVICE
        $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        return $cal;
    }
    public function BDTL_INPUT_save()
    {
        global $USERSTAMP;
        $calid=$this->Cal_service();
        $BDTL_INPUT_tb_newaircon=$this->input->post('BDTL_INPUT_tb_newaircon');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_save($USERSTAMP,$BDTL_INPUT_tb_newaircon,$calid) ;
        echo JSON_encode($result);
    }

}