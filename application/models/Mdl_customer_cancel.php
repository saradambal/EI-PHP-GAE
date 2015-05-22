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

    //*************************** FUNCTION TO GET CUSTOMER DETAIL'S*****************************************************//
    public function CCAN_get_customervalues($id,$CCAN_select_type,$CCAN_recver,$USERSTAMP)
  {
      $CCAN_custid=$id;
      $CCAN_guest_array=array();
    $CCAN_select_roomtype=$this->db->query('SELECT URTD.URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED WHERE (CED.CUSTOMER_ID='.$CCAN_custid.') AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID) AND(CED.CED_REC_VER='.$CCAN_recver.')');
        $CCAN_roomtype = $CCAN_select_roomtype->row()->URTD_ROOM_TYPE;
        $callquery="CALL SP_CUSTOMER_CANCEL_TEMP_FEE_DETAIL(".$CCAN_custid.",'".$USERSTAMP."',@CCAN_FEETMPTBLNAM)";
        $this->db->query($callquery);
        $CCAN_feetemptbl_query = 'SELECT @CCAN_FEETMPTBLNAM AS TEMP_TABLE';
        $outparm_result = $this->db->query($CCAN_feetemptbl_query);
        $CCAN_temptblname=$outparm_result->row()->TEMP_TABLE;
    if($CCAN_select_type=="CANCEL CUSTOMER"){
        $this->db->select();
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC ,UNIT U');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD',' CED.CUSTOMER_ID=CCD.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_LP_DETAILS CLP','CED.CUSTOMER_ID=CLP.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD','CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID','left');
        $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','UASD.UASD_ID=CACD.UASD_ID','left');
        $this->db->join($CCAN_temptblname.' CF','CED.CUSTOMER_ID=CF.CUSTOMER_ID','left');
         $this->db->join('CUSTOMER C','CED.CUSTOMER_ID=C.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD','CED.CUSTOMER_ID=CPD.CUSTOMER_ID','left');
        $this->db->where('(CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CCAN_custid.') and (CPD.NC_ID=NC.NC_ID) and (CLP.CLP_TERMINATE IS NULL) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and (CED.CED_REC_VER='.$CCAN_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
        $this->db->order_by('CED.CED_REC_VER');


//        $CCAN_alldata=$this->db->query("SELECT  * FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CLP on CED.CUSTOMER_ID=CLP.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CLP.UASD_ID=CACD.UASD_ID)left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID) left join ".$CCAN_temptblname." CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U  where   (CED.UNIT_ID=U.UNIT_ID)AND (CED.CUSTOMER_ID=".$CCAN_custid.") and(CPD.NC_ID=NC.NC_ID)and(CLP.CLP_TERMINATE is null) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and(CED.CED_REC_VER=".$CCAN_recver.") AND CED.CED_REC_VER=CLP.CED_REC_VER order by CED.CED_REC_VER ");


    }
    if($CCAN_select_type=="UNCANCEL CUSTOMER"){
        $this->db->select();
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC ,UNIT U');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD',' CED.CUSTOMER_ID=CCD.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_LP_DETAILS CLP','CED.CUSTOMER_ID=CLP.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD','CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID AND CACD.ACN_ID IS NULL','left');
        $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','UASD.UASD_ID=CACD.UASD_ID','left');
        $this->db->join($CCAN_temptblname.' CF','CED.CUSTOMER_ID=CF.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER C','CED.CUSTOMER_ID=C.CUSTOMER_ID','left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD','CED.CUSTOMER_ID=CPD.CUSTOMER_ID','left');
        $this->db->where('(CED.UNIT_ID=U.UNIT_ID)AND (CED.CUSTOMER_ID='.$CCAN_custid.') and(CPD.NC_ID=NC.NC_ID)and(CLP.CLP_TERMINATE is null) and  (CED.CED_REC_VER=CF.CUSTOMER_VER) and (CED.CED_CANCEL_DATE is not null)  and(CED.CED_REC_VER='.$CCAN_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
        $this->db->order_by('CED.CED_REC_VER');
     }
    $CCAN_alldata=$this->db->get();

    foreach($CCAN_alldata->result_array() as $row){
        $CCAN_cardno='';
        $CCAN_cardno2 = $row["UASD_ACCESS_CARD"];
        if($CCAN_cardno2!=null)
        {
            $CCAN_guest = $row["CLP_GUEST_CARD"];
            if($CCAN_guest!='X')
            {
                $CCAN_cardno = $row["UASD_ACCESS_CARD"];
                $CCAN_startdate = $row["CLP_STARTDATE"];
                $CCAN_enddate = $row["CLP_ENDDATE"];
            }
            else
            {
                $CCAN_cardno1 = $row["UASD_ACCESS_CARD"];
                $CCAN_guest_array[]=($CCAN_cardno1);
            }
        }
        else{
            $CCAN_startdate = $row["CLP_STARTDATE"];
            $CCAN_enddate = $row["CLP_ENDDATE"];
        }
        $CCAN_company = $row["CCD_COMPANY_NAME"];
        $CCAN_firstname = $row["CUSTOMER_FIRST_NAME"];
        $CCAN_lastname = $row["CUSTOMER_LAST_NAME"];
        $CCAN_deposit = $row["CC_DEPOSIT"];
        $CCAN_rental = $row["CC_PAYMENT_AMOUNT"];
        $CCAN_electricitycap = $row["CC_ELECTRICITY_CAP"];
        $CCAN_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
        $CCAN_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
        $CCAN_epno = $row["CPD_EP_NO"];
        $CCAN_epdate = $row["CPD_EP_DATE"];
        $CCAN_passportno = $row["CPD_PASSPORT_NO"];
        $CCAN_passportdate = $row["CPD_PASSPORT_DATE"];
        $CCAN_drycleanfee = $row["CC_DRYCLEAN_FEE"];
        $CCAN_processingfee = $row["CC_PROCESSING_FEE"];
        $CCAN_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
        $CCAN_noticeperiod = $row["CED_NOTICE_PERIOD"];
        $CCAN_noticedate = $row["CED_NOTICE_START_DATE"];
        $CCAN_nationality = $row["NC_DATA"];
        $CCAN_dob= $row["CPD_DOB"];
        $CCAN_lease=$row["CED_LEASE_PERIOD"];
        $CCAN_mobile = $row["CPD_MOBILE"];
        $CCAN_mobile1 = $row["CPD_INTL_MOBILE"];
        $CCAN_officeno = $row["CCD_OFFICE_NO"];
        $CCAN_email = $row["CPD_EMAIL"];
        $CCAN_extension= $row["CED_EXTENSION"];
        $CCAN_redver = $row["CED_REC_VER"];
        $CCAN_canceldate = $row["CED_CANCEL_DATE"];
        $CCAN_comments = $row["CPD_COMMENTS"];
        $CCAN_QUARTERS=$row["CED_QUARTERS"];
    }
    $values_array=(object)['firstname'=>$CCAN_firstname,'lastname'=>$CCAN_lastname,'email'=>$CCAN_email,'mobile1'=>$CCAN_mobile,'mobile2'=>$CCAN_mobile1,'officeno'=>$CCAN_officeno,'dob'=>$CCAN_dob,'passportno'=>$CCAN_passportno,'passportdate'=>$CCAN_passportdate,'epno'=>$CCAN_epno,'epdate'=>$CCAN_epdate,'roomtype'=>$CCAN_roomtype,'cardno'=>$CCAN_cardno,'startdate'=>$CCAN_startdate,'enddate'=>$CCAN_enddate,'lease'=>$CCAN_lease,'QUARTERS'=>$CCAN_QUARTERS,'noticeperiod'=>$CCAN_noticeperiod,'noticedate'=>$CCAN_noticedate,'electricitycap'=>$CCAN_electricitycap,'drycleanfee'=>$CCAN_drycleanfee,'checkoutcleaningfee'=>$CCAN_checkoutcleaningfee,'deposit'=>$CCAN_deposit,'rental'=>$CCAN_rental,'processingfee'=>$CCAN_processingfee,'comments'=>$CCAN_comments,'company'=>$CCAN_company,'nationality'=>$CCAN_nationality,'airconfixedfee'=>$CCAN_airconfixedfee,'airconquartelyfee'=>$CCAN_airconquartelyfee];
        $CCAN_guest_array=array_values(array_unique($CCAN_guest_array));
    $CCAN_data_array=array();
    $CCAN_data_array[]=($values_array);
    $CCAN_data_array[]=($CCAN_guest_array);
        $drop_query = "DROP TABLE ".$CCAN_temptblname;
        $this->db->query($drop_query);
        return $CCAN_data_array;
  }

//    Function to cancel customer
    public function CCAN_cancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments)
  {
      try{
//          $CCAN_unit_value=$_POST['CCAN_unitnumber'];
//          $CCAN_firstname = $_POST['CCAN_tb_firstname'];
//          $CCAN_lastname  = $_POST['CCAN_tb_lastname'];
          $CCAN_comments_fetch = $CCAN_ta_comments;
          $card_array=array();
          $CCAN_custid=$custid;
          $CCAN_rec_ver=$recver;
          $CCAN_userStamp=$UserStamp;
           if($CCAN_comments_fetch!=''){
               $CCAN_comments_fetch=$this->db->escape_like_str($CCAN_comments_fetch);
           }
          $type="CANCEL";


//    CCAN_conn.setAutoCommit(false);

    $CCAN_save=("CALL SP_CUSTOMER_CANCEL_INSERT(".$CCAN_custid.",".$CCAN_rec_ver.",'".$UserStamp."','".$CCAN_comments_fetch."',@cancel_temptable1,@cancel_temptable2,@cancel_flag)");

   $this->db->query($CCAN_save);
    $CCAN_getresult=("SELECT @cancel_temptable1 as cancel_temptable1,@cancel_temptable2 as cancel_temptable2,@cancel_flag as cancel_flag");
    $CCAN_getresult_rs = $this->db->query($CCAN_getresult);
                $CCAN_temptable1=$CCAN_getresult_rs->row()->cancel_temptable1;
                $CCAN_temptable2=$CCAN_getresult_rs->row()->cancel_temptable2;
          $CCAN_chkcancelflag=$CCAN_getresult_rs->row()->cancel_flag;

     if($CCAN_chkcancelflag==1){
         $CCAN_customerevent=$this->db->query("SELECT CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME ,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE FROM CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID ,CUSTOMER_LP_DETAILS CLP  WHERE    (CED.CUSTOMER_ID=".$CCAN_custid.")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) and CED.CED_REC_VER>=".$CCAN_rec_ver." AND CLP.CLP_TERMINATE IS NULL");

      foreach( $CCAN_customerevent->result_array() as $row)
      {
          $CCAN_checkin_date = $row["CLP_STARTDATE"];
          $CCAN_checkout_date = $row["CLP_ENDDATE"];
//          $CCAN_calenderIDcode= eilib.CUST_getCalenderId(CCAN_conn);
//          $CCAN_cal = CalendarApp.getCalendarsByName(CCAN_calenderIDcode)[0] ;
          $CCAN_start_time_in=$row["CED_SD_STIME"];
          $CCAN_start_time_out=$row["CED_SD_ETIME"];
          $CCAN_end_time_in=$row["CED_ED_STIME"];
          $CCAN_end_time_out=$row["CED_ED_ETIME"];
//          eilib.CUST_customercalenderdeletion(CCAN_custid,CCAN_calenderIDcode,CCAN_checkin_date,CCAN_start_time_in,CCAN_start_time_out,CCAN_checkout_date,CCAN_end_time_in,CCAN_end_time_out,"")
      }
    }
          $drop_query = "DROP TABLE ".$CCAN_temptable1;
          $this->db->query($drop_query);
          $drop_query = "DROP TABLE ".$CCAN_temptable2;
          $this->db->query($drop_query);
          $this->db->trans_commit();
//     eilib.DropTempTable(CCAN_conn,CCAN_temptable1)
//     eilib.DropTempTable(CCAN_conn,CCAN_temptable2)
//      CCAN_conn.commit();
//       CCAN_conn.close();
    return $CCAN_chkcancelflag;
    }
      catch(Exception $err){

//          CCAN_finalconn.rollback();
//          eilib.DropTempTable(CCAN_finalconn,CCAN_temptable1)
//      eilib.DropTempTable(CCAN_finalconn,CCAN_temptable2)
//      Logger.log(err)
//      return Logger.getLog();

    }
  }
//    //Function to Uncancel customer
//    function CCAN_uncancel(uncancelform){
//        try{
//            $CCAN_unit_value=uncancelform.CCAN_unitnumber;
//            $CCAN_firstname = uncancelform.CCAN_tb_firstname;
//            $CCAN_lastname  = uncancelform.CCAN_tb_lastname;
//            $CCAN_comments_fetch = uncancelform.CCAN_ta_comments;
//            $CCAN_roomType=uncancelform.CCAN_tb_roomtype;
//            $CCAN_custid=PropertiesService.getUserProperties().getProperty('CCAN_custid');
//            $CCAN_rec_ver=PropertiesService.getUserProperties().getProperty('CCAN_rec_ver')
//    $CCAN_userStamp=UserStamp;
//    $CCAN_conn = eilib.db_GetConnection();
//       CCAN_conn.setAutoCommit(false);
//    $CCAN_customerevent="SELECT  URTD.URTD_ROOM_TYPE,U.UNIT_NO,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CLP,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U  WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID="+CCAN_custid+")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NOT NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)and CED.CED_REC_VER>="+CCAN_rec_ver+" order by CED.CED_REC_VER"
//    $CCAN_custevent_stmt = CCAN_conn.createStatement();
//    $CCAN_custeventrs = CCAN_custevent_stmt.executeQuery(CCAN_customerevent);
//    $count=0;
//    $type='UNCANCEL'
//    $lease_period_array=[];
//    $quaters_array=[];
//    $recver_array=[];
//    $cancel_date_array=[]
//    $unit_no_array=[];
//    while( CCAN_custeventrs.next())
//    {
//        $CCAN_checkin_date = $row["CLP_STARTDATE");
//        $CCAN_checkout_date = $row["CLP_ENDDATE");
//        $recver=$row["CED_REC_VER");
//        $CCAN_sdate=CCAN_checkin_date.split('-');
//        $CCAN_edate=CCAN_checkout_date.split('-');
//        $CCAN_Leaseperiod  = eilib.leasePeriodCalc(new Date(CCAN_sdate[0],CCAN_sdate[1]-1,CCAN_sdate[2]),new Date(CCAN_edate[0],CCAN_edate[1]-1,CCAN_edate[2]));
//      $CCAN_quators  = eilib.quarterCalc(new Date(CCAN_sdate[0],CCAN_sdate[1]-1,CCAN_sdate[2]),new Date(CCAN_edate[0],CCAN_edate[1]-1,CCAN_edate[2]));
//      lease_period_array.push(CCAN_Leaseperiod)
//      quaters_array.push(CCAN_quators)
//      recver_array.push(recver)
//    }
//    $lease_quaters=''
//    for($k=0;k<recver_array.length;k++){
//                lease_quaters+=recver_array[k]+',&'+lease_period_array[k]+',&'+quaters_array[k]
//      if(k==recver_array.length-1)break;
//      lease_quaters+=',&';
//    }
//     if(CCAN_comments_fetch!=''){
//         CCAN_comments_fetch=eilib.ConvertSpclCharString(CCAN_comments_fetch)
//    }
//    $CCAN_save_stmt=CCAN_conn.createStatement();
//    CCAN_save_stmt.execute("CALL SP_CUSTOMER_UNCANCEL_INSERT("+CCAN_custid+","+CCAN_rec_ver+",'"+CCAN_comments_fetch+"','"+lease_quaters+"','"+UserStamp+"',@uncancel_temptable1,@uncancel_temptable2,@uncancel_temptable3,@uncancel_temptable4,@uncancel_flag)")
//    CCAN_save_stmt.close();
//    $CCAN_return_flag_stmt=CCAN_conn.createStatement();
//    $CCAN_getresult= CCAN_return_flag_stmt.executeQuery("SELECT @uncancel_temptable1,@uncancel_temptable2,@uncancel_temptable3,@uncancel_temptable4,@uncancel_flag");
//    while(CCAN_getresult.next()){
//        CCAN_uncancel_temptable1=CCAN_getresult.getString("@uncancel_temptable1");
//        CCAN_uncancel_temptable2=CCAN_getresult.getString("@uncancel_temptable2");
//        CCAN_uncancel_temptable3=CCAN_getresult.getString("@uncancel_temptable3");
//        CCAN_uncancel_temptable4=CCAN_getresult.getString("@uncancel_temptable4");
//        $CCAN_chkuncancelflag=CCAN_getresult.getString("@uncancel_flag");
//    }
//       if(CCAN_chkuncancelflag==1){
//           $CCAN_customerevent="SELECT  URTD.URTD_ROOM_TYPE,U.UNIT_NO,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CLP,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U  WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID="+CCAN_custid+")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS   NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)and CED.CED_REC_VER>="+CCAN_rec_ver+" order by CED.CED_REC_VER"
//        $CCAN_custevent_stmt = CCAN_conn.createStatement();
//        $CCAN_custeventrs = CCAN_custevent_stmt.executeQuery(CCAN_customerevent);
//        $count=0;
//        $type='UNCANCEL'
//        $cancel_date_array=[]
//        $unit_no_array=[];
//        while( CCAN_custeventrs.next())
//        {
//            count++;
//            $CCAN_checkin_date = $row["CLP_STARTDATE");
//            $CCAN_checkout_date = $row["CLP_ENDDATE");
//            $recver=$row["CED_REC_VER");
//            $CCAN_calenderIDcode= eilib.CUST_getCalenderId(CCAN_conn);
//            $CCAN_cal = CalendarApp.getCalendarsByName(CCAN_calenderIDcode)[0] ;
//            $CCAN_CANCEL_date=$row["CED_CANCEL_DATE");
//            cancel_date_array.push(CCAN_CANCEL_date)
//          $CCAN_start_time_in=$row["CED_SD_STIME");
//          $CCAN_start_time_out=$row["CED_SD_ETIME");
//          $CCAN_end_time_in=$row["CED_ED_STIME");
//          $CCAN_end_time_out=$row["CED_ED_ETIME");
//          $CCAN_mobile=$row["CPD_MOBILE");
//          $CCAN_intmoblie=$row["CPD_INTL_MOBILE");
//          $CCAN_office=$row["CCD_OFFICE_NO");
//          $CCAN_emailid=$row["CPD_EMAIL");
//          $CCAN_unitno=$row["UNIT_NO");
//          unit_no_array.push(CCAN_unitno)
//          $CCAN_roomtype=$row["URTD_ROOM_TYPE");
//          if(CCAN_unitno==CCAN_unit_value && CCAN_roomtype==CCAN_roomType){
//              if(count==1){
//                  eilib.CUST_customercalendercreation(CCAN_custid, CCAN_calenderIDcode, CCAN_checkin_date, CCAN_start_time_in, CCAN_start_time_out, CCAN_checkout_date, CCAN_end_time_in, CCAN_end_time_out, CCAN_firstname, CCAN_lastname, CCAN_mobile, CCAN_intmoblie, CCAN_office, CCAN_emailid, CCAN_unitno, CCAN_roomtype,"")
//              eilib.CUST_customercalenderdeletion(CCAN_custid,CCAN_calenderIDcode,"","","",CCAN_checkout_date,CCAN_end_time_in,CCAN_end_time_out,type)
//            }
//              else{
//                  eilib.CUST_customercalendercreation(CCAN_custid, CCAN_calenderIDcode, CCAN_checkin_date, CCAN_start_time_in, CCAN_start_time_out, CCAN_checkout_date, CCAN_end_time_in, CCAN_end_time_out, CCAN_firstname, CCAN_lastname, CCAN_mobile, CCAN_intmoblie, CCAN_office, CCAN_emailid, CCAN_unitno, CCAN_roomtype,"")
//              eilib.CUST_customercalenderdeletion(CCAN_custid,CCAN_calenderIDcode,CCAN_checkin_date,CCAN_start_time_in,CCAN_start_time_out,"","","",type)
//            }
//          }
//          if(CCAN_roomtype!=CCAN_roomType&&CCAN_unitno==CCAN_unit_value){
//              $CCAN_custunittype="DIFF RM";
//              eilib.CUST_customercalenderdeletion(CCAN_custid,CCAN_calenderIDcode,CCAN_checkin_date,CCAN_start_time_in,CCAN_start_time_out,"","","",type)
//            eilib.CUST_customercalendercreation(CCAN_custid, CCAN_calenderIDcode, CCAN_checkin_date, CCAN_start_time_in, CCAN_start_time_out, CCAN_checkout_date, CCAN_end_time_in, CCAN_end_time_out, CCAN_firstname, CCAN_lastname, CCAN_mobile, CCAN_intmoblie, CCAN_office, CCAN_emailid, CCAN_unitno, CCAN_roomtype, CCAN_custunittype)
//          }
//          if(CCAN_unitno!=CCAN_unit_value){
//              $CCAN_custunittype="DIFF UNIT";
//              eilib.CUST_customercalenderdeletion(CCAN_custid,CCAN_calenderIDcode,CCAN_checkin_date,CCAN_start_time_in,CCAN_start_time_out,"","","",type)
//            eilib.CUST_customercalendercreation(CCAN_custid, CCAN_calenderIDcode, CCAN_checkin_date, CCAN_start_time_in, CCAN_start_time_out, CCAN_checkout_date, CCAN_end_time_in, CCAN_end_time_out, CCAN_firstname, CCAN_lastname, CCAN_mobile, CCAN_intmoblie, CCAN_office, CCAN_emailid, CCAN_unitno, CCAN_roomtype, CCAN_custunittype)
//          }
//        }
//        if(count==1){
//            eilib.CUST_customercalendercreation(CCAN_custid, CCAN_calenderIDcode, "", "", "", CCAN_checkout_date, CCAN_end_time_in, CCAN_end_time_out, CCAN_firstname, CCAN_lastname, CCAN_mobile, CCAN_intmoblie, CCAN_office, CCAN_emailid, CCAN_unitno, CCAN_roomtype,"")
//        }
//
//      }
//      if(CCAN_uncancel_temptable1!=null){
//          eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable1)
//      }
//      if(CCAN_uncancel_temptable2!=null){
//          eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable2)
//      }
//      if(CCAN_uncancel_temptable3!=null){
//          eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable3)
//      }
//      if(CCAN_uncancel_temptable4!=null){
//          eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable4)
//      }
//      CCAN_conn.commit();
//      CCAN_conn.close();
//      return CCAN_chkuncancelflag
//    }
//        catch(err){
//
//            CCAN_conn.rollback();
//            if(CCAN_uncancel_temptable1!=null){
//                eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable1)
//      }
//            if(CCAN_uncancel_temptable2!=null){
//                eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable2)
//      }
//            if(CCAN_uncancel_temptable3!=null){
//                eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable3)
//      }
//            if(CCAN_uncancel_temptable4!=null){
//                eilib.DropTempTable(CCAN_conn,CCAN_uncancel_temptable4)
//      }
//            Logger.log(err)
//      return Logger.getLog();
//
//    }
//    }


} 