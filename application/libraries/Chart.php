<html>
<head>
    <script type="text/javascript">
        // function for graphics chart
        function drawChart(twoarr,CHART_errormsg,CHART_linebar) {
            $("html, body").animate({ scrollTop: $(document).height()}, "slow");
            var data = google.visualization.arrayToDataTable(twoarr);
            var options = {
                'title': CHART_errormsg,'width':'100%','height':'100%'
            };
            if((CHART_linebar==10)||(CHART_linebar==22)||(CHART_linebar==27)||(CHART_linebar==18)||(CHART_linebar==16)){
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            }
            else{
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            }
            chart.draw(data, options);
        }
        google.load('visualization', '1.0', {packages:['corechart']});
        google.setOnLoadCallback(drawChart);
        // function for data table chart
        function drawTable(twodim,arr1,arr2){
            var data = new google.visualization.DataTable();
            for(var i=0;i<twodim[0].length;i++){
                data.addColumn(arr1[i],arr2[i]);
            }
            data.addRows(twodim);
            var table = new google.visualization.Table(document.getElementById('chart_tablediv'));
            table.draw(data, {showRowNumber: true});
        }
        google.load('visualization', '1.0', {packages:['table']});
        google.setOnLoadCallback(drawTable);
    </script>
</head>
</html>