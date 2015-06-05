<html>
<head>
    <?php include 'EI_HDR.php'; ?>
</head>
<script>
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_Configuration_Trigger/TriggerConfiguration',
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                for(var i=0;i<value_array.length;i++)
                {
                    var data=value_array[i];
                    $('#Triggername').append($('<option>').text(data.TC_DATA).attr('value', data.TC_ID));
                }
            },
            error: function(data){
                $('.preloader').hide();
                alert('error in getting'+JSON.stringify(data));
            }
        });
        $(document).on('change','#Triggername',function() {
            var tirgger=$('#Triggername').val();
            if(tirgger!='SELECT')
            {
                $("#Trigger_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#Trigger_submitbutton").attr("disabled", "disabled");
            }
        });
        $(document).on('click','#Trigger_submitbutton',function() {
            var Tirgger=$('#Triggername').val();
            $('.preloader').show();
            $.ajax({
                type: "POST",
                data:{Triggernameid:Tirgger},
                url: '/index.php/Ctrl_Configuration_Trigger/CSV_Initaildatas',
                success: function(data){
                    alert(data)

                    var returnvalue=JSON.parse(data);
                    $('section').html(returnvalue);
                    show_msgbox("CSV UPDATION",returnvalue,"success",false);
                    $('.preloader').hide();
                    var value_array=JSON.parse(data);
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
    });
    </script>

    <body>
    <div class="container">
        <div class="wrapper">
            <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
            <div class="row title text-center"><h4><b>TRIGGER</b></h4></div>
            <div class ='row content'>
            <form id="TriggerForm" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>TRIGGER NAME<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="Triggername" id="Triggername">
                                <OPTION value="SELECT">SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="Trigger_submitbutton" class="btn" value="RUN" disabled>
                        </div>
                    </div>
                    <div>
                        <section>

                        </section>
                    </div>
                </div>
            </form>
        </body>

