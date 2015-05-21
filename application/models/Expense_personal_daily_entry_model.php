<?php
Class Expense_personal_daily_entry_model extends CI_Model {

    public function common_data($ErrorMessage)
    {
        //EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=22");
        $this->db->order_by("ECN_DATA", "asc");
        $expensetypeqry = $this->db->get();
        $expensetype=$expensetypeqry->result();

        // PERSONALEXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=24");
        $this->db->order_by("ECN_DATA", "asc");
        $perexpypeqry = $this->db->get();
        $perexpype=$perexpypeqry->result();

        //BABY EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=25");
        $this->db->order_by("ECN_DATA", "asc");
        $babyexptypeqry = $this->db->get();
        $babyexptype=$babyexptypeqry->result();

        //CAR EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=21");
        $this->db->order_by("ECN_DATA", "asc");
        $carexptypeqry = $this->db->get();
        $carexptype=$carexptypeqry->result();

//        //ERROR MESSAGE CONFIGURATION
//        $this->db->select("EMC_ID,EMC_DATA");
//        $this->db->from("ERROR_MESSAGE_CONFIGURATION");
//        $this->db->where("EMC_ID IN (105,400)");
//        $errmsg = $this->db->get();
//        $errormessage=$errmsg->result();

        //AUTOCOMPLETE FUNCTION FOR INVOICE FROM
        $this->db->select("EP_INVOICE_FROM");
        $this->db->from("EXPENSE_PERSONAL");
        $invoicefrom = $this->db->get();
        $personalinvoicefrom=$invoicefrom->result();

        return $arrayvalues=array($expensetype,$perexpype,$babyexptype,$carexptype,$ErrorMessage,$personalinvoicefrom);
    }
    // CAR EXPENSE INSERT FUNCTION
    public function carexpenseinsert($USERSTAMP){

        $invdate=$_POST['PCE_tb_invdate'];
        $invdate=date('Y-m-d',strtotime($invdate));
        $ecnid=$_POST['PCE_lb_ctry'];
        $ec_amount=$_POST['PCE_tb_invamt'];
        $ec_invoiceitesm=$this->db->escape_like_str($_POST['PCE_ta_invitems']);
        $ec_invoicefrom=$this->db->escape_like_str($_POST['PCE_tb_invfrom']);
        $ec_comments=$this->db->escape_like_str($_POST['PCE_ta_comments']);

        $insertquery = "INSERT INTO EXPENSE_CAR(ULD_ID,ECN_ID,EC_INVOICE_DATE,EC_AMOUNT,EC_INVOICE_ITEMS,EC_INVOICE_FROM,EC_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$ecnid','$invdate','$ec_amount','$ec_invoiceitesm','$ec_invoicefrom','$ec_comments')";

        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    // CAR LOAN INSERT FUNCTION
    public function carloaninsert($USERSTAMP){

        $paiddate=$_POST['PCLE_tb_paiddte'];
        $paiddate=date('Y-m-d',strtotime($paiddate));
        $fromperiod=$_POST['PCLE_tb_fromperiod'];
        $fromperiod=date('Y-m-d',strtotime($fromperiod));
        $toperiod=$_POST['PCLE_ta_toperiod'];
        $toperiod=date('Y-m-d',strtotime($toperiod));
        $invoiceamt=$_POST['PCLE_tb_invamt'];
        $invoice_comments=$this->db->escape_like_str($_POST['PCLE_ta_comments']);

        $insertquery = "INSERT INTO EXPENSE_CAR_LOAN(ULD_ID,ECL_PAID_DATE,ECL_FROM_PERIOD,ECL_TO_PERIOD,ECL_AMOUNT,ECL_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$paiddate','$fromperiod','$toperiod','$invoiceamt','$invoice_comments')";

        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //BABY AND PERSONAL SAVE FUNCTION
    public function babypersonalinsert($USERSTAMP){
        $PDLY_INPUT_typelistdb=$_POST['PE_lb_expensetype'];
        $PDLY_INPUT_expenselist=$_POST['PDLY_INPUT_lb_category'];
        $PDLY_INPUT_invoiceDate=$_POST['PDLY_INPUT_db_invdate'];
        $PDLY_INPUT_in_items=$_POST['PDLY_INPUT_ta_invitem'];
        $PDLY_INPUT_invoiceAmount=$_POST['PDLY_INPUT_tb_incamtrp'];
        $PDLY_INPUT_inv_from=$_POST['PDLY_INPUT_tb_invfrom'];
        $PDLY_INPUT_comments=$_POST['PDLY_INPUT_tb_comments'];
        $PDLY_INPUT_comments_split='';$PDLY_INPUT_invfrom_split='';$PDLY_INPUT_invitem_split='';
        $PDLY_INPUT_amountsplit='';$PDLY_INPUT_datesplit='';$PDLY_INPUT_ctrylist='';

         if((is_array($PDLY_INPUT_inv_from))==true){
         for($i=0;$i<count($PDLY_INPUT_inv_from);$i++)
         {
          if($PDLY_INPUT_comments[$i]=='')
          {
              if($i==0)
                  $PDLY_INPUT_comments_split.=' ';
                else
                    $PDLY_INPUT_comments_split.='^^'.' ';
          }
          else
          {
              if($i==0){
                  $PDLY_INPUT_comments_split.=$this->db->escape_like_str($PDLY_INPUT_comments[$i]);
              }
              else{
                  $PDLY_INPUT_comments_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_comments[$i]);
              }
          }
        if($i==0)
        {
          $PDLY_INPUT_invitem_split.=$this->db->escape_like_str($PDLY_INPUT_in_items[$i]);
          $PDLY_INPUT_invfrom_split.=$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
          $PDLY_INPUT_amountsplit=$PDLY_INPUT_invoiceAmount[$i];
          $PDLY_INPUT_datesplit=date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate[$i]));
          $PDLY_INPUT_ctrylist=$PDLY_INPUT_expenselist[$i];
        }
        else
        {
          $PDLY_INPUT_invitem_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_in_items[$i]);
          $PDLY_INPUT_invfrom_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
          $PDLY_INPUT_amountsplit.=",".$PDLY_INPUT_invoiceAmount[$i];
          $PDLY_INPUT_datesplit.=",".date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate[$i]));
          $PDLY_INPUT_ctrylist.=",".$PDLY_INPUT_expenselist[$i];
        }
        }
        }
        else
        {
            if($PDLY_INPUT_comments=='')
                $PDLY_INPUT_comments_split='';
            else
            {
                $PDLY_INPUT_comments_split=$this->db->escape_like_str($PDLY_INPUT_comments);
                $PDLY_INPUT_invfrom_split=$this->db->escape_like_str($PDLY_INPUT_inv_from);
                $PDLY_INPUT_invitem_split=$this->db->escape_like_str($PDLY_INPUT_in_items);
                $PDLY_INPUT_datesplit=date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate));
                $PDLY_INPUT_amountsplit=$PDLY_INPUT_invoiceAmount;
                $PDLY_INPUT_ctrylist=$PDLY_INPUT_expenselist;

            }
        }
        if($PDLY_INPUT_typelistdb==36)
        {
            $PDLY_INPUT_insertintoExpense_Baby_withComment = "CALL SP_PERSONALBABY_INSERT('$PDLY_INPUT_ctrylist','$PDLY_INPUT_datesplit','$PDLY_INPUT_amountsplit','$PDLY_INPUT_invitem_split','$PDLY_INPUT_invfrom_split','$PDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
            $this->db->query($PDLY_INPUT_insertintoExpense_Baby_withComment);
        }
        elseif($PDLY_INPUT_typelistdb==37)
        {
            $PDLY_INPUT_ExpensePersonal_withComment = "CALL SP_PERSONAL_INSERT('$PDLY_INPUT_ctrylist','$PDLY_INPUT_datesplit','$PDLY_INPUT_amountsplit','$PDLY_INPUT_invitem_split','$PDLY_INPUT_invfrom_split','$PDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
            $this->db->query($PDLY_INPUT_ExpensePersonal_withComment);
        }

        $PDLY_INPUT_rs_flag = 'SELECT @FLAG_INSERT as FLAG_INSERT';
        $query = $this->db->query($PDLY_INPUT_rs_flag);
        return $query->result();

    }


}