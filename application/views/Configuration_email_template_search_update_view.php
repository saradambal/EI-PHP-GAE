
<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMAIL TEMPLATE ENTRY/SEARCH/UPDATE*******************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:18/05/2015 ED:18/05/2015
//************************************************************************************************************-->
<?php
//require_once('HEADER.php');
include 'Header.php';
?>
<html>
<head>
<script>
var ET_SRC_UPD_DEL_result_array=[];
var ET_SRC_UPD_DEL_name;
var listboxoption;
//READY FUNCTION START
$(document).ready(function() {
    $('#spacewidth').height('0%');
    $(".preloader").hide();
    $('#ET_SRC_UPD_DEL_lb_scriptname').hide();
    var value_err_array=[];
    $('#ET_SRC_UPD_DEL_btn_search').hide();
    var ET_ENTRY_chknull_input="";
    //JQUERY LIB VALIDATION START
    $('.uppercase').doValidation({rule:'general',prop:{uppercase:true}});
    $('textarea').autogrow({onInitialize: true});
    //JQUERY LIB VALIDATION END
    // INITIAL DATA LODING
    $.ajax({
        type: "POST",
        'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/Initaildatas",
        data:{"Formname":'EmailTemplateSearchUpdate',"ErrorList":'278,279,280,281,291,400,401'},
        success: function(data){
            $('.preloader').hide();
            value_err_array=JSON.parse(data);
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
    //LIST BOX ITEM CHANGE FUNCTION
    $('.PE_rd_selectform').click(function(){
        $(".preloader").show();
        listboxoption=$(this).val();
        $('#ET_ENTRY_ta_subject').val('');
        $('#CONFIG_SRCH_UPD_div_htmltable').hide();
        $('#CONFIG_SRCH_UPD_div_header').hide();
        $("#ET_SRC_UPD_DEL_lbl_scriptname").hide();
        $("#ET_SRC_UPD_DEL_lb_scriptname").hide();
        $("#CONFIG_ENTRY_tr_type").hide();
        $("#CONFIG_ENTRY_tr_data").hide();
        $("#CONFIG_ENTRY_tr_btn").hide();
        $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[2].EMC_DATA).hide();
        if(listboxoption=='EMAIL ENTRY')
        {
            $(".preloader").hide();
            $("#enrtyfrm").show();
            $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
            $('section').html('');
            $('#ET_SRC_UPD_DEL_div_header').hide();

        }
        else if(listboxoption=='EMAIL SEARCH/UPDATE')
        {
            $(".preloader").hide();
            $("#enrtyfrm").hide();
            $("#ET_SRC_UPD_DEL_lb_scriptname").val('SELECT').show();
            $("#ET_SRC_UPD_DEL_lbl_scriptname").show();
        }
    });
    //CLICK EVENT FUCNTION FOR RESET
    $('#ET_ENTRY_btn_reset').click(function()
    {
        ET_ENTRY_email_template_rset()
    });
    //CLEAR ALL FIELDS
    function ET_ENTRY_email_template_rset()
    {
        $("#ET_ENTRY_tb_scriptname").val('');
        $("#ET_ENTRY_ta_body").val('');
        $("#ET_ENTRY_ta_subject").val('');
//        $("#ET_SRC_UPD_DEL_form_emailtemplate")[0].reset();
        $("#ET_ENTRY_tb_scriptname").removeClass('invalid');
        $('#ET_ENTRY_lbl_validid').hide();
        $("#ET_ENTRY_btn_save").attr("disabled", "disabled");
        $('#ET_ENTRY_tb_scriptname').prop("size","20");
        $('#ET_ENTRY_ta_subject').css('height', 150);
        $('#ET_ENTRY_ta_body').css('height', 150);
    }
    //SCRIPT NAME LOADING
    $.ajax({
        type: "POST",
        'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/ET_SRC_UPD_DEL_script_name",
        success: function(data){
            var value_array=JSON.parse(data);
            for(var i=0;i<value_array[0].length;i++)
            {
                var data=value_array[0][i];
                $('#ET_SRC_UPD_DEL_lb_scriptname').append($('<option>').text(data.ET_EMAIL_SCRIPT).attr('value', data.ET_ID));
            }
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
    var values_array=[];
    //CHANGE FUNCTION FOR SCRIPTNAME
    $('#ET_SRC_UPD_DEL_lb_scriptname').change(function()
    {
         $('.preloader').show();
        $('#ET_SRC_UPD_DEL_div_headernodata').hide();
        ET_SRC_UPD_DEL_name=$('#ET_SRC_UPD_DEL_lb_scriptname').find('option:selected').text();
        $('#ET_SRC_UPD_DEL_div_header').hide();
        var ET_SRC_UPD_DEL_scriptname = $("#ET_SRC_UPD_DEL_lb_scriptname").val();
        if(ET_SRC_UPD_DEL_scriptname=='SELECT')
        {
            $('.preloader').hide();
            $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
            $('section').html('');
            $('#ET_SRC_UPD_DEL_div_header').hide();
            $('#ET_SRC_UPD_DEL_div_headernodata').hide();
            $('#ET_SRC_UPD_DEL_div_update').hide();
            // $('#ET_SRC_UPD_DEL_tble_srchupd').hide();
            $('#ET_SRC_UPD_DEL_btn_search').hide();
        }
        else
        {
            $('#ET_SRC_UPD_DEL_div_table').show();
            $('#ET_SRC_UPD_DEL_div_update').hide();
//            $('#ET_SRC_UPD_DEL_tble_srchupd').hide();
            $('#ET_SRC_UPD_DEL_btn_search').hide();
            $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
            $('section').html('');
            ET_SRC_UPD_DEL_srch_result();
        }
    });
    var ET_SRC_UPD_DEL_max=3000;
    $('.maxlength').keypress(function(e)
    {
        if(e.which < 0x20)
        {
            return;
        }
        if(this.value.length==ET_SRC_UPD_DEL_max)
        {
            e.preventDefault();
        }
        else if(this.value.length > ET_SRC_UPD_DEL_max)
        {
            this.value=this.value.substring(0,ET_SRC_UPD_DEL_max);
        }
    });
//KEY PRESS FUNCTION END
    //CHANGE FUNCTION FOR VALIDATION
    $("#ET_SRC_UPD_DEL_form_emailtemplate").change(function(){
        $("#ET_ENTRY_hidden_chkvalid").val("")//SET VALIDATION FUNCTION VALUE
        ET_ENTRY_checkscriptname()
    });
    //CHANGE FUNCTION FOR VALIDATION
    $("#ET_ENTRY_tb_scriptname").blur(function(){
        $("#ET_ENTRY_hidden_chkvalid").val("")//SET VALIDATION FUNCTION VALUE
        ET_ENTRY_checkscriptname()
    });
    //BLUR FUNCTION FOR TRIM SUBJECT
    $("#ET_ENTRY_ta_subject").blur(function(){
        $(".preloader").hide();
        $('#ET_ENTRY_ta_subject').val($('#ET_ENTRY_ta_subject').val().toUpperCase())
        var trimfunc=($('#ET_ENTRY_ta_subject').val()).trim()
        $('#ET_ENTRY_ta_subject').val(trimfunc)
    });
    //BLUR FUNCTION FOR TRIM BODY
    $("#ET_ENTRY_ta_body").blur(function(){
        $(".preloader").hide();
        $('#ET_ENTRY_ta_body').val($('#ET_ENTRY_ta_body').val().toUpperCase())
        var trimfunc=($('#ET_ENTRY_ta_body').val()).trim()
        $('#ET_ENTRY_ta_body').val(trimfunc)
    });
    //EMAIL TEMPLATE  SUBIT BUTTON VALIDATION
    function ET_ENTRY_checkscriptname()
    {
        var ET_ENTRY_scriptnametxt=$('#ET_ENTRY_tb_scriptname').val();
        var ET_ENTRY_subjecttxt=$('#ET_ENTRY_ta_subject').val();
        var ET_ENTRY_bodytxt=$('#ET_ENTRY_ta_body').val();
        if((ET_ENTRY_scriptnametxt.trim()=="") ||(ET_ENTRY_subjecttxt.trim()=="") || (ET_ENTRY_bodytxt.trim()==""))
        {
            $("#ET_ENTRY_btn_save").attr("disabled", "disabled");
            ET_ENTRY_chknull_input=false;
        }
        else
        {
            ET_ENTRY_chknull_input=true;
        }
        var ET_ENTRY_scriptname=$('#ET_ENTRY_tb_scriptname').val();
        if(ET_ENTRY_scriptname!="")
        {
            ET_ENTRY_already_result()
        }
        //SUCCESS FUNCTION FOR ALREADY EXIST FOR SCRIPT NAME
        function ET_ENTRY_already_result()
        {
            var ET_ENTRY_scriptname=$('#ET_ENTRY_tb_scriptname').val();
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/scriptname_exists",
                data: {'scriptnme': ET_ENTRY_scriptname},
                success: function(data) {
                    var ET_ENTRY_response=JSON.parse(data.script_name_already_exits_array)//retdata.final_array[0];
                    var ET_ENTRY_chkinput=ET_ENTRY_response;
                    if(ET_ENTRY_chkinput==0)
                    {
                        $('#ET_ENTRY_lbl_validid').hide();
                        $("#ET_ENTRY_tb_scriptname").removeClass('invalid');
                    }
                    if(ET_ENTRY_chkinput==0&&ET_ENTRY_chknull_input==true)
                    {
                        if($("#ET_ENTRY_hidden_chkvalid").val()=="")
                        {
                            $('#ET_ENTRY_lbl_validid').hide();
                            $("#ET_ENTRY_btn_save").removeAttr("disabled");
                        }
                        else
                        {
                            ET_ENTRY_save_resultsuccess()
                            $("#ET_ENTRY_hidden_chkvalid").val("");
                        }
                    }
                    else if(ET_ENTRY_chkinput==1)
                    {
                        $(".preloader").hide();
                        $('#ET_ENTRY_lbl_validid').show();
                        $('#ET_ENTRY_lbl_validid').text(value_err_array[1].EMC_DATA);
                        $("#ET_ENTRY_tb_scriptname").addClass('invalid');
                        $("#ET_ENTRY_btn_save").attr("disabled", "disabled");
                    }
                },
                error: function(data) {
                    alert('Error has occurred');
                }
            });
        }
    }
    //CLICK EVENT FOR SAVE BUTTON
    $('#ET_ENTRY_btn_save').click(function()
    {
        $('.preloader').show();
        $("#ET_ENTRY_hidden_chkvalid").val("SAVE")//SET SAVE FUNCTION VALUE
        var ET_ENTRY_scriptname=$('#ET_ENTRY_tb_scriptname').val();
        if($('#ET_SRC_UPD_DEL_form_emailtemplate')!="")
        {
            ET_ENTRY_checkscriptname()
        }
    });

    //CLICK FUNCTION FOR SAVE BTN
    //SUCCESS FUNCTIOIN FOR SAVE
    function ET_ENTRY_save_resultsuccess()
    {
        $('.preloader').hide();
        var ET_ENTRY_scriptname=$('#ET_ENTRY_tb_scriptname').val();
        var ET_ENTRY_subject=$('#ET_ENTRY_ta_subject').val();
        var ET_ENTRY_body=$('#ET_ENTRY_ta_body').val();
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/login",
            data: {'scriptnme': ET_ENTRY_scriptname,'sub': ET_ENTRY_subject,'bdy': ET_ENTRY_body},
            success: function(data) {
                var flag="EMAILINSERT_FLAG";
                var result_value=JSON.parse(data.final_array[0].EMAILINSERT_FLAG);//retdata.final_array[0];
               alert(result_value)
                if(result_value==1)
                {
                    //MESSAGE BOX FOR SAVED
                    $("#ET_ENTRY_btn_save").attr("disabled","disabled");
                    //MESSAGE BOX FOR SAVED SUCCESS
                    show_msgbox("EMAIL TEMPLATE ENTRY",value_err_array[0].EMC_DATA,"error",false)
                    $('input:radio[name=optradio]').attr('checked',false);
                    $("#ET_ENTRY_hidden_chkvalid").val("");
//                    ET_ENTRY_email_template_rset();
                    $('#enrtyfrm').hide();
                }
                else
                {
                    //MESSAGE BOX FOR NOT SAVED
                    show_msgbox("EMAIL TEMPLATE ENTRY",value_err_array[5].EMC_DATA,"error",false)
                    $('input:radio[name=optradio]').attr('checked',false);
                }
            },
            error: function(data) {
//                    alert('Error has occurred. Status: ' + status + ' - Message: ' + message);
            }
        });
    }
    //update form
    var ET_SRC_UPD_DEL_emailsubject;
    var ET_SRC_UPD_DEL_emailbody;
    var ET_SRC_UPD_DEL_userstamp;
    var ET_SRC_UPD_DEL_timestmp;
    var id;
    var ET_SRC_UPD_DEL_table_value='';
    //RESPONSE FUNCTION FOR FLEXTABLE SHOWING
    function ET_SRC_UPD_DEL_srch_result(){
        var ET_SRC_UPD_DEL_scriptname_id = $("#ET_SRC_UPD_DEL_lb_scriptname").val();
        $('.preloader').hide();
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/fetchdata",
            data: {'scriptnameid': ET_SRC_UPD_DEL_scriptname_id},
            success: function(data) {
                values_array=JSON.parse(data);
                if(values_array.length!=0)
                {
                    var ET_SRC_UPD_DEL_table_header='<table id="ET_SRC_UPD_DEL_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white"><tr><th style="width:1000px">EMAIL SUBJECT</th><th style="width:1000px">EMAIL BODY</th><th style="width:90px">USERSTAMP</th><th style="width:150px" nowrap>TIMESTAMP</th></tr></thead><tbody>'
                    var ET_SRC_UPD_DEL_errmsg =value_err_array[4].EMC_DATA.replace('[SCRIPT]',ET_SRC_UPD_DEL_name);
                    $('#ET_SRC_UPD_DEL_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                    for(var j=0;j<values_array.length;j++){
                        ET_SRC_UPD_DEL_emailsubject=values_array[j].ETD_EMAIL_SUBJECT;
                        ET_SRC_UPD_DEL_emailbody=values_array[j].ETD_EMAIL_BODY;
                        ET_SRC_UPD_DEL_userstamp=values_array[j].ULD_LOGINID;
                        ET_SRC_UPD_DEL_timestmp=values_array[j].ETD_TIMESTAMP;
                        id=values_array[j].ETD_ID;
                        ET_SRC_UPD_DEL_table_header+='<tr><td id=name_'+id+' class="emailsubject" style="width:500px">'+ET_SRC_UPD_DEL_emailsubject+'</td><td id=body_'+id+' class="emailbody" style="width:500px">'+ET_SRC_UPD_DEL_emailbody+'</td><td>'+ET_SRC_UPD_DEL_userstamp+'</td><td>'+ET_SRC_UPD_DEL_timestmp+'</td></tr>';
                    }
                    ET_SRC_UPD_DEL_table_header+='</tbody></table>';
                    $('section').html(ET_SRC_UPD_DEL_table_header);
                    $('#ET_SRC_UPD_DEL_tble_htmltable').DataTable({
                        "bInfo" : false,
                        "bPaginate": false,
//                    "dom": '<"pull-left"f>tip',
                        "dom": 'tip',
                    "aaSorting": [],
                    'bSort': false });
                }
                else
                {
                    $('#ET_SRC_UPD_DEL_div_header').hide();
                    $('#ET_SRC_UPD_DEL_div_table').hide();
                    $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[2].EMC_DATA).show();
                    $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
                    $('section').html('');
                    $('.preloader').hide();
                }
                $('#ET_SRC_UPD_DEL_tble').show();
            }
        });
    }
    var previous_id;
    var combineid;
    var tdvalue;
    //click function for email subject
    $(document).on('click','.emailsubject', function (){
        if(previous_id!=undefined){
            $('#'+previous_id).replaceWith("<td class='data' id='"+previous_id+"' >"+tdvalue+"</td>");
        }
        var cid = $(this).attr('id');
        previous_id=cid;
        var id=cid.split('_');
        combineid=id[1];
        tdvalue=$(this).text();
        if(tdvalue!=''){
            $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><textarea  id='name' name='data'  class='subjectupdate' style='width: 400px' >"+tdvalue+"</textarea></td>");
        }
    } );
    //blur function for subject update
    $(document).on('change','.subjectupdate',function(){
        var subjectvalue=$(this).val().trim();
        if((subjectvalue!='')){
            var data = $('#ET_SRC_UPD_DEL_form_emailtemplate').serialize();
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/subupdatefunction",
                data:{'id':id,'subjectvalue':subjectvalue},
                success: function(ET_SRC_UPD_DEL_update_result) {
                    if(ET_SRC_UPD_DEL_update_result=='true')
                    {
                        var ET_SRC_UPD_DEL_errmsg=value_err_array[3].EMC_DATA.replace('[SCRIPTNAME]',ET_SRC_UPD_DEL_name);
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",ET_SRC_UPD_DEL_errmsg,"success",false)
                        ET_SRC_UPD_DEL_srch_result()
                        previous_id=undefined;
                    }

                    else
                    {
                        //MESSAGE BOX FOR NOT UPDATED
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",value_err_array[3].EMC_DATA,"error",false)
                    }
                }
            });
        }
    });
    var previous_id;
    var combineid;
    var tdvalue;
    //click function for email body
    $(document).on('click','.emailbody', function (){
        if(previous_id!=undefined){
            $('#'+previous_id).replaceWith("<td class='data' id='"+previous_id+"' >"+tdvalue+"</td>");
        }
        var cid = $(this).attr('id');
        previous_id=cid;
        var id=cid.split('_');
        combineid=id[1];
        tdvalue=$(this).text();
        if(tdvalue!=''){
            $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><textarea id='name' name='data'  class='bodyupdate'  style='width: 400px' maxlength='50'  >"+tdvalue+"</textarea></td>");
        }
    } );
    //blur function for body updation
    $(document).on('change','.bodyupdate',function(){
        var bodyvalue=$(this).val().trim();
        if((bodyvalue!='')){
            var data = $('#ET_SRC_UPD_DEL_form_emailtemplate').serialize();
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/bdyupdatefunction",
                data:{'id':id,'bodyvalue':bodyvalue},
                success: function(ET_SRC_UPD_DEL_update_result) {
                    if(ET_SRC_UPD_DEL_update_result=='true')
                    {
                        var ET_SRC_UPD_DEL_errmsg=value_err_array[3].EMC_DATA.replace('[SCRIPTNAME]',ET_SRC_UPD_DEL_name);
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",ET_SRC_UPD_DEL_errmsg,"success",false)
                        ET_SRC_UPD_DEL_srch_result()
                        previous_id=undefined;
                    }
                    else
                    {
                        //MESSAGE BOX FOR NOT UPDATED
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",value_err_array[3].EMC_DATA,"error",false)
                    }
                }
            });
        }
    });
    //RADIO CLICK FUNCTION
    $(document).on('click','.ET_SRC_UPD_DEL_radio',function(){
        $('#ET_SRC_UPD_DEL_div_update').hide();
        $('#ET_SRC_UPD_DEL_btn_search').show();
        $("#ET_SRC_UPD_DEL_btn_search").removeAttr("disabled","disabled").show();
    });
    //CLICK EVENT FUCNTION FOR BUTTON SEARCH
    $(document).on('click','#ET_SRC_UPD_DEL_btn_search',function(){
        $("html, body").animate({ scrollTop: $(document).height() }, "fast");
        $('#ET_SRC_UPD_DEL_div_update').show();
        $("#ET_SRC_UPD_DEL_btn_search").attr("disabled","disabled");
        $("#ET_SRC_UPD_DEL_btn_update").attr("disabled","disabled");
        var SRC_UPD_idradiovalue=$('input:radio[name=ET_SRC_UPD_DEL_rd_flxtbl]:checked').attr('id');
        for(var j=0;j<values_array.length;j++){
            if(id==SRC_UPD_idradiovalue)
            {
                ET_SRC_UPD_DEL_name=$('#ET_SRC_UPD_DEL_lb_scriptname').find('option:selected').text();
                var ET_SRC_UPD_DEL_names=(ET_SRC_UPD_DEL_name).length+2;
                $('#ET_SRC_UPD_DEL_tb_script').attr("size",ET_SRC_UPD_DEL_names);
                $('#ET_SRC_UPD_DEL_tb_script').val(ET_SRC_UPD_DEL_name).show();
                $('#ET_SRC_UPD_DEL_tb_script').val(ET_SRC_UPD_DEL_name).show();
                var ET_SRC_UPD_DEL_subject=ET_SRC_UPD_DEL_emailsubject.length;
                $('#ET_SRC_UPD_DEL_ta_updsubject').val(ET_SRC_UPD_DEL_emailsubject).attr("size",ET_SRC_UPD_DEL_subject+15);
                $('#ET_SRC_UPD_DEL_ta_updbody').val(ET_SRC_UPD_DEL_emailbody).show();
                $("#ET_SRC_UPD_DEL_btn_update").attr("disabled","disabled");
            }
        }
        $("textarea").height(30);
    });
    //EMAIL SCRIPT VALIDATION
    $(document).on('change blur','.validation',function()
    {
        if(($("#ET_SRC_UPD_DEL_ta_updsubject").val()=='')||($("#ET_SRC_UPD_DEL_ta_updbody").val()=='')||($("#ET_SRC_UPD_DEL_ta_updsubject").val().trim()==ET_SRC_UPD_DEL_emailsubject)&&($("#ET_SRC_UPD_DEL_ta_updbody").val().trim()==ET_SRC_UPD_DEL_emailbody))
        {
            $("#ET_SRC_UPD_DEL_btn_update").attr("disabled", "disabled");
        }
        else
        {
            $("#ET_SRC_UPD_DEL_btn_update").removeAttr("disabled");
        }
    });
    //CLICK EVENT FUCNTION FOR UPDATE
    $('#ET_SRC_UPD_DEL_btn_update').click(function()
    {
        $('.preloader').show();
        var ET_SRC_UPD_DEL_scriptname=$('#ET_SRC_UPD_DEL_lb_scriptname').val();
        var ET_SRC_UPD_DEL_datasubject=$('#ET_SRC_UPD_DEL_ta_updsubject').val();
        var ET_SRC_UPD_DEL_databody=$('#ET_SRC_UPD_DEL_ta_updbody').val();
        var formElement = document.getElementById("ET_SRC_UPD_DEL_form_emailtemplate");
        var data = $('#ET_SRC_UPD_DEL_form_emailtemplate').serialize();
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Template_Forms/updatefunction",
            data: data+'&id='+ id,
            success: function(ET_SRC_UPD_DEL_update_result) {
                $('.preloader').hide();
                if(ET_SRC_UPD_DEL_update_result==1){
                    var ET_SRC_UPD_DEL_scriptname=$('#ET_SRC_UPD_DEL_lb_scriptname').val();
                    $("#ET_SRC_UPD_DEL_btn_search").hide();
                    $('#ET_SRC_UPD_DEL_div_update').hide();
                    var ET_SRC_UPD_DEL_errmsg=value_err_array[3].EMC_DATA.replace('[SCRIPTNAME]',ET_SRC_UPD_DEL_scriptname);
                    show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",ET_SRC_UPD_DEL_errmsg,"success",false)
                    ET_SRC_UPD_DEL_srch_result()
                }
                else
                {
                    //MESSAGE BOX FOR NOT UPDATED
                    show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",value_err_array[6].EMC_DATA,"error",false)
                }
                $('.preloader').hide();
            }
        });
    });
    //CLICK EVENT FUCNTION FOR RESET
    $('#ET_SRC_UPD_DEL_btn_reset').click(function()
    {
        $('#ET_SRC_UPD_DEL_ta_updsubject').val('');
        $('#ET_SRC_UPD_DEL_ta_updbody').val('');
        $("#ET_SRC_UPD_DEL_btn_update").attr("disabled", "disabled");
        $("textarea").height(150);
    });
});
//READY FUNCTION END
</script>
<!--SCRIPT TAG END-->
<!--BODY TAG START-->
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>EMAIL TEMPLATE ENTRY/SEARCH/UPDATE</b></h4></div>
    <form id="ET_SRC_UPD_DEL_form_emailtemplate" name="ET_SRC_UPD_DEL_form_emailtemplate" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px">
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMAIL ENTRY" class="PE_rd_selectform">ENTRY</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMAIL SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
                    </div>
                </div>
                <div id="enrtyfrm" hidden>
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_scriptname" id="ET_ENTRY_lbl_scriptname" class="col-sm-2">SCRIPT NAME<em>*</em></label>
                    <div class="col-sm-10">
                        <input  type="text" name="ET_ENTRY_tb_scriptname" id="ET_ENTRY_tb_scriptname" class=" uppercase autosize" maxlength=100>
                        <label id="ET_ENTRY_lbl_validid" name="ET_ENTRY_lbl_validid" class="errormsg" disabled=""></label>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_subject" id="ET_ENTRY_lbl_subject" class="col-sm-2">SUBJECT<em>*</em></label>
                    <div class="col-sm-5">
                        <textarea class="form-control tarea maxlength"   rows="8" cols="10" name="ET_ENTRY_ta_subject" id="ET_ENTRY_ta_subject" class="tarea maxlength">
                        </textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_body" id="ET_ENTRY_lbl_body" class="col-sm-2">BODY<em>*</em></label>
                    <div class="col-sm-5">
                        <textarea class="form-control tarea maxlength" rows="8" name="ET_ENTRY_ta_body" id="ET_ENTRY_ta_body"  >
                        </textarea>
                    </div>
                </div>
                <div class="col-lg-3 col-lg-offset-2">
                    <input type="button" class=" btn" name="ET_ENTRY_btn_save" id="ET_ENTRY_btn_save"    value="SAVE" disabled="" >
                    <input type="button" class=" btn" name="ET_ENTRY_btn_reset" id="ET_ENTRY_btn_reset"  value="RESET">
                </div>
                <input type=hidden id="ET_ENTRY_hidden_chkvalid">
        </div>
                <div class="form-group">
                    <label  name="ET_SRC_UPD_DEL_lbl_scriptname" id="ET_SRC_UPD_DEL_lbl_scriptname" class="col-sm-2" hidden>SCRIPT NAME<em>*</em></label>
                    <div class="col-sm-4">
                        <select class="form-control  validation" name="ET_SRC_UPD_DEL_lb_scriptname"  required id="ET_SRC_UPD_DEL_lb_scriptname" style="width:300px" hidden>
                            <option>SELECT</option>
                        </select/>
                    </div>
                </div>
                <br><br>
                <div class="srctitle" name="ET_SRC_UPD_DEL_div_header" id="ET_SRC_UPD_DEL_div_header"></div><br>
                <div class="errormsg" name="ET_SRC_UPD_DEL_div_headernodata" id="ET_SRC_UPD_DEL_div_headernodata"></div>
                <div class="table-responsive" id="ET_SRC_UPD_DEL_tble" hidden>
                    <section>
                    </section>
                </div>
                <div>
                    <input type="button" class="btn " name="ET_SRC_UPD_DEL_btn_search" id="ET_SRC_UPD_DEL_btn_search" hidden value="SEARCH" style="width:100;height:30" disabled>
                </div>
                <div id="ET_SRC_UPD_DEL_div_update" name="ET_SRC_UPD_DEL_div_update"  hidden>
                    <div class="row form-group">
                        <label name="ET_SRC_UPD_DEL_lbl_scriptupd" id="ET_SRC_UPD_DEL_lbl_scriptupd" class="col-sm-2">SCRIPT NAME<em>*</em></label>
                        <div class="col-sm-10">
                            <input  type="text" name="ET_SRC_UPD_DEL_tb_script" id="ET_SRC_UPD_DEL_tb_script" class="rdonly" readonly>
                        </div>
                    </div>
                    <input type="text" name="ET_SRC_UPD_DEL_tb_scriptnamehidden" id="ET_SRC_UPD_DEL_tb_scriptnamehidden" hidden>
                    <div class="row form-group">
                        <label name="ET_SRC_UPD_DEL_lbl_subjectupd" id="ET_SRC_UPD_DEL_lbl_subjectupd" class="control-label col-sm-2">SUBJECT<em>*</em></label>
                        <div class="col-sm-10">
                            <textarea  class="form-control  textareaupd validation uppercase tarea maxlength"  name="ET_SRC_UPD_DEL_ta_updsubject" id="ET_SRC_UPD_DEL_ta_updsubject" >
                            </textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="ET_SRC_UPD_DEL_lbl_bodyupd" id="ET_SRC_UPD_DEL_lbl_bodyupd" class="control-label col-sm-2">BODY<em>*</em></label>
                        <div class="col-sm-10">
                            <textarea   class="form-control textareaupd validation uppercase tarea maxlength" rows="10" cols="50"  name="ET_SRC_UPD_DEL_ta_updbody" id="ET_SRC_UPD_DEL_ta_updbody">
                            </textarea>
                        </div>
                    </div>
                    <input type="button" class="btn" name="ET_SRC_UPD_DEL_btn_update" id="ET_SRC_UPD_DEL_btn_update" value="UPDATE">
                    <input type="button" class="btn" name="ET_SRC_UPD_DEL_btn_reset" id="ET_SRC_UPD_DEL_btn_reset" value="RESET">
                    <fieldset>
                </div>
        </div>
    </form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->