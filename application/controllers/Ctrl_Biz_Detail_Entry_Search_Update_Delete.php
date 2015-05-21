<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Biz_Detail_Entry_Search_Update_Delete extends CI_Controller{
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/Vw_Biz_Detail_Entry_Search_Update_Delete');
    }
    public function BDTL_INPUT_expense_err_invoice(){
        $this->load->model('Mdl_Biz_Detail_Entry_Search_Update_Delete');
        $result = $this->Mdl_Biz_Detail_Entry_Search_Update_Delete->BDTL_INPUT_expense_err_invoice() ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_all_exp_types_unitno(){
        $BDTL_INPUT_all_expense_types=$this->input->post('BDTL_INPUT_all_expense_types');
        $this->load->model('Mdl_Biz_Detail_Entry_Search_Update_Delete');
        $result = $this->Mdl_Biz_Detail_Entry_Search_Update_Delete->BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types) ;
        echo JSON_encode($result);
    }
}