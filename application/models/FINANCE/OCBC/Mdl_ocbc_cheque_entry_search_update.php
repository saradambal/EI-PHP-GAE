<?php
error_reporting(0);
class Mdl_ocbc_cheque_entry_search_update extends CI_Model
{
  public function Cheque_Entry_FormData_Save($UserStamp)
  {
      $chequedate=date('Y-m-d',strtotime($_POST['CHEQUE_ENTRY_db_date']));
      $chequeno=$_POST['CHEQUE_ENTRY_tb_chequeno'];
      $chequeto=$_POST['CHEQUE_ENTRY_tb_chequeto'];
      $chequefor=$_POST['CHEQUE_ENTRY_tb_chequefor'];
      $chequeamount=$_POST['CHEQUE_ENTRY_tb_amount'];
      $chequeunit=$_POST['CHEQUE_ENTRY_tb_unit'];
      $chequecomments=$this->db->escape_like_str($_POST['CHEQUE_ENTRY_ta_comments']);
      $CHEQUE_ENTRY_QUERY="CALL SP_CHEQUE_INSERT('$chequedate','$chequeto',$chequeno,'$chequefor',$chequeamount,'$chequeunit','$chequecomments','$UserStamp',@CHEQUEFLAG)";
      $this->db->query($CHEQUE_ENTRY_QUERY);
      $Cheque_Entry_flag = 'SELECT @CHEQUEFLAG as FLAG_INSERT';
      $query = $this->db->query($Cheque_Entry_flag);
      $Confirm_Meessage=$query->row()->FLAG_INSERT;
      return $Confirm_Meessage;
  }
    public function getSearchOption()
    {
        $this->db->select('CQCN_ID,CQCN_DATA');
        $this->db->from('CHEQUE_CONFIGURATION');
        $this->db->order_by("CQCN_DATA", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getChequeStatus()
    {
        $this->db->select('BCN_ID,BCN_DATA');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->order_by("BCN_DATA", "ASC");
        $this->db->where('CGN_ID=70');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllDatas($Option,$Data1,$Data2,$timeZoneFormat)
    {
        if($Option==1)
        {
            $query=$this->db->query("SELECT CED.CHEQUE_ID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DATE,CED.CHEQUE_NO,CED.CHEQUE_TO,CED.CHEQUE_FOR,CED.CHEQUE_AMOUNT,CED.CHEQUE_UNIT_NO,BC.BCN_DATA,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DEBITED_RETURNED_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DEBITED_RETURNED_DATE,CED.CHEQUE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS CED_TIME_STAMP FROM CHEQUE_ENTRY_DETAILS CED,BANKTT_CONFIGURATION BC,USER_LOGIN_DETAILS ULD WHERE CED.BCN_ID=BC.BCN_ID AND CED.CHEQUE_AMOUNT BETWEEN '$Data1' AND '$Data2' AND ULD.ULD_ID=CED.ULD_ID ORDER BY CHEQUE_NO ASC");
        }
        if($Option==2)
        {
            $query=$this->db->query("SELECT CED.CHEQUE_ID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DATE,CED.CHEQUE_NO,CED.CHEQUE_TO,CED.CHEQUE_FOR,CED.CHEQUE_AMOUNT,CED.CHEQUE_UNIT_NO,BC.BCN_DATA,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DEBITED_RETURNED_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DEBITED_RETURNED_DATE,CED.CHEQUE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS CED_TIME_STAMP FROM CHEQUE_ENTRY_DETAILS CED,BANKTT_CONFIGURATION BC,USER_LOGIN_DETAILS ULD WHERE CED.BCN_ID=BC.BCN_ID AND CED.CHEQUE_NO ='$Data1' AND ULD.ULD_ID=CED.ULD_ID ORDER BY CHEQUE_NO ASC");
        }
        if($Option==3)
        {
            $fromdate=date('Y-m-d',strtotime($Data1));
            $todate=date('Y-m-d',strtotime($Data2));
            $query=$this->db->query("SELECT CED.CHEQUE_ID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DATE,CED.CHEQUE_NO,CED.CHEQUE_TO,CED.CHEQUE_FOR,CED.CHEQUE_AMOUNT,CED.CHEQUE_UNIT_NO,BC.BCN_DATA,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DEBITED_RETURNED_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DEBITED_RETURNED_DATE,CED.CHEQUE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS CED_TIME_STAMP FROM CHEQUE_ENTRY_DETAILS CED,BANKTT_CONFIGURATION BC,USER_LOGIN_DETAILS ULD WHERE CED.BCN_ID=BC.BCN_ID AND CED.CHEQUE_DATE BETWEEN '$fromdate' AND '$todate' AND ULD.ULD_ID=CED.ULD_ID ORDER BY CHEQUE_DATE ASC");
        }
        if($Option==4)
        {
            $query=$this->db->query("SELECT CED.CHEQUE_ID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DATE,CED.CHEQUE_NO,CED.CHEQUE_TO,CED.CHEQUE_FOR,CED.CHEQUE_AMOUNT,CED.CHEQUE_UNIT_NO,BC.BCN_DATA,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_DEBITED_RETURNED_DATE,".$timeZoneFormat."), '%d-%m-%Y')AS CHEQUE_DEBITED_RETURNED_DATE,CED.CHEQUE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(CED.CHEQUE_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS CED_TIME_STAMP FROM CHEQUE_ENTRY_DETAILS CED,BANKTT_CONFIGURATION BC,USER_LOGIN_DETAILS ULD WHERE CED.BCN_ID=BC.BCN_ID AND CED.CHEQUE_UNIT_NO ='$Data1' AND ULD.ULD_ID=CED.ULD_ID ORDER BY CHEQUE_UNIT_NO ASC");
        }
        return $query->result();
    }
    public function getChequeNo()
    {
        $this->db->select('CHEQUE_NO');
        $this->db->from('CHEQUE_ENTRY_DETAILS');
        $this->db->order_by("CHEQUE_NO", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getChequeUnit()
    {
        $this->db->select('CHEQUE_UNIT_NO');
        $this->db->from('CHEQUE_ENTRY_DETAILS');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getUpdation_Details($Rowid,$chequedate,$chequeno,$chequeto,$chequefor,$checkamount,$checkunit,$checkstatus,$checquedebiteddate,$comments,$UserStamp,$timeZoneFormat)
    {
        $chequedate=date('Y-m-d',strtotime($chequedate));
        if($checquedebiteddate!=''){$checquedebiteddate=date('Y-m-d',strtotime($chequedate));}
        $comments=$this->db->escape_like_str($comments);
        $updatequery="CALL SP_CHEQUE_UPDATE($Rowid,'$checkstatus','$chequedate','$chequeto','$chequeno','$chequefor',$checkamount,'$checkunit','$checquedebiteddate','$comments','$UserStamp',@CHEQUEFLAG)";
        $this->db->query($updatequery);
        $ERM_Entry_flag = 'SELECT @CHEQUEFLAG as FLAG_UPDATE';
        $query = $this->db->query($ERM_Entry_flag);
        $Confirm_Meessage=$query->row()->FLAG_UPDATE;
        $Timestamp;
        if($Confirm_Meessage==1)
        {
            $SelectQuery="SELECT DATE_FORMAT(CONVERT_TZ(CHEQUE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CHEQUE_TIMESTAMP FROM CHEQUE_ENTRY_DETAILS WHERE CHEQUE_ID=".$Rowid;
            $query = $this->db->query($SelectQuery);
            $Timestamp=$query->row()->CHEQUE_TIMESTAMP;
        }
       $ReturnValues=array($Confirm_Meessage,$UserStamp,$Timestamp);
        return $ReturnValues;
    }
}