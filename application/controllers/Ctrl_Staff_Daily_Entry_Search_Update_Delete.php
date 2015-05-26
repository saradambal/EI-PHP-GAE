<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Staff_Daily_Entry_Search_Update_Delete extends CI_Controller{
    public function index(){
        $this->load->view('EXPENSE/Vw_staff_daily_entry_search_update_delete');
    }
    public function Initialdata(){
        $this->load->model('Common');
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);

        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $query=$this->Mdl_staff_daily_entry_search_update_delete->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savedata()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insert($USERSTAMP) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savestaff()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insertstaff($USERSTAMP) ;
        echo JSON_encode($result);
    }
    public function STDLY_SEARCH_searchbyagentcommission(){
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $query=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_searchby_agent();
        echo json_encode($query);
    }
    // fetch data
    public function fetchdata()
    {
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_data();
        echo json_encode($data);
    }
    // fetch data
    public function fetch_salary_data()
    {
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_salarydata();
        echo json_encode($data);
    }
    public function STDLY_SEARCH_func_comments()
    {
        global $USERSTAMP;
        $this->load->database();
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $data=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_comments($USERSTAMP,$this->input->post('STDLY_SEARCH_srchoption'));
        echo json_encode($data);
    }
    //FUNCTION FOR UPDATE PART
    public function updatefunction()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_agentdata($USERSTAMP,$this->input->post('id')) ;
        echo JSON_encode($result);
    } //FUNCTION FOR UPDATE PART
    public function updatefunction_staffentry()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_staffentrydata($USERSTAMP) ;
        echo json_encode($result);
    }
    // fetch data
    public function STDLY_SEARCH_sendallstaffdata()
    {
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_staffsalarydata();
        echo json_encode($data);
    }
    //FUNCTION FOR GET EMP ND CPF NO
    public function STDLY_SEARCH_loadcpfno(){
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $Values = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_getempcpfno();
        echo json_encode($Values);
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        global $USERSTAMP;
        $this->load->model('Mdl_staff_daily_entry_search_update_delete');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->DeleteRecord($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
}