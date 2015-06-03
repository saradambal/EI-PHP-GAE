<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 29-05-2015
 * Time: 05:14 PM
 */

class Mdl_report_report extends CI_Model {
    public function REP_getdomain_err(){

        $REP_searchoptions_dataid=array();
        $this->db->select('CGN_ID,CGN_TYPE');
        $this->db->from('CONFIGURATION');
        $this->db->where('CGN_ID IN(59,60,61,73,82)');
        $this->db->order_by('CGN_TYPE ASC');
        $REP_select_catagotyreport_name=$this->db->get();
//        $REP_select_catagotyreport_name="SELECT CGN_ID,CGN_TYPE FROM CONFIGURATION WHERE CGN_ID IN(59,60,61,73,82) ORDER BY CGN_TYPE ASC";
//        $REP_catagoryreport_name_stmt=REP_conn.createStatement();
//        $REP_catagoryreport_name_rs=REP_catagoryreport_name_stmt.executeQuery( REP_select_catagotyreport_name);
        foreach($REP_select_catagotyreport_name->result_array() as $row) {
            $REP_searchoptions_id = $row['CGN_ID'];
            $REP_searchoptions_data = $row['CGN_TYPE'];
            $REP_searchoptions_object = (object)["REP_searchoption_id" => $REP_searchoptions_id, "REP_searchoption_data" => $REP_searchoptions_data];
            $REP_searchoptions_dataid[]=$REP_searchoptions_object;
        }

        //REPORT NAME
        $REP_report_name_arraydataid=array();
        $this->db->select('RCN_ID,RCN_DATA');
        $this->db->from('REPORT_CONFIGURATION');
        $this->db->where('RCN_INITIALIZE_FLAG','X');
        $this->db->order_by('RCN_DATA ASC');
        $REP_select_report_name=$this->db->get();
        //        $REP_select_report_name="SELECT RCN_ID,RCN_DATA FROM REPORT_CONFIGURATION WHERE RCN_INITIALIZE_FLAG='X' ORDER BY RCN_DATA ASC";
        //        $REP_report_name_rs=REP_report_name_stmt.executeQuery( REP_select_report_name);
        foreach($REP_select_report_name->result_array() as $row)
        {
            $REP_reportname_id=$row['RCN_ID'];
            $REP_reportname_data=$row['RCN_DATA'];
            $REP_reportname_object=(object)["REP_reportnames_id"=>$REP_reportname_id,"REP_reportnames_data"=>$REP_reportname_data];
            $REP_report_name_arraydataid[]=($REP_reportname_object);
        }
        //        REP_report_name_rs.close();
        //        REP_report_name_stmt.close();
        //EMAIL ID
        $REP_emailid_array=array();
        $this->load->model('EILIB/Common_function');
        $REP_emailid_array= $this->Common_function->getProfileEmailId('REPORT');
        //        $REP_emailid_array=eilib.getProfileEmailId(REP_conn,"REPORT")
        //RETRIEVE MESSAGE FOR REPORT RECORD FROM ERROR TABLE
        $REP_errmsgids="282,341,395,459";
        $REP_errorMsg_array=array();
        $REP_errorMsg_array=$this->Common_function->getErrorMessageList($REP_errmsgids);
        $REP_result=(object)["REP_catagoryreportname"=>$REP_searchoptions_dataid,"REP_reportname"=>$REP_report_name_arraydataid,"REP_emailid"=>$REP_emailid_array,"REP_errormsg"=>$REP_errorMsg_array];
        //    REP_conn.close();
        return $REP_result;
    }
    //FUNCTION FOR ALL SEARCH BY CATAGORY REPORT
    function REP_func_load_searchby_option($REP_report_optionfetch){
        $REP_loaddata_arrdataid=array();
        $REP_selectquery=array();
        $REP_selectquery[59]='1,2,3,4,5,30';$REP_selectquery[60]='6';$REP_selectquery[61]='7,8,31';$REP_selectquery[73]='28';$REP_selectquery[82]='32';
        $this->db->select('RCN_ID,RCN_DATA');
        $this->db->from('REPORT_CONFIGURATION');
        $this->db->where('RCN_ID',$REP_selectquery[$REP_report_optionfetch]);
        $this->db->order_by('RCN_DATA');
        $REP_separate_rs=$this->db->get();

//      $REP_reportconfig="SELECT RCN_ID,RCN_DATA FROM REPORT_CONFIGURATION WHERE RCN_ID IN ("+REP_selectquery[REP_report_optionfetch]+") ORDER BY RCN_DATA ASC";
//       $REP_separate_rs=REP_stmt.executeQuery(REP_reportconfig);
        foreach($REP_separate_rs->result_array() as $row){
            $REP_seperatereportname_id=$row['RCN_ID'];
            $REP_seperatereportname_data=$row['RCN_DATA'];
            $REP_seperatereportname_object=(object)["REP_seperatereportnames_id"=>$REP_seperatereportname_id,"REP_seperatereportnames_data"=>$REP_seperatereportname_data];
            $REP_loaddata_arrdataid[]=($REP_seperatereportname_object);
        }
        $REP_result_obj=(object)["REP_loaddata_searchby"=>$REP_loaddata_arrdataid,"REP_flag"=>$REP_report_optionfetch];
//    REP_separate_rs.close();
//    REP_stmt.close();
//    REP_conn.close();
        return $REP_result_obj;
    }
    // FUNCTION FOR SHOW THE DATA IN SS
    public function REP_ss_getdatas($REP_id,$REP_name,$REP_emailid,$REP_catagry,$REP_dtepickmonth)
    {
    if($REP_id==32)//ERM LEEDS
        {
            if($REP_dtepickmonth!=null)
            {
               $REP_dtepickmonth=explode('-',$REP_dtepickmonth);
                $monthArr=['January','February','March','April','May','June','July','August','September','October','November','December'];
//               print_r($monthArr);
//                exit;
                $fromMonth=$REP_dtepickmonth[0];
                $toMonth=$REP_dtepickmonth[1];
//                echo $fromMonth;
//                print_r($monthArr);
//                exit;

                             for($i=0;$i<=count($monthArr);$i++)
                               {
                                  if($monthArr[$i]==$fromMonth)
                                  {
                                 $getfromMonth=$i;
                                   }
                               }
//                echo $fromMonth;
//                echo $toMonth;
//                exit;
                $getdate= date("d", strtotime($fromMonth));
//                $newdate=new Date($toMonth,$getfromMonth);


//               $getdate=$newdate.getDate();
//                echo $fromMonth;
//                echo $toMonth;
////                echo $newdate;
//                print_r($getdate);
//                exit;
      $endnewdate=new Date(toMonth,getfromMonth,getdate-1);
      $startdate=new Date(toMonth,getfromMonth-1);
//      var REP_utstrdte=Utilities.formatDate(new Date(startdate), TimeZone,'yyyy-MM-dd');
//      var REP_utenddte=Utilities.formatDate(new Date(endnewdate),TimeZone, 'yyyy-MM-dd');
            }
        }
    }

}