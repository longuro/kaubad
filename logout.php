<?php
session_start();

if (!isset($_SESSION['tuvastamine'])) {
    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/ab_login.php';</script>";
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();

    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/ab_login.php';</script>";
    exit();
}
?>