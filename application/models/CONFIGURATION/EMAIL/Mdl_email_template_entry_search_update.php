<?php
class Mdl_email_template_entry_search_update extends CI_Model{
    //FUNCTION FOR GETTING SCRIPT NAME
    Public function getscriptname()
    {
        $this->db->select("ET_ID,ET_EMAIL_SCRIPT");
        $this->db->order_by("ET_EMAIL_SCRIPT", "ASC");
        $this->db->from('EMAIL_TEMPLATE');
        $query = $this->db->get();
        return $query->result();
    }
    public function fetch_data($scriptid,$timeZoneFormat)
    {
        $this->db->select("EMD.ETD_ID,EMD.ETD_EMAIL_SUBJECT,EMD.ETD_EMAIL_BODY,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EMD.ETD_TIMESTAMP,".$timeZoneFormat."), '%d-%m-%Y %T') AS ETD_TIMESTAMP");
        $this->db->from('EMAIL_TEMPLATE_DETAILS EMD,USER_LOGIN_DETAILS ULD');
        $this->db->where("EMD.ULD_ID=ULD.ULD_ID AND EMD.ET_ID=".$scriptid);
        $query = $this->db->get();
        return $query->result();
    }
    public function update_data($id,$data){
        $this->db->where('ETD_ID', $id);
        $this->db->update('EMAIL_TEMPLATE_DETAILS', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //INLINE SUBJECT UPDATE
    public  function update_subdata($USERSTAMP,$id,$subjectvalue)
    {
        $updatequery = "UPDATE EMAIL_TEMPLATE_DETAILS SET ETD_EMAIL_SUBJECT='$subjectvalue',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE ETD_ID='$id'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //INLINE SUBJECT UPDATE
    public  function update_bdydata($USERSTAMP,$id,$bodyvalue)
    {
        $updatequery = "UPDATE EMAIL_TEMPLATE_DETAILS SET ETD_EMAIL_BODY='$bodyvalue',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE ETD_ID='$id'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //FUNCTION FOR SAVE PART
    public function login_models($scriptnme,$sub,$bdy,$USERSTAMP)
    {
        $sql = "CALL SP_EMAIL_TEMPLATE_INSERT('$scriptnme','$sub','$bdy','$USERSTAMP',@EMAILINSERT_FLAG)";
        $query = $this->db->query($sql);
        $this->db->select('@EMAILINSERT_FLAG as EMAILINSERT_FLAG', FALSE);
        $result = $this->db->get()->result_array();
        return  $result;
    }
    //FUNCTION FOR ALREADY EXIT
    public function script_name_exists($scriptnme)
    {
        $this->db->where('ET_EMAIL_SCRIPT',$scriptnme);
        $query = $this->db->get('EMAIL_TEMPLATE');

        if ($query->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
}
