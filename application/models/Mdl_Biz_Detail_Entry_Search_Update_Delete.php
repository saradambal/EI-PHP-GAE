<?php
Class Mdl_biz_detail_entry_search_update_delete extends CI_Model {

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
    public function BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types)
    {
      $BDTL_INPUT_bizexp_alltypes='';
      $BDTL_INPUT_bizexp_unitno_array = [];
      $BDTL_INPUT_twodimen=[16=>['EDAS_ID','EXPENSE_DETAIL_AIRCON_SERVICE'],17=>['EDCP_ID','EXPENSE_DETAIL_CARPARK'],15=>['EDDV_ID','EXPENSE_DETAIL_DIGITAL_VOICE'],
                             13=>['EDE_ID','EXPENSE_DETAIL_ELECTRICITY'],14=>['EDSH_ID','EXPENSE_DETAIL_STARHUB']];
    $BDTL_INPUT_expunitnumbers = "SELECT UNIT_ID,UNIT_NO FROM UNIT WHERE UNIT_ID NOT IN (SELECT UNIT_ID FROM ".$BDTL_INPUT_twodimen[$BDTL_INPUT_all_expense_types][1].") ORDER BY UNIT_NO ASC";
    $BDTL_INPUT_expense_unitno_rs = $this->db->query($BDTL_INPUT_expunitnumbers);
    foreach($BDTL_INPUT_expense_unitno_rs->result_array() as $row)
    {
        $BDTL_INPUT_bizexp_unitno_array[]=["BDTL_INPUT_obj_unitid"=>$row['UNIT_ID'],"BDTL_INPUT_obj_unitno"=>$row['UNIT_NO']];
    }
    return $BDTL_INPUT_bizexp_unitno_array;
   }
    //FUNCTION TO GET UNIT SDATE AND EDATE
    public function BDTL_INPUT_get_SDate_EDate($BDTL_INPUT_unitno)
    {
        $this->load->model('Eilib/Common_function');
        $BDTL_INPUT_getDate=$this->Common_function->GetUnitSdEdate($BDTL_INPUT_unitno);
      return  $BDTL_INPUT_getDate;
    }
    /*------------------------------------CODING TO CHECK AIRCONSERVICE BY IN TABLE------------------------------------------------------*/
    public function BDTL_INPUT_airconservicedby_check($BDTL_INPUT_alreadyexists)
    {
      $BDTL_INPUT_airconservicedby_array = [];
      $this->load->model('Eilib/Common_function');
      $BDTL_INPUT_flag=$this->Common_function->Check_ExistsAirconservicedby($BDTL_INPUT_alreadyexists);
      return $BDTL_INPUT_flag;
   }
    /*--------------------------------------FUNCTION TO CHECK WHETHER THE DATA INSERTED OR NOT---------------------------------------*/
    public function BDTL_INPUT_getmaxprimaryid($BDTL_INPUT_profile_names){
       $BDTL_INPUT_twodimen=[17=>['EDCP_ID','EXPENSE_DETAIL_CARPARK'],15=>['EDDV_ID','EXPENSE_DETAIL_DIGITAL_VOICE'],
                             13=>['EDE_ID','EXPENSE_DETAIL_ELECTRICITY'],14=>['EDSH_ID','EXPENSE_DETAIL_STARHUB']];
        $id=$BDTL_INPUT_twodimen[$BDTL_INPUT_profile_names][0];
        $from=$BDTL_INPUT_twodimen[$BDTL_INPUT_profile_names][1];
        $BDTL_INPUT_select="SELECT MAX($id) AS PRIMARY_ID FROM $from";
        $BDTL_INPUT_rs_primaryid=$this->db->query($BDTL_INPUT_select);
        $BDTL_INPUT_primaryid=$BDTL_INPUT_rs_primaryid->row()->PRIMARY_ID;
        return $BDTL_INPUT_primaryid;
  }
    /*-----------------------------CODING TO SAVE THE AIRCON DETAIL,CARPARK,ELECTRICITY,DIGITAL VOICE,STARHUB IN DATABASE----------------------------------------------------------*/
    public function BDTL_INPUT_save($USERSTAMP,$BDTL_INPUT_tb_newaircon,$calid)
     {
          $BDTL_INPUT_aircon_list_ref=[];
          $BDTL_INPUT_expensetypes =$_POST['BDTL_INPUT_lb_expense_type'];
          $BDTL_INPUT_unitno =$_POST['BDTL_INPUT_lb_unitno_list'];
          $BDTL_INPUT_unitnoaircon =$_POST['BDTL_INPUT_hidden_unitno'];
          $BDTL_INPUT_aircon_oldservice = $_POST['BDTL_INPUT_lb_airconservicedby'];
          $BDTL_INPUT_aircon_newservice = $BDTL_INPUT_tb_newaircon;
          $BDTL_INPUT_aircon_comments=$_POST['BDTL_INPUT_ta_aircon_comments'];
          $BDTL_INPUT_aircon_comments=$this->db->escape_like_str($BDTL_INPUT_aircon_comments);
          $BDTL_INPUT_carno= $_POST['BDTL_INPUT_tb_exp_carno'];
          $BDTL_INPUT_car_comments= $_POST['BDTL_INPUT_ta_carpark_comments'];
          $BDTL_INPUT_digital_invoiceto= $_POST['BDTL_INPUT_lb_digital_invoiceto'];
          $BDTL_INPUT_digital_voice= $_POST['BDTL_INPUT_tb_exp_digivoiceno'];
          $BDTL_INPUT_digital_acctno= $_POST['BDTL_INPUT_tb_exp_digiaccno'];
          $BDTL_INPUT_digital_comments=$_POST['BDTL_INPUT_ta_digitalvoice_comments'];
          $BDTL_INPUT_electricity_invoice= $_POST['BDTL_INPUT_lb_bizdetail_electricity_invoiceto'];
          $BDTL_INPUT_electricity_comments=$_POST['BDTL_INPUT_ta_ectricity_comments'];
          $BDTL_INPUT_starhub_invoiceto= $_POST['BDTL_INPUT_lb_starhub_invoiceto'];
          $BDTL_INPUT_starhub_acctno= $_POST['BDTL_INPUT_tb_starhub_account_no'];
          $BDTL_INPUT_starhub_appldate= $_POST['BDTL_INPUT_db_appl_date'];
          $BDTL_INPUT_starhub_cable_startdate= $_POST['BDTL_INPUT_db_cable_startdate'];
          $BDTL_INPUT_starhub_cable_enddate= $_POST['BDTL_INPUT_db_cable_enddate'];
          $BDTL_INPUT_starhub_internet_startdate= $_POST['BDTL_INPUT_db_internet_startdate'];
          $BDTL_INPUT_starhub_internet_enddate= $_POST['BDTL_INPUT_db_internet_enddate'];
          $BDTL_INPUT_starhub_ssid=$_POST['BDTL_INPUT_tb_ssid'];
          $BDTL_INPUT_starhub_pwd=$_POST['BDTL_INPUT_tb_pwd'];
          $BDTL_INPUT_starhub_cable_serialno=$_POST['BDTL_INPUT_tb_cablebox_sno'];
          $BDTL_INPUT_starhub_modem_serialno=$_POST['BDTL_INPUT_tb_modem_sno'];
          $BDTL_INPUT_starhub_basicgroup=$_POST['BDTL_INPUT_ta_basic_group'];
          $BDTL_INPUT_starhub_addtnlch=$_POST['BDTL_INPUT_ta_addtl_ch'];
          $BDTL_INPUT_starhub_comments=$_POST['BDTL_INPUT_ta_starhub_comments'];
          if($BDTL_INPUT_expensetypes!=16)
        $BDTL_INPUT_primaryid_before=$this->BDTL_INPUT_getmaxprimaryid($BDTL_INPUT_expensetypes);
        $BDTL_INPUT_aircon_finalservice ='';
         $BDTL_INPUT_starhub_cablestartdate_shtime='';
         $BDTL_INPUT_starhub_cableenddate_shtime='';
         $BDTL_INPUT_starhub_internetstartdate_shtime='';
         $BDTL_INPUT_starhub_internetenddate_shtime='';
      if(($BDTL_INPUT_aircon_newservice!='')&&($BDTL_INPUT_aircon_newservice!='undefined'))
          $BDTL_INPUT_aircon_finalservice=$BDTL_INPUT_aircon_newservice;
      else
          $BDTL_INPUT_aircon_finalservice=$BDTL_INPUT_aircon_oldservice;

      if($BDTL_INPUT_digital_invoiceto=='SELECT')
      {
          $BDTL_INPUT_digital_invoiceto='null';
      }
      else
          $BDTL_INPUT_digital_invoiceto="'$BDTL_INPUT_digital_invoiceto'";

      if($BDTL_INPUT_electricity_invoice=='SELECT')
          $BDTL_INPUT_electricity_invoice='null';
      else
          $BDTL_INPUT_electricity_invoice="'$BDTL_INPUT_electricity_invoice'";

      if(($BDTL_INPUT_starhub_invoiceto=='SELECT')||($BDTL_INPUT_starhub_invoiceto==''))
      {
          $BDTL_INPUT_starhub_invoiceto='null';
          $BDTL_INPUT_starhub_ecnid='null';
      }
      else
          $BDTL_INPUT_starhub_invoiceto="'$BDTL_INPUT_starhub_invoiceto'";

      if($BDTL_INPUT_starhub_appldate=="")
          $BDTL_INPUT_starhub_appldate='null';
      else
      {
          $BDTL_INPUT_starhub_appldate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_appldate));
        $BDTL_INPUT_starhub_appldate="'$BDTL_INPUT_starhub_appldate'";
      }
      if($BDTL_INPUT_starhub_cable_startdate=="")
          $BDTL_INPUT_starhub_cable_startdate='null';
      else
      {
          $BDTL_INPUT_starhub_cablestartdate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_startdate));
          $BDTL_INPUT_starhub_cable_startdate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_startdate));
        $BDTL_INPUT_starhub_cable_startdate="'$BDTL_INPUT_starhub_cable_startdate'";
      }
      if($BDTL_INPUT_starhub_cable_enddate=="")
          $BDTL_INPUT_starhub_cable_enddate='null';
      else
      {
          $BDTL_INPUT_starhub_cableenddate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_enddate));
          $BDTL_INPUT_starhub_cable_enddate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_enddate));
        $BDTL_INPUT_starhub_cable_enddate="'$BDTL_INPUT_starhub_cable_enddate'";
      }
      if($BDTL_INPUT_starhub_internet_startdate=="")
          $BDTL_INPUT_starhub_internet_startdate='null';
      else
      {
          $BDTL_INPUT_starhub_internetstartdate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_startdate));
          $BDTL_INPUT_starhub_internet_startdate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_startdate));
        $BDTL_INPUT_starhub_internet_startdate="'$BDTL_INPUT_starhub_internet_startdate'";
      }
      if($BDTL_INPUT_starhub_internet_enddate=="")
          $BDTL_INPUT_starhub_internet_enddate='null';
      else
      {
          $BDTL_INPUT_starhub_internetenddate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_enddate));
          $BDTL_INPUT_starhub_internet_enddate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_enddate));
        $BDTL_INPUT_starhub_internet_enddate="'$BDTL_INPUT_starhub_internet_enddate'";
      }
      /*-----------------------------------INSERT CODING FOR AIRCON----------------------------------------*/
      if($BDTL_INPUT_expensetypes==16)
      {
          $BDTL_INPUT_aircon_sp =$this->db->query("CALL SP_BIZDTL_AIRCON_SERVICE_BY_INSERT('$BDTL_INPUT_unitnoaircon','$BDTL_INPUT_aircon_finalservice','$BDTL_INPUT_aircon_comments','$USERSTAMP',@FLAG)");
          $BDTL_INPUT_flag_rs=$this->db->query("SELECT @FLAG as FLAG");
          $BDTL_INPUT_saveflag=$BDTL_INPUT_flag_rs->row()->FLAG;
          $BDTL_INPUT_aircon_list_ref=$this->BDTL_INPUT_aircon_list();
      }
      /*-----------------------------------INSERT CODING FOR CARPARK----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==17)
      {
          if($BDTL_INPUT_car_comments=="")//COMMENTS
          {
              $BDTL_INPUT_car_comments='null';
          }else{
              $BDTL_INPUT_car_comments=$this->db->escape_like_str($BDTL_INPUT_car_comments);
              $BDTL_INPUT_car_comments="'$BDTL_INPUT_car_comments'";
          }
          $BDTL_INPUT_carpark_insert =$this->db->query("INSERT INTO EXPENSE_DETAIL_CARPARK(ULD_ID,UNIT_ID,EDCP_REC_VER,EDCP_CAR_NO,EDCP_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDTL_INPUT_unitno','1','$BDTL_INPUT_carno',$BDTL_INPUT_car_comments)");
      }
      /*-----------------------------------INSERT CODING FOR DIGITAL VOICE----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==15)
      {
          if($BDTL_INPUT_digital_comments=="")//COMMENTS
          {
              $BDTL_INPUT_digital_comments='null';
          }else{
              $BDTL_INPUT_digital_comments=$this->db->escape_like_str($BDTL_INPUT_digital_comments);
              $BDTL_INPUT_digital_comments="'$BDTL_INPUT_digital_comments'";
          }

        $BDTL_INPUT_insert_digitalvoice = $this->db->query("INSERT INTO EXPENSE_DETAIL_DIGITAL_VOICE(UNIT_ID,ECN_ID,EDDV_REC_VER,EDDV_DIGITAL_VOICE_NO,EDDV_DIGITAL_ACCOUNT_NO,EDDV_COMMENTS,ULD_ID) VALUES('$BDTL_INPUT_unitno',$BDTL_INPUT_digital_invoiceto,'1','$BDTL_INPUT_digital_voice','$BDTL_INPUT_digital_acctno',$BDTL_INPUT_digital_comments,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'))");
      }
      /*-----------------------------------INSERT CODING FOR ELECTRICITY----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==13)
      {
          if($BDTL_INPUT_electricity_comments=="")//COMMENTS
          {
              $BDTL_INPUT_electricity_comments='null';
          }else{
              $BDTL_INPUT_electricity_comments=$this->db->escape_like_str($BDTL_INPUT_electricity_comments);
              $BDTL_INPUT_electricity_comments="'$BDTL_INPUT_electricity_comments'";
          }
          $BDTL_INPUT_insert_electricity = $this->db->query("INSERT INTO EXPENSE_DETAIL_ELECTRICITY(ULD_ID,UNIT_ID,EDE_REC_VER,ECN_ID,EDE_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDTL_INPUT_unitno','1',$BDTL_INPUT_electricity_invoice,$BDTL_INPUT_electricity_comments)");
      }
      /*-----------------------------------INSERT CODING FOR STARHUB----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==14)
      {
        if($BDTL_INPUT_starhub_ssid=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_ssid='null';
        }else{
            $BDTL_INPUT_starhub_ssid=$this->db->escape_like_str($BDTL_INPUT_starhub_ssid);
            $BDTL_INPUT_starhub_ssid="'$BDTL_INPUT_starhub_ssid'";
        }
        if($BDTL_INPUT_starhub_pwd=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_pwd='null';}else{
            $BDTL_INPUT_starhub_pwd=$this->db->escape_like_str($BDTL_INPUT_starhub_pwd);
            $BDTL_INPUT_starhub_pwd="'$BDTL_INPUT_starhub_pwd'";
        }
        if($BDTL_INPUT_starhub_cable_serialno=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_cable_serialno='null';}else{
            $BDTL_INPUT_starhub_cable_serialno=$this->db->escape_like_str($BDTL_INPUT_starhub_cable_serialno);
            $BDTL_INPUT_starhub_cable_serialno="'$BDTL_INPUT_starhub_cable_serialno'";
        }
        if($BDTL_INPUT_starhub_comments=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_comments='null';}else{
            $BDTL_INPUT_starhub_comments=$this->db->escape_like_str($BDTL_INPUT_starhub_comments);
            $BDTL_INPUT_starhub_comments="'$BDTL_INPUT_starhub_comments'";
        }
        if($BDTL_INPUT_starhub_addtnlch=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_addtnlch='null';}else{
            $BDTL_INPUT_starhub_addtnlch=$this->db->escape_like_str($BDTL_INPUT_starhub_addtnlch);
            $BDTL_INPUT_starhub_addtnlch="'$BDTL_INPUT_starhub_addtnlch'";
        }
        if($BDTL_INPUT_starhub_modem_serialno=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_modem_serialno='null';}else{
            $BDTL_INPUT_starhub_modem_serialno=$this->db->escape_like_str($BDTL_INPUT_starhub_modem_serialno);
            $BDTL_INPUT_starhub_modem_serialno="'$BDTL_INPUT_starhub_modem_serialno'";
        }
        if($BDTL_INPUT_starhub_basicgroup=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_basicgroup='null';}else{
            $BDTL_INPUT_starhub_basicgroup=$this->db->escape_like_str($BDTL_INPUT_starhub_basicgroup);
            $BDTL_INPUT_starhub_basicgroup="'$BDTL_INPUT_starhub_basicgroup'";
        }
//        $BDTL_INPUT_insert_starhub =$this->db->query("INSERT INTO EXPENSE_DETAIL_STARHUB(UNIT_ID,ECN_ID,EDSH_REC_VER,EDSH_ACCOUNT_NO,EDSH_APPL_DATE,EDSH_CABLE_START_DATE,EDSH_CABLE_END_DATE,EDSH_INTERNET_START_DATE,EDSH_INTERNET_END_DATE,EDSH_SSID,EDSH_PWD,EDSH_CABLE_BOX_SERIAL_NO,EDSH_MODEM_SERIAL_NO,EDSH_BASIC_GROUP,EDSH_ADDTNL_CH,EDSH_COMMENTS,ULD_ID) VALUES('$BDTL_INPUT_unitno',$BDTL_INPUT_starhub_invoiceto,'1','$BDTL_INPUT_starhub_acctno',$BDTL_INPUT_starhub_appldate,$BDTL_INPUT_starhub_cable_startdate,$BDTL_INPUT_starhub_cable_enddate,$BDTL_INPUT_starhub_internet_startdate,$BDTL_INPUT_starhub_internet_enddate,$BDTL_INPUT_starhub_ssid,$BDTL_INPUT_starhub_pwd,$BDTL_INPUT_starhub_cable_serialno,$BDTL_INPUT_starhub_modem_serialno,$BDTL_INPUT_starhub_basicgroup,$BDTL_INPUT_starhub_addtnlch,$BDTL_INPUT_starhub_comments,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'))");

        /*-------------------------------CREATING CALENDAR EVENT FUNCTION FOR STARHUB------------------------*/
          $this->load->model('Eilib/Common_function');
          $BDTL_INPUT_sh_arr=$this->Common_function->getStarHubUnitCalTime();
          $BDTL_INPUT_sh_starttime=$BDTL_INPUT_sh_arr[0]['ECN_DATA'];
          $BDTL_INPUT_sh_endtime=$BDTL_INPUT_sh_arr[1]['ECN_DATA'];

        if(($BDTL_INPUT_starhub_cablestartdate_shtime!='')&&($BDTL_INPUT_starhub_cableenddate_shtime!='')&&($BDTL_INPUT_starhub_cablestartdate_shtime!='undefined')&&($BDTL_INPUT_starhub_cableenddate_shtime!='undefined'))
        {

            $value=$this->Calender->StarHubUnit_CreateCalEvent($calid,"2015-01-25",'10:00:00','10:30:00','2015-01-28','10:00:00','10:30:00','','0422','','START DATE','END DATE','X','20.00');
//             $return=$this->Calendar->StarHubUnit_CreateCalEvent($calid,'2015-01-25','10:00:00','10:30:00','2015-01-28','10:00:00','10:30:00',"STARHUB","0422","00023123",'START DATE','END DATE','','');
            print_r($value);
            exit;
        }
        if(($BDTL_INPUT_starhub_internetstartdate_shtime!='')&&($BDTL_INPUT_starhub_internetenddate_shtime!='')&&($BDTL_INPUT_starhub_internetstartdate_shtime!='undefined')&&($BDTL_INPUT_starhub_internetenddate_shtime!='undefined'))
        {
            $this->Calendar->StarHubUnit_CreateCalEvent($calid,$BDTL_INPUT_starhub_internetstartdate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,$BDTL_INPUT_starhub_internetenddate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,'STARHUB',$BDTL_INPUT_unitnoaircon,$BDTL_INPUT_starhub_acctno,'INTERNET START DATE','INTERNET END DATE','','');
        }
      }

      return [$BDTL_INPUT_aircon_list_ref,1];
    }
}