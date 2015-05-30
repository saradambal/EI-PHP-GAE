<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_CSV/TriggerConfiguration',
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
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
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
                url: '/index.php/Ctrl_CSV/CSV_Initaildatas',
                success: function(data){
                    alert(data)
                    var returnvalue=JSON.parse(data);
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
            <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
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
                </div>
            </form>
        </body>

