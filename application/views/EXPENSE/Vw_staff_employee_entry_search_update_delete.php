<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE*******************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:27/05/2015 ED:18/05/2015
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
        var EMPSRC_UPD_DEL_sucsval=0;
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
            //SEARCH FORM
            var EMPSRC_UPD_DEL_fullarray=[];
            var EMPSRC_UPD_DEL_searchoption=[];
            var EMPSRC_UPD_DEL_expensearr_designation=[];
            var EMPSRC_UPD_DEL_expensearr_employeename=[];
            var EMPSRC_UPD_DEL_flexheader_array=[];
            var EMPSRC_UPD_DEL_multi_array=[];
            var EMPSRC_UPD_DEL_confmsg_array=[];
            var EMPSRC_UPD_DEL_employeenameconcat;
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
                $("#EMPSRC_UPD_DEL_ta_mobile").hide();
                $("#EMPSRC_UPD_DEL_ta_comments").hide();
                $("#EMPSRC_UPD_DEL_btn_search_autocomplt").hide();
                $('#STDTL_INPUT_noform').hide();
                $('#EMPSRC_UPD_DEL_ta_email').hide();
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
                    $('#searchform').hide();
                    $("#EMPSRC_UPD_DEL_table_employee").hide();
                    $("#EMPSRC_UPD_DEL_lbl_searchoption").hide();
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
//                            alert(EMP_ENTRY_error[7].EMC_DATA)
//                            alert(EMP_ENTRY_multi_array)
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
                    $("#searchform").show();
                    $("#EMPSRC_UPD_DEL_table_employee").show();
                    $("#EMPSRC_UPD_DEL_lbl_searchoption").show();
                    $("#EMPSRC_UPD_DEL_lb_searchoption").show();
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').hide();
                    $("#STDTL_SEARCH_lb_employeename_listbox").hide();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Ctrl_Staff_Employee_Entry_Search_Update_Delete/EMPSRC_UPD_DEL_searchoptionresult'); ?>",
                        success: function(data){
                            $('.preloader').hide();
                            EMPSRC_UPD_DEL_fullarray=JSON.parse(data);
                            EMPSRC_UPD_DEL_searchoption=EMPSRC_UPD_DEL_fullarray[0]
                            EMPSRC_UPD_DEL_expensearr_employeename=EMPSRC_UPD_DEL_fullarray[2]
                            //GET STAFF SEARCH OPTION
                            var EMPSRC_UPD_DEL_searchoptions ='';
                            for (var i = 0; i < EMPSRC_UPD_DEL_searchoption.length; i++) {
                                if( i>=2 && i<=6)
                                {
                                    var EMPSRC_UPD_DEL_searchoption_data=EMPSRC_UPD_DEL_searchoption[i].ECN_DATA;
                                    var EMPSRC_UPD_DEL_searchoption_id=EMPSRC_UPD_DEL_searchoption[i].ECN_ID;
                                    $('#EMPSRC_UPD_DEL_lb_searchoption').append($('<option>').text(EMPSRC_UPD_DEL_searchoption_data).attr('value', EMPSRC_UPD_DEL_searchoption_id));
                                }
                            }
                            EMPSRC_UPD_Sortit('EMPSRC_UPD_DEL_lb_searchoption');
                            $('#EMPSRC_UPD_DEL_lbl_searchoption').show();
                            //GET STAFF EMPLOYEE DESIGNATION
//                            $('#EMPSRC_UPD_DEL_lb_designation_listbox').append($('<option> SELECT </option>'));
                            var EMPSRC_UPD_DEL_searchoptions ='';
                            for (var i = 0; i < EMPSRC_UPD_DEL_searchoption.length; i++) {
                                if( i>=0 && i<=1)
                                {
                                    var EMPSRC_UPD_DEL_searchoption_data=EMPSRC_UPD_DEL_searchoption[i].ECN_DATA;
                                    var EMPSRC_UPD_DEL_searchoption_id=EMPSRC_UPD_DEL_searchoption[i].ECN_ID;
                                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').append($('<option>').text(EMPSRC_UPD_DEL_searchoption_data).attr('value', EMPSRC_UPD_DEL_searchoption_id));
                                }
                            }
                            //GET STAFF EMPLOYEE NAME
                            var EMPSRC_UPD_DEL_expensearray_employeename ='<option>SELECT</option>';
                            for (var i = 0; i < EMPSRC_UPD_DEL_expensearr_employeename.length; i++)
                            {
                                EMPSRC_UPD_DEL_employeenameconcat=EMPSRC_UPD_DEL_expensearr_employeename[i].EMP_DETAIL_names_concat.split("_");
                                EMPSRC_UPD_DEL_expensearray_employeename += '<option value="' + EMPSRC_UPD_DEL_expensearr_employeename[i] + '">' + EMPSRC_UPD_DEL_employeenameconcat[0]+" "+EMPSRC_UPD_DEL_employeenameconcat[1]+ '</option>';
                            }
                            $('#EMPSRC_UPD_DEL_lb_employeename_listbox').html(EMPSRC_UPD_DEL_expensearray_employeename);
                            $('#EMPSRC_UPD_DEL_lb_empdesig').html(EMPSRC_UPD_DEL_searchoption_data)
                        }
                    });
                }
            });
            //FUNCTION FOR SORTING
            function EMPSRC_UPD_Sortit(lbid) {
                var $r = $("#"+lbid+" "+"option");
                $r.sort(function(a, b) {
                    if (a.text < b.text) return -1;
                    if (a.text == b.text) return 0;
                    return 1;
                });
                $($r).remove();
                $("#"+lbid).append($($r));
                $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
                $("select#"+lbid)[0].selectedIndex = 0;
            }
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
//                var EMP_ENTRY_submenu=$("input[name=submenu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6) && (EMP_ENTRY_empdesig!='SELECT'))
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
//                var EMP_ENTRY_submenu=$("input[name=submenu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if(EMP_ENTRY_empdesig=='STAFF'){
                    if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6)&& (EMP_ENTRY_empdesig!='SELECT'))
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
            //SUCCESS FUNCTION FOR SAVE
            function EMP_ENTRY_save_result()
            {
                var EMP_ENTRY_firstname = $('#EMP_ENTRY_tb_firstname').val();
                var EMP_ENTRY_lastname = $('#EMP_ENTRY_tb_lastname').val();
                var EMP_ENTRY_empdesigname = $('#EMP_ENTRY_lb_empdesig').val();
                var EMP_ENTRY_mobilenumber = $('#EMP_ENTRY_tb_mobile').val();
                var EMP_ENTRY_email = $('#EMP_ENTRY_tb_email').val();
                var EMP_ENTRY_comments = $('#EMP_ENTRY_ta_comments').val();
                var EMP_ENTRY_radio_null=$('input:radio[name=EMP_ENTRY_radio_null]:checked').attr('id');
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Staff_Employee_Entry_Search_Update_Delete/EMP_ENTRY_save",
                    data:form_element+"&EMP_ENTRY_firstname="+EMP_ENTRY_firstname+"&EMP_ENTRY_lastname="+EMP_ENTRY_lastname+"&EMP_ENTRY_empdesigname="+EMP_ENTRY_empdesigname+"&EMP_ENTRY_mobilenumber="+EMP_ENTRY_mobilenumber+"&EMP_ENTRY_comments="+EMP_ENTRY_comments+"&EMP_ENTRY_radio_null="+EMP_ENTRY_radio_null,
                    success: function(data) {
                        $(".preloader").hide();
                        var result_value=JSON.parse(data);
                        var EMP_ENTRY_flagrslt=  result_value[0];
                        var EMP_ENTRY_multi_array=  result_value[1];
                        if(EMP_ENTRY_flagrslt==1)
                        {
                            EMP_ENTRY_multitreeview(EMP_ENTRY_multi_array);
//MESSAGE BOX FOR SAVED SUCCESS
                            show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[7].EMC_DATA,"success",false)
                            EMP_ENTRY_employeedetailrset();
                        }
                        else{
//MESSAGE BOX FOR NOT SAVED
                            if(EMP_ENTRY_flagrslt==0){
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[21].EMC_DATA,"error",false)
                            }
                            else
                            {
//CARD SHOULD NOT BE ASSIGNED
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_flagrslt,"error",false)
                            }
                        }
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
            //SEARCH FORM START
            //SEARCH BY ALL OPTIONS//
            $('#EMPSRC_UPD_DEL_lb_searchoption').change(function(){
                var  newPos= adjustPosition($(this).position(),100,270);
                resetPreloader(newPos);
                $(".preloader").show();
                $("textarea").height(116);
                $("textarea").width(300);
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').hide();
                $('#EMPSRC_UPD_DEL_lb_employeename_listbox').hide();
                $('#EMPSRC_UPD_DEL_lbl_designation_listbox').hide();
                $('#EMPSRC_UPD_DEL_lb_designation_listbox').hide();
                $('#EMPSRC_UPD_DEL_lbl_comments').hide();
                $('#EMPSRC_UPD_DEL_ta_comments').hide();
                $('#STDTL_INPUT_lbl_email').hide();
                $('#EMPSRC_UPD_DEL_ta_email').hide();
                $('#STDTL_INPUT_lbl_mobile').hide();
                $('#EMPSRC_UPD_DEL_ta_mobile').hide();
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').attr("disabled", "disabled");
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').hide();
                var EMPSRC_UPD_DEL_search_option = $(this).val();
                if(EMPSRC_UPD_DEL_search_option=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lbl_designation_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lbl_comments').hide();
                    $('#EMPSRC_UPD_DEL_ta_comments').hide();
                    $('#STDTL_INPUT_lbl_email').hide();
                    $('#EMPSRC_UPD_DEL_ta_email').hide();
                    $('#STDTL_INPUT_lbl_mobile').hide();
                    $('#EMPSRC_UPD_DEL_ta_mobile').hide();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').hide();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').hide();
                }
                if(EMPSRC_UPD_DEL_search_option==95)//DESIGNATION
                {
                    $('#EMPSRC_UPD_DEL_lbl_designation_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').val('SELECT');
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('EMPSRC_UPD_DEL_tble_email_option').hide();
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==90)//EMPLOYEE NAME
                {
                    $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val('SELECT');
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==96)//EMAIL
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
//                    google.script.run.withFailureHandler(EMPSRC_UPD_error).withSuccessHandler(EMPSRC_UPD_DEL_autocomplts_autocompleteresult).EMPSRC_UPD_DEL_autocomplts_autocomplete($('#EMPSRC_UPD_DEL_lb_searchoption').val());
                    $('#STDTL_INPUT_lbl_email').show();
                    $('#EMPSRC_UPD_DEL_ta_email').show();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_email').val('');
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==99)//MOBILE NO
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
                    $('#STDTL_INPUT_lbl_mobile').show();
                    $('#EMPSRC_UPD_DEL_ta_mobile').show();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
//                    google.script.run.withFailureHandler(EMPSRC_UPD_error).withSuccessHandler(EMPSRC_UPD_DEL_autocomplts_autocompleteresult).EMPSRC_UPD_DEL_autocomplts_autocomplete($('#EMPSRC_UPD_DEL_lb_searchoption').val());
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_mobile').val('');
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==94)//COMMENTS
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
//                    google.script.run.withFailureHandler(EMPSRC_UPD_error).withSuccessHandler(EMPSRC_UPD_DEL_autocomplts_autocompleteresult).EMPSRC_UPD_DEL_autocomplts_autocomplete($('#EMPSRC_UPD_DEL_lb_searchoption').val());
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_comments').val('');
                    $('#EMPSRC_UPD_DEL_lbl_comments').show();
                    $('#EMPSRC_UPD_DEL_ta_comments').show();
                    $(".preloader").hide();
                }
            });
            //CHANGE EVENT FUNCTION FOR EMPLOYEE DESIGNATION
            $('#EMPSRC_UPD_DEL_lb_designation_listbox').change(function(){
//                EMPSRC_UPD_DEL_sucsval=0;
//                $(".preloader").show();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                var EMPSRC_UPD_DEL_designation = $("#EMPSRC_UPD_DEL_lb_designation_listbox").val();
                if(EMPSRC_UPD_DEL_designation=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //CHANGE EVENT FUNCTION FOR EMPLOYEE NAME
            $('#EMPSRC_UPD_DEL_lb_employeename_listbox').change(function(){
                $(".preloader").show();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                var EMPSRC_UPD_DEL_employeename = $("#EMPSRC_UPD_DEL_lb_employeename_listbox").val();
                if(EMPSRC_UPD_DEL_employeename=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //CHANGE EVENT FUNCTION FOR COMMENTS
            $( "#EMPSRC_UPD_DEL_ta_comments" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
            });
//CHANGE EVENT FUNCTION FOR EMAIL
            $( "#EMPSRC_UPD_DEL_ta_email" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
            });
//CHANGE EVENT FUNCTION FOR MOBILE
            $( "#EMPSRC_UPD_DEL_ta_mobile" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
            });
            //FUNCTION TO AUTOCOMPLETE SEARCH TEXT
            var EMPSRC_UPD_DEL_comments=[];
            var EMPSRC_UPD_DEL_email=[];
            var EMPSRC_UPD_DEL_mobile=[];
            var EMPSRC_UPD_DEL_autocomplt_flag;
            var EMPSRC_UPD_DEL_auto=[];
            function EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
            {
                EMPSRC_UPD_DEL_autocomplt_flag=$('#EMPSRC_UPD_DEL_lb_searchoption').val();
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Staff_Employee_Entry_Search_Update_Delete/EMPSRC_UPD_DEL_comments",
                    data:form_element,
                    success: function(data){
                        $('.preloader').hide();
                        $('#STDTL_SEARCH_div_headernodata').hide();
                        EMPSRC_UPD_DEL_auto=JSON.parse(data);
                        EMPSRC_UPD_DEL_comments=EMPSRC_UPD_DEL_auto
                        //KEY PRESS FUNCTION
                        $(".keypressvalid").keypress(function(){
//                            EMPSRC_UPD_DEL_chkflag=0;
                            EMPSRC_UPD_DEL_highlightSearchText();
                            if(EMPSRC_UPD_DEL_autocomplt_flag==94)//COMMENTS
                            {
                                $( "#EMPSRC_UPD_DEL_ta_comments" ).autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                            if(EMPSRC_UPD_DEL_autocomplt_flag==96)//EMAIL
                            {
                                $("#EMPSRC_UPD_DEL_ta_email").autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                            else if(EMPSRC_UPD_DEL_autocomplt_flag==99)//MOBILE NO
                            {
                                $("#EMPSRC_UPD_DEL_ta_mobile").autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                        });
                    }
                });
            }
            //CHANGE FUNCTION FOR COMMENTS
            var EMPSRC_UPD_DEL_chkflag;
            $(document).on('change ','.commentsresultsvalidate',function(){
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                var EMPSRC_UPD_DEL_search_option = $('#EMPSRC_UPD_DEL_lb_searchoption').val();
                if(EMPSRC_UPD_DEL_search_option==94)//COMMENTS
                {
                    var EMPSRC_UPD_DEL_empcomments=$("#EMPSRC_UPD_DEL_btn_search_autocomplt").val();
                    var EMPSRC_UPD_DEL_empcommentstxt=$('#EMPSRC_UPD_DEL_ta_comments').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[3];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[COMMENTS]',EMPSRC_UPD_DEL_empcommentstxt);
                }
                else if(EMPSRC_UPD_DEL_search_option==96)//EMAIL
                {
                    var EMPSRC_UPD_DEL_empemailtxt=$('#EMPSRC_UPD_DEL_ta_email').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[11];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[EMAIL]',EMPSRC_UPD_DEL_empemailtxt);
                }
                else if(EMPSRC_UPD_DEL_search_option==99)//MOBILE NO
                {
                    var EMPSRC_UPD_DEL_empmobiletxt=$('#EMPSRC_UPD_DEL_ta_mobile').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[13];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[MOBILE NO]',EMPSRC_UPD_DEL_empmobiletxt);
                }
                if(EMPSRC_UPD_DEL_chkflag==1){
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').text(EMPSRC_UPD_DEL_errormsg).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                    $("#EMPSRC_UPD_DEL_btn_search_autocomplt").attr("disabled","disabled");
                }
                if($(this).val()=="")
                {
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                    $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_table_updateform').hide();
                    $('#EMPSRC_UPD_DEL_searchbutton').hide();
                    $("#EMPSRC_UPD_DEL_btn_search_autocomplt").attr("disabled","disabled");
                }
            });
            //FUNCTION TO GET SELECTED VALUE
            function EMPSRC_UPD_DEL_AutoCompleteSelectHandler(event, ui) {
//                EMPSRC_UPD_DEL_chkflag=1;
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').removeAttr("disabled");
            }

            //FUNCTION TO HIGHLIGHT SEARCH TEXT
            function EMPSRC_UPD_DEL_highlightSearchText() {
                $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                    var re = new RegExp(this.term, "i") ;
                    var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + t + "</a>" )
                        .appendTo( ul );
                };
            }
            //CLICK FUNCTION FOR AUTO SEARCH BUTTON
            $('#EMPSRC_UPD_DEL_btn_search_autocomplt').click(function(){
                var EMPSRC_UPD_DEL_empcommentstxt=$('#EMPSRC_UPD_DEL_ta_comments').val();
                var EMPSRC_UPD_DEL_empemailtxt=$('#EMPSRC_UPD_DEL_ta_email').val();
                var EMPSRC_UPD_DEL_empmobilenotxt=$('#EMPSRC_UPD_DEL_ta_mobile').val();
                if((EMPSRC_UPD_DEL_empcommentstxt!="")||(EMPSRC_UPD_DEL_empemailtxt!="")||(EMPSRC_UPD_DEL_empmobilenotxt!=""))
                {
                    $(".preloader").show();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //SUCCESS FUNCTION FOR SELECTING DATA
            var EMPSRC_UPD_DEL_result_array;
            var id;var comments;var EMPSRC_UPD_DEL_unitno;var email;var cardnumber;
            function EMPSRC_UPD_DEL_srch_result()
            {
//                var STDTL_SEARCH_firstlastname = EMPSRC_UPD_DEL_employeenameconcat
//                data:form_element+"&EMP_ENTRY_firstname="+EMP_ENTRY_firstname+"&EMP_ENTRY_lastname="+EMP_ENTRY_lastname+"&EMP_ENTRY_empdesigname="+EMP_ENTRY_empdesigname+"&EMP_ENTRY_mobilenumber="+EMP_ENTRY_mobilenumber+"&EMP_ENTRY_comments="+EMP_ENTRY_comments+"&EMP_ENTRY_radio_null="+EMP_ENTRY_radio_null,
                var EMPSRC_UPD_DEL_lb_designation_listbox=$('#EMPSRC_UPD_DEL_lb_designation_listbox').find('option:selected').text();
//  var STDTL_SEARCH_firstlastname = $("#STDTL_SEARCH_lb_employeename_listbox").val();
                var emp_first_name=EMPSRC_UPD_DEL_employeenameconcat[0]
                var emp_last_name=EMPSRC_UPD_DEL_employeenameconcat[1]

                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Staff_Employee_Entry_Search_Update_Delete/fetchdata",
                    data:form_element+"&EMPSRC_UPD_DEL_lb_designation_listbox="+EMPSRC_UPD_DEL_lb_designation_listbox+"&emp_first_name="+emp_first_name+"&emp_last_name="+emp_last_name,
                    success: function(data) {
                        $('.preloader').hide();
                        EMPSRC_UPD_DEL_result_array=JSON.parse(data);
                if(EMPSRC_UPD_DEL_result_array.length==0)
                {

                }
                else
                {
                    var EMPSRC_UPD_DEL_value='';
                        var EMPSRC_UPD_DEL_header='<table id="EMPSRC_UPD_DEL_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white" width="1500"><tr><th>EDIT/DELETE</th><th style="width:80px">FIRST NAME</th><th style="width:80px">LAST NAME</th><th style="width:80px">MOBILE</th><th style="width:80px">EMAIL</th><th style="width:80px">DESIGNATION</th><th style="width:80px">UNIT NO</th><th style="width:80px">CARD NUMBER</th><th style="width:250px">COMMENTS</th><th style="width:200px">USERSTAMP</th><th style="width:150px">TIMESTAMP</th></tr></thead><tbody>'
                        for(var j=0;j<EMPSRC_UPD_DEL_result_array.length;j++){
                            var EMPSRC_UPD_DEL_values=EMPSRC_UPD_DEL_result_array[j]
                            id=EMPSRC_UPD_DEL_result_array[j].ID
                            comments=EMPSRC_UPD_DEL_result_array[j].comments
                            if((comments=='null')||(comments==undefined))
                            {
                                comments='';
                            }
                            EMPSRC_UPD_DEL_unitno=EMPSRC_UPD_DEL_result_array[j].EMPSRC_UPD_DEL_unitno
                            if((EMPSRC_UPD_DEL_unitno=='null')||(EMPSRC_UPD_DEL_unitno==undefined))
                            {
                                EMPSRC_UPD_DEL_unitno='';
                            }
                            email=EMPSRC_UPD_DEL_result_array[j].email
                            if((email=='null')||(email==undefined))
                            {
                                email='';
                            }
                            cardnumber=EMPSRC_UPD_DEL_result_array[j].cardnumber
                            if((cardnumber=='null')||(cardnumber==undefined))
                            {
                                cardnumber='';
                            }
                            EMPSRC_UPD_DEL_header+='<tr><td><div class="col-lg-1"><span style="display: block;color:green" class="glyphicon glyphicon-edit staffsalary_editbutton" id='+id+' title="Edit"></div><div class="col-lg-1"><span style="display: block;color:red" class="glyphicon glyphicon-trash deletebutton" id='+id+' title="Delete"></div></td><td>'+EMPSRC_UPD_DEL_values.Femployeename+'</td><td>'+EMPSRC_UPD_DEL_values.Lemployeename+'</td><td>'+EMPSRC_UPD_DEL_values.mobile+'</td><td>'+email+'</td><td>'+EMPSRC_UPD_DEL_values.designation+'</td><td>'+EMPSRC_UPD_DEL_unitno+'</td><td>'+cardnumber+'</td><td>'+comments+'</td><td>'+EMPSRC_UPD_DEL_values.userstamp+'</td><td>'+EMPSRC_UPD_DEL_values.timestamp+'</td></tr>';
                        }
                    EMPSRC_UPD_DEL_header+='</tbody></table>';
                        $('section').html(EMPSRC_UPD_DEL_header);
                        $('#EMPSRC_UPD_DEL_tble_htmltable').DataTable( {
                            "aaSorting": [],
                            "pageLength": 10,
                            "sPaginationType":"full_numbers"
                        });
                    $('#EMPSRC_UPD_DEL_div_htmltable').show();
                }
            }
                });
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
                <div id="searchform" hidden>
                    <form id="EMPSRC_UPD_DEL_form_errormsg">
                        <table id="EMPSRC_UPD_DEL_table_errormsg">
                        </table>
                    </form>
                    <div id="EMPSRC_UPD_DEL_table_employee">
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_searchoption" id="EMPSRC_UPD_DEL_lbl_searchoption" class="col-sm-2" hidden>SEARCH BY<em>*</em></label>
                        <div class="col-sm-4"><select name="EMPSRC_UPD_DEL_lb_searchoption" id="EMPSRC_UPD_DEL_lb_searchoption"  hidden>
                            </select>
                        </div>
                    </div>
                    <div><lable id = "EMPSRC_UPD_DEL_lbl_searchoptionheader" name = "EMPSRC_UPD_DEL_lbl_searchoptionheader" class = "srctitle" hidden ></div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR EMPLOYEE FIRST NAME------------------------------------------------>
                    <div class="row form-group">
                        <lable id ="EMPSRC_UPD_DEL_lbl_employeename_listbox" class="col-sm-2" hidden> EMPLOYEE NAME </lable>
                        <div class="col-sm-4"><select id="EMPSRC_UPD_DEL_lb_employeename_listbox" name="EMPSRC_UPD_DEL_lb_employeename_listbox" hidden>
                                <option>SELECT</option>
                            </select> </div>
                    </div>
                        <!----------ELEMENT TO CREATE SEARCH FORM FOR DESIGNATION------------------------------------------------>
                        <div class="row form-group">
                        <lable id ="EMPSRC_UPD_DEL_lbl_designation_listbox" class="col-sm-2" hidden>DESIGNATION</lable>
                            <div class="col-sm-4"><select id="EMPSRC_UPD_DEL_lb_designation_listbox" name="EMPSRC_UPD_DEL_lb_designation_listbox" hidden>
                                    <option>SELECT</option>
                                </select>
                            </div>
                        </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR COMMENTS------------------------------------------------>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_comments" id="EMPSRC_UPD_DEL_lbl_comments"  class="col-sm-2" hidden>COMMENTS</label>
                        <div class="col-sm-3"><textarea name="EMPSRC_UPD_DEL_ta_comments"  id="EMPSRC_UPD_DEL_ta_comments" class="form-control  auto commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR EMAIL------------------------------------------------>
                    <div class="row form-group">
                        <label name="STDTL_INPUT_lbl_email" id="STDTL_INPUT_lbl_email"  class="col-sm-2" hidden>E-MAIL ID</label>
                        <div class="col-sm-3"><textarea name="EMPSRC_UPD_DEL_ta_email"  id="EMPSRC_UPD_DEL_ta_email" class="form-control  auto commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR MOBILE------------------------------------------------>
                    <div class="row form-group">
                        <label name="STDTL_INPUT_lbl_mobile" id="STDTL_INPUT_lbl_mobile"  class="col-sm-2" hidden>MOBILE</label>
                        <div class="col-sm-3"><textarea name="EMPSRC_UPD_DEL_ta_mobile"  id="EMPSRC_UPD_DEL_ta_mobile" class="form-control auto commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-offset-2">
                        <input type="button" class=" btn" name="EMPSRC_UPD_DEL_btn_search_autocomplt" id="EMPSRC_UPD_DEL_btn_search_autocomplt"  disabled=""   value="SEARCH"  >
                    </div>
                    <div class="srctitle" name="EMPSRC_UPD_DEL_lbl_htmltablemsg" id="EMPSRC_UPD_DEL_lbl_htmltablemsg"></div><br>
                    <div class="errormsg" name="EMPSRC_UPD_DEL_nodataerrormsg" id="EMPSRC_UPD_DEL_nodataerrormsg"></div>
                    <div class="table-responsive" id="EMPSRC_UPD_DEL_div_htmltable" style="  overflow-y: hidden;" hidden>
                        <section>
                        </section>
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