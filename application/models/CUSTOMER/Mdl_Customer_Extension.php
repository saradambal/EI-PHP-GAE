<?php




class Mdl_Customer_Extension extends CI_Model{
    //FUNCTION TO GET ALL EXTENSION UNIT NOS
    public  function CEXTN_getExtnUnitNo()
    {
        $CEXTN_extndtsarray =[];
        $this->db->select("UNIT_NO");
        $this->db->from('VW_EXTENSION_CUSTOMER');
        $this->db->order_by('UNIT_NO');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $CEXTN_extndtsarray[]=$row['UNIT_NO'];

        }
    return $CEXTN_extndtsarray;
    }
    //FUNCTION TO GET CUSTOMER NAME N CUSTOMER ID
    public function CEXTN_getCustomerNameId($CEXTN_lb_unitno)
  {
      $CEXTN_extndtsarray =[];
      $CEXTN_customeridarray =[];
      $CEXTN_customernamearray=[];
      $this->db->select("CUSTOMER_ID,CUSTOMERNAME");
      $this->db->from('VW_EXTENSION_CUSTOMER');
      $this->db->where('UNIT_NO=', $CEXTN_lb_unitno);
      $this->db->order_by('CUSTOMERNAME');
      $query=$this->db->get();
      foreach($query->result_array() as $row){
          $CEXTN_customeridarray[]=$row['CUSTOMER_ID'];
          $CEXTN_customernamearray[]=$row['CUSTOMERNAME'];

      }
      $CEXTN_extndtsarray=array($CEXTN_customeridarray,$CEXTN_customernamearray);
    return $CEXTN_extndtsarray;
  }
    //FUNCTION TO GET CUSTOMER DETAILS FOR THE SELECTED CUSTOMER ID
    public function CEXTN_getCustomerdtls($CEXTN_custid,$CEXTN_unitno,$UserStamp)
  {
      $CEXTN_feedtl_CallQuery="CALL SP_CUSTOMER_EXTENSION_TEMP_FEE_DETAIL($CEXTN_custid,'$UserStamp',@EXTN_FEETMPTBLNAM)";
//     echo $CEXTN_feedtl_CallQuery; exit;
      $this->db->query($CEXTN_feedtl_CallQuery);

////      $this->db->order_by('CUSTOMERNAME');
      $outparm_query = 'SELECT @EXTN_FEETMPTBLNAM AS CEXTN_FEE_TEMP_TABLE';
      $outparm_result = $this->db->query($outparm_query);

        $CExtntblname=$outparm_result->row()->CEXTN_FEE_TEMP_TABLE;
//                $this->db->select();
//        $this->db->from($temptable);
//        $query=$this->db->get();
//        foreach($query->result_array() as $row){
//            $CEXTN_customeridarray[]=$row['CUSTOMER_ID'];
//            $CEXTN_customernamearray[]=$row['CUSTOMERNAME'];
//
//        }

////
//        $this->db->query('DROP TABLE IF EXISTS '.$temptable);
////      $Confirm_query = 'SELECT @CUSTOMER_SUCCESSFLAG AS CONFIRM';
////      $Confirm_result = $this->db->query($Confirm_query);
////      $Confirm_Meessage=$Confirm_result->row()->CONFIRM;
      //READ CUST MIN RV
        $CEXTN_rv_CallQuery="CALL SP_CUSTOMER_MIN_MAX_RV($CEXTN_custid,@MIN_LP,@MAX_LP)";
//     echo $CEXTN_feedtl_CallQuery; exit;
        $this->db->query($CEXTN_rv_CallQuery);
        $CEXTN_minrv_query = 'SELECT @MIN_LP as MIN_LP';
        $CEXTN_minrv_result= $this->db->query($CEXTN_minrv_query);
        $CExtnminlpval=$CEXTN_minrv_result->row()->MIN_LP;
        $this->db->select('CED.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CPD.CPD_EMAIL,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_DOB,NC.NC_DATA,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,URTD.URTD_ROOM_TYPE,UASD.UASD_ACCESS_CARD,CTD.CLP_ENDDATE,EF.CC_AIRCON_QUARTERLY_FEE,EF.CC_AIRCON_FIXED_FEE,EF.CC_DEPOSIT,EF.CC_PAYMENT_AMOUNT,EF.CC_PROCESSING_FEE,EF.CC_ELECTRICITY_CAP,EF.CC_DRYCLEAN_FEE,EF.CC_CHECKOUT_CLEANING_FEE,CED.CED_PRORATED,CED.CED_PROCESSING_WAIVED,CED.CED_NOTICE_START_DATE,CED.CED_NOTICE_PERIOD,CPD.CPD_COMMENTS,CTD.CLP_PRETERMINATE_DATE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME');
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U,UNIT_ROOM_TYPE_DETAILS URTD,VW_EXTENSION_CUSTOMER TEC');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPA', 'CED.CED_SD_STIME = CTPA.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPB', 'CED.CED_SD_ETIME = CTPB.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPC', 'CED.CED_ED_STIME = CTPC.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPD', 'CED.CED_ED_ETIME = CTPD.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD', 'CED.CUSTOMER_ID=CCD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD', 'CED.CUSTOMER_ID=CPD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CED.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_LP_DETAILS CTD', 'CED.CUSTOMER_ID=CTD.CUSTOMER_ID' , 'left');
        $this->db->join($CExtntblname.' EF', 'CED.CUSTOMER_ID=EF.CUSTOMER_ID' , 'left');
        $this->db->where('TEC.CUSTOMER_ID=CTD.CUSTOMER_ID AND CPD.NC_ID=NC.NC_ID AND UASD.UASD_ID=CED.UASD_ID AND UASD.URTD_ID=URTD.URTD_ID AND U.UNIT_ID=UASD.UNIT_ID AND CED.UNIT_ID=U.UNIT_ID AND CTD.CED_REC_VER=CED.CED_REC_VER AND C.CUSTOMER_ID='.$CEXTN_custid." AND CED.CED_REC_VER =TEC.CED_REC_VER AND CED.CED_REC_VER=EF.CUSTOMER_VER AND CTD.CLP_TERMINATE IS NULL AND CTD.CLP_GUEST_CARD IS NULL AND U.UNIT_NO=".$CEXTN_unitno);
        $this->db->order_by('CED.CED_REC_VER');
        $CEXTN_custdtls_query = $this->db->get();
        foreach($CEXTN_custdtls_query->result_array() as $row){
            $CEXTN_currentcheckoutdate="";
        $CEXTN_customerrecver=$row["CED_REC_VER"];
        $CEXTN_customerrecver=intval($CEXTN_customerrecver)+1;
            $this->db->select("CLP_STARTDATE");
            $this->db->from('CUSTOMER_LP_DETAILS');
            $this->db->where('CUSTOMER_ID='.$CEXTN_custid.' AND CED_REC_VER='.$CEXTN_customerrecver.' AND IF (CLP_PRETERMINATE_DATE IS NOT NULL ,CLP_PRETERMINATE_DATE>CURDATE(),CLP_ENDDATE>CURDATE())');
//            $this->db->order_by('CUSTOMERNAME');
            $CEXTN_custrvquery=$this->db->get();
            foreach($CEXTN_custrvquery->result_array() as $CEXTN_custrvres){
                $CEXTN_currentcheckoutdate=$CEXTN_custrvres['CLP_STARTDATE'];
            }

      $CEXTN_firstname=$row["CUSTOMER_FIRST_NAME"];
      $CEXTN_lastname=$row["CUSTOMER_LAST_NAME"];
      $CEXTN_compname=$row["CCD_COMPANY_NAME"];
      if($CEXTN_compname==null)
      {
          $CEXTN_compname="";
      }
      $CEXTN_compaddr=$row["CCD_COMPANY_ADDR"];
      if($CEXTN_compaddr==null)
      {
          $CEXTN_compaddr="";
      }
      $CEXTN_comppostcode=$row["CCD_POSTAL_CODE"];
      if($CEXTN_comppostcode==null)
      {
          $CEXTN_comppostcode="";
      }
      $CEXTN_email=$row["CPD_EMAIL"];
      $CEXTN_mobile=$row["CPD_MOBILE"];
      if($CEXTN_mobile==null)
      {
          $CEXTN_mobile="";
      }
      $CEXTN_intlmobile=$row["CPD_INTL_MOBILE"];
      if($CEXTN_intlmobile==null)
      {
          $CEXTN_intlmobile="";
      }
      $CEXTN_compofficeno=$row["CCD_OFFICE_NO"];
      if($CEXTN_compofficeno==null)
      {
          $CEXTN_compofficeno="";
      }
      $CEXTN_dob=$row["CPD_DOB"];
      if($CEXTN_dob==null)
      {
          $CEXTN_dob="";
      }
      $CEXTN_nation=$row["NC_DATA"];
      $CEXTN_passno=$row["CPD_PASSPORT_NO"];
      if($CEXTN_passno==null)
      {
          $CEXTN_passno="";
      }
      $CEXTN_passdate=$row["CPD_PASSPORT_DATE"];
      if($CEXTN_passdate==null)
      {
          $CEXTN_passdate="";
      }
      $CEXTN_epno=$row["CPD_EP_NO"];
      if($CEXTN_epno==null)
      {
          $CEXTN_epno="";
      }
      $CEXTN_epdate=$row["CPD_EP_DATE"];
      if($CEXTN_epdate==null)
      {
          $CEXTN_epdate="";
      }
      $CEXTN_rmtype=$row["URTD_ROOM_TYPE"];
      $CEXTN_custcard=$row["UASD_ACCESS_CARD"];
      //GET PREV CHECK IN DATE
            $CEXTN_prev_chkindate_query = 'SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS CTD,CUSTOMER_ENTRY_DETAILS CED WHERE CED.CED_REC_VER=CTD.CED_REC_VER AND CED.CUSTOMER_ID = CTD.CUSTOMER_ID AND CED.CED_REC_VER=(SELECT CED_REC_VER FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID='.$CEXTN_custid.' AND CLP_TERMINATE IS NULL AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_STARTDATE<CLP_PRETERMINATE_DATE,CLP_STARTDATE<CLP_ENDDATE) AND CED_REC_VER='.$CExtnminlpval.' AND CLP_GUEST_CARD IS NULL) AND CED.CUSTOMER_ID='.$CEXTN_custid.' AND CTD.CLP_GUEST_CARD IS NULL';
            $CEXTN_prev_chkindate_result= $this->db->query($CEXTN_prev_chkindate_query);
//            $CExtnminlpval=$CEXTN_minrv_result->row()->MIN_LP;
//            $this->db->select("CLP_STARTDATE");
//            $this->db->from('CUSTOMER_LP_DETAILS CTD,CUSTOMER_ENTRY_DETAILS CED');
//            $this->db->where('CED.CED_REC_VER=CTD.CED_REC_VER AND CED.CUSTOMER_ID = CTD.CUSTOMER_ID AND CED.CED_REC_VER=(SELECT CED_REC_VER FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID='.$CEXTN_custid.' AND CLP_TERMINATE IS NULL AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_STARTDATE<CLP_PRETERMINATE_DATE,CLP_STARTDATE<CLP_ENDDATE) AND CED_REC_VER='.$CExtnminlpval.' AND CLP_GUEST_CARD IS NULL) AND CED.CUSTOMER_ID='.$CEXTN_custid.' AND CTD.CLP_GUEST_CARD IS NULL');
//////            $this->db->order_by('CUSTOMERNAME');
//            $CEXTN_custminrvquery=$this->db->get();
//            print_r($CEXTN_prev_chkindate_result->result_array());exit;
            foreach($CEXTN_prev_chkindate_result->result_array() as $CEXTN_prev_chkindate_res){
                $CEXTN_chkindate=$CEXTN_prev_chkindate_res['CLP_STARTDATE'];
            }
//      $CEXTN_custminrvquery="SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS CTD,CUSTOMER_ENTRY_DETAILS CED WHERE CED.CED_REC_VER=CTD.CED_REC_VER AND CED.CUSTOMER_ID = CTD.CUSTOMER_ID AND CED.CED_REC_VER=(SELECT CED_REC_VER FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID="+CEXTN_custid+" AND CLP_TERMINATE IS NULL AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_STARTDATE<CLP_PRETERMINATE_DATE,CLP_STARTDATE<CLP_ENDDATE) AND CED_REC_VER="+CExtnminlpval+" AND CLP_GUEST_CARD IS NULL)AND CED.CUSTOMER_ID="+CEXTN_custid+" AND CTD.CLP_GUEST_CARD IS NULL";
//
//      $CEXTN_custminrvres = CEXTN_custminrvstmt.executeQuery(CEXTN_custminrvquery);
//      while(CEXTN_custminrvres.next())
//      {
//          $CEXTN_chkindate=CEXTN_custminrvres.getString("CLP_STARTDATE"];
//      }
//            echo $CEXTN_chkindate;exit;
      $CEXTN_chkoutdate=$row["CLP_ENDDATE"];
      $CEXTN_airconfee="";
      $CEXTN_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
      if($CEXTN_airconquartelyfee==null)
      {
          $CEXTN_airconquartelyfee="";
      }
      $CEXTN_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
      if($CEXTN_airconfixedfee==null)
      {
          $CEXTN_airconfixedfee="";
      }
      $CEXTN_deposit = $row["CC_DEPOSIT"];
      if($CEXTN_deposit==null)
      {
          $CEXTN_deposit="";
      }
      $CEXTN_rental = $row["CC_PAYMENT_AMOUNT"];
      $CEXTN_processingfee = $row["CC_PROCESSING_FEE"];
      if($CEXTN_processingfee==null)
      {
          $CEXTN_processingfee="";
      }
      $CEXTN_electricitycap = $row["CC_ELECTRICITY_CAP"];
      if($CEXTN_electricitycap==null)
      {
          $CEXTN_electricitycap="";
      }
      $CEXTN_drycleanfee = $row["CC_DRYCLEAN_FEE"];
      if($CEXTN_drycleanfee==null)
      {
          $CEXTN_drycleanfee="";
      }
      $CEXTN_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
      if($CEXTN_checkoutcleaningfee==null)
      {
          $CEXTN_checkoutcleaningfee="";
      }
      $CEXTN_prorated = $row["CED_PRORATED"];
      if($CEXTN_prorated==null)
      {
          $CEXTN_prorated="";
      }
      $CEXTN_waived = $row["CED_PROCESSING_WAIVED"];
      if($CEXTN_waived==null)
      {
          $CEXTN_waived="";
      }
      $CEXTN_noticedate= $row["CED_NOTICE_START_DATE"];
      if($CEXTN_noticedate==null)
      {
          $CEXTN_noticedate="";
      }
      $CEXTN_stfrmtime=$row["CED_SD_STIME"];
      $CEXTN_sttotime=$row["CED_SD_ETIME"];
      $CEXTN_edfrmtime=$row["CED_ED_STIME"];
      $CEXTN_edtotime=$row["CED_ED_ETIME"];
      $CEXTN_noticeperiod=$row["CED_NOTICE_PERIOD"];
      $CEXTN_comments=$row["CPD_COMMENTS"];
      if($CEXTN_comments==null)
      {
          $CEXTN_comments="";
      }
      if($CEXTN_noticeperiod==null)
      {
          $CEXTN_noticeperiod="";
      }
      $CEXTN_preterminatedate = $row["CLP_PRETERMINATE_DATE"];
//            echo $CEXTN_preterminatedate;exit;
      if($CEXTN_preterminatedate==null){ $CEXTN_preterminatedate=""; }
//            array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
      $CEXTN_custdtls=array("cust_firstname"=>$CEXTN_firstname,"cust_lastname"=>$CEXTN_lastname,"cust_compname"=>$CEXTN_compname,"cust_compaddr"=>$CEXTN_compaddr,"cust_comppostcode"=>$CEXTN_comppostcode,"cust_email"=>$CEXTN_email,"cust_mobile"=>$CEXTN_mobile,"cust_intlmobile"=>$CEXTN_intlmobile,"cust_officeno"=>$CEXTN_compofficeno,"cust_dob"=>$CEXTN_dob,"cust_nation"=>$CEXTN_nation,"cust_passno"=>$CEXTN_passno,"cust_passdate"=>$CEXTN_passdate,"cust_epno"=>$CEXTN_epno,"cust_epdate"=>$CEXTN_epdate,"cust_rmtype"=>$CEXTN_rmtype,"cust_chkindate"=>$CEXTN_chkindate,"cust_chkoutdate"=>$CEXTN_chkoutdate,"cust_airconquarterfee"=>$CEXTN_airconquartelyfee,"cust_airconfixedfee"=>$CEXTN_airconfixedfee,"cust_deposit"=>$CEXTN_deposit,"cust_rental"=>$CEXTN_rental,"cust_procfee"=>$CEXTN_processingfee,"cust_electcapfee"=>$CEXTN_electricitycap,"cust_dryclean"=>$CEXTN_drycleanfee,"cust_chkoutfee"=>$CEXTN_checkoutcleaningfee,"cust_prorated"=>$CEXTN_prorated,"cust_waived"=>$CEXTN_waived,"cust_noticedate"=>$CEXTN_noticedate,"cust_stfrmtime"=>$CEXTN_stfrmtime,"cust_sttotime"=>$CEXTN_sttotime,"cust_edfrmtime"=>$CEXTN_edfrmtime,"cust_edtotime"=>$CEXTN_edtotime,"cust_noticeperiod"=>$CEXTN_noticeperiod,"cust_preterminatedate"=>$CEXTN_preterminatedate,"cust_comts"=>$CEXTN_comments);
      }

    //GET CUSTOMER CARDS
    $CEXTN_cardarray =array();
    $CEXTN_custcardquery= "SELECT UASD.UASD_ACCESS_CARD,CTD.CLP_GUEST_CARD,CTD.CLP_PRETERMINATE_DATE FROM UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U,CUSTOMER C,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER_LP_DETAILS CTD,CUSTOMER_ACCESS_CARD_DETAILS CACD,VW_EXTENSION_CUSTOMER TEC WHERE TEC.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CED_REC_VER =TEC.CED_REC_VER AND CACD.CUSTOMER_ID=CTD.CUSTOMER_ID AND CTD.UASD_ID=CACD.UASD_ID AND CACD.ACN_ID IS NULL AND UASD.UASD_ID=CACD.UASD_ID AND UASD.UASD_ID=CTD.UASD_ID AND CED.CED_REC_VER=CTD.CED_REC_VER AND CTD.CLP_TERMINATE IS NULL AND C.CUSTOMER_ID=CED.CUSTOMER_ID AND C.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND U.UNIT_ID=CED.UNIT_ID  AND C.CUSTOMER_ID=".$CEXTN_custid." AND CTD.UASD_ID IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND U.UNIT_NO=".$CEXTN_unitno." ORDER BY CTD.CLP_GUEST_CARD ASC";
    $CEXTN_custcardres = $this->db->query($CEXTN_custcardquery);
    foreach($CEXTN_custcardres->result_array() as $row)
    {
        $CEXTN_cgstcard=$row["CLP_GUEST_CARD"];
        $CEXTN_cptddate=$row["CLP_PRETERMINATE_DATE"];
        $CEXTN_custcard=$row["UASD_ACCESS_CARD"];
      if(($CEXTN_cptddate==null&&$CEXTN_cgstcard!=null)||($CEXTN_cgstcard==null))
      {
          $CEXTN_cardarray[]=($CEXTN_custcard);
      }
    }
//    CEXTN_custcardres.close();
//    CEXTN_custcardstmt.close();
//    eilib.DropTempTable(CEXTN_cdtlscon, CExtntblname);
    $CEXTN_diffunittno=array();
        $this->load->model('Eilib/Common_function');
    $CEXTN_unitdate=$this->Common_function->GetUnitSdEdate($CEXTN_unitno);//call function to get unit start n end date
     $CEXTN_unitsdate=$CEXTN_unitdate['unitsdate'];//get unit start date
    $CEXTN_unitedate=$CEXTN_unitdate['unitedate'];//get unit end date
    $CEXTN_diffunittno=$this->CEXTN_getdiffUnitNo($CEXTN_unitno);
    $CEXTN_finaldtls=array("currentcheckoutdate"=>$CEXTN_currentcheckoutdate,"custdtls"=>$CEXTN_custdtls,"cardarray"=>$CEXTN_cardarray,"unitno"=>$CEXTN_diffunittno,"unitsdate"=>$CEXTN_unitsdate,"unitedate"=>$CEXTN_unitedate);
//        $CEXTN_finaldtls=array("currentcheckoutdate"=>$CEXTN_currentcheckoutdate,"custdtls"=>$CEXTN_custdtls);
////        $CEXTN_custdtls
//        echo json_encode($CEXTN_finaldtls);
//    CEXTN_cdtlscon.close();
    return $CEXTN_finaldtls;
  }

    //FUNCTION TO GET UNIT NO EXCEPT SELECTED UNIT NO
    function CEXTN_getdiffUnitNo($CEXTN_unitno){

          $CEXTN_unoarray =array();
          $CEXTN_unoquery= "SELECT UNIT_NO FROM VW_ACTIVE_UNIT ORDER BY UNIT_NO ASC";
          $CEXTN_unores = $this->db->query($CEXTN_unoquery);
          foreach($CEXTN_unores->result_array() as $row)
          {
              $unitno=$row["UNIT_NO"];
              if($CEXTN_unitno!=$unitno)
              {
                  $CEXTN_unoarray[]=($unitno);
              }
          }
          return $CEXTN_unoarray;

    }


}