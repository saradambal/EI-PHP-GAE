<?php
class Mdl_menu extends CI_Model{
    public function fetch_data($USERSTAMP){
        $this->db->distinct();
        $this->db->select("MP_MNAME");
        $this->db->order_by("MP_MNAME", "ASC");
        $this->db->from('USER_LOGIN_DETAILS ULD,USER_ACCESS UA,USER_MENU_DETAILS UMP,MENU_PROFILE MP');
        $this->db->where("ULD_LOGINID='$USERSTAMP' and UA.ULD_ID=ULD.ULD_ID and UA.RC_ID=UMP.RC_ID and MP.MP_ID=UMP.MP_ID");
        $query = $this->db->get();
        $URSC_Main_menu_array=array();
     $i=0;
        foreach ($query->result_array() as $row)
        {
            $URSC_Main_menu_array[]=$row["MP_MNAME"];
           // $USERSTAMP='dhandapani.sattanathan@ssomens.com';
            $this->db->distinct();
            $this->db->select("MP_MSUB");
            $this->db->order_by("MP_MSUB", "ASC");
            $this->db->from('USER_LOGIN_DETAILS ULD,USER_ACCESS UA,USER_MENU_DETAILS UMP,MENU_PROFILE MP');
            $this->db->where("ULD_LOGINID='$USERSTAMP' and UA.ULD_ID=ULD.ULD_ID and UA.RC_ID=UMP.RC_ID and MP.MP_ID=UMP.MP_ID and MP.MP_MNAME="."'".$URSC_Main_menu_array[$i]."'");
            $query1 = $this->db->get();
            $URSC_sub_menu_row=array();
            $URSC_sub_sub_menu_row_col=array();
            $URSC_sub_sub_menu_row_col_data=array();
            $j=0;
            foreach ($query1->result_array() as $row1)
            {
            $URSC_sub_menu_row[]=$row1["MP_MSUB"];

                   // $USERSTAMP='dhandapani.sattanathan@ssomens.com';
                    $this->db->distinct();
                    $this->db->select("MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG");
                    $this->db->order_by("MP_MSUBMENU", "ASC");
                    $this->db->from('USER_LOGIN_DETAILS ULD,USER_ACCESS UA,USER_MENU_DETAILS UMP,MENU_PROFILE MP');
                    $this->db->where("ULD_LOGINID='$USERSTAMP' and UA.ULD_ID=ULD.ULD_ID and UA.RC_ID=UMP.RC_ID and MP.MP_ID=UMP.MP_ID and MP.MP_MNAME='".$URSC_Main_menu_array[$i]."' AND MP_MSUB="."'".$URSC_sub_menu_row[$j]."'");
                $query2 = $this->db->get();
                $URSC_sub_sub_menu_row_data=array();
                $script_flag=array();
                $file_name=array();
                foreach ($query2->result_array() as $row2)
                {
                    $script_flag[]=$row2["MP_SCRIPT_FLAG"];
                    $file_name[]=$row2["MP_MFILENAME"];
                    if($row2["MP_MSUBMENU"]==null||$row2["MP_MSUBMENU"]=="")continue;
                    $URSC_sub_sub_menu_row_data[]=$row2["MP_MSUBMENU"];
                }
                $URSC_script_flag[]=$script_flag;
                $URSRC_filename[]=array_unique($file_name);
                $URSC_sub_sub_menu_data_array[]=$URSC_sub_sub_menu_row_data;
               $j++;
                }
            $URSC_sub_menu_array[]=$URSC_sub_menu_row;
            $i++;
        }

      //LOADING LOGO AND CALENDER
        $this->load->model("EILIB/Mdl_eilib_common_function");
        $logocalender=$this->Mdl_eilib_common_function->getLogoCalendar();
//        print_r($logocalender);
//        exit;

        if(count($URSC_Main_menu_array)!=0){
            $final_values=array($URSC_Main_menu_array, $URSC_sub_menu_array,$URSC_sub_sub_menu_data_array,$URSC_script_flag,$URSRC_filename,$USERSTAMP,$logocalender);    // $final = array($URSC_sub_menu_array,$URSC_sub_sub_menu_array,$URSC_sub_sub_menu_data_array);
        }
        else{
            $final_values=array($URSC_Main_menu_array,$USERSTAMP);
        }
return json_encode($final_values);
}
}

