<?php
class Common extends CI_Model {
    Public function getAllActiveUnits()
    {
        $this->db->select("UNIT_NO");
        $this->db->order_by("UNIT_NO", "ASC");
        $this->db->from('VW_ACTIVE_UNIT');
        $query = $this->db->get();
        return $query->result();
    }
    Public function getAllUnits()
    {
        $this->db->select("UNIT_NO");
        $this->db->order_by("UNIT_NO", "ASC");
        $this->db->from('UNIT');
        $query = $this->db->get();
        return $query->result();
    }
    Public function getNationality()
    {
        $this->db->select("NC_DATA");
        $this->db->order_by("NC_DATA", "ASC");
        $this->db->from('NATIONALITY_CONFIGURATION');
        $query = $this->db->get();
        return $query->result();
    }
    Public function getEmailId($formname)
    {
        if($formname=='CustomerCreation')
        {
        $formid=1;
        }
        $this->db->select("EL_EMAIL_ID");
        $this->db->order_by("EL_EMAIL_ID", "ASC");
        $this->db->from('EMAIL_LIST');
        $this->db->where('EP_ID='.$formid);
        $query = $this->db->get();
        return $query->result();
    }
    Public function getOption()
    {
        $this->db->select("CCN_ID,CCN_DATA");
        $this->db->order_by("CCN_DATA", "ASC");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CGN_ID=3');
        $query = $this->db->get();
        return $query->result();
    }
    Public function getErrorMessageList($errormessage)
    {
        $this->db->select("EMC_ID,EMC_DATA");
        $this->db->order_by("EMC_ID", "ASC");
        $this->db->from('ERROR_MESSAGE_CONFIGURATION');
        $this->db->where('EMC_ID IN('.$errormessage.')');
        $query = $this->db->get();
        return $query->result();
    }
    public function getTimeList()
    {
        $this->db->select("DATE_FORMAT(CTP_DATA, '%H:%i')AS TIME");
        $this->db->from('CUSTOMER_TIME_PROFILE');
        $query = $this->db->get();
        return $query->result();
    }
    public function getUnitRoomType($unit)
    {
        $this->db->select("URTD.URTD_ID,URTD.URTD_ROOM_TYPE");
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('URTD.URTD_ID=UASD.URTD_ID AND U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='.$unit);
        $query = $this->db->get();
        return $query->result();
    }
    public function getUnit_Start_EndDate($unit)
    {
        $this->db->select("UD_START_DATE,UD_END_DATE");
        $this->db->from('UNIT_DETAILS UD,UNIT U');
        $this->db->where('U.UNIT_ID=UD.UNIT_ID AND U.UNIT_NO='.$unit);
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomerStartDate()
    {
        $this->db->select("CCN_DATA");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CGN_ID=76');
        $query = $this->db->get();
        return $query->result();
    }
    public function CUST_getunitCardNo($unit)
    {
        $this->db->select("UASD.UASD_ACCESS_CARD");
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND U.UNIT_NO='.$unit);
        $this->db->order_by("UASD.UASD_ACCESS_CARD", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function CUST_getProratedWaivedValue()
    {
        $this->db->select("CCN_DATA");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CCN_ID IN(7,8)');
        $this->db->order_by("CCN_ID", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getOccupationList()
    {
        $this->db->select("ERMO_DATA");
        $this->db->from('ERM_OCCUPATION_DETAILS');
        $this->db->order_by("ERMO_DATA", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

}