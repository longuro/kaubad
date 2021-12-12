<?php

session_start();

require("conf.php");
global $connection;
if (!empty($_POST['login']) && !empty($_POST['pass']) && (strlen($_POST['pass']))>2){
    $login=htmlspecialchars(trim($_POST['login']));
    $pass=htmlspecialchars(trim($_POST['pass']));
    $sool='tavalinetext';
    $krypt=crypt($pass, $sool);
    $paring="SELECT nimi, parool FROM kasutajad WHERE nimi='$login' AND parool='$krypt'";
    $yhendus=mysqli_query($connection, $paring);
        if(mysqli_num_rows($yhendus)==1){
            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM kasutajad WHERE nimi='$login' AND parool='$krypt' AND tyyp=1"))==1){
                $_SESSION['tuvastamine']='Tere admin';
                echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/admin_index.php';</script>";
                exit();
            } else {
                $_SESSION['tuvastamine']='Tere kasutaja';

                echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/index.php';</script>";
                exit();
            }
        } else {
            echo '<p style="color:red; font-family: Arial, sans-serif; text-align: center;">Kasutaja ja parool on valed</p>';
        }
} elseif (strlen($_POST['pass'])<3 && $_POST['login']) {
        echo '<p style="color:red; font-family: Arial, sans-serif; text-align: center;">Parool peab olema 3 ja rohkem sümboleid</p>';
    }
?>
<link rel="stylesheet" href="login_style.css">
<title>Login vorm</title>
<table class="login">
    <form action="" method="post">
        <tr>
            <td colspan="2" class="login-header">Login vorm</td>
        </tr>
        <tr>
            <td>Kasutaja nimi:</td>
            <td><input type="text" name="login" placeholders="Login"></td>
        </tr>
        <tr>
            <td>Salasõna:</td>
            <td><input type="password" name="pass" placeholders="Salasõna"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Logi sisse"></td>
        </tr>
    </form>
</table>