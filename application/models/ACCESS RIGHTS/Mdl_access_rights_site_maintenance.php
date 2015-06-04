<?php
/**
//*******************************************FILE DESCRIPTION*********************************************/
//*******************************************SITE MAINTENANCE*********************************************//
//DONE BY:safi

//VER 0.01-INITIAL VERSION, SD:19/05/2015 ED:19/05/2015
//*********************************************************************************************************

class Mdl_access_rights_site_maintenance extends  CI_Model{


        //TREE VIEW
        public  function  USR_SITE_getintialvalue(){
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $USR_SITE_errmsg=$this->Mdl_eilib_common_function->getErrorMessageList('397,398');
            $this->db->select('MP_ID');
            $this->db->from('MENU_PROFILE');
            $this->db->where('MP_SCRIPT_FLAG IS NOT NULL');
            $USR_SITE_select_mpid=$this->db->get();
            $USR_SITE_usermenudetails_array=array();
            foreach($USR_SITE_select_mpid->result_array() as $row)
            {
                $USR_SITE_usermenudetails_array[]=$row["MP_ID"];
            }
            $URSRC_main_main=array();
            $URSRC_first_submenu=array();
            $URSRC_second_sub_menu=array();
            $i=0;
            $main_menu_query= $this->db->query("SELECT DISTINCT MP_MNAME FROM MENU_PROFILE MP WHERE MP_ID NOT IN(40,41,42,43) ORDER BY MP_MNAME ASC");
            foreach ($main_menu_query->result_array() as $row)//main menu loop
            {
                $URSRC_main_main[]=$row["MP_MNAME"];
                $URSRC_submenu_array =array();
                $sub_menu_query=$this->db->query("SELECT  MP_MSUB, MP.MP_ID FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND MP.MP_MSUB IS NOT NULL GROUP BY MP_MSUB ORDER BY MP.MP_MSUB ASC ");
                $j=0;
                $URSRC_submenu=array();
                foreach($sub_menu_query->result_array() as $row1)//sub menu loop
                {
                    $URSRC_submenu[]=$row1["MP_MSUB"];
                    if($URSRC_submenu[$j]!=''){
                        $URSRC_select_mpid=$this->db->query("SELECT  MP.MP_ID FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP_MSUB='".$URSRC_submenu[$j]."' and MP.MP_MSUB IS NOT NULL GROUP BY MP_MSUB ORDER BY MP.MP_MSUB ASC ");
                        foreach($URSRC_select_mpid->result_array() as $row2){
                            $mp_id=$row2['MP_ID'];
                            $final_submenu=$URSRC_submenu[$j]."_".$mp_id;
                            $URSRC_submenu_array[]=($final_submenu);
                        }
                    }
                    $URSRC_sub_submenu_array =array();
                    $URSRC_sub_submenu=array();
                    $URSRC_select_sub_submenu=$this->db->query("SELECT MP.MP_ID, MP_MSUBMENU FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU IS NOT NULL  ORDER BY MP_MSUBMENU ASC");
                    $h=0;
                    foreach($URSRC_select_sub_submenu->result_array() as $row3)//sun sub menu loop
                    {
                        $URSRC_sub_submenu[]=$row3["MP_MSUBMENU"];
                        if($URSRC_sub_submenu[$h]!=""){
                            $select_mpid=$this->db->query("SELECT MP.MP_ID, MP_MSUBMENU FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU='".$URSRC_sub_submenu[$h]."' AND MP.MP_MSUBMENU IS NOT NULL  ORDER BY MP_MSUBMENU ASC");
                            foreach($select_mpid->result_array() as $row4){
                                $mp_id=$row4["MP_ID"];
                                $URSRC_final_sub_submenu=$URSRC_sub_submenu[$h]."_".$mp_id;
                                $URSRC_sub_submenu_array[]=($URSRC_final_sub_submenu);
                            }
                        }
                        $h++;
                    }//sub sub menu loop end
                    $URSRC_second_sub_menu[]=($URSRC_sub_submenu_array);
                    $j++;
                }//sub menu loop end
                $URSRC_first_submenu[]=($URSRC_submenu_array);
                $i++;
            }//main menu loop end
            $USR_SITE_menuarray=[$URSRC_main_main,$URSRC_first_submenu,$URSRC_second_sub_menu];
            $final_values=[$USR_SITE_menuarray,$USR_SITE_usermenudetails_array,$USR_SITE_errmsg];
            return $final_values;
        }
        ////FUNCTION FOR TO UPDATE THE MENU PROFILE
        public function USR_SITE_update($mainmenu,$Sub_menu,$Sub_menu1){
            $USR_SITE_menu=$mainmenu;
            $USR_SITE_menuid='';
            $USR_SITE_sub_submenu=$Sub_menu1;
            $USR_SITE_submenu=$Sub_menu;
            if($USR_SITE_menu==NULL && $USR_SITE_submenu==NULL && $USR_SITE_sub_submenu==NULL){
                $id='null';
                $this->db->trans_begin();
                $USR_SITE_callsp = ("CALL SP_ACCESS_RIGHTS_SITE_MAINTANENCE('$id')");
                $this->db->query($USR_SITE_callsp);
                if ($this->db->trans_status() === FALSE){
                    $result=0;
                }
                else{
                    $result=1;
                }
                echo $result;
            }
            else{
                $USR_SITE_sub_submenu_array=array();
                $submenu_array=array();
                $menu_array=array();
                $sub_menu_menus=array();
                $length=count($USR_SITE_submenu);
                $sub_menu1_length=count($USR_SITE_sub_submenu);
                for($i=0;$i<$length;$i++){
                    if (!(preg_match('/&&/',$USR_SITE_submenu[$i])))
                    {
                        $sub_menu_menus[]=$USR_SITE_submenu[$i];
                    }
                }
                if($sub_menu1_length!=0){
                    for($j=0;$j<$sub_menu1_length;$j++){
                        $sub_menu_menus[]=$USR_SITE_sub_submenu[$j];
                    }
                }
                $id='';
                for($j=0;$j<count($sub_menu_menus);$j++){
                    if($j==0){
                        $id=$sub_menu_menus[$j];
                    }
                    else{
                        $id=$id .",".$sub_menu_menus[$j];
                    }
                }
                $this->db->trans_begin();
                $USR_SITE_callsp = ("CALL SP_ACCESS_RIGHTS_SITE_MAINTANENCE('$id')");
                $this->db->query($USR_SITE_callsp);
                if ($this->db->trans_status() === FALSE){
                    $result=0;
                }
                else{
                    $result=1;
                }
                echo $result;
            }
        }
}


