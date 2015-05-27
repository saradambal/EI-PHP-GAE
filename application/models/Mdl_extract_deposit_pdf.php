<?php
class Mdl_extract_deposit_pdf extends CI_Model{
    public function Initial_data(){
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList('263,264,265,266,267,268,269,270,271,282,381,449,452,459,468');
        $srtemailarray= $this->Common_function->getProfileEmailId('DD');
        $DDE_month_array =[];
        $DDE_month_exequery ="SELECT DDC_DATA FROM DEPOSIT_DEDUCTION_CONFIGURATION WHERE CGN_ID=30";
        $DDE_errormsg_rs = $this->db->query($DDE_month_exequery);
        $DDE_folderid=$DDE_errormsg_rs->row()->DDC_DATA;
        $curdate=date('Y-M');
        $date=explode('-',$curdate);
        $DDE_currentdateyear=$date[1];
        $DDE_currentmonth=$date[0];
        $DDE_ssname_currentyear='EI_DEPOSIT_DEDUCTIONS_'.$DDE_currentdateyear;
//        $DDE_getfiles = DriveApp.getFolderById($DDE_folderid).getFiles();
        $DDE_flag_ss=0;
//        while($DDE_getfiles.hasNext())
//        {
//            $DDE_oldfile=$DDE_getfiles.next();
//            $DDE_oldfile_id= $DDE_oldfile.getId();//DriveApp.getFilesByName(DDE_oldfile).next().getId();
//            if($DDE_oldfile==$DDE_ssname_currentyear)
//            {
//                $DDE_currentfile_id=$DDE_oldfile_id;
//                $DDE_flag_ss=1;
//            }
//        }
        if($DDE_flag_ss==0){
            return ['DDE_flag_noss'=>'DDE_flag_noss','DDE_errorAarray'=>$ErrorMessage];
        }
    }
}