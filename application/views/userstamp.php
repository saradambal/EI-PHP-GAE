<?php
session_start();

if(isset($_SESSION['login_user'])){
    $UserStamp='sasikala.djeasankar@ssomens.com';
}
?>
<h3><?php echo $UserStamp ?></h3>