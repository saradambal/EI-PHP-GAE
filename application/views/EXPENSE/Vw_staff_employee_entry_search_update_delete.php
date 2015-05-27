<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE*******************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:27/05/2015
//************************************************************************************************************-->
<?php
include 'Header.php';
?>
<html>
<head>
    <script>
        //READY FUNCTION START
        var listboxoption;
        var ErrorControl ={EmailId:'Invalid'}
        $(document).ready(function() {
            $('#spacewidth').height('0%');
            $(".preloader").hide();
            $('textarea').autogrow({onInitialize: true});
            $("textarea").height(116);
            var EMP_ENTRY_multi_array=[];
            var EMP_ENTRY_emparr_employeedesig=[];
            var EMP_ENTRY_errorMsg_array=[];
            var EMP_ENTRY_expensearr_unitnumber=[];
            var EMP_ENTRY_unitArray=[];
            var EMP_ENTRY_fullarr=[];
            var EMP_ENTRY_error=[];
            //JQUERY LIB VALIDATION START
            $('#EMP_ENTRY_tb_email').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
            $(".autosizealph").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            $("#EMP_ENTRY_tb_mobile").doValidation({rule:'numbersonly',prop:{realpart:10,leadzero:true}});
//JQUERY LIB VALIDATION END
            //LIST BOX ITEM CHANGE FUNCTION
            $('.PE_rd_selectform').click(function(){
                $(".preloader").show();
                listboxoption=$(this).val();
                $('#ET_ENTRY_ta_subject').val('');
                $('#CONFIG_SRCH_UPD_div_htmltable').hide();
                $('#CONFIG_SRCH_UPD_div_header').hide();
                $("#STDTL_INPUT_lb_employeename").hide();
                $("#STDTL_INPUT_lbl_employeename").hide();
                $("#CONFIG_ENTRY_tr_type").hide();
                $("#CONFIG_ENTRY_tr_data").hide();
                $("#CONFIG_ENTRY_tr_btn").hide();
                $('#STDTL_INPUT_noform').hide();
                if(listboxoption=='EMPLOYEE ENTRY')
                {
                    $(".preloader").hide();
                    $('#enrtyfrm').show();
                    $('section').html('');
                    $('#EMP_ENTRY_lbl_firstname').show();
                    $('#EMP_ENTRY_tb_firstname').show();
                    $('#searchfrm').hide();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').hide();
                    $('#STDTL_SEARCH_tble_amt_option').hide();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Staff_Employee_Entry_Search_Update_Delete/Initialdata'); ?>",
                        data:{'ErrorList':'1,2,34,71,154,248,135,136,153,155,157,158,163,164,165,166,167,168,169,315,339,400,401,446'},
                        success: function(data){
                            $('.preloader').hide();
                            EMP_ENTRY_fullarr=JSON.parse(data);
                            EMP_ENTRY_emparr_employeedesig=EMP_ENTRY_fullarr[0];
                            EMP_ENTRY_unitArray=EMP_ENTRY_fullarr[1];
                            EMP_ENTRY_multi_array=EMP_ENTRY_fullarr[2];
                            EMP_ENTRY_error=EMP_ENTRY_fullarr[3];
//                            alert(EMP_ENTRY_error[18].EMC_DATA)
                            $(".EMP_ENTRY_title_alpha").prop("title",EMP_ENTRY_error[0].EMC_DATA);
                            $("#EMP_ENTRY_tb_mobile").prop("title",EMP_ENTRY_error[1].EMC_DATA)
                            if(((EMP_ENTRY_unitArray).length!=0))
                            {
                                $('#EMP_ENTRY_form_errormsg').show();
                                $('#EMP_ENTRY_table_employeetbl').show();
                                $('#EMP_ENTRY_table_errormsg tr').remove().hide();
                                var EMP_ENTRY_emparray_employeedesig ='<option>SELECT</option>';
                                for (var i = 0; i < EMP_ENTRY_emparr_employeedesig.length; i++)
                                {
                                    var EMP_ENTRY_emparray_employee=EMP_ENTRY_emparr_employeedesig[i].ECN_DATA;
                                    $('#EMP_ENTRY_lb_empdesig').append($('<option>').text(EMP_ENTRY_emparray_employee).attr('value', EMP_ENTRY_emparray_employee));

                                }
                            }
                            else
                            {
                                if((EMP_ENTRY_unitArray).length==0)
                                {
                                    $('#EMP_ENTRY_table_errormsg').show();
                                    $('#EMP_ENTRY_form_employeename').hide();
                                    var uniterrormsg='<p><label class="errormsg">'+EMP_ENTRY_error[18].EMC_DATA+'</label></p>';
                                    $('#EMP_ENTRY_table_errormsg').append(uniterrormsg);
                                }
                            }
                        },
                        error:function(data){

                            alert(JSON.stringify(data))
                        }
                    });
                }
                else if(listboxoption=='EMPLOYEE SEARCH/UPDATE')
                {
                    $(".preloader").hide();
                    $("#enrtyfrm").hide();
                    $("#STDTL_INPUT_lb_employeename").val('SELECT').show();
                    $("#STDTL_INPUT_lbl_employeename").show();
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').hide();
                    $("#STDTL_SEARCH_lb_employeename_listbox").hide();
                }
            });
//CHANGE FUNCTION FOR DESIGNATION
            $("#EMP_ENTRY_lb_empdesig").change(function(){
                var EMP_ENTRY_desigoption=$(this).val();
                if((EMP_ENTRY_desigoption=="CLEANER")||(EMP_ENTRY_desigoption=="SELECT"))
                {
                    $('#EMP_ENTRY_lbl_cardno').hide();
                    $('#card').hide();
                    $('#EMP_ENTRY_nullcard').hide();
                    $('#EMP_ENTRY_lbl_shwcardno').hide();
                    $('#EMP_ENTRY_radio_selectcard').hide();
                    $('#EMP_ENTRY_radio_null').hide();
                    $('#EMP_ENTRY_tble_menu').hide();
                }
                else
                {
                    $('#EMP_ENTRY_lbl_cardno').show();
                    $('#card').show();
                    $('#EMP_ENTRY_nullcard').show();
                    $('#EMP_ENTRY_lbl_shwcardno').show();
                    $('#EMP_ENTRY_radio_selectcard').show();
                    $('#EMP_ENTRY_radio_null').show();
                    $('input[name="EMP_ENTRY_selectcard"]').prop('checked', false);
                    $('input[name="menu"]').prop('checked', false);
                    $('input[name="submenu"]').prop('checked', false);
                }
            });
//CLICK FUNCTION FOR RADIO BUTTON
            $('.radio_selected').click(function()
            {
                var EMP_ENTRY_radio=$("input[name=EMP_ENTRY_selectcard]:checked").val()
                if(EMP_ENTRY_radio=='CARD')
                {
                    EMP_ENTRY_multitreeview(EMP_ENTRY_multi_array);
                    $('#EMP_ENTRY_tble_menu').show();
                    $(".preloader").hide();
                }else
                {
                    $('#EMP_ENTRY_tble_menu').hide();
                    $('#EMP_ENTRY_lbl_error').hide();
                    $(".preloader").hide();
                }
            });
            //SHOW THE TREE VIEW FORMATE//
            function EMP_ENTRY_multitreeview(EMP_ENTRY_multi_arraynew)
            {
                if((EMP_ENTRY_multi_arraynew.length)==0)
                {
                    EMP_ENTRY_multi_array=EMP_ENTRY_multi_arraynew;
                }else
                {
                    var EMPENTRY_multi_array=[];
                    EMPENTRY_multi_array=EMP_ENTRY_multi_arraynew
                    EMP_ENTRY_multi_array=EMPENTRY_multi_array;
                }
                if(EMP_ENTRY_multi_array==""||EMP_ENTRY_multi_array.length==0 || EMP_ENTRY_multi_array.length==null)
                {
                    $('#EMP_ENTRY_lbl_cardno').hide();
                    $('#card').hide();
                    if($('#EMP_ENTRY_radio_selectcard').is(":checked")==true)
                    {
                        $('#EMP_ENTRY_lbl_error').text(EMP_ENTRY_error[2].EMC_DATA).show();
                    }
                    $("#EMP_ENTRY_tble_menu").hide();
                }
                else
                {
//SHOW TREE VIEW FORMATE//
                    $('#EMP_ENTRY_lbl_cardno').show();
                    $('#card').show();
                    $('#EMP_ENTRY_lbl_error').hide();
                    $("#EMP_ENTRY_tble_menu").replaceWith("<table id ='EMP_ENTRY_tble_menu'></table>");
                    var EMP_ENTRY_menu=''
                    for (var j = 0; j < EMP_ENTRY_multi_array[0].length; j++) {
                        var id="EMP_ENTRY_tble_submenu"+j;
                        var id1="menu"+"_"+j;
                        var id2="sub"+j;
                        var id_menu=j+'m'
                        var mainmenuid=j;
                        EMP_ENTRY_menu = '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"   id='+id1+' height="5" width="5" class="exp" /><input type="checkbox" name="menu" id='+id_menu+' value='+EMP_ENTRY_multi_array[0][j]+' level="parent" class="tree empsubmitvalidat"  />' + EMP_ENTRY_multi_array[0][j] + '</td></tr>';
                        EMP_ENTRY_menu+='<div id='+id2+' hidden ><tr><td><table id='+id+' class="EMP_ENTRY_class_submenu"  ></table></tr></div></li></ul></div>';
                        $('#EMP_ENTRY_tble_menu').append(EMP_ENTRY_menu);
                        var EMP_ENTRY_submenu='';
                        var submenulength=EMP_ENTRY_multi_array[j+1].length;
                        for (var j1 = 0; j1 < EMP_ENTRY_multi_array[j+1].length; j1++) {
                            var id3="EMP_ENTRY_tble_submenu1"+j1;
                            var submenuids="EMP_submenus-"+mainmenuid+'-'+submenulength+'-'+j1;
                            EMP_ENTRY_submenu='<div><ul style="list-style: none;"><li style="list-style: none;" ><tr><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="submenu[]" id='+submenuids+' value='+EMP_ENTRY_multi_array[j+1][j1]+' class="tree submenucheck Child" level="child" />' + EMP_ENTRY_multi_array[j+1][j1] + '</td></tr>';
                            $('#'+"EMP_ENTRY_tble_submenu"+j).append(EMP_ENTRY_submenu);
                        }
                    }
                }
            }
            //VALIDATION FOR SUB MENU CHECK BOX CLICKING
            $(document).on('click','.submenucheck',function(){
                var idvalid=$(this).attr("id");
                var idsplit=idvalid.split('-');
                var countchecking=0;
                for(var g=0;g<idsplit[2];g++)
                {
                    var EMP_checked='EMP_submenus-'+idsplit[1]+'-'+idsplit[2]+'-'+g;
                    var EMP_checked=$('#'+EMP_checked).attr("checked");
                    if(EMP_checked)
                    {
                        countchecking++;
                    }
                }
                if(countchecking!=0)
                {
                    $('#'+idsplit[1]+'m').prop('checked',true);
                }
                else
                {
                    $('#'+idsplit[1]+'m').prop('checked',false);
                }
            });
            //CLASS USED FOR TREE VIEW//
            $(document).on("click",'.exp,.collapse', function (){
                var id=$(this).attr("id")
                var btnid=id.split("_");
                var menu_btnid=btnid[1]
                if($(this).val()=='+'){
                    $(this).val('-')
//                    $(this).replaceWith('<input type="button"   value="-" id='+id+'  height="3" width="3" class="collapse" />');
                    $('#sub'+menu_btnid).toggle("fold",100);
                }
                else
                {
                    $('#sub'+menu_btnid).toggle("fold",100);
                    $(this).replaceWith('<input type="button"   value="+" id='+id+'  height="3" width="3" class="exp" />');
                }
            });
//VALIDATION FOR MENU SUB MENU FULLY CHECKED BOX CLICKING
            $(document).on("change",'.tree ', function (){
                var val = $(this).attr("checked");
                $(this).parent().find("input:checkbox").each(function() {
                    if (val!=undefined) {
                        $(this).attr("checked", "checked");
                    } else {
                        $(this).removeAttr("checked");
                        $(this).parents('ul').each(function()
                        {
                            $(this).prev('input:checkbox').removeAttr("checked");
                            $(this).closest('ul').prev().attr('checked', false);
                        });
                    }
                });
            });
            //BLUR FUNCTION FOR EMAIL ID
            $("#EMP_ENTRY_tb_email").blur(function(){
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                if(EMP_ENTRY_email.length==0)
                {
                    $('#EMP_ENTRY_lbl_validemailid').hide();
                    $("#EMP_ENTRY_tb_email").removeClass('invalid');
                }
                else
                {
                    var validtype=ErrorControl.EmailId;
                    if(validtype=='Valid')
                    {
                        $('#EMP_ENTRY_lbl_validemailid').hide();
                        $("#EMP_ENTRY_tb_email").removeClass('invalid');
                        $('#EMP_ENTRY_tb_email').val($('#EMP_ENTRY_tb_email').val().toLowerCase())
                    }
                    else
                    {
                        $('#EMP_ENTRY_lbl_validemailid').text(EMP_ENTRY_error[6].EMC_DATA).show();
                        $("#EMP_ENTRY_tb_email").addClass('invalid');
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
            });
//SUBMIT BUTTON VALIDATION//
            $(document).on("blur",'.empsubmitvalidat',function ()
            {
                var EMP_ENTRY_Firstname= $("#EMP_ENTRY_tb_firstname").val();
                var EMP_ENTRY_Lastname =$("#EMP_ENTRY_tb_lastname").val();
                var EMP_ENTRY_empdesig =$("#EMP_ENTRY_lb_empdesig").val();
                var EMP_ENTRY_Mobileno = $("#EMP_ENTRY_tb_mobile").val();
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                var EMP_ENTRY_unitno = $("#EMP_ENTRY_lb_unitno").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$("input[name=submenu]").is(":checked");
                if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu==true &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6) && (EMP_ENTRY_empdesig!='SELECT'))
                {
                    $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                }
                else
                {
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                }
            });
//EMPLOYEE SAVE BUTTON VALIDATION
            $("#EMP_ENTRY_form_employeename").change(function(){
                var EMP_ENTRY_Firstname= $("#EMP_ENTRY_tb_firstname").val();
                var EMP_ENTRY_Lastname =$("#EMP_ENTRY_tb_lastname").val();
                var EMP_ENTRY_empdesig =$("#EMP_ENTRY_lb_empdesig").val();
                var EMP_ENTRY_Mobileno = $("#EMP_ENTRY_tb_mobile").val();
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                var EMP_ENTRY_unitno = $("#EMP_ENTRY_lb_unitno").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$("input[name=submenu]").is(":checked");
                if(EMP_ENTRY_empdesig=='STAFF'){
                    if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu==true &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6)&& (EMP_ENTRY_empdesig!='SELECT'))
                    {
                        $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
                else if(EMP_ENTRY_empdesig=='CLEANER'){
                    if((EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0)) && (EMP_ENTRY_Mobileno.length>=6)&& (EMP_ENTRY_empdesig!='SELECT'))
                    {
                        $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
                else
                {
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                }
            });
            //CLICK EVENT FOR SAVE BUTTON
            $("#EMP_ENTRY_btn_save").click(function(){
                $(".preloader").show();
                var EMP_ENTRY_mobilenolength=$('#EMP_ENTRY_tb_mobile').val();
                if(EMP_ENTRY_mobilenolength.length<6 ||EMP_ENTRY_mobilenolength=="" )
                {$(".preloader").hide();
                    $('#EMP_ENTRY_tb_mobile').addClass('invalid');
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    $("#EMP_ENTRY_lbl_errmsg").text(EMP_ENTRY_errorMsg_array[6]).show();
                }
                else
                {
                    EMP_ENTRY_save_result()
                }
            });
            function EMP_ENTRY_save_result()
            {
                var EMP_ENTRY_firstname = $('#EMP_ENTRY_tb_firstname').val();
                var EMP_ENTRY_lastname = $('#EMP_ENTRY_tb_lastname').val();
                var EMP_ENTRY_empdesigname = $('#EMP_ENTRY_lb_empdesig').val();
                var EMP_ENTRY_mobilenumber = $('#EMP_ENTRY_tb_mobile').val();
                var EMP_ENTRY_email = $('#EMP_ENTRY_tb_email').val();
                var EMP_ENTRY_comments = $('#EMP_ENTRY_ta_comments').val();
                var EMP_ENTRY_radio_null=$('input:radio[name=EMP_ENTRY_radio_null]:checked').attr('id');
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Staff_Employee_Entry_Search_Update_Delete/EMP_ENTRY_save",
                    data :{'EMP_ENTRY_firstname':EMP_ENTRY_firstname,'EMP_ENTRY_lastname':EMP_ENTRY_lastname,'EMP_ENTRY_empdesigname':EMP_ENTRY_empdesigname,'EMP_ENTRY_mobilenumber':EMP_ENTRY_mobilenumber,'EMP_ENTRY_comments':EMP_ENTRY_comments,'EMP_ENTRY_radio_null':EMP_ENTRY_radio_null},
                    success: function(data) {
                        $(".preloader").hide();
                        alert(data)
                        var result_value=JSON.parse(data);
                    }
                });
            }
//CLICK EVENT FUCNTION FOR RESET
            $('#EMP_ENTRY_btn_reset').click(function()
            {
                EMP_ENTRY_employeedetailrset()
            });
            //CLEAR ALL FIELDS
            function EMP_ENTRY_employeedetailrset()
            {
                $("#EMP_ENTRY_form_employeename")[0].reset();
                $("#EMP_ENTRY_btn_save").attr("disabled", "disabled");
                $('#EMP_ENTRY_lbl_validemailid').hide();
                $('#EMP_ENTRY_tble_avail_cardno').hide();
                $('#EMP_ENTRY_div_avail_cardno').hide();
                $("#EMP_ENTRY_tb_email").removeClass('invalid');
                $('#EMP_ENTRY_tble_menu').hide();
                $('#EMP_ENTRY_tb_mobile').removeClass('invalid');
                $("#EMP_ENTRY_lbl_errmsg").hide();
                $('#EMP_ENTRY_lbl_error').hide();
                $('#EMP_ENTRY_table_errormsg').hide();
                $('.sizefix').prop("size","20");
                $('#EMP_ENTRY_lbl_cardno').hide();
                $('#card').hide();
                $('#EMP_ENTRY_nullcard').hide();
                $('#EMP_ENTRY_lbl_shwcardno').hide();
                $('#EMP_ENTRY_radio_selectcard').hide();
                $('#EMP_ENTRY_radio_null').hide();
                $('#EMP_ENTRY_tble_menu').hide();
                $('textarea').height(20);
            }
        });
        //READY FUNCTION END
    </script>
    <!--SCRIPT TAG END-->
    <!--BODY TAG START-->
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="EMP_ENTRY_form_employeename" name="EMP_ENTRY_form_employeename" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px">
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMPLOYEE ENTRY" class="PE_rd_selectform">ENTRY</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMPLOYEE SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
                    </div>
                </div>
                <div id="enrtyfrm" hidden>
                    <form id="EMP_ENTRY_form_errormsg">
                        <div id="EMP_ENTRY_table_errormsg">
                        </div>
                    </form>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_firstname" id="EMP_ENTRY_lbl_firstname" class="col-sm-2" hidden>FIRST NAME <em>*</em></label>
                        <div class="col-sm-10">
                            <input  type="text" name="EMP_ENTRY_tb_firstname" id="EMP_ENTRY_tb_firstname" class=" autosizealph EMP_ENTRY_title_alpha empsubmitvalidat sizefix" maxlength=30 hidden>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_lastname" id="EMP_ENTRY_lbl_lastname" class="col-sm-2" >LAST NAME <em>*</em></label>
                        <div class="col-sm-10">
                            <input  type="text" name="EMP_ENTRY_tb_lastname" id="EMP_ENTRY_tb_lastname" class="autosizealph EMP_ENTRY_title_alpha empsubmitvalidat sizefix" maxlength=30 >
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_empdesig" id="EMP_ENTRY_lbl_empdesig" class="col-sm-2" >DESIGNATION<em>*</em></label>
                        <div class="col-sm-4"><select name="EMP_ENTRY_lb_empdesig" id="EMP_ENTRY_lb_empdesig">
                                <option>SELECT</option>
                            </select> </div>
                    </div>
                    <div id="card" hidden>
                        <div class="form-group">
                            <label class="col-sm-3">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="EMP_ENTRY_selectcard" id="EMP_ENTRY_radio_selectcard" value='CARD' class='radio_selected empsubmitvalidat' hidden>CARD NUMBER</label>
                                    <label align='bottom' name='error' id='EMP_ENTRY_lbl_error' visible="false" class='errormsg'></label>
                                </div>
                                <div id="EMP_ENTRY_tble_menu" style="padding-left: 10px;display: none;" hidden="hidden">
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="EMP_ENTRY_selectcard" id="EMP_ENTRY_radio_null" value='NULL' class='radio_selected empsubmitvalidat' hidden>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                            <div id="EMP_ENTRY_div_avail_cardno">
                                <div id="EMP_ENTRY_tble_avail_cardno" hidden></div></div>
                    <div class="row form-group">
                            <label name="EMP_ENTRY_lbl_mobile" id="EMP_ENTRY_lbl_mobile" class="col-sm-2">MOBILE<em>*</em></label>
                        <div class="col-sm-10"><input type="text" name="EMP_ENTRY_tb_mobile" id="EMP_ENTRY_tb_mobile"  maxlength='10' style="width:75px"><label hidden name="EMP_ENTRY_lbl_errmsg" id="EMP_ENTRY_lbl_errmsg" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="row form-group">
                            <label name="EMP_ENTRY_lbl_email" id="EMP_ENTRY_lbl_email" class="col-sm-2">E-MAIL ID</label>
                        <div class="col-sm-10"><input type="text" name="EMP_ENTRY_tb_email" id="EMP_ENTRY_tb_email" maxlength="40" class="sizefix">
                        <label id="EMP_ENTRY_lbl_validemailid" name="EMP_ENTRY_lbl_validemailid" class="errormsg"></label></div>
                        </div>
                    <div class="row form-group">
                            <label name="EMP_ENTRY_lbl_comments" id="EMP_ENTRY_lbl_comments"  class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-3"><textarea name="EMP_ENTRY_ta_comments"  id="EMP_ENTRY_ta_comments" class="form-control  maxlength"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-offset-2">
                        <input type="button" class=" btn" name="EMP_ENTRY_btn_save" id="EMP_ENTRY_btn_save"  disabled=""   value="SAVE"  >
                        <input type="button" class=" btn" name="EMP_ENTRY_btn_reset" id="EMP_ENTRY_btn_reset"  value="RESET">
                    </div>
                </div>
                </fieldset>
        </div>
</form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->