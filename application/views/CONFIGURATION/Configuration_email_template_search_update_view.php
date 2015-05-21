<?php
include 'Header.php';
?>
<html>
<head>
<title>EMAIL TEMPLATE SEARCH/UPDATE</title>
<script>
var ET_SRC_UPD_DEL_result_array=[];
var ET_SRC_UPD_DEL_name;
//READY FUNCTION START
$(document).ready(function() {
    $('#spacewidth').height('0%');
    var value_err_array=[];
    $('#ET_SRC_UPD_DEL_btn_search').hide();
    $('textarea').autogrow({onInitialize: true});
    // INITIAL DATA LODING
    $.ajax({
        type: "POST",
        'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/Initaildatas",
        data:{"Formname":'EmailTemplateSearchUpdate',"ErrorList":'281,280,291,401'},
        success: function(data){
            $('.preloader').hide();
            value_err_array=JSON.parse(data);
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
    $.ajax({
        type: "POST",
        'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/ET_SRC_UPD_DEL_script_name",
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
            'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/fetchdata",
            data: {'scriptnameid': ET_SRC_UPD_DEL_scriptname_id},
            success: function(data) {
                values_array=JSON.parse(data);
                if(values_array.length!=0)
                {
//                            var ET_SRC_UPD_DEL_table_header='<table border="1"  cellspacing="0"><tr><th></th><th style="width:1000px">EMAIL SUBJECT</th><th style="width:1000px">EMAIL BODY</th><th style="width:90px">USERSTAMP</th><th style="width:150px" nowrap>TIMESTAMP</th></tr></thead><tbody>'
                   // var ET_SRC_UPD_DEL_table_header='<table border="1"  cellspacing="0"><tr><th style="width:1000px">EMAIL SUBJECT</th><th style="width:1000px">EMAIL BODY</th><th style="width:90px">USERSTAMP</th><th style="width:150px" nowrap>TIMESTAMP</th></tr></thead><tbody>'
                    var ET_SRC_UPD_DEL_table_header='<table id="ET_SRC_UPD_DEL_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white"><tr><th style="width:1000px">EMAIL SUBJECT</th><th style="width:1000px">EMAIL BODY</th><th style="width:90px">USERSTAMP</th><th style="width:150px" nowrap>TIMESTAMP</th></tr></thead><tbody>'
                    var ET_SRC_UPD_DEL_errmsg =value_err_array[2].EMC_DATA.replace('[SCRIPT]',ET_SRC_UPD_DEL_name);
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
                    $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[0].EMC_DATA).show();
                    $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
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
            $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='name' name='data'  class='subjectupdate' maxlength='50'  value='"+tdvalue+"'>");
        }
    } );
    //blur function for subject update
    $(document).on('change blur','.subjectupdate',function(){
        var subjectvalue=$(this).val().trim();
        if((subjectvalue!='')){
            var data = $('#ET_SRC_UPD_DEL_form_emailtemplate').serialize();
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/subupdatefunction",
                data: data+'&id='+ id+'&subjectvalue='+ subjectvalue,
                success: function(ET_SRC_UPD_DEL_update_result) {
                    if(ET_SRC_UPD_DEL_update_result==1)
                    {
                        var ET_SRC_UPD_DEL_errmsg=value_err_array[1].EMC_DATA.replace('[SCRIPTNAME]',ET_SRC_UPD_DEL_name);
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",ET_SRC_UPD_DEL_errmsg,"success",false)
                        ET_SRC_UPD_DEL_srch_result()
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
            $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='name' name='data'  class='bodyupdate' maxlength='50'  value='"+tdvalue+"'>");
        }
    } );
    //blur function for body updation
    $(document).on('change blur','.bodyupdate',function(){
        var bodyvalue=$(this).val().trim();
        if((bodyvalue!='')){
            var data = $('#ET_SRC_UPD_DEL_form_emailtemplate').serialize();
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/bdyupdatefunction",
                data: data+'&id='+ id+'&bodyvalue='+ bodyvalue,
                success: function(ET_SRC_UPD_DEL_update_result) {
                    if(ET_SRC_UPD_DEL_update_result)
                    {
                        var ET_SRC_UPD_DEL_errmsg=value_err_array[1].EMC_DATA.replace('[SCRIPTNAME]',ET_SRC_UPD_DEL_name);
                        show_msgbox("EMAIL TEMPLATE SEARCH/UPDATE",ET_SRC_UPD_DEL_errmsg,"success",false)
                        ET_SRC_UPD_DEL_srch_result()
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
//        $('#ET_SRC_UPD_DEL_tble_srchupd').show();
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
//                $('#ET_SRC_UPD_DEL_ta_updsubject').val(ET_SRC_UPD_DEL_emailsubject).show();
                var ET_SRC_UPD_DEL_subject=ET_SRC_UPD_DEL_emailsubject.length;
                $('#ET_SRC_UPD_DEL_ta_updsubject').val(ET_SRC_UPD_DEL_emailsubject).attr("size",ET_SRC_UPD_DEL_subject+15);
                $('#ET_SRC_UPD_DEL_ta_updbody').val(ET_SRC_UPD_DEL_emailbody).show();

//                $('#ET_SRC_UPD_DEL_ta_updsubject').css('height', 150);
//                var ET_SRC_UPD_DEL_body=ET_SRC_UPD_DEL_emailbody.length;
//                $('#ET_SRC_UPD_DEL_ta_updbody').val(ET_SRC_UPD_DEL_emailbody).attr("size",ET_SRC_UPD_DEL_body+100);
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
            'url': "<?php echo base_url(); ?>" + "index.php/Configuration_email_template_search_update_controller/updatefunction",
            data: data+'&id='+ id,
            success: function(ET_SRC_UPD_DEL_update_result) {
                $('.preloader').hide();
                if(ET_SRC_UPD_DEL_update_result==1){
                    var ET_SRC_UPD_DEL_scriptname=$('#ET_SRC_UPD_DEL_lb_scriptname').val();
                    $("#ET_SRC_UPD_DEL_btn_search").hide();
                    $('#ET_SRC_UPD_DEL_div_update').hide();
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"EMAIL TEMPLATE SEARCH/UPDATE",msgcontent:value_err_array[1].EMC_DATA,position:{top:150,left:500}}});
                    ET_SRC_UPD_DEL_srch_result()
                }
                else
                {
                    //MESSAGE BOX FOR NOT UPDATED
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"EMAIL TEMPLATE SEARCH/UPDATE",msgcontent:value_err_array[3].EMC_DATA,position:{top:150,left:500}}});
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
    //JQUERY LIB VALIDATION START
            $('.uppercase').doValidation({rule:'general',prop:{uppercase:true}});
//            $('textarea').autogrow({onInitialize: true});
    //JQUERY LIB VALIDATION END
    //KEY PRESS FUNCTION START
});
//READY FUNCTION END
</script>
<!--SCRIPT TAG END-->
<!--BODY TAG START-->
</head>
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
        <div class="row title text-center"><h4><b>EMAIL TEMPLATE SEARCH/UPDATE</b></h4></div>
        <div class ='row content'>
            <form   id="ET_SRC_UPD_DEL_form_emailtemplate" class="form-horizontal" role="form">
                <div class="form-group">
                    <label  name="ET_SRC_UPD_DEL_lbl_scriptname" id="ET_SRC_UPD_DEL_lbl_scriptname" class="col-sm-2 control-label">SCRIPT NAME<em>*</em></label>
                    <div class="col-sm-10">
                        <select class="form-control  validation" name="ET_SRC_UPD_DEL_lb_scriptname"  required id="ET_SRC_UPD_DEL_lb_scriptname" style="width:300px">
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
                        <label name="ET_SRC_UPD_DEL_lbl_scriptupd" id="ET_SRC_UPD_DEL_lbl_scriptupd" class="control-label col-sm-2">SCRIPT NAME<em>*</em></label>
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
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->