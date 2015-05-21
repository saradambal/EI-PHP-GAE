<?php
class Pdfcontroller extends CI_Controller{

    public function pdfexport()
    {
        $this->load->library('pdf');
        $data='';
        $PDLY_SEARCH_lb_babysearchoptionmatch= $this->input->post('PDLY_SEARCH_lb_babysearchoption');
        $PDLY_SEARCH_lbl_flextableheader=$this->input->post('PDLY_SEARCH_hdn_flextableheader');
        $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
        if(($PDLY_SEARCH_lb_babysearchoptionmatch==56)||($PDLY_SEARCH_lb_babysearchoptionmatch==62)||($PDLY_SEARCH_lb_babysearchoptionmatch==73)||($PDLY_SEARCH_lb_babysearchoptionmatch==67))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments=$this->input->post('PDLY_SEARCH_tb_searchabycmt');
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $this->load->model('Pdf_model');
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==52)||($PDLY_SEARCH_lb_babysearchoptionmatch==58)||($PDLY_SEARCH_lb_babysearchoptionmatch==69))
        {
              $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory=$this->input->post('PDLY_SEARCH_lb_babyexpansecategory');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $this->load->model('Pdf_model');
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==51)||($PDLY_SEARCH_lb_babysearchoptionmatch==57)||($PDLY_SEARCH_lb_babysearchoptionmatch==68)||($PDLY_SEARCH_lb_babysearchoptionmatch==65))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount=$this->input->post('PDLY_SEARCH_tb_fromamount');
            $PDLY_SEARCH_toamount=$this->input->post('PDLY_SEARCH_tb_toamount');;
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('Pdf_model');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==53)||($PDLY_SEARCH_lb_babysearchoptionmatch==59)||($PDLY_SEARCH_lb_babysearchoptionmatch==70)||($PDLY_SEARCH_lb_babysearchoptionmatch==63)||($PDLY_SEARCH_lb_babysearchoptionmatch==66)||($PDLY_SEARCH_lb_babysearchoptionmatch==64))
        {
           $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('Pdf_model');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==55)||($PDLY_SEARCH_lb_babysearchoptionmatch==61)||($PDLY_SEARCH_lb_babysearchoptionmatch==72))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt=$this->input->post('PDLY_SEARCH_tb_searchbyinvfrom');
            $PDLY_SEARCH_babycategory="";
            $this->load->model('Pdf_model');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==54)||($PDLY_SEARCH_lb_babysearchoptionmatch==60)||($PDLY_SEARCH_lb_babysearchoptionmatch==71))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom=$this->input->post('PDLY_SEARCH_tb_searchbyinvitem');
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('Pdf_model');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Pdf_model->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory);

        }
        if($PDLY_SEARCH_typelistvalue==36){$pdfFilePath='BABY EXPENSE.pdf';}
        else if($PDLY_SEARCH_typelistvalue==35){$pdfFilePath='CAR EXPENSE.pdf';}
        else if($PDLY_SEARCH_typelistvalue==37){$pdfFilePath='PERSONAL EXPENSE.pdf';}
        else if($PDLY_SEARCH_typelistvalue==38){$pdfFilePath='CARLOAN EXPENSE.pdf';}
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$PDLY_SEARCH_lbl_flextableheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>'); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        $pdf->WriteHTML($data); // write the HTML into the PDF
        $pdf->Output($PDLY_SEARCH_lbl_flextableheader.'.pdf', 'd');

    }
}

