<!--*********************************************GLOBAL DECLARATION******************************************-->
<!--*********************************************************************************************************//-->
<!--//*******************************************FILE DESCRIPTION*********************************************//
//****************************************CONFIGURATION SEARCH/UPDATE/DELETE*************************************************//
//DONE BY:LALITHA
//VER 0.01-SD:06/01/2015 ED:06/01/2015
//*********************************************************************************************************//
<?php
include "HEADER.php"
?>
<!--SCRIPT TAG START-->
<script>
    //DOCUMENT READY FUNCTION START
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        //INITIAL DATAS
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_search_update_delete_controller/CONF_ENTRY_module_name",
            success: function(data){
                $('.preloader').hide();

                var value_array=JSON.parse(data);
                for(var i=0;i<value_array[0].length;i++)
                {
                    var data=value_array[0][i];
                    $('#CONFIG_SRCH_UPD_lb_module').append($('<option>').text(data.CNP_DATA).attr('value', data.CNP_ID));
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
        //CHANGE EVENT FOR MODULE CONFIG
        $(document).on('change','#CONFIG_SRCH_UPD_lb_module',function(){
            $('#CONFIG_SRCH_UPD_err_flex').hide();
            var CONFIG_SRCH_UPD_mod=$(this).val();
            $('#CONFIG_SRCH_UPD_tr_data,#CONFIG_SRCH_UPD_tr_btn,#CONFIG_SRCH_UPD_tr_type,section').empty();
            $('#CONFIG_SRCH_UPD_div_errMod').hide();
            var CONFIG_SRCH_UPD_typ_opt='<option value="SELECT">SELECT</option>';
            var formElement = document.getElementById("CONFIG_SRCH_UPD_form");
            if($(this).val()!='SELECT'){
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    'url': "<?php echo base_url(); ?>" + "index.php/Configuration_configuration_search_update_delete_controller/CONF_ENTRY_type_name",
                    data :{'CONFIG_SRCH_UPD_mod':CONFIG_SRCH_UPD_mod},
                    success: function(data){
                        $('.preloader').hide();
                        var CONFIG_SRCH_UPD_values=JSON.parse(data);
                        if(CONFIG_SRCH_UPD_values.length==0){
//                    $('#CONFIG_SRCH_UPD_div_errMod').show();
//                    $('#CONFIG_SRCH_UPD_div_errMod').text(CONFIG_SRCH_UPD_errmsg[5].replace('[TYPE]',$("#CONFIG_SRCH_UPD_lb_module option:selected").text()));
                        }else{
                            $('#CONFIG_SRCH_UPD_div_errMod').hide();
                            for (var i=0;i<CONFIG_SRCH_UPD_values.length;i++) {
                                CONFIG_SRCH_UPD_typ_opt += '<option value="' + CONFIG_SRCH_UPD_values[i].CNP_ID + '">' + CONFIG_SRCH_UPD_values[i].CGN_TYPE + '</option>';
                            }
                            $('#CONFIG_SRCH_UPD_tr_type').append('<div class="form-group row" ><label  class="col-sm-2 control-label">TYPE<em>*</em></label><div class="col-sm-10"><select id="CONFIG_SRCH_UPD_lb_type" name="CONFIG_SRCH_UPD_lb_type"  class="form-control" style="width:305px"></select></div></div>')
                            $('#CONFIG_SRCH_UPD_lb_type').html(CONFIG_SRCH_UPD_typ_opt);
                        }
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                    }
                });
            }
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
        <div class="row title text-center"><h4><b>CONFIGURATION SEARCH/UPDATE/DELETE</b></h4></div>
        <div class ='row content'>
            <form   id="ET_ENTRY_form_template" class="form-horizontal" role="form">
                <div class="form-group row" >
                    <label  class="col-sm-2 control-label">MODULE NAME<em>*</em></label>
                    <div class="col-sm-10">
                        <select name="CONFIG_SRCH_UPD_lb_module" id="CONFIG_SRCH_UPD_lb_module" class="form-control" style="width:305px">
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <div id="CONFIG_SRCH_UPD_tr_type"></div>
                <div class="table-responsive" >
                    <section></section>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->