<?php
require_once('Header.php');
?>
<!--SCRIPT TAG START-->
<script>
    //DOCUMENT READY FUNCTION START
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        $('.preloader').hide();
        $('#CONFIG_ENTRY_lb_module').hide();
        //CHANGE EVENT FOR TYPE CONFIG
        $(document).on('change','#CONFIG_ENTRY_lb_searchby',function(){
            var CONFIG_ENTRY_searchby=$('#CONFIG_ENTRY_lb_searchby').val();
            $("#CONFIG_ENTRY_lb_module").hide();
            $("#CONFIG_ENTRY_lbl_module").hide();
            $("#CONFIG_ENTRY_tr_type").hide();
            $("#CONFIG_ENTRY_tr_data").hide();
            $("#CONFIG_ENTRY_tr_btn").hide();
            if(CONFIG_ENTRY_searchby=='SELECT')
            {
                $("#CONFIG_ENTRY_lb_module").hide();
                $("#CONFIG_ENTRY_lbl_module").hide();
                $("#CONFIG_ENTRY_tr_type").hide();
                $("#CONFIG_ENTRY_tr_data").hide();
                $("#CONFIG_ENTRY_tr_btn").hide();
            }
            else  if(CONFIG_ENTRY_searchby=='CONFIGURATION ENTRY')
            {
            $("#CONFIG_ENTRY_lb_module").val('SELECT').show();
            $("#CONFIG_ENTRY_lbl_module").show();
            }
            else  if(CONFIG_ENTRY_searchby=='CONFIGURATION SEARCH/UPDATE')
            {
                $("#CONFIG_ENTRY_lb_module").val('SELECT').show();
                $("#CONFIG_ENTRY_lbl_module").show();
            }
        });
        var CONFIG_ENTRY_searchby=$('#CONFIG_ENTRY_lb_searchby').val();
        $(document).on('change','#CONFIG_ENTRY_lb_searchby',function(){
            $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONFIG_ENTRY_tr_type').empty();
            $('#CONFIG_ENTRY_div_errMod').hide();
            var CONFIG_ENTRY_data=$(this).val();
            if($(this).val()!='SELECT'){
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_entry_controller/CONF_ENTRY_script_name",
            data :{'CONFIG_ENTRY_searchby':CONFIG_ENTRY_data},
            success: function(data){
                $('.preloader').hide(); value_array=JSON.parse(data);
                for(var i=0;i<value_array[0].length;i++)
                {
                    var data=value_array[0][i];
                    $('#CONFIG_ENTRY_lb_module').append($('<option>').text(data.CNP_DATA).attr('value', data.CNP_ID));
                }
//                    for(var i=0;i<value_array[1].length;i++)
//                    {
//                        var data=value_array[1][i];
//                        $('#Finance_Entry_Payment').append($('<option>').text(data.PP_DATA).attr('value', data.PP_DATA));
//                    }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
            }
        });
        //CHANGE EVENT FOR MODULE CONFIG
        $(document).on('change','#CONFIG_ENTRY_lb_module',function(){
            $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONFIG_ENTRY_tr_type').empty();
            $('#CONFIG_ENTRY_div_errMod').hide();
            var CONFIG_ENTRY_data=$(this).val();
            var CONFIG_ENTRY_searchby=$('#CONFIG_ENTRY_lb_searchby').val();
            var CONFIG_ENTRY_typ_opt='<option value="SELECT">SELECT</option>';
            var formElement = document.getElementById("CONFIG_ENTRY_form");

            if($(this).val()!='SELECT'){
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_entry_controller/CONF_ENTRY_type_name",
                    data :{'CONFIG_ENTRY_data':CONFIG_ENTRY_data,'CONFIG_ENTRY_searchby':CONFIG_ENTRY_searchby},
                    success: function(data){
                        $('.preloader').hide();
                        var CONFIG_ENTRY_values=JSON.parse(data)
                        if(CONFIG_ENTRY_values.length==0){
//                            $('#CONFIG_ENTRY_div_errMod').show();
//                            $('#CONFIG_ENTRY_div_errMod').text(CONFIG_ENTRY_errmsg[1].replace('[TYPE]',$("#CONFIG_ENTRY_lb_module option:selected").text()));
                        }else{
                            $('#CONFIG_ENTRY_div_errMod').hide();
                            for (var i=0;i<CONFIG_ENTRY_values.length;i++) {

                                CONFIG_ENTRY_typ_opt += '<option value="' + CONFIG_ENTRY_values[i].CNP_ID + '">' + CONFIG_ENTRY_values[i].CGN_TYPE + '</option>';
                            }
                            $('#CONFIG_ENTRY_tr_type').append(' <div class="form-group row" ><label class="col-sm-2 control-label">TYPE<em>*</em></label> <div class="col-sm-10"><select id="CONFIG_ENTRY_lb_type" name="CONFIG_ENTRY_lb_type"  class="form-control" style="width:305px"></select> </div></div>')
                            $('#CONFIG_ENTRY_lb_type').html(CONFIG_ENTRY_typ_opt);
                            $("#CONFIG_ENTRY_tr_type").show();
                        }
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                    }
            });
            }
        });
        //CHANGE EVENT FOR TYPE CONFIG
        $(document).on('change','#CONFIG_ENTRY_lb_type',function(){
            $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
            if($('#CONFIG_ENTRY_lb_type').val()!='SELECT' && $('#CONFIG_ENTRY_lb_searchby').val()!='CONFIGURATION SEARCH/UPDATE')
            {
                $('#CONFIG_ENTRY_tr_data').append('<div class="form-group row" ><label class="control-label col-sm-2">DATA<em>*</em></label> <div class="col-sm-10"><input type="text" id="CONFIG_ENTRY_tb_data" name="CONFIG_ENTRY_tb_data" class="form-control"  style="width:305px"></div><td><div id="CONFIG_ENTRY_div_errmsg" hidden class="errormsg"></div></td>');
                $('#CONFIG_ENTRY_tr_btn').append('&nbsp;&nbsp;&nbsp;<input  type="button" id="CONFIG_ENTRY_btn_save" class="btn  btn-info btn-lg" value="SAVE" disabled>&nbsp;&nbsp;&nbsp;<input type="button" id="CONFIG_ENTRY_btn_reset" class="btn btn-info btn-lg" value="RESET">');
                $("#CONFIG_ENTRY_tb_data").doValidation({rule:'alphanumeric',prop:{whitespace:true,uppercase:true,autosize:true}});
                $("#CONFIG_ENTRY_tr_data").show();
                $("#CONFIG_ENTRY_tr_btn").show();
                $(".alphabets").doValidation({rule:'alphabets',prop:{whitespace:true,uppercase:true,autosize:true}});
            }
            else if($('#CONFIG_ENTRY_lb_type').val()!='SELECT' && $('#CONFIG_ENTRY_lb_searchby').val()=='CONFIGURATION SEARCH/UPDATE')
            {
                CONFIG_SRCH_UPD_fetch_configdata()
            }
            else
            {
                $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
            }
        });
        //CHANGE FUNCTION FOR DATA
        $(document).on('change blur','#CONFIG_ENTRY_tb_data',function(){
            var formElement = document.getElementById("CONFIG_ENTRY_form");
            var CONFIG_ENTRY_tb_data=$('#CONFIG_ENTRY_tb_data').val();
            if($(this).val()!=''){
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_entry_controller/CONF_ENTRY_type_name",
                    data :{'CONFIG_ENTRY_tb_data':CONFIG_ENTRY_tb_data},
                    success: function(data){
                        $('.preloader').hide();
                        var CONFIG_ENTRY_values=JSON.parse(data)
                        if(CONFIG_ENTRY_values.length==0){
                            $("#CONFIG_ENTRY_div_errmsg").show();
//                            $("#CONFIG_ENTRY_div_errmsg").text(CONFIG_ENTRY_errmsg[3].replace('[TYPE]',$("#CONFIG_ENTRY_lb_type option:selected").text()));}
                        } else
                            $("#CONFIG_ENTRY_div_errmsg").text('');
                        if(CONFIG_ENTRY_values==0)
                            $("#CONFIG_ENTRY_btn_save").removeAttr("disabled","disabled");
                        else
                            $("#CONFIG_ENTRY_btn_save").attr("disabled","disabled");

                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                    }
                });
            }
            else
            {
                $("#CONFIG_ENTRY_btn_save").attr("disabled","disabled");
            }
        });
        //FUNCTION FOR FETCHING DATA FOR FLEX TABLE
        function CONFIG_SRCH_UPD_fetch_configdata(){
            var formElement = document.getElementById("CONFIG_SRCH_UPD_form");
            $.ajax({
                type: "POST",
                data: $('#CONFIG_ENTRY_form').serialize(),
                'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_entry_controller/CONF_ENTRY_flex_data",
//                data :{'CONFIG_ENTRY_tb_data':CONFIG_ENTRY_tb_data},
                success: function(data){
//                    alert(data)
                    $('.preloader').hide();
                    var CONFIG_SRCH_UPD_values=JSON.parse(data)
                    $('section').html(CONFIG_SRCH_UPD_values);
                    var oTable= $('#CONFIG_SRCH_UPD_tble_config').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers"
                    });
                    if(oTable.rows().data().length==0){
//                        $('#CONFIG_SRCH_UPD_err_flex').text(CONFIG_SRCH_UPD_errmsg[6].replace('[TYPE]',$("#CONFIG_SRCH_UPD_lb_type option:selected").text())).show();
                        $('section').html('');
                        $('#CONFIG_SRCH_UPD_tble_config').hide();
                    }
                    else{
//                        $('#CONFIG_SRCH_UPD_div_errmsg').removeClass('errormsg').addClass('srctitle');
//                        $('#CONFIG_SRCH_UPD_div_errmsg').text(CONFIG_SRCH_UPD_errmsg[3].replace('[TYPE]',$("#CONFIG_SRCH_UPD_lb_type option:selected").text()));
                    }
//                    if(CONFIG_flag_upd==1){
//                        var errmsg=CONFIG_SRCH_UPD_errmsg[4].replace('[MODULE NAME]',$("#CONFIG_SRCH_UPD_lb_module option:selected").text());
//                        $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CONFIGURATION ENTRY",msgcontent:errmsg,position:{top:150,left:530}}});}
//                    }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        }
        //CLICK EVENT FOR BUTTON
        $(document).on('click','#CONFIG_ENTRY_btn_save',function(){
            $('.preloader').show();
            var CONFIG_ENTRY_module=$('#CONFIG_ENTRY_lb_module').val();
            var CONFIG_ENTRY_type=$('#CONFIG_ENTRY_lb_type').val();
            var CONFIG_ENTRY_data=$('#CONFIG_ENTRY_tb_data').val();
            $.ajax({
                type: "POST",
                data: $('#CONFIG_ENTRY_form').serialize(),
                'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_entry_controller/CONF_ENTRY_save_data",
//                data :{'CONFIG_ENTRY_module':CONFIG_ENTRY_module,'CONFIG_ENTRY_type':CONFIG_ENTRY_type,'CONFIG_ENTRY_tb_data':CONFIG_ENTRY_tb_data},
                success: function(data){
//                    alert(data)
                    $('.preloader').hide();
                    var CONFIG_ENTRY_msg_alert=JSON.parse(data)
                    if(CONFIG_ENTRY_msg_alert==1)
                    {
//                        var errmsg=CONFIG_ENTRY_errmsg[2].replace('[MODULE NAME]',$("#CONFIG_ENTRY_lb_module option:selected").text());
//                        $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CONFIGURATION ENTRY",msgcontent:errmsg,position:{top:150,left:530}}});
                        show_msgbox("CONFIGURATION ENTRY",'save success',"success",false)
                    }
                    else if(CONFIG_ENTRY_msg_alert==0)
                    {
                        show_msgbox("CONFIGURATION ENTRY",'not saved',"error",false)
//                        $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CONFIGURATION ENTRY",msgcontent:CONFIG_ENTRY_errmsg[0],position:{top:150,left:530}}});
                    }
                    if(CONFIG_ENTRY_msg_alert==2){
//                        $("#CONFIG_ENTRY_btn_save").attr("disabled","disabled");
//                        $("#CONFIG_ENTRY_div_errmsg").text(CONFIG_ENTRY_errmsg[3].replace('[TYPE]',$("#CONFIG_ENTRY_lb_type option:selected").text())).show();
                    }
                    else{
                        $('#CONFIG_ENTRY_tr_type,#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
                        $('#CONFIG_ENTRY_lbl_module').hide();
                        $('#CONFIG_ENTRY_lb_module').hide();
                    }
                    $('#CONFIG_ENTRY_lb_module').val('SELECT');
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
        //CLICK EVENT FOR BUTTON RESET
        $(document).on('click','#CONFIG_ENTRY_btn_reset',function(){
//            alert('ll')
            $('#CONFIG_ENTRY_tr_type,#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
            $("#CONFIG_ENTRY_lb_module").hide();
            $("#CONFIG_ENTRY_lbl_module").hide();
            $('#CONFIG_ENTRY_lb_searchby').val('SELECT')
        });

    });
//DOCUMENT READY FUNCTION END
</script>
<!--SCRIPT TAG END-->
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
        <div class="row title text-center"><h4><b>CONFIGURATION ENTRY</b></h4></div>
        <div class ='row content'>
            <form   id="CONFIG_ENTRY_form"  name="CONFIG_ENTRY_form" class="form-horizontal" role="form">
                <div class="form-group row" >
                    <label  id="CONFIG_ENTRY_lbl_searchby" class="col-sm-2 control-label">SEARCH BY<em>*</em></label>
                    <div class="col-sm-10">
                        <select name="CONFIG_ENTRY_lb_searchby" id="CONFIG_ENTRY_lb_searchby" class="form-control" style="width:305px" hidden>
                            <option>SELECT</option>
                            <option value="CONFIGURATION ENTRY">CONFIGURATION ENTRY</option>
                            <option value="CONFIGURATION SEARCH/UPDATE">CONFIGURATION SEARCH/UPDATE</option>
                        </select><br><label id="CONFIG_ENTRY_div_errMod" hidden class="errormsg" hidden></label>
                    </div>
                </div>
<!--                <div id="CONFIG_ENTRY_entry_form" >-->
                <div class="form-group row" >
                    <label  id="CONFIG_ENTRY_lbl_module" class="col-sm-2 control-label" hidden>MODULE NAME<em>*</em></label>
                    <div class="col-sm-10">
                        <select name="CONFIG_ENTRY_lb_module" id="CONFIG_ENTRY_lb_module" class="form-control" style="width:305px" hidden>
                            <option>SELECT</option>
                        </select><br><label id="CONFIG_ENTRY_div_errMod" hidden class="errormsg" hidden></label>
                    </div>
                </div>
        <div id="CONFIG_ENTRY_tr_type"> </div>
                <div id="CONFIG_ENTRY_tr_data"></div>
                    <div id="CONFIG_ENTRY_tr_btn"></div>
<!--                    </div>-->
    </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->