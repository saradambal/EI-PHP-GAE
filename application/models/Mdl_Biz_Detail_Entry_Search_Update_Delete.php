<?php
Class Mdl_Biz_Detail_Entry_Search_Update_Delete extends CI_Model {

    public function BDTL_INPUT_expense_err_invoice()
    {
    $BDTL_INPUT_biz_expense_type_array = [];
    $BDTL_INPUT_bizexp_invoiceto_array = [];
    $BDTL_INPUT_arr_aircon=[];
    $this->load->model('Eilib/Common_function');
    $BDTL_INPUT_biz_detail_error_array=$this->Common_function->GetErrorMessageList('1,2,103,105,238,248,400,458');
    $BDTL_INPUT_check_unitflag=false;
    $BDTL_INPUT_check_unitno= 'SELECT UNIT_ID FROM UNIT';
    $BDTL_INPUT_checkunit_rs = $this->db->query($BDTL_INPUT_check_unitno);
    foreach ($BDTL_INPUT_checkunit_rs->result_array() as $row)
        $BDTL_INPUT_check_unitflag=true;
    if($BDTL_INPUT_check_unitflag==true){
        $BDTL_INPUT_lb_expense_type_query = "SELECT ECN_ID,ECN_DATA FROM EXPENSE_CONFIGURATION WHERE  ECN_ID IN(16,17,15,13,14,19,20,21,200) ORDER BY ECN_DATA ASC";
        $BDTL_INPUT_type_rs = $this->db->query($BDTL_INPUT_lb_expense_type_query);
        foreach ($BDTL_INPUT_type_rs->result_array() as $row)
        {
            if($row['ECN_ID']==200)
            $BDTL_INPUT_configmonth=$row['ECN_DATA'];
        else if(($row['ECN_ID']==19)||($row['ECN_ID']==20)||($row['ECN_ID']==21))
                $BDTL_INPUT_bizexp_invoiceto_array[]=["BDTL_INPUT_expensetypes_id"=>$row['ECN_ID'],"BDTL_INPUT_expensetypes_data"=>$row['ECN_DATA']];
        else{
                $BDTL_INPUT_biz_expense_type_array[]=["BDTL_INPUT_expensetypes_id"=>$row['ECN_ID'],"BDTL_INPUT_expensetypes_data"=>$row['ECN_DATA']];
        }}
        $BDTL_INPUT_arr_aircon=$this->BDTL_INPUT_aircon_list();
    }
    $BDTL_INPUT_result=[];
        $BDTL_INPUT_result=["BDTL_INPUT_error"=>$BDTL_INPUT_biz_detail_error_array,"BDTL_INPUT_expense"=>$BDTL_INPUT_biz_expense_type_array,"BDTL_INPUT_invoice"=>$BDTL_INPUT_bizexp_invoiceto_array,"BDTL_INPUT_obj_unitflag"=>$BDTL_INPUT_check_unitflag,"BDTL_INPUT_obj_aircon"=>$BDTL_INPUT_arr_aircon,"BDTL_INPUT_obj_configmonth"=>$BDTL_INPUT_configmonth];
    return $BDTL_INPUT_result;
  }
    /*----------------------------------------------CODING TO GET AIRCON SERVICED BY DATA LIST-------------------------------------------------*/
    public function BDTL_INPUT_aircon_list()
    {
        $BDTL_INPUT_aircon_data_array = [];
        $BDTL_INPUT_selectaircon_data = "SELECT EASB_DATA FROM EXPENSE_AIRCON_SERVICE_BY WHERE EASB_DATA  IS NOT NULL ORDER BY EASB_DATA ASC";
        $BDTL_INPUT_aircon_datas_rs = $this->db->query($BDTL_INPUT_selectaircon_data);
        foreach ($BDTL_INPUT_aircon_datas_rs->result_array() as $row)
        {
            $BDTL_INPUT_aircon_data_array[]=$row["EASB_DATA"];
        }
        return $BDTL_INPUT_aircon_data_array;
    }
    /*-----------------------------------------CODING TO GET UNIT NO FROM UNIT TABLE------------------------------------------------------------------*/
//    public function BDTL_INPUT_all_exp_types_unitno(BDTL_INPUT_all_expense_types)
//    {
//      $BDTL_INPUT_bizexp_alltypes='';
//      $BDTL_INPUT_bizexp_unitno_array = [];
//      $BDTL_INPUT_twodimen=[16=>['EDAS_ID','EXPENSE_DETAIL_AIRCON_SERVICE'],17=>['EDCP_ID','EXPENSE_DETAIL_CARPARK'],15=>['EDDV_ID','EXPENSE_DETAIL_DIGITAL_VOICE'],
//                             13=>['EDE_ID','EXPENSE_DETAIL_ELECTRICITY'],14=>['EDSH_ID','EXPENSE_DETAIL_STARHUB']];
//    $BDTL_INPUT_expunitnumbers = "SELECT UNIT_ID,UNIT_NO FROM UNIT WHERE UNIT_ID NOT IN (SELECT UNIT_ID FROM "+BDTL_INPUT_twodimen[BDTL_INPUT_all_expense_types][1]+") ORDER BY UNIT_NO ASC";
//    var BDTL_INPUT_expense_unitno_rs = BDTL_INPUT_unitno_stmt.executeQuery(BDTL_INPUT_expunitnumbers);
//    while(BDTL_INPUT_expense_unitno_rs.next())
//    {
//        BDTL_INPUT_bizexp_unitno_array.push({"BDTL_INPUT_obj_unitid":BDTL_INPUT_expense_unitno_rs.getString(1),"BDTL_INPUT_obj_unitno":BDTL_INPUT_expense_unitno_rs.getString(2)});
//    }
//    return BDTL_INPUT_bizexp_unitno_array;
//    BDTL_INPUT_expense_unitno_rs.close(); BDTL_INPUT_unitno_stmt.close();
//    BDTL_INPUT_conn.close();
//   }
}