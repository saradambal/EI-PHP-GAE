<?php


class Access_rights_access_rights_search_update_model extends CI_Model{

public  function URSRC_loadintialvalue(){
    $UserStamp='safiyullah.mohideen@ssomens.com';
    $URSRC_userrights_array=array();

    $this->db->select('URC_DATA');
    $this->db->from('USER_RIGHTS_CONFIGURATION URC','BASIC_ROLE_PROFILE BRP','ROLE_CREATION RC','USER_LOGIN_DETAILS ULD','USER_ACCESS UA');
    $this->db->join('BASIC_ROLE_PROFILE BRP', 'BRP.BRP_BR_ID=URC.URC_ID');
    $this->db->join('ROLE_CREATION RC',' RC.URC_ID=BRP.URC_ID');
    $this->db->join('USER_ACCESS UA','RC.RC_ID=UA.RC_ID');
    $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
    $this->db->where('ULD.ULD_LOGINID',$UserStamp);
    $this->db->order_by('URC_DATA');
    $query = $this->db->get();
    foreach ($query->result_array() as $row){

        $URSRC_userrights_array[]=$row['URC_DATA'];
    }
    $URSRC_basicroles_array=array();
    $this->db->select('URC_DATA');
    $this->db->from('USER_RIGHTS_CONFIGURATION');
    $this->db->where('CGN_ID','43');
    $this->db->order_by('URC_DATA ASC');
    $query = $this->db->get();
    foreach($query->result_array() as $row){
        $URSRC_basicroles_array[]=$row['URC_DATA'];
    }
    $this->db->select('URC_DATA');
    $this->db->from('USER_RIGHTS_CONFIGURATION URC');
    $this->db->join('ROLE_CREATION RC','RC.URC_ID=URC.URC_ID');
    $this->db->join('USER_ACCESS UA','RC.RC_ID=UA.RC_ID');
    $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
    $this->db->where('ULD.ULD_LOGINID',$UserStamp);
    $query = $this->db->get();
    foreach($query->result_array() as $row){
        $URSRC_basicrole=$row['URC_DATA'];
    }
     $URSRC_basicroleid_array=array();
    $this->db->select('BRP_BR_ID');
    $this->db->from('USER_RIGHTS_CONFIGURATION URC');
    $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
    $this->db->where('URC.URC_DATA',$URSRC_basicrole);
    $query = $this->db->get();
    foreach($query->result_array() as $row){
        $URSRC_basicroleid_array[]=$row['BRP_BR_ID'];
    }

    $URSRC_basicrole_profile_array=array();
    for($i=0;$i<count($URSRC_basicroleid_array);$i++){
        $this->db->select('URC_DATA');
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('BASIC_ROLE_PROFILE BRP','BRP.BRP_BR_ID=URC.URC_ID');
        $this->db->where('BRP.BRP_BR_ID',$URSRC_basicroleid_array[$i]);
        $this->db->order_by('URC_DATA ASC');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicrole_profile_array[]=$row['URC_DATA'];
        }
    }
    $URSRC_basicrole_profile_array=array_values(array_unique($URSRC_basicrole_profile_array));

     $URSRC_role_array=array();
     $this->db->select('RC_NAME');
     $this->db->from('ROLE_CREATION');
     $this->db->order_by('RC_NAME');
     $query = $this->db->get();
     foreach($query->result_array() as $row){
        $URSRC_role_array[]=$row['RC_NAME'];
     }

    $URSRC_logindetails_array=array();
    $this->db->select('*');
    $this->db->from('VW_ACCESS_RIGHTS_TERMINATE_LOGINID');
    $query = $this->db->get();
    foreach($query->result_array() as $row){
        $URSRC_logindetails_array[]=$row['ULD_LOGINID'];
    }
    $this->load->model('Common');
    $ErrorMessage= $this->Common->getErrorMessageList('36,354,360,361,362,363,364,365,366,367,370,371,372,373,374,376,401,454,455,458,465');
    $URSRC_initial_values=(object)['URSRC_userrights'=>$URSRC_userrights_array,'URSRC_role_array'=>$URSRC_role_array,'URSRC_loginid_array'=>$URSRC_logindetails_array,'URSRC_errorAarray'=>$ErrorMessage,'URSRC_basicroles_array'=>$URSRC_basicroles_array,'URSRC_basicrole'=>$URSRC_basicrole,'URSRC_basicrole_profile_array'=>$URSRC_basicrole_profile_array,'UserStamp'=>$UserStamp];
    return $URSRC_initial_values;



}
    public function URSRC_check_role($role){

        $this->db->like('RC_NAME', $role);
        $this->db->from('ROLE_CREATION');
        $row=$this->db->count_all_results();
        $x=$row;
        if($x > 0)
        {
            $URSRC_already_exist_flag=1;
        }
        else{
            $URSRC_already_exist_flag=0;
        }
         return ($URSRC_already_exist_flag);

    }


}

