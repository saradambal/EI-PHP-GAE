<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    $(document).ready(function() {
//                   $.ajax({
//            type: "POST",
//            data:$('#sample').serialize(),
//            url: 'http://localhost/CILocal/index.php/Ctrl_CSV/CSV_Initaildatas',
//            success: function(data){
//                alert(data);
//                var value_array=JSON.parse(data);
//            },
//            error: function(data){
//                alert('error in getting'+JSON.stringify(data));
//            }
//        });
//        });
        $.ajax({
            type: "POST",
            url: 'http://localhost/CILocal/index.php/Ctrl_CSV/CSV_Initaildatas',
            success: function(data){
                alert(data);
                var value_array=JSON.parse(data);
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
    });
    </script>

    <body>
    <form method="post" id="sample" name="sample">

    </form>
        </body>

