<?php
class Mdl_staff_employee_entry_search_update_delete extends CI_Model{
    public function Initialdata($ErrorMessage)
    {
        $this->db->distinct();
        $this->db->select('ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID=35');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('UNIT_ID,UNIT_NO',FALSE);
        $this->db->from('UNIT');
        $query = $this->db->get();
        $result2 = $query->result();

        $EMP_ENTRY_multi_array = $this->EMP_ENTRY_gettreeviewunit() ;
        return $result[]=array($result1,$result2,$EMP_ENTRY_multi_array,$ErrorMessage);
    }
    public function EMP_ENTRY_gettreeviewunit()
    {
        $EMP_ENTRY_main_menu_array=array();
        $EMP_ENTRY_multi_array=array();
        $EMP_ENTRY_select_main_menu="SELECT DISTINCT U.UNIT_NO FROM UNIT U,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT_DETAILS UD ,VW_ACTIVE_UNIT VAU WHERE VAU.UNIT_ID=U.UNIT_ID AND  U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UD.UD_OBSOLETE IS NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND  UASD.UASD_ID NOT IN(SELECT ECD.UASD_ID FROM EMPLOYEE_CARD_DETAILS ECD)";
        $EMP_ENTRY_main_menu_result=$this->db->query($EMP_ENTRY_select_main_menu);
        foreach($EMP_ENTRY_main_menu_result->result_array() as $row){
            $EMP_ENTRY_main_menu_array[]=$row["UNIT_NO"];
        }
        $EMP_ENTRY_multi_array[]=($EMP_ENTRY_main_menu_array);
        for($i=0;$i<count($EMP_ENTRY_multi_array[0]);$i++){
            $menu=$EMP_ENTRY_multi_array[0][$i];
            $EMP_ENTRY_sub_menu_array=array();
            $EMP_ENTRY_select_sub_menu="SELECT UASD.UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U WHERE U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='".$menu."' AND UASD.UASD_ID NOT IN(SELECT ECD.UASD_ID FROM EMPLOYEE_CARD_DETAILS ECD)AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL ORDER BY UASD.UASD_ACCESS_CARD ASC";
            $EMP_ENTRY_sub_menu_result=$this->db->query($EMP_ENTRY_select_sub_menu);
            foreach($EMP_ENTRY_sub_menu_result->result_array() as $row){
                $EMP_ENTRY_sub_menu_array[]=$row["UASD_ACCESS_CARD"];
            }
            $EMP_ENTRY_multi_array[]=($EMP_ENTRY_sub_menu_array);
        }
        return $EMP_ENTRY_multi_array;
    }
    //FUNCTION FOR SAVE PART
    public function EMP_ENTRY_insert($USERSTAMP,$EMP_ENTRY_email,$EMP_ENTRY_comments,$EMP_ENTRY_radio_null,$submenu){
        global  $USERSTAMP;
        $EMP_ENTRY_cardno=$submenu;
        $EMP_ENTRY_firstname =$_POST['EMP_ENTRY_firstname'];
        $EMP_ENTRY_lastname = $_POST['EMP_ENTRY_lastname'];
        $EMP_ENTRY_empdesigname =$_POST['EMP_ENTRY_empdesigname'];
        $EMP_ENTRY_mobilenumber = $_POST['EMP_ENTRY_mobilenumber'];
        if($EMP_ENTRY_email==''){
            $EMP_ENTRY_email='null';
        }
        else{
            $EMP_ENTRY_email="'$EMP_ENTRY_email'";
        }
        if($EMP_ENTRY_comments==''){
            $EMP_ENTRY_comments='null';
        }
        else{
            $EMP_ENTRY_comments="'$EMP_ENTRY_comments'";
        }
        $menu='';
        for($i=0;$i<count($EMP_ENTRY_cardno);$i++){
            if($i==0){
                $menu=$EMP_ENTRY_cardno[$i];
            }
            else{
                $menu=$menu.','.$EMP_ENTRY_cardno[$i];
            }
        }
        if(count($EMP_ENTRY_cardno)==0 ||$EMP_ENTRY_radio_null=='null'){
            $menu='null';
        }
        else{
            $menu="'".$menu."'";
        }
        $insertquery = "CALL SP_EMPDTL_INSERT('$EMP_ENTRY_firstname','$EMP_ENTRY_lastname','$EMP_ENTRY_empdesigname','$EMP_ENTRY_mobilenumber',$EMP_ENTRY_email,$EMP_ENTRY_comments,'$USERSTAMP',".$menu.",@FLAG_ENTRYEMP)";
        $query = $this->db->query($insertquery);
        $FLAG= $this->db->query('SELECT @FLAG_ENTRYEMP as SUCCESSMSG');
        $finalFLAG = $FLAG->row()->SUCCESSMSG;
        $EMP_ENTRY_multi_array = $this->EMP_ENTRY_gettreeviewunit() ;
        return $result[]=array($finalFLAG,$EMP_ENTRY_multi_array);
    }
    //FUNCTION FOR INITIAL DATA FOR SEARCH FORM
    public function EMPSRC_UPD_DEL_searchoptionresult()
    {
        $this->db->distinct();
        $this->db->select();
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('ECN_ID IN (90,94,95,96,99) OR CGN_ID=35');
        $this->db->order_by("ECN_ID", "ASC");
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('UNIT_ID,UNIT_NO',FALSE);
        $this->db->from('UNIT');
        $query = $this->db->get();
        $result2 = $query->result();

        $this->db->distinct();
        $this->db->select('CONCAT(EMP_FIRST_NAME,"_",EMP_LAST_NAME) AS EMP_DETAIL_names_concat',FALSE);
        $this->db->order_by("EMP_FIRST_NAME,EMP_LAST_NAME", "ASC");
        $this->db->from('EMPLOYEE_DETAILS');
        $this->db->where('ECN_ID=74 OR ECN_ID=75');
        $query = $this->db->get();
        $result3 = $query->result();

//        $EMP_ENTRY_multi_array = $this->EMP_ENTRY_gettreeviewunit() ;
        return $result[]=array($result1,$result2,$result3);
    }
    public function fetch_data($EMPSRC_UPD_DEL_lb_designation_listbox,$emp_first_name,$emp_last_name,$EMPSRC_UPD_DEL_ta_mobile,$EMPSRC_UPD_DEL_ta_email,$EMPSRC_UPD_DEL_lb_searchoption,$EMPSRC_UPD_DEL_ta_comments)
    {
        if($EMPSRC_UPD_DEL_lb_searchoption==95){
            $this->db->select("ED.EMP_ID AS ID, ED.EMP_FIRST_NAME AS Femployeename,ED.EMP_LAST_NAME AS Lemployeename,ED.EMP_MOBILE AS mobile,ED.EMP_EMAIL AS email,EXPCONFIG.ECN_DATA AS designation,ED.EMP_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,UASD.UASD_ACCESS_CARD AS cardnumber,DATE_FORMAT(CONVERT_TZ(ED.EMP_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp,U.UNIT_NO AS EMPSRC_UPD_DEL_unitno");
            $this->db->from("EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD");
            $this->db->join('EMPLOYEE_CARD_DETAILS ECD','ED.EMP_ID=ECD.EMP_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','ECD.UASD_ID=UASD.UASD_ID','left');
            $this->db->join('UNIT U','UASD.UNIT_ID=U.UNIT_ID','left');
            $this->db->where("ULD.ULD_ID=ED.ULD_ID AND (EXPCONFIG.ECN_DATA= '$EMPSRC_UPD_DEL_lb_designation_listbox') AND (ED.ECN_ID=EXPCONFIG.ECN_ID)");
            $query = $this->db->get();
            return $query->result();
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==90){
            $this->db->select("ED.EMP_ID AS ID, ED.EMP_FIRST_NAME AS Femployeename,ED.EMP_LAST_NAME AS Lemployeename,ED.EMP_MOBILE AS mobile,ED.EMP_EMAIL AS email,EXPCONFIG.ECN_DATA AS designation,ED.EMP_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,UASD.UASD_ACCESS_CARD AS cardnumber,DATE_FORMAT(CONVERT_TZ(ED.EMP_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp,U.UNIT_NO AS EMPSRC_UPD_DEL_unitno");
            $this->db->from("EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD");
            $this->db->join('EMPLOYEE_CARD_DETAILS ECD','ED.EMP_ID=ECD.EMP_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','ECD.UASD_ID=UASD.UASD_ID','left');
            $this->db->join('UNIT U','UASD.UNIT_ID=U.UNIT_ID','left');
            $this->db->where("ULD.ULD_ID=ED.ULD_ID AND (ED.EMP_FIRST_NAME ='$emp_first_name' AND ED.EMP_LAST_NAME ='$emp_last_name') AND (ED.ECN_ID=EXPCONFIG.ECN_ID)");
            $query = $this->db->get();
            return $query->result();
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==99)//MOBILE NO
        {
            $this->db->select("ED.EMP_ID AS ID, ED.EMP_FIRST_NAME AS Femployeename,ED.EMP_LAST_NAME AS Lemployeename,ED.EMP_MOBILE AS mobile,ED.EMP_EMAIL AS email,EXPCONFIG.ECN_DATA AS designation,ED.EMP_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,UASD.UASD_ACCESS_CARD AS cardnumber,DATE_FORMAT(CONVERT_TZ(ED.EMP_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp,U.UNIT_NO AS EMPSRC_UPD_DEL_unitno");
            $this->db->from("EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD");
            $this->db->join('EMPLOYEE_CARD_DETAILS ECD','ED.EMP_ID=ECD.EMP_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','ECD.UASD_ID=UASD.UASD_ID','left');
            $this->db->join('UNIT U','UASD.UNIT_ID=U.UNIT_ID','left');
            $this->db->where("ULD.ULD_ID=ED.ULD_ID AND (ED.EMP_MOBILE ='$EMPSRC_UPD_DEL_ta_mobile') AND (ED.ECN_ID=EXPCONFIG.ECN_ID)");
            $query = $this->db->get();
            return $query->result();
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==96)//EMAIL ID
        {
            $this->db->select("ED.EMP_ID AS ID, ED.EMP_FIRST_NAME AS Femployeename,ED.EMP_LAST_NAME AS Lemployeename,ED.EMP_MOBILE AS mobile,ED.EMP_EMAIL AS email,EXPCONFIG.ECN_DATA AS designation,ED.EMP_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,UASD.UASD_ACCESS_CARD AS cardnumber,DATE_FORMAT(CONVERT_TZ(ED.EMP_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp,U.UNIT_NO AS EMPSRC_UPD_DEL_unitno");
            $this->db->from("EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD");
            $this->db->join('EMPLOYEE_CARD_DETAILS ECD','ED.EMP_ID=ECD.EMP_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','ECD.UASD_ID=UASD.UASD_ID','left');
            $this->db->join('UNIT U','UASD.UNIT_ID=U.UNIT_ID','left');
            $this->db->where("ULD.ULD_ID=ED.ULD_ID AND (ED.EMP_EMAIL ='$EMPSRC_UPD_DEL_ta_email') AND (ED.ECN_ID=EXPCONFIG.ECN_ID)");
            $query = $this->db->get();
            return $query->result();
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==94)//COMMENTS
        {
            $this->db->select("ED.EMP_ID AS ID, ED.EMP_FIRST_NAME AS Femployeename,ED.EMP_LAST_NAME AS Lemployeename,ED.EMP_MOBILE AS mobile,ED.EMP_EMAIL AS email,EXPCONFIG.ECN_DATA AS designation,ED.EMP_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,UASD.UASD_ACCESS_CARD AS cardnumber,DATE_FORMAT(CONVERT_TZ(ED.EMP_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp,U.UNIT_NO AS EMPSRC_UPD_DEL_unitno");
            $this->db->from("EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD");
            $this->db->join('EMPLOYEE_CARD_DETAILS ECD','ED.EMP_ID=ECD.EMP_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','ECD.UASD_ID=UASD.UASD_ID','left');
            $this->db->join('UNIT U','UASD.UNIT_ID=U.UNIT_ID','left');
            $this->db->where("ULD.ULD_ID=ED.ULD_ID AND (ED.EMP_COMMENTS ='$EMPSRC_UPD_DEL_ta_comments') AND (ED.ECN_ID=EXPCONFIG.ECN_ID)");
            $query = $this->db->get();
            return $query->result();
        }
   }
    //FUNCTION FOR COMMENTS
    public function EMPSRC_UPD_DEL_comments($EMPSRC_UPD_DEL_lb_searchoption){
        if($EMPSRC_UPD_DEL_lb_searchoption==99)
        {
        $this->db->distinct();
        $this->db->select("EMP_MOBILE");
        $this->db->from("EMPLOYEE_DETAILS");
        $this->db->order_by("EMP_MOBILE", "ASC");
        $STDTL_SEARCH_EMP_MOBILE = $this->db->get();
        foreach ($STDTL_SEARCH_EMP_MOBILE->result_array() as $row)
        {
            $EMPSRC_UPD_DEL_final_autocomplts[]=$row['EMP_MOBILE'];
        }
                return $EMPSRC_UPD_DEL_final_autocomplts;
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==96)
        {
            $this->db->distinct();
            $this->db->select("EMP_EMAIL");
            $this->db->from("EMPLOYEE_DETAILS");
            $this->db->order_by("EMP_EMAIL", "ASC");
            $STDTL_SEARCH_EMP_MOBILE = $this->db->get();
            foreach ($STDTL_SEARCH_EMP_MOBILE->result_array() as $row)
            {
                $EMPSRC_UPD_DEL_final_autocomplts[]=$row['EMP_EMAIL'];
            }
            return $EMPSRC_UPD_DEL_final_autocomplts;
        }
        if($EMPSRC_UPD_DEL_lb_searchoption==94)
        {
            $this->db->distinct();
            $this->db->select("EMP_COMMENTS");
            $this->db->from("EMPLOYEE_DETAILS");
            $this->db->order_by("EMP_COMMENTS", "ASC");
            $STDTL_SEARCH_EMP_MOBILE = $this->db->get();
            foreach ($STDTL_SEARCH_EMP_MOBILE->result_array() as $row)
            {
                $EMPSRC_UPD_DEL_final_autocomplts[]=$row['EMP_COMMENTS'];
            }
            return $EMPSRC_UPD_DEL_final_autocomplts;
        }
    }
    //FUNTION FOR GETTING CARDNO ND UNITNO
    public function EMPSRC_UPD_DEL_getcardnoandunitno($EMPSRC_UPD_DEL_id)
    {
        $EMPSRC_UPD_DEL_id=$_POST['EMPSRC_UPD_DEL_id'];
       $EMPSRC_UPD_DEL_cardunitnoarray=array();
       $EMPSRC_UPD_DEL_getcardnoandunitno ="select DISTINCT U.UNIT_NO,UASD.UASD_ACCESS_CARD  from EMPLOYEE_DETAILS ED left join EMPLOYEE_CARD_DETAILS ECD on (ECD.EMP_ID=ED.EMP_ID) left join UNIT_ACCESS_STAMP_DETAILS UASD on (UASD.UASD_ID=ECD.UASD_ID) left join UNIT U on (UASD.UNIT_ID=U.UNIT_ID) where ED.EMP_ID=".$EMPSRC_UPD_DEL_id."";
       $EMPSRC_UPD_DEL_sub_card_result=$this->db->query($EMPSRC_UPD_DEL_getcardnoandunitno);
       $EMPSRC_UPD_DEL_unitno_array=array();
       $EMPSRC_UPD_DEL_cardno_array=array();
        foreach($EMPSRC_UPD_DEL_sub_card_result->result_array() as $row){
            $EMPSRC_UPD_DEL_unitno_array[]=$row["UNIT_NO"];
            $EMPSRC_UPD_DEL_cardno_array[]=$row["UASD_ACCESS_CARD"];
        }
        $EMPSRC_UPD_DEL_cardunitnoarray[]=($EMPSRC_UPD_DEL_unitno_array);
        $EMPSRC_UPD_DEL_cardunitnoarray[]=($EMPSRC_UPD_DEL_cardno_array);

        $EMPSRC_UPD_DEL_multi_array = $this->EMPSRC_UPD_DEL_gettreeviewunit($EMPSRC_UPD_DEL_id) ;
        $EMPSRC_UPD_DEL_cardunitnoarray[]=($EMPSRC_UPD_DEL_multi_array);
        return $EMPSRC_UPD_DEL_cardunitnoarray;
    }
    //GET THE TREEVIEW UNIT AND CARD VALUES//
    public function EMPSRC_UPD_DEL_gettreeviewunit($EMPSRC_UPD_DEL_id)
    {
        $EMP_ENTRY_main_menu_array=array();
        $EMP_ENTRY_multi_array=array();
        $EMP_ENTRY_select_main_menu="SELECT DISTINCT U.UNIT_NO FROM UNIT U,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT_DETAILS UD,VW_ACTIVE_UNIT VAU WHERE VAU.UNIT_ID=U.UNIT_ID AND U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UD.UD_OBSOLETE IS NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND UASD.UASD_ID NOT IN(SELECT ECD.UASD_ID FROM EMPLOYEE_CARD_DETAILS ECD WHERE ECD.EMP_ID !='".$EMPSRC_UPD_DEL_id."')";
        $EMP_ENTRY_main_menu_result=$this->db->query($EMP_ENTRY_select_main_menu);
        foreach($EMP_ENTRY_main_menu_result->result_array() as $row){
            $EMP_ENTRY_main_menu_array[]=$row["UNIT_NO"];
        }
        $EMP_ENTRY_multi_array[]=($EMP_ENTRY_main_menu_array);
        for($i=0;$i<count($EMP_ENTRY_multi_array[0]);$i++){
            $menu=$EMP_ENTRY_multi_array[0][$i];
            $EMP_ENTRY_sub_menu_array=array();
            $EMP_ENTRY_select_sub_menu="SELECT UASD.UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U WHERE U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='".$menu."' AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND UASD.UASD_ID NOT IN(SELECT ECD.UASD_ID FROM EMPLOYEE_CARD_DETAILS ECD WHERE ECD.EMP_ID!='".$EMPSRC_UPD_DEL_id."') ORDER BY UASD.UASD_ACCESS_CARD ASC";
            $EMP_ENTRY_sub_menu_result=$this->db->query($EMP_ENTRY_select_sub_menu);
            foreach($EMP_ENTRY_sub_menu_result->result_array() as $row){
                $EMP_ENTRY_sub_menu_array[]=$row["UASD_ACCESS_CARD"];
            }
            $EMP_ENTRY_multi_array[]=($EMP_ENTRY_sub_menu_array);
        }
        return $EMP_ENTRY_multi_array;
    }
    //FUNCTION FOR UPDATE PART
    public function EMPSRC_UPD_DEL_update($USERSTAMP,$EMPSRC_UPD_DEL_email,$EMPSRC_UPD_DEL_comments,$EMP_ENTRY_radio_null,$submenu,$EMPSRC_UPD_DEL_carcunitarray,$EMPSRC_UPD_DEL_id){
        global  $USERSTAMP;

        $EMP_ENTRY_cardno=$submenu;
        $EMPSRC_UPD_DEL_searchoption =$_POST['EMPSRC_UPD_DEL_searchoption'];
        $EMPSRC_UPD_DEL_firstname =$_POST['EMPSRC_UPD_DEL_firstname'];
        $EMPSRC_UPD_DEL_lastname = $_POST['EMPSRC_UPD_DEL_lastname'];
        $EMPSRC_UPD_DEL_empdesigname =$_POST['EMPSRC_UPD_DEL_empdesigname'];
        $EMPSRC_UPD_DEL_mobilenumber = $_POST['EMPSRC_UPD_DEL_mobilenumber'];
//echo 'asd';
//        echo $EMPSRC_UPD_DEL_id;
//        exit;
        $EMPSRC_UPD_DEL_cardunitnoarray =$this->EMPSRC_UPD_DEL_getcardnoandunitno($EMPSRC_UPD_DEL_id);


        $EMPSRC_UPD_DEL_cardunitnoarray_final='';
        for($i=0;$i<count($EMPSRC_UPD_DEL_cardunitnoarray[1]);$i++){
            if($i==0){
                $EMPSRC_UPD_DEL_cardunitnoarray_final=$EMPSRC_UPD_DEL_cardunitnoarray[1][$i];
            }
            else{
                $EMPSRC_UPD_DEL_cardunitnoarray_final=$EMPSRC_UPD_DEL_cardunitnoarray_final.','.$EMPSRC_UPD_DEL_cardunitnoarray[1][$i];
            }
        }
        if(count($EMPSRC_UPD_DEL_cardunitnoarray[1])==0 ||$EMP_ENTRY_radio_null=='null'){
            $EMPSRC_UPD_DEL_cardunitnoarray_final='null';
        }
        else{
            $EMPSRC_UPD_DEL_cardunitnoarray_final="'".$EMPSRC_UPD_DEL_cardunitnoarray_final."'";
        }


//        echo $EMPSRC_UPD_DEL_firstname;
//        echo $EMPSRC_UPD_DEL_lastname;
//        echo $EMPSRC_UPD_DEL_empdesigname;
//        echo $EMPSRC_UPD_DEL_mobilenumber;
//        echo 'pp';
//
//        echo $EMPSRC_UPD_DEL_cardunitnoarray_final;
//        echo 'asdsada';
//        exit;

//print_r($EMP_ENTRY_cardno);

        if($EMPSRC_UPD_DEL_email==''){
            $EMPSRC_UPD_DEL_email='null';
        }
        else{
            $EMPSRC_UPD_DEL_email="'$EMPSRC_UPD_DEL_email'";
        }
        if($EMPSRC_UPD_DEL_comments==''){
            $EMPSRC_UPD_DEL_comments='null';
        }
        else{
            $EMPSRC_UPD_DEL_comments="'$EMPSRC_UPD_DEL_comments'";
        }
        $menu='';
        for($i=0;$i<count($EMP_ENTRY_cardno);$i++){
            if($i==0){
                $menu=$EMP_ENTRY_cardno[$i];
            }
            else{
                $menu=$menu.','.$EMP_ENTRY_cardno[$i];
            }
        }
        if(count($EMP_ENTRY_cardno)==0 ||$EMP_ENTRY_radio_null=='null'){
            $menu='null';
        }
        else{
            $menu="'".$menu."'";
        }



        $finalarray =array();
        if($EMP_ENTRY_radio_null=='NULL')
        {
            $menu="";
           $EMPSRC_UPD_DEL_getcardnoarray =$EMPSRC_UPD_DEL_cardunitnoarray_final;
    }
        else
        {

            $j=0;
            for($i=0; $i<=count($EMPSRC_UPD_DEL_cardunitnoarray_final-1);$i++)
      {

//          if($EMPSRC_UPD_DEL_cardno.indexOf(EMPSRC_UPD_DEL_cardunitnoarray[1][$i])==-1)
                if(array_search($EMP_ENTRY_cardno[$i],($EMPSRC_UPD_DEL_cardunitnoarray)==""))
        {
//            print_r($EMP_ENTRY_cardno);
            $finalarray[$j]=$EMPSRC_UPD_DEL_cardunitnoarray;
          $j++;
        }
        $EMPSRC_UPD_DEL_getcardnoarray = $finalarray;
      }
    }
        $EMPSRC_UPD_DEL_lastupdatecard=$menu;


//        print_r($EMPSRC_UPD_DEL_cardunitnoarray);
//        echo $EMPSRC_UPD_DEL_lastname;
//        echo $EMPSRC_UPD_DEL_empdesigname;
//        echo $EMPSRC_UPD_DEL_mobilenumber;
//        echo 'pp';
//
//        echo $EMPSRC_UPD_DEL_cardunitnoarray_final;
//        echo $menu;
//        echo 'asdsada';
//        exit;



//        echo "CALL SP_EMPDTL_UPDATE('$EMPSRC_UPD_DEL_id',$EMPSRC_UPD_DEL_firstname','$EMPSRC_UPD_DEL_lastname','$EMPSRC_UPD_DEL_empdesigname','$EMPSRC_UPD_DEL_mobilenumber',$EMPSRC_UPD_DEL_email,$EMPSRC_UPD_DEL_comments,'$USERSTAMP',".$EMPSRC_UPD_DEL_getcardnoarray.",".$EMPSRC_UPD_DEL_lastupdatecard.",@FLAG_ENTRYEMP)";
//      exit;
        $insertquery = "CALL SP_EMPDTL_UPDATE('$EMPSRC_UPD_DEL_id',$EMPSRC_UPD_DEL_firstname','$EMPSRC_UPD_DEL_lastname','$EMPSRC_UPD_DEL_empdesigname','$EMPSRC_UPD_DEL_mobilenumber',$EMPSRC_UPD_DEL_email,$EMPSRC_UPD_DEL_comments,'$USERSTAMP',".$EMPSRC_UPD_DEL_getcardnoarray.",".$EMPSRC_UPD_DEL_lastupdatecard.",@FLAG_ENTRYEMP)";
        $query = $this->db->query($insertquery);
        $FLAG= $this->db->query('SELECT @FLAG_ENTRYEMP as SUCCESSMSG');
        $finalFLAG = $FLAG->row()->SUCCESSMSG;
        $EMP_ENTRY_multi_array = $this->EMP_ENTRY_gettreeviewunit() ;
        return $result[]=array($finalFLAG,$EMP_ENTRY_multi_array);
    }
}