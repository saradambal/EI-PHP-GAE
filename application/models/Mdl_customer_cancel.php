<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 20/5/15
 * Time: 3:45 PM
 */

class Mdl_customer_cancel extends CI_Model {

    public function CCAN_getcustomer(){

        $CCAN_cust_values='';
        $CCAN_select_cust_values=$this->db->query("SELECT * FROM VW_CANCEL_CUSTOMER UNION SELECT * FROM VW_UNCANCEL_CUSTOMER");
        if($CCAN_select_cust_values->num_rows() > 0){
          $CCAN_cust_values='true';
        }
        else{
          $CCAN_cust_values='false';
        }
        $CCAN_select_err_msg='44,90,248,328,330,401,458';
        $this->load->model("Eilib/Common_function");
        $CCAN_errorAarray=$this->Common_function->getErrorMessageList($CCAN_select_err_msg);
        $CCAN_initial_values_array=array();
        $CCAN_initial_values=(object)['CCAN_error_msg'=>$CCAN_errorAarray,'CCAN_cust_values'=>$CCAN_cust_values];
        $CCAN_initial_values_array=[$CCAN_initial_values];
        return $CCAN_initial_values_array;
    }

        //*************FUNCTION TO RETURN UNIT NO  *************************//
    public  function CCAN_getcustomer_details($CCAN_select_type){


        return $this->CCAN_allcustomerdetails($CCAN_select_type);
    }
    public function CCAN_allcustomerdetails($CCAN_select_type){

        $CCAN_customer_array =array();
        if($CCAN_select_type=="CANCEL CUSTOMER"){
           $CCAN_allcancelunit="SELECT UNIT_NO,CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER FROM VW_CANCEL_CUSTOMER ORDER BY UNIT_NO ASC,CUSTOMERNAME ASC";
        }
        else{
          $CCAN_allcancelunit="SELECT UNIT_NO,CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER FROM VW_UNCANCEL_CUSTOMER ORDER BY UNIT_NO ASC,CUSTOMERNAME ASC";
        }
        $CCAN_customerresult = $this->db->query($CCAN_allcancelunit);
        foreach($CCAN_customerresult->result_array() as $row)
        {
            $CCAN_customer_array[]=(object)['unit'=>$row["UNIT_NO"],'customerid'=>$row["CUSTOMER_ID"],'name'=>$row["CUSTOMERNAME"],'recver'=>$row["CED_REC_VER"]];
        }

        return $CCAN_customer_array;
    }

//    //*************************** FUNCTION TO GET CUSTOMER DETAIL'S*****************************************************//
//    public function CCAN_get_customervalues($id,$CCAN_select_type,$CCAN_recver)
//  {
//      var CCAN_custid=id;
//      var CCAN_guest_array=[];
//      PropertiesService.getUserProperties().setProperty('CCAN_custid',CCAN_custid )
//    var CCAN_conn = eilib.db_GetConnection();
//    var CCAN_roomtype_stmt = CCAN_conn.createStatement();
//    var CCAN_select_roomtype="SELECT URTD.URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED WHERE (CED.CUSTOMER_ID="+CCAN_custid+") AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID) AND(CED.CED_REC_VER="+CCAN_recver+")";//6.UASD
//    var CCAN_roomtype_result = CCAN_roomtype_stmt.executeQuery(CCAN_select_roomtype);
//    if(CCAN_roomtype_result.next()){
//        var CCAN_roomtype = CCAN_roomtype_result.getString("URTD_ROOM_TYPE");
//    }
//    CCAN_roomtype_result.close();
//    CCAN_roomtype_stmt.close();
//    var tempstmt=CCAN_conn.createStatement();
//    tempstmt.execute("CALL SP_CUSTOMER_CANCEL_TEMP_FEE_DETAIL("+CCAN_custid+",'"+UserStamp+"',@CCAN_FEETMPTBLNAM)");
//    tempstmt.close();
//    var CCAN_feetemptbl_stmt=CCAN_conn.createStatement();
//    var CCAN_feetemptbl_query="SELECT @CCAN_FEETMPTBLNAM";
//    var CCAN_feetemptblres=CCAN_feetemptbl_stmt.executeQuery(CCAN_feetemptbl_query);
//    var CCAN_temptblname="";
//    while(CCAN_feetemptblres.next())
//    {
//        CCAN_temptblname=CCAN_feetemptblres.getString(1);
//    }
//    CCAN_feetemptblres.close();
//    CCAN_feetemptbl_stmt.close();
//    var CCAN_alldata_stmt = CCAN_conn.createStatement();
//    if(CCAN_select_type=="CANCEL CUSTOMER"){
//        var CCAN_alldata="SELECT  * FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CLP on CED.CUSTOMER_ID=CLP.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CLP.UASD_ID=CACD.UASD_ID)left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID) left join "+CCAN_temptblname+" CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U  where   (CED.UNIT_ID=U.UNIT_ID)AND (CED.CUSTOMER_ID="+CCAN_custid+") and(CPD.NC_ID=NC.NC_ID)and(CLP.CLP_TERMINATE is null) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and(CED.CED_REC_VER="+CCAN_recver+") AND CED.CED_REC_VER=CLP.CED_REC_VER order by CED.CED_REC_VER "
//    }
//    if(CCAN_select_type=="UNCANCEL CUSTOMER"){
//        var CCAN_alldata="SELECT  * FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CLP on CED.CUSTOMER_ID=CLP.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CLP.UASD_ID=CACD.UASD_ID) AND CACD.ACN_ID IS NULL left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID) left join "+CCAN_temptblname+" CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U  where   (CED.UNIT_ID=U.UNIT_ID)AND (CED.CUSTOMER_ID="+CCAN_custid+") and(CPD.NC_ID=NC.NC_ID)and(CLP.CLP_TERMINATE is null) and (CED.CED_CANCEL_DATE is not null) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and(CED.CED_REC_VER="+CCAN_recver+") AND CED.CED_REC_VER=CLP.CED_REC_VER  order by CED.CED_REC_VER "
//     }
//    var CCAN_alldata_rs = CCAN_alldata_stmt.executeQuery(CCAN_alldata);
//    while(CCAN_alldata_rs.next()){
//        var CCAN_cardno2 = CCAN_alldata_rs.getString("UASD_ACCESS_CARD");
//        if(CCAN_cardno2!=null)
//        {
//            var CCAN_guest = CCAN_alldata_rs.getString("CLP_GUEST_CARD");
//            if(CCAN_guest!='X')
//            {
//                var CCAN_cardno = CCAN_alldata_rs.getString("UASD_ACCESS_CARD");
//                var CCAN_startdate = CCAN_alldata_rs.getString("CLP_STARTDATE");
//                var CCAN_enddate = CCAN_alldata_rs.getString("CLP_ENDDATE");
//            }
//            else
//            {
//                var CCAN_cardno1 = CCAN_alldata_rs.getString("UASD_ACCESS_CARD");
//                CCAN_guest_array.push(CCAN_cardno1);
//            }
//        }
//        else{
//            var CCAN_startdate = CCAN_alldata_rs.getString("CLP_STARTDATE");
//            var CCAN_enddate = CCAN_alldata_rs.getString("CLP_ENDDATE");
//        }
//        var CCAN_company = CCAN_alldata_rs.getString("CCD_COMPANY_NAME");
//        var CCAN_firstname = CCAN_alldata_rs.getString("CUSTOMER_FIRST_NAME");
//        var CCAN_lastname = CCAN_alldata_rs.getString("CUSTOMER_LAST_NAME");
//        var CCAN_deposit = CCAN_alldata_rs.getString("CC_DEPOSIT");
//        var CCAN_rental = CCAN_alldata_rs.getString("CC_PAYMENT_AMOUNT");
//        var CCAN_electricitycap = CCAN_alldata_rs.getString("CC_ELECTRICITY_CAP");
//        var CCAN_airconfixedfee = CCAN_alldata_rs.getString("CC_AIRCON_FIXED_FEE");
//        var CCAN_airconquartelyfee = CCAN_alldata_rs.getString("CC_AIRCON_QUARTERLY_FEE");
//        var CCAN_epno = CCAN_alldata_rs.getString("CPD_EP_NO");
//        var CCAN_epdate = CCAN_alldata_rs.getString("CPD_EP_DATE");
//        var CCAN_passportno = CCAN_alldata_rs.getString("CPD_PASSPORT_NO");
//        var CCAN_passportdate = CCAN_alldata_rs.getString("CPD_PASSPORT_DATE");
//        var CCAN_drycleanfee = CCAN_alldata_rs.getString("CC_DRYCLEAN_FEE");
//        var CCAN_processingfee = CCAN_alldata_rs.getString("CC_PROCESSING_FEE");
//        var CCAN_checkoutcleaningfee = CCAN_alldata_rs.getString("CC_CHECKOUT_CLEANING_FEE");
//        var CCAN_noticeperiod = CCAN_alldata_rs.getString("CED_NOTICE_PERIOD");
//        var CCAN_noticedate = CCAN_alldata_rs.getString("CED_NOTICE_START_DATE");
//        var CCAN_nationality = CCAN_alldata_rs.getString("NC_DATA");
//        var CCAN_dob= CCAN_alldata_rs.getString("CPD_DOB");
//        var CCAN_lease=CCAN_alldata_rs.getString("CED_LEASE_PERIOD");
//        var CCAN_mobile = CCAN_alldata_rs.getString("CPD_MOBILE");
//        var CCAN_mobile1 = CCAN_alldata_rs.getString("CPD_INTL_MOBILE");
//        var CCAN_officeno = CCAN_alldata_rs.getString("CCD_OFFICE_NO");
//        var CCAN_email = CCAN_alldata_rs.getString("CPD_EMAIL");
//        var CCAN_extension= CCAN_alldata_rs.getString("CED_EXTENSION");
//        var CCAN_redver = CCAN_alldata_rs.getString("CED_REC_VER");
//        var CCAN_canceldate = CCAN_alldata_rs.getString("CED_CANCEL_DATE");
//        var CCAN_comments = CCAN_alldata_rs.getString("CPD_COMMENTS");
//        var CCAN_QUARTERS=CCAN_alldata_rs.getString("CED_QUARTERS");
//    }
//    var values_array={'firstname':CCAN_firstname,'lastname':CCAN_lastname,'email':CCAN_email,'mobile1':CCAN_mobile,'mobile2':CCAN_mobile1,'officeno':CCAN_officeno,'dob':CCAN_dob,'passportno':CCAN_passportno,'passportdate':CCAN_passportdate,'epno':CCAN_epno,'epdate':CCAN_epdate,'roomtype':CCAN_roomtype,'cardno':CCAN_cardno,'startdate':CCAN_startdate,'enddate':CCAN_enddate,'lease':CCAN_lease,'QUARTERS':CCAN_QUARTERS,'noticeperiod':CCAN_noticeperiod,'noticedate':CCAN_noticedate,'electricitycap':CCAN_electricitycap,'drycleanfee':CCAN_drycleanfee,'checkoutcleaningfee':CCAN_checkoutcleaningfee,'deposit':CCAN_deposit,'rental':CCAN_rental,'processingfee':CCAN_processingfee,'comments':CCAN_comments,'company':CCAN_company,'nationality':CCAN_nationality,'airconfixedfee':CCAN_airconfixedfee,'airconquartelyfee':CCAN_airconquartelyfee}
//    CCAN_guest_array= eilib.unique(CCAN_guest_array)
//    var CCAN_data_array=[];
//    CCAN_data_array.push(values_array)
//    CCAN_data_array.push(CCAN_guest_array)
//    PropertiesService.getUserProperties().setProperty('CCAN_rec_ver',CCAN_redver);
//    CCAN_alldata_rs.close()
//    CCAN_alldata_stmt.close()
//    eilib.DropTempTable(CCAN_conn,CCAN_temptblname);
//    CCAN_conn.close();
//    return CCAN_data_array;
//  }




} 