<?php
require_once "Header.php";
?>
<html>
<head>
    <style>
        .errpadding{
            padding-top: 10px;
        }
        .colsmhf {
            width: 11.666%;
            padding-top: 2px;
            padding-left: 15px;
            padding-right: 0px;
        }
        th{
            text-align: center;
        }
    </style>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var DCSU_doorcode_val='';
            var DCSU_weblogin_val='';
            var DCSU_webpass_val='';
            var DCSU_flg_Doorcode=1;
            var DCSU_flg_Login=1;
            var DCSU_errormsg=[];
            var DCSU_unitno=[];
            var DCSU_login_id='';
            $('#spacewidth').height('0%');
            $('textarea').autogrow({onInitialize: true});
        // initial data
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Ctrl_Door_Code_Search_Update/Initialdata'); ?>",
                success: function(data) {
                    var initial_values=JSON.parse(data);
                    DCSU_unitno_errSuccess(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                }
            });
        // SUCCESS FUNCTION FOR ERRORMSG & UNIT NO
            function DCSU_unitno_errSuccess(DCSU_response){
                DCSU_errormsg=DCSU_response.DCSU_errorarray;
                DCSU_unitno=DCSU_response.DCSU_unitno;
                if(DCSU_unitno.length==0){
                    $('#DCSU_form_doorcode').replaceWith('<form id="DCSU_form_doorcode" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="errormsg"> '+DCSU_errormsg[3].EMC_DATA+'</label></div></fieldset></div></form>');
                }
                else{
                    var DCSU_options ='<option>SELECT</option>';
                    for (var i = 0; i < DCSU_unitno.length; i++)
                    {
                        DCSU_options += '<option value="' + DCSU_unitno[i].UNIT_NO + '">' + DCSU_unitno[i].UNIT_NO + '</option>';
                    }
                    $('#DCSU_lb_unitnumber').html(DCSU_options);
                    $("#DCSU_form_doorcode").show();
                }
                $('.preloader').hide();
            }
        // CHANGE EVENT FUNCTION FOR UNIT NUMBER
            $("#DCSU_lb_unitnumber").change(function(){
                $("#DCSU_div_htmltable").hide();
                $("#DCSU_div_errmsgdooor,#DCSU_div_errmsgNodooor").hide();
                $("#DCSU_lbl_errmsgdooor").text('');
                $("#DCSU_div_errmsgdooor").hide();
                $("#DCSU_div_errmsgNodooor").text('').hide();
                if($('#DCSU_lb_unitnumber').val()!='SELECT'){
                    $(".preloader").show();
                    var DCSU_unitnumber=$('#DCSU_lb_unitnumber').val();
                    var DCSU_flag='DCSU_flex';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Door_Code_Search_Update/DCSU_logindetails'); ?>",
                        data: {'DCSU_unitnumber':DCSU_unitnumber,'DCSU_flag':DCSU_flag},
                        success: function(doordata) {
                            var door_values=JSON.parse(doordata);
                            DCSU_loginSuccess(door_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                        }
                    });
                }
                else {
                    $("#DCSU_div_htmltable").hide();
                }
            });
        // SUCCESS FUNCTION FOR LOGIN DETAILS
            function DCSU_loginSuccess(DCSU_response){
                $(".preloader").hide();
                $("#DCSU_div_htmltable").hide();
                var DCSU_unitnumber=$('#DCSU_lb_unitnumber').val();
                if((DCSU_response.DCSU_id!='')&&(DCSU_response.DCSU_id!=undefined)){
                    $('#DCSU_div_htmltable').empty();
                    var DCSU_div_errmsg=DCSU_errormsg[1].EMC_DATA.replace('[UNIT NO]',DCSU_unitnumber);
                    $("#DCSU_lbl_errmsgdooor").text(DCSU_div_errmsg);
                    $("#DCSU_div_errmsgdooor").show();
                    var tr='<table id="DCSU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white;"><tr><th style="width:80px">DOOR CODE</th><th style="width:120px">WEB LOGIN</th><th style="width:50px">WEB PASSWORD</th><th style="width:200px">USERSTAMP</th><th style="width:130px">TIMESTAMP</th></tr></thead><tbody>';
                    var i=0;
                    DCSU_login_id=DCSU_response.DCSU_id;
                    tr += '<tr id="'+DCSU_response.DCSU_id+'"><td style="text-align: center" class="data">'+DCSU_response.DCSU_doorcode+'</td><td class="data" style="text-align: center">'+DCSU_response.DCSU_weblog+'</td><td class="data" style="text-align: center">'+DCSU_response.DCSU_webpass+'</td><td>'+DCSU_response.DCSU_user+'</td><td style="text-align: center">'+DCSU_response.DCSU_time+'</td></tr></tbody></table>';
                    $('#DCSU_div_htmltable').append(tr);
                    $('#DCSU_tble_htmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers"
                    });
                    $("#DCSU_div_htmltable").show();
                }
                else{
                    var DCSU_div_errmsg=DCSU_errormsg[2].EMC_DATA.replace('[UNIT NO]',DCSU_unitnumber);
                    $("#DCSU_div_errmsgNodooor").text(DCSU_div_errmsg).show();
                    $("#DCSU_div_errmsgdooor").hide();
                    $("#DCSU_lbl_errmsgdooor").text('');
                }
                if(DCSU_response.DCSU_flg==1){
                    var DCSU_upd_errmsg=DCSU_errormsg[4].EMC_DATA.replace('[UNITNO]',DCSU_unitnumber);
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_upd_errmsg,'success',false);
                }
                if(DCSU_response.DCSU_flg==0){
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[5].EMC_DATA,'error',false);
                }
            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>DOOR CODE: SEARCH / UPDATE</b></h4></div>
    <form id="DCSU_form_doorcode" name="DCSU_form_doorcode" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="DCSU_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="DCSU_lb_unitnumber" id="DCSU_lb_unitnumber" class="form-control"></select></div>
                </div>
                <div class="form-group" id="DCSU_div_errmsgdooor" hidden>
                    <label id="DCSU_lbl_errmsgdooor" class="srctitle col-lg-12"></label>
                </div>
                <div style="padding-bottom: 10px;" id="pdf_btn" hidden>
                    <input type="button" id="DCSU_btn_pdf" class="btnpdf" value="PDF">
                </div>
                <div class="form-group col-lg-12 errormsg" id="DCSU_div_errmsgNodooor" hidden>
                </div>
                <div class="table-responsive" id="DCSU_div_htmltable" hidden>
                    <section id="DCSU_section">
                    </section>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>