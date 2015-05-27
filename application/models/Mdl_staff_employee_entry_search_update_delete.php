<?php
class Mdl_staff_employee_entry_search_update_delete extends CI_Model{
    public function Initialdata($ErrorMessage)
    {
        $this->db->select('ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID=35');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('UNIT_ID,UNIT_NO',FALSE);
        $this->db->from('UNIT');
        $query = $this->db->get();
        $result2 = $query->result();

//        $EMP_ENTRY_multi_array = $this->EMP_ENTRY_gettreeviewunit() ;
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
//        $this->db->select('EMP_ID');
//        $this->db->from('EMPLOYEE_DETAILS');
//        $query = $this->db->get();
//        $result3 = $query->result();

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
      $EMP_ENTRY_select_sub_menu="SELECT UASD.UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U WHERE U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='.$menu.' AND UASD.UASD_ID NOT IN(SELECT ECD.UASD_ID FROM EMPLOYEE_CARD_DETAILS ECD)AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL ORDER BY UASD.UASD_ACCESS_CARD ASC";
      $EMP_ENTRY_sub_menu_result=$this->db->query($EMP_ENTRY_select_sub_menu);
      foreach($EMP_ENTRY_sub_menu_result->result_array() as $row){
          $EMP_ENTRY_sub_menu_array[]=$row["UASD_ACCESS_CARD"];
      }
     $EMP_ENTRY_multi_array[]=($EMP_ENTRY_sub_menu_array);
    }
    }
    //FUNCTION FOR SAVE PART
    public function EMP_ENTRY_insert($USERSTAMP){
        global  $USERSTAMP;
//        $EMP_ENTRY_cardno=$_POST['submenu'];
        $EMP_ENTRY_firstname =$_POST['EMP_ENTRY_firstname'];
        $EMP_ENTRY_lastname = $_POST['EMP_ENTRY_lastname'];
        $EMP_ENTRY_empdesigname =$_POST['EMP_ENTRY_empdesigname'];
        $EMP_ENTRY_mobilenumber = $_POST['EMP_ENTRY_mobilenumber'];
        $EMP_ENTRY_email =  $_POST['EMP_ENTRY_email'];
        $EMP_ENTRY_comments = $_POST['EMP_ENTRY_comments'];
        $EMP_ENTRY_radio_null =  $_POST['EMP_ENTRY_radio_null'];
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
//        if($EMP_ENTRY_cardno=='undefined'||$EMP_ENTRY_radio_null=='null')
//        {
//            $EMP_ENTRY_cardno="";
//        }
//        else
//        {
//            $EMP_ENTRY_cardno=$EMP_ENTRY_cardno;
//        }
        echo "CALL SP_EMPDTL_INSERT('$EMP_ENTRY_firstname','$EMP_ENTRY_lastname','$EMP_ENTRY_empdesigname','$EMP_ENTRY_mobilenumber',$EMP_ENTRY_email,$EMP_ENTRY_comments,'$USERSTAMP','$EMP_ENTRY_cardno',@FLAG_ENTRYEMP)";
       exit;
        $insertquery = "CALL SP_EMPDTL_INSERT('$EMP_ENTRY_firstname','$EMP_ENTRY_lastname','$EMP_ENTRY_empdesigname','$EMP_ENTRY_mobilenumber',$EMP_ENTRY_email,$EMP_ENTRY_comments,'$USERSTAMP','$EMP_ENTRY_cardno',@FLAG_ENTRYEMP)";
        $query = $this->db->query($insertquery);
        $this->db->select('@FLAG_ENTRYEMP as SUCCESSMSG', FALSE);
        $result = $this->db->get()->result_array();
        return  $result;
    }
}