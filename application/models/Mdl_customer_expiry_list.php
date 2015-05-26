<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 26/5/15
 * Time: 4:30 PM
 */

class Mdl_customer_expiry_list extends CI_Model{


    public function CEXP_get_initial_values(){


        $CEXP_errorAarray=array();
        $CEXP_select_err_msg="80,81,82,83,84,85,86,87,88,89,282,256";
        $this->load->model("Eilib/Common_function");
        $CEXP_errorAarray=$this->Common_function->getErrorMessageList($CEXP_select_err_msg);
        $this->db->select();
        $this->db->from('CUSTOMER');
        $CEXP_select_customer=$this->db->get();
        $CEXP_custAarray=array();
        foreach($CEXP_select_customer->result_array() as $row){
           $CEXP_custAarray[]=$row["CUSTOMER_ID"];
        }
        $CEXP_max_date_array=array();
        $CEXP_select_max_date="SELECT MAX(CLP_ENDDATE) as CLP_ENDDATE FROM CUSTOMER_LP_DETAILS";
        $CEXP_select_maxdate_rs=$this->db->query($CEXP_select_max_date);
        foreach($CEXP_select_maxdate_rs->result_array() as $row){
           $CEXP_max_date_array[]=($row["CLP_ENDDATE"]);
        }
       //-----------------CODING TO GET EMAIL LIST FROM DATABASE----------------------------//
       $CWEXP_email_array=$this->Common_function->getProfileEmailId('EXPIRY');
       $CEXP_initial_values_array=array();
       $CEXP_initial_values=(object)['CEXP_error_msg'=>$CEXP_errorAarray,'CEXP_emailid'=>$CWEXP_email_array,'CEXP_custAarray'=>$CEXP_custAarray,'CEXP_max_date_array'=>$CEXP_max_date_array];
       $CEXP_initial_values_array[]=($CEXP_initial_values);
       return $CEXP_initial_values_array;

    }
    //FUNCTION TO GET CUSTOMER DATA'S FROM DATABASE---------------------
//    function CEXP_get_customer_details(fromdate,todate,radiovalue){
//        var CEXP_fromdate=eilib.SqlDateFormat(fromdate);
//        var CEXP_todate=eilib.SqlDateFormat(todate);
//        var CEXP_check_radio_value=radiovalue;
//        var CEXP_cust_id_array=[];
//        var CEXP_conn = eilib.db_GetConnection();
//        var CEXP_final_expiry_result=[];
//        //TO CHECK EQUAL DATE
//        if(CEXP_check_radio_value=="EQUAL"){
//            var CEXP_temptable_equal_stmt = CEXP_conn.createStatement();
//            CEXP_temptable_equal_stmt.execute("CALL SP_CUSTOMER_EXPIRY('1','"+CEXP_fromdate+"',NULL,'"+UserStamp+"',@CEXP_EQUALFEETMPTBLNAM)");
//            CEXP_temptable_equal_stmt.close();
//            var CEXP_equalfeetemptbl_stmt=CEXP_conn.createStatement();
//            var CEXP_equalfeetemptbl_query="SELECT @CEXP_EQUALFEETMPTBLNAM";
//            var CEXP_equalfeetemptblres=CEXP_equalfeetemptbl_stmt.executeQuery(CEXP_equalfeetemptbl_query);
//            var CEXP_equaltemptblname="";
//            while(CEXP_equalfeetemptblres.next())
//            {
//                CEXP_equaltemptblname=CEXP_equalfeetemptblres.getString(1);
//            }
//            CEXP_equalfeetemptblres.close();
//            CEXP_equalfeetemptbl_stmt.close();
//            var CEXP_alldata_equal_stmt=CEXP_conn.createStatement();
//            var CEXP_select_expirylist_equaldate="SELECT UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,"+timeZoneFormat+"),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP from  "+CEXP_equaltemptblname+""
//      var CEXP_expirylist_rs = CEXP_alldata_equal_stmt.executeQuery(CEXP_select_expirylist_equaldate);
//      var tablename=CEXP_equaltemptblname
//    }
//        //TO CHECK ON OR BEFORE DATE
//        if(CEXP_check_radio_value=="BEFORE"){
//            var CEXP_temptable_before_stmt = CEXP_conn.createStatement();
//            CEXP_temptable_before_stmt.execute("CALL SP_CUSTOMER_EXPIRY('2','"+CEXP_fromdate+"',NULL,'"+UserStamp+"',@CEXP_BEFOREFEETMPTBLNAM)");
//            CEXP_temptable_before_stmt.close();
//            var CEXP_beforefeetemptbl_stmt=CEXP_conn.createStatement();
//            var CEXP_beforefeetemptbl_query="SELECT @CEXP_BEFOREFEETMPTBLNAM";
//            var CEXP_beforefeetemptblres=CEXP_beforefeetemptbl_stmt.executeQuery(CEXP_beforefeetemptbl_query);
//            var CEXP_beforetemptblname="";
//            while(CEXP_beforefeetemptblres.next())
//            {
//                CEXP_beforetemptblname=CEXP_beforefeetemptblres.getString(1);
//            }
//            CEXP_beforefeetemptblres.close();
//            CEXP_beforefeetemptbl_stmt.close();
//            var CEXP_alldata_before_stmt = CEXP_conn.createStatement();
//            var CEXP_select_expirylist_beforedate="SELECT UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,"+timeZoneFormat+"),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP from  "+CEXP_beforetemptblname+""
//      var CEXP_expirylist_rs = CEXP_alldata_before_stmt.executeQuery(CEXP_select_expirylist_beforedate);
//            var tablename=CEXP_beforetemptblname;
//    }
//        //TO CHECK BETWEEN DATE
//        if(CEXP_check_radio_value=="BETWEEN"){
//            var CEXP_temptable_between_stmt = CEXP_conn.createStatement();
//            CEXP_temptable_between_stmt.execute("CALL SP_CUSTOMER_EXPIRY('3','"+CEXP_fromdate+"','"+CEXP_todate+"','"+UserStamp+"',@CEXP_BETWEENFEETMPTBLNAM)");
//            CEXP_temptable_between_stmt.close();
//            var CEXP_betweenfeetemptbl_stmt=CEXP_conn.createStatement();
//            var CEXP_betweenfeetemptbl_query="SELECT @CEXP_BETWEENFEETMPTBLNAM";
//            var CEXP_betweenfeetemptblres=CEXP_betweenfeetemptbl_stmt.executeQuery(CEXP_betweenfeetemptbl_query);
//            var CEXP_betweentemptblname="";
//            while(CEXP_betweenfeetemptblres.next())
//            {
//                CEXP_betweentemptblname=CEXP_betweenfeetemptblres.getString(1);
//            }
//            CEXP_betweenfeetemptblres.close();
//            CEXP_betweenfeetemptbl_stmt.close();
//            var CEXP_alldata_between_stmt = CEXP_conn.createStatement();
//            var CEXP_expiryquery="SELECT UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,"+timeZoneFormat+"),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP from  "+CEXP_betweentemptblname+""
//      var CEXP_expirylist_rs = CEXP_alldata_between_stmt.executeQuery(CEXP_expiryquery);
//      var tablename=CEXP_betweentemptblname;
//    }
//        while(CEXP_expirylist_rs.next())
//        {
//            var CEXP_unitno = CEXP_expirylist_rs.getString("UNITNO");
//            var CEXP_firstname = CEXP_expirylist_rs.getString("CUSTOMERFIRSTNAME");
//            var CEXP_lastname = CEXP_expirylist_rs.getString("CUSTOMERLASTNAME");
//            var CEXP_startdate = CEXP_expirylist_rs.getString("STARTDATE");
//            var CEXP_enddate = CEXP_expirylist_rs.getString("ENDDATE");
//            var CEXP_deposit = CEXP_expirylist_rs.getString("DEPOSIT");
//            if(CEXP_deposit==null){ CEXP_deposit=""; }
//            var CEXP_rental = CEXP_expirylist_rs.getString("PAYMENT");
//            var CEXP_processingfee = CEXP_expirylist_rs.getString("PROCESSINGFEE");
//            if(CEXP_processingfee==null){ CEXP_processingfee=""; }
//            var CEXP_roomtype = CEXP_expirylist_rs.getString("ROOMTYPE");
//            var CEXP_extension= CEXP_expirylist_rs.getString("EXTENSIONFLAG");
//            if(CEXP_extension==null){ CEXP_extension=""; }
//            var CEXP_rechk = CEXP_expirylist_rs.getString("RECHECKINGFLAG");
//            if(CEXP_rechk==null){ CEXP_rechk=""; }
//            var CEXP_comments = CEXP_expirylist_rs.getString("COMMENTS");
//            if(CEXP_comments==null){ CEXP_comments=""; }
//            var CEXP_userstamp = CEXP_expirylist_rs.getString("USERSTAMP");
//            var CEXP_timestamp = (CEXP_expirylist_rs.getString("EXPIRY_TIMESTAMP"))
//      var CEXP_preterminatedate = CEXP_expirylist_rs.getString("PRETERMINATEDATE");
//      if(CEXP_preterminatedate==null){ CEXP_preterminatedate=""; }
//      var CEXP_expiry_result={'unitno':CEXP_unitno,'firstname':CEXP_firstname,'lastname':CEXP_lastname,'roomtype':CEXP_roomtype,'extension':CEXP_extension,'rechecking':CEXP_rechk,'rental':CEXP_rental,'comments':CEXP_comments,'userstamp':CEXP_userstamp,'timestamp':CEXP_timestamp,'startdate':CEXP_startdate,'enddate':CEXP_enddate,'preterminatedate':CEXP_preterminatedate,'deposit':CEXP_deposit}
//      CEXP_final_expiry_result.push(CEXP_expiry_result)
//    }
//        CEXP_droptemptable(CEXP_conn,tablename)
//    CEXP_conn.close();
//    return CEXP_final_expiry_result
//  }
} 