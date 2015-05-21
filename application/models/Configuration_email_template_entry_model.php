<?php
class Configuration_email_template_entry_model extends CI_Model{
    //FUNCTION FOR SAVE PART
    public function login_models($scriptnme,$sub,$bdy,$USERSTAMP)
    {
        global  $USERSTAMP;
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
