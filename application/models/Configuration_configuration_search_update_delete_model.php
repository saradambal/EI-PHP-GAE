<?php
class Configuration_configuration_search_update_delete_model extends CI_Model{
//FUNCTION FOR GETTING MODEL NAME
    Public function getmodulename()
    {
        $this->db->distinct();
        $this->db->select("CP.CNP_ID,CP.CNP_DATA");
        $this->db->order_by("CP.CNP_DATA", "ASC");
        $this->db->from('CONFIGURATION_PROFILE CP,CONFIGURATION C');
        $this->db->where('CP.CNP_ID=C.CNP_ID AND (C.CGN_NON_IP_FLAG ="X")');
        $query = $this->db->get();
        return $query->result();
    }
    //FUNCTION FOR GETTING TYPE NAME
    Public function gettypename($CONFIG_SRCH_UPD_mod)
    {
//        print_r($CONFIG_ENTRY_data);
//        exit;
//        $this->Db_configuration_configuration_entry->login_models($this->input->post('CONFIG_ENTRY_data'));
        $this->db->distinct();
        $this->db->select("CNP_ID,CGN_TYPE");
        $this->db->order_by("CGN_TYPE", "ASC");
        $this->db->from("CONFIGURATION C");
        $this->db->where("CNP_ID='$CONFIG_SRCH_UPD_mod' AND (CGN_NON_IP_FLAG != 'XX' or CGN_NON_IP_FLAG is null)");
        $query = $this->db->get();
        return $query->result_array();
    }
}