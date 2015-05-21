<?php
class Mdl_Customer_access_card_card_assign extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select('UNIT_ID,UNIT_NO,CED_REC_VER,CUSTOMER_ID,CUSTOMERNAME,DATE_FORMAT(CLP_STARTDATE,"%d-%m-%Y") as CLP_STARTDATE,DATE_FORMAT(CLP_ENDDATE,"%d-%m-%Y") as CLP_ENDDATE,DATE_FORMAT(CLP_PRETERMINATE_DATE,"%d-%m-%Y") as CLP_PRETERMINATE_DATE');
        $this->db->from('VW_CARDASSIGN');
        $this->db->order_by('UNIT_NO');
        $this->db->order_by('CUSTOMERNAME');
        $this->db->order_by('CED_REC_VER');
        $query = $this->db->get();
        $result1 = $query->result();
        $resultset=array($result1,$ErrorMessage);
        return $resultset;
    }
    public function Customer_details($CA_recver,$CA_unit,$CA_custid,$USERSTAMP){
        $CA_guest_array=[];
        $flag=0;
        $this->db->select('CLP.UASD_ID');
        $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($CA_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL AND CLP.CED_REC_VER IN (SELECT CED_REC_VER  FROM VW_CARDASSIGN)');
        $query = $this->db->get();
        $resultrow = $query->result();
        if(count($resultrow)>=1){
            $flag=1;
            $prev_recver=$CA_recver-1;
        }
        if($flag==1){
            $this->db->select('CLP.UASD_ID');
            $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
            $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($prev_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL and CLP.CED_REC_VER in (select CED_REC_VER  FROM VW_CARDASSIGN)');
            $query = $this->db->get();
            $resultrow1 = $query->result();
            if(count($resultrow1)>=1){
                $prev_recver=$prev_recver-1;
            }
        }
        $CA_today_date=date('Y-M-d');
        $this->db->select('URTD.URTD_ROOM_TYPE');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('(CED.CUSTOMER_ID='.$CA_custid.') AND (CED.CED_REC_VER='.$CA_recver.') AND (UASD.UASD_ID=CED.UASD_ID) AND (UASD.URTD_ID=URTD.URTD_ID)');
        $roomtype = $this->db->get();
        $roomtyperow = $roomtype->row()->URTD_ROOM_TYPE;
    // sp
        $callquery="CALL SP_CUSTOMER_CARD_ASSIGN_TEMP_FEE_DETAIL(".$CA_custid.",'".$USERSTAMP."',@CARD_FEETMPTBLNAM)";
        $this->db->query($callquery);
        $outparm_query = 'SELECT @CARD_FEETMPTBLNAM AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $tablename=$outparm_result->row()->TEMP_TABLE;
        $this->db->select();
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC,UNIT U');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD', 'CED.CUSTOMER_ID=CCD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_LP_DETAILS CLP', 'CED.CUSTOMER_ID=CLP.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD', 'CLP.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID' , 'left');
        $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD', 'CLP.UASD_ID=UASD.UASD_ID AND CACD.UASD_ID=UASD.UASD_ID' , 'left');
        $this->db->join($tablename.' CF', 'CED.CUSTOMER_ID=CF.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CED.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD', 'CED.CUSTOMER_ID=CPD.CUSTOMER_ID' , 'left');
        $this->db->where('U.UNIT_ID=CED.UNIT_ID AND CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CLP.CLP_TERMINATE IS NULL AND CACD.CACD_VALID_TILL IS NULL AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CA_custid.') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=CF.CUSTOMER_VER) AND (CED.CED_REC_VER='.$CA_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
        $this->db->order_by('CED.CED_REC_VER');
        $query = $this->db->get();
        $CA_alldetails = $query->result();
        return $CA_alldetails;
    }
}