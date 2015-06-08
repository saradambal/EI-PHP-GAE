<?php
class Ctrl_Staff_Daily_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('EXPENSE/STAFF/Mdl_staff_daily_entry_search_update_delete');
    }
    public function index(){
        $this->load->view('EXPENSE/STAFF/Vw_Staff_Daily_Entry_Search_Update_Delete');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_staff_daily_entry_search_update_delete->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savedata()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insert($USERSTAMP) ;
        echo JSON_encode($result);
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savestaff()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insertstaff($USERSTAMP) ;
        echo JSON_encode($result);
    }
    public function STDLY_SEARCH_searchbyagentcommission(){
        $query=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_searchby_agent();
        echo json_encode($query);
    }
    // fetch data
    public function fetchdata()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_data();
        echo json_encode($data);
    }
    // fetch data
    public function fetch_salary_data()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_salarydata();
        echo json_encode($data);
    }
    public function STDLY_SEARCH_func_comments()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->database();
        $data=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_comments($USERSTAMP,$this->input->post('STDLY_SEARCH_srchoption'));
        echo json_encode($data);
    }
    //FUNCTION FOR UPDATE PART
    public function updatefunction()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_agentdata($USERSTAMP,$this->input->post('id')) ;
        echo JSON_encode($result);
    } //FUNCTION FOR UPDATE PART
    public function updatefunction_staffentry()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_staffentrydata($USERSTAMP) ;
        echo json_encode($result);
    }
    // fetch data
    public function STDLY_SEARCH_sendallstaffdata()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_staffsalarydata();
        echo json_encode($data);
    }
    //FUNCTION FOR GET EMP ND CPF NO
    public function STDLY_SEARCH_loadcpfno(){
        $Values = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_getempcpfno();
        echo json_encode($Values);
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->DeleteRecord($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
}