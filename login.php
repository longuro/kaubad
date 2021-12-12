<?php

session_start();
if (!empty($_POST['login']) && !empty($_POST['pass'])){
    $login=$_POST['login'];
    $pass=$_POST['pass'];
    if($login=='admin' && $pass=='admin'){
        $_SESSION['tuvastamine']='tere';

        echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/index.php';</script>";
    }
}
?>
<h1>Login vorm</h1>
<table>
    <form action="" method="post">
        <tr>
            <td>Kasutaja nimi:</td>
            <td><input type="text" name="login" placeholders="Login"></td>
        </tr>
        <tr>
            <td>Salasõna:</td>
            <td><input type="text" name="pass" placeholders="Salasõna"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Logi sisse"></td>
        </tr>
    </form>
</table>