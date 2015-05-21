<?php
class Mdl_email_profile_forms extends CI_Model{
    //FUNCTION FOR GETTING MODEL NAME
    Public function getprofilename($EMAIL_ENTRY_searchby)
    {
        if($EMAIL_ENTRY_searchby=="EMAIL ENTRY")
        {
            $this->db->select("EP_ID,EP_EMAIL_DOMAIN");
            $this->db->order_by("EP_EMAIL_DOMAIN", "ASC");
            $this->db->from('EMAIL_PROFILE');
            $this->db->where('EP_NON_IP_FLAG is null');
            $query = $this->db->get();
            return $query->result();
        }
        else{
            $this->db->distinct();
            $this->db->select("EP.EP_ID,EP.EP_EMAIL_DOMAIN,EL.EL_ID,EP.EP_NON_IP_FLAG");
            $this->db->order_by("EP_EMAIL_DOMAIN", "ASC");
            $this->db->from('EMAIL_PROFILE EP,EMAIL_LIST EL');
            $this->db->where('EL.EP_ID=EP.EP_ID');
            $query = $this->db->get();
            return $query->result();
        }
    }
    public function fetch_data($scriptid)
    {
        $this->db->select("EL_ID,EL_EMAIL_ID,ULD.ULD_LOGINID AS USERSTAMP,EP_NON_IP_FLAG,DATE_FORMAT(CONVERT_TZ(EL_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS TIMESTAMP");
        $this->db->order_by("EL.EL_EMAIL_ID", "ASC");
        $this->db->from('EMAIL_LIST EL,EMAIL_PROFILE EP ,USER_LOGIN_DETAILS ULD');
        $this->db->where("EL.EP_ID='$scriptid' AND (EL.EP_ID=EP.EP_ID AND EL.ULD_ID=ULD.ULD_ID)");
        $query = $this->db->get();
        return $query->result();
    }
    // EXPENSE CARLOAN UPDATE PART
    public  function email_update($USERSTAMP,$rowid,$profileid)
    {
        $updatequery = "UPDATE EMAIL_LIST SET EL_EMAIL_ID='$profileid',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE EL_ID='$rowid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //FUNCTION FOR ALREADY EXIT
    public function email_name_exists($EP_ENTRY_emailid,$EP_ENTRY_listboxname)
    {
        $EP_ENTRY_alreadyemailid = "SELECT * FROM EMAIL_LIST WHERE EL_EMAIL_ID='$EP_ENTRY_emailid' AND EP_ID=(SELECT  EP_ID FROM EMAIL_PROFILE WHERE EP_EMAIL_DOMAIN='$EP_ENTRY_listboxname')";
        $this->db->query($EP_ENTRY_alreadyemailid);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    //FUNCTION FOR SAVE PART
    public function save_models($EP_ENTRY_profilenameid,$EP_ENTRY_emailid,$USERSTAMP)
    {
        global  $USERSTAMP;
        $insertquery = "INSERT INTO EMAIL_LIST(ULD_ID,EP_ID,EL_EMAIL_ID) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$EP_ENTRY_profilenameid','$EP_ENTRY_emailid')";
        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //SINGLE ROW DELETION PROCESS CALLING EILIB  FUNCTION
    public function DeleteRecord($USERSTAMP,$rowid)
    {
        global  $USERSTAMP;
          $this->load->model('Eilib/Common_function');
          $deleteflag=$this->Common_function->DeleteRecord(22,$rowid,$USERSTAMP);
          return $deleteflag;
    }
    //FUNCTION FOR ALREADY EXIT
    public function updemail_name_exists($EP_SRC_UPD_DEL_updemailid,$EP_ENTRY_listboxname)
    {
        $EP_ENTRY_alreadyemailid = "SELECT * FROM EMAIL_LIST WHERE EL_EMAIL_ID='$EP_SRC_UPD_DEL_updemailid' AND EP_ID=(SELECT  EP_ID FROM EMAIL_PROFILE WHERE EP_EMAIL_DOMAIN='$EP_ENTRY_listboxname')";
        $this->db->query($EP_ENTRY_alreadyemailid);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
}