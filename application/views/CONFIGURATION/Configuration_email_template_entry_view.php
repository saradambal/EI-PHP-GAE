<?php
include 'Header.php';
?>
<head>
    <title>EMAIL</title>
    <script>
        //READY FUNCTION START
        $(document).ready(function() {
            $('#spacewidth').height('0%');
            var value_err_array=[];
            var ET_ENTRY_chknull_input="";
            //JQUERY LIB VALIDATION START
            $('.uppercase').doValidation({rule:'general',prop:{uppercase:true}});
            $('textarea').autogrow({onInitialize: true});
            //JQUERY LIB VALIDATION END
            // INITIAL DATA LODING
            $.ajax({
                type: "POST",
                'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Configuration_Email_Template_Entry_Search_Update/Initaildatas",
                data:{"Formname":'EmailTemplateEntry',"ErrorList":'278,279,400'},
                success: function(data){
                    $(".preloader").hide();
                    value_err_array=JSON.parse(data);
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
            //KEY PRESS FUNCTION START
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
            $("#ET_ENTRY_form_template").change(function(){
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
                $('.preloader', window.parent.document).hide();
                $('#ET_ENTRY_ta_subject').val($('#ET_ENTRY_ta_subject').val().toUpperCase())
                var trimfunc=($('#ET_ENTRY_ta_subject').val()).trim()
                $('#ET_ENTRY_ta_subject').val(trimfunc)
            });
            //BLUR FUNCTION FOR TRIM BODY
            $("#ET_ENTRY_ta_body").blur(function(){
                $('.preloader', window.parent.document).hide();
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
                        'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Configuration_Email_Template_Entry_Search_Update/scriptname_exists",
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
                                $('.preloader', window.parent.document).hide();
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
                if($('#ET_ENTRY_form_template')!="")
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
                    'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Configuration_Email_Template_Entry_Search_Update/login",
                    data: {'scriptnme': ET_ENTRY_scriptname,'sub': ET_ENTRY_subject,'bdy': ET_ENTRY_body},
                    success: function(data) {
                        var flag="EMAILINSERT_FLAG";
                        var result_value=JSON.parse(data.final_array[0].EMAILINSERT_FLAG);//retdata.final_array[0];
                        if(result_value==1)
                        {
                            //MESSAGE BOX FOR SAVED
                            $("#ET_ENTRY_btn_save").attr("disabled","disabled");
                            //MESSAGE BOX FOR SAVED SUCCESS
                            show_msgbox("EMAIL TEMPLATE ENTRY",value_err_array[0].EMC_DATA,"error",false)
                            $("#ET_ENTRY_hidden_chkvalid").val("");
                            ET_ENTRY_email_template_rset();
                        }
                        else
                        {
                            //MESSAGE BOX FOR NOT SAVED
                            show_msgbox("EMAIL TEMPLATE ENTRY",value_err_array[2].EMC_DATA,"error",false)
                        }
                    },
                    error: function(data) {
//                    alert('Error has occurred. Status: ' + status + ' - Message: ' + message);
                    }
                });
            }
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
                $("#ET_ENTRY_form_template")[0].reset();
                $("#ET_ENTRY_tb_scriptname").removeClass('invalid');
                $('#ET_ENTRY_lbl_validid').hide();
                $("#ET_ENTRY_btn_save").attr("disabled", "disabled");
                $('#ET_ENTRY_tb_scriptname').prop("size","20");
                $('#ET_ENTRY_ta_subject').css('height', 150);
                $('#ET_ENTRY_ta_body').css('height', 150);
            }
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
        <div class="row title text-center"><h4><b>EMAIL TEMPLATE ENTRY</b></h4></div>
        <div class ='row content'>
            <form   id="ET_ENTRY_form_template" class="form-horizontal" role="form">
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_scriptname" id="ET_ENTRY_lbl_scriptname" class="control-label col-sm-2">SCRIPT NAME<em>*</em></label>
                    <div class="col-sm-10">
                        <input  type="text" name="ET_ENTRY_tb_scriptname" id="ET_ENTRY_tb_scriptname" class=" uppercase autosize" maxlength=100>
                        <label id="ET_ENTRY_lbl_validid" name="ET_ENTRY_lbl_validid" class="errormsg" disabled=""></label>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_subject" id="ET_ENTRY_lbl_subject" class="control-label col-sm-2">SUBJECT<em>*</em></label>
                    <div class="col-sm-5">
                        <textarea class="form-control tarea maxlength"   rows="8" cols="10" name="ET_ENTRY_ta_subject" id="ET_ENTRY_ta_subject" class="tarea maxlength">
                        </textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="ET_ENTRY_lbl_body" id="ET_ENTRY_lbl_body" class="control-label col-sm-2">BODY<em>*</em></label>
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
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->

