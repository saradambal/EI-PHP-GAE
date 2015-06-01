<!--//*******************************************FILE DESCRIPTION*********************************************//
//*******************************************MENU*********************************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:21/01/2015 ED:21/01/2015
//*********************************************************************************************************//-->
<?php
require_once('Header.php');
?>
<html>
<head>
    <style>
        .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.open>a {
            background-color: rgba(0,0,0,0) !important;
            background-image: none;
        }
    </style>
<script>
var all_menu_array=[];
var MenuPage=1;
    var SubPage=2;
    var address='';
var final_menu_value=[];
var final_sub_value=[];
//FUNCTION FOR CLOCK
function updateClock ( )
{
    var currentTime = new Date ( );
    $("#clock").html(currentTime);
}
//READY FUNCTION START
$(document).ready(function(){
    setInterval('updateClock()', 1000);
        var value_err_array=[];
        var Page_url;
    // INITIAL DATA LODING
    $.ajax({
        type: "POST",
        'url': "<?php echo base_url(); ?>" + "index.php/MENU_CONTROLLER/Initaildatas",
        data:{"Formname":'Menu',"ErrorList":'456'},
        success: function(data){
            value_err_array=JSON.parse(data);
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
        $(document).on("click",'.btnclass', function (){
            Page_url =$(this).attr('page');
            var attr_id=$(this).attr("id");
            if(attr_id==undefined){
                attr_id='';
            }
            show_msgbox("MENU CONFIRMATION","Do You Want to Open "+attr_id+" "+$(this).text()+" ?","success",true);
            return false;
        });
        $(document).on('click','.menuconfirm',function(){
            if(Page_url!='ERROR_PAGE_CONTROLLER'){
                $(".preloader").show();
                $('#menu_frame').load("<?php echo site_url(); ?>" + "/"+Page_url+"/index");
<!--                               window.location.href="--><?php //echo site_url(); ?><!--" + "/"+Page_url+"/index";-->
            }
            else
            {
                $(".preloader").show();
                $('#menu_frame').load("<?php echo site_url(); ?>" + "/"+Page_url+"/index");
            }
        });
        var all_menu_array=[];
        var checkintime;
        var checkouttime;
        var checkinerrormsg=[];
        $.ajax({
            type: "POST",
            'url': "/index.php/MENU_CONTROLLER/fetchdata",
            success: function(data){
                var value_array=JSON.parse(data);
                all_menu_array= value_array;
                checkinerrormsg=value_array[1];
                if(all_menu_array[0]!=''){
                    $('#menu_nav').show();
                    $('#RPT').show();
                    $('#AE').show();
                    ACRMENU_getallmenu_result(all_menu_array)
                }
                else{
                    var error_msg= "NO ACCESS AVAILABLE FOR LOGIN ID : "
//                    error_msg=(error_msg).toString().replace('[LOGIN ID]',all_menu_array[5]);
                    error_msg=(error_msg +all_menu_array[1]);
                    $('#ACRMENU_lbl_errormsg').text(error_msg);
                    $('#ACRMENU_lbl_errormsg').show();
                    $(".preloader").hide();
                    $('#menu_nav').hide();
                    $('#RPT').hide();
                    $('#AE').hide();
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        function ACRMENU_getallmenu_result(all_menu_array)
        {
            var ACRMENU_mainmenu=all_menu_array[0];//['ACCESS RIGHTS','DAILY REPORTS','PROJECT','REPORT']//main menu
            var ARCMENU_first_submenu=all_menu_array[1];
            //[['ACCESS RIGHTS-SEARCH/UPDATE','TERMINATE-SEARCH/UPDATE','USER SEARCH DETAILS'],['ADMIN ','USER '],['PROJECT ENTRY','PROJECT SEARCH/UPDATE'],['ATTENDANCE','REVENUE']]//submenu
            var ARCMENU_second_submenu=[];
            ARCMENU_second_submenu=all_menu_array[2]//[[], [], [], ['REPORT ENTRY', 'SEARCH/UPDATE/DELETE','WEEKLY REPORT ENTRY','WEEKLY SEARCH/UPDATE'], ['REPORT ENTRY', 'SEARCH/UPDATE'],[],[],[],[]];
            var count=0;
            var mainmenuItem="";
            var submenuItem="";
            var filelist=all_menu_array[4];
            var sub_submenuItem="";
            var script_flag=all_menu_array[3];
//        var dashbord='<ul class="nav navbar-nav  "><li ><a href="MENU.php">DASH BOARD</a></li></ul>';
//        $("#menu").append(dashbord);
//        $(".preloader").hide();
            for(var i=0;i<ACRMENU_mainmenu.length;i++)//add main menu
            {
                var main='mainmenu'+i
                var submen='submenu'+i;
                var filename=filelist[count]+'.php';
                if(ARCMENU_first_submenu[i].length==0)

                {
                    mainmenuItem='<li><a class="btnclass" page="'+filename+'" href="#"  id="'+ACRMENU_mainmenu[i]+'" >'+ACRMENU_mainmenu[i]+'</a></li>'
                }
                else
                {
                    mainmenuItem='<li class="dropdown"><a tabindex="0" href="#" data-toggle="dropdown">'+ACRMENU_mainmenu[i]+'<b class="caret"></b></a><ul class="dropdown-menu fa-ul '+submen+'">'
                }
                $("#ACRMENU_ulclass_mainmenu").append(mainmenuItem);
                for(var j=0;j<ARCMENU_first_submenu.length;j++)
                {
                    if(i==j)
                    {
                        for(var k=0;k<ARCMENU_first_submenu[j].length;k++)//add submenu1
                        {
                            var sub_submenu='sub_submenu'+j+k;
                            if(ARCMENU_second_submenu[count].length==0)
                            {
                                if(script_flag[count]!='X'){
                                    var file_name=filelist[count];
                                }
                                else{
                                    var file_name='ERROR_PAGE_CONTROLLER';
                                }
                                submenuItem='<li class=""><a class="btnclass" page="'+file_name+'" href="#"   id="'+ACRMENU_mainmenu[i]+'" >'+ARCMENU_first_submenu[j][k]+'</a></li></ul>'
                            }
                            else
                            {
                                submenuItem='<li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'+ARCMENU_first_submenu[j][k]+'</a><ul class="dropdown-menu '+sub_submenu+'" role="menu">'
                            }
                            $("."+submen).append(submenuItem);
                            for(var m=0;m<ARCMENU_second_submenu[count].length;m++)//add submenu2
                            {
                                if(script_flag[count][m]!='X'){
                                    var file_name=filelist[count][m];
                                }
                                else{
                                    var file_name='ERROR_PAGE_CONTROLLER';
                                }

                                sub_submenuItem='<li class=""><a class="btnclass" page="'+file_name+'" href="#"   id="'+ARCMENU_first_submenu[j][k]+'" >'+ARCMENU_second_submenu[count][m]+'</a></li>'
                                $("."+sub_submenu).append(sub_submenuItem);
                            }
                            count++;
                            $("#ACRMENU_ulclass_mainmenu").append('</ul></li>');
                        }
                    }
                }
                $("#ACRMENU_ulclass_mainmenu").append('</li>');
            }
        }
    });
</script>
<title>EXPATS INTEGRATED CRM DEV</title>
<meta charset="utf-8">
</head>
<body >
<div style="background-color: #EEF8Fb;height:20%">
    <table><tr><td><img src="images/customLogo.gif"/></td>
<!--            <td><h1><b>EXPATS INTEGRATED CRM - DEV</b></h1></td>-->
</tr></table>
</div>
<div>
    <table>
        <tr>
            <td style="width:1000px";><b><h4><span id="clock" ></span></h4></b></td>
        </tr>
    </table>
</div>
<iframe src="https://www.google.com/calendar/embed?showTitle=0;src=ssomens.com_sf0vt1s2tultotlshpcsiob75o@group.calendar.google.com&ctz=Asia/Calcutta" style="border: 0" width="1350" height="680" frameborder="0" scrolling="no"></iframe>
<div class="wrapper">
<!--    <div  id="confrmmaskpanel" class="preloader MaskPanel" hidden></div>-->
<!--    <div  id="mainmaskpanel" class="preloader MaskPanel" hidden><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif"  /></div></div></div>-->
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <nav class="navbar navbar-default" id="menu_nav">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="menu" >
                <ul class="nav navbar-nav" id="ACRMENU_ulclass_mainmenu">
                </ul>
            </div>
        </nav>
        <br><label id="ACRMENU_lbl_errormsg" class="errormsg" hidden ></label>
        <div id="menu_frame" name="iframe_a" ></div>
    <div style="height:100%" id="spacewidth"></div>
    <div></div>
    </div>
</div>
</body>
