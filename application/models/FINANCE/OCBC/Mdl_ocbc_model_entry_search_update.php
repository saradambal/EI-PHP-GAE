<?php
error_reporting(0);
class Mdl_ocbc_model_entry_search_update extends CI_Model
{
    public function getAllModels_Details($timeZoneFormat)
    {
        $MODEL_SRC_modelselect_query ="SELECT BTM.BTM_ID,BTM.BTM_DATA,BTM.BTM_OBSOLETE,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BTM.BTM_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BTM_TIME_STAMP FROM BANK_TRANSFER_MODELS BTM,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=BTM.ULD_ID ORDER BY BTM_DATA ASC";
        $resultset=$this->db->query($MODEL_SRC_modelselect_query);
        return $resultset->result();
    }
    public function ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option)
    {
        if($Option=='Model')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_DATA='$modelname',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
        }
        if($Option=='Obsolete')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_OBSOLETE='$modelname',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
        }
        $resultset=$this->db->query($MODEL_SRC_updatequery);
        return $resultset;
    }
    public function ModelnameDeletion($UserStamp,$Rowid)
    {
        $this->db->select("BTM_ID");
        $this->db->from('BANK_TRANSFER');
        $this->db->where("BTM_ID=".$Rowid);
        $id=$this->db->get()->row()->BTM_ID;
        $returnmessage;
        if($id!='')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_OBSOLETE='X',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
            $this->db->query($MODEL_SRC_updatequery);
            $returnmessage='UPDATED';
        }
        return $returnmessage;
    }
    public function NewModelnameInsert($UserStamp,$modelname)
    {
        $UserStamp="'".$UserStamp."'";
        $modelname="'".$modelname."'";
        $modelinsertquery="INSERT INTO BANK_TRANSFER_MODELS(BTM_DATA,ULD_ID) VALUES(".$modelname.",(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID=".$UserStamp."))";
        $result=$this->db->query($modelinsertquery);
        return $result;
    }
}