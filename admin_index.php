<?php

session_start();

require("conf.php");
if (!isset($_SESSION['tuvastamine'])) {

    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/ab_login.php';</script>";
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();

    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/ab_login.php';</script>";
    exit();
}

require("functions.php");

$search_term = "";

if(isset($_REQUEST["kaubagrupi_lisamine"])&&!empty($_REQUEST["kaubagrupp"])) {
    addProductGroup($_REQUEST["kaubagrupp"]);

    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/admin_index.php';</script>";

    exit();
}


if(isset($_REQUEST["delete"])) {
    deleteProductType($_REQUEST["delete"]);
}

$group = product_typeData();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Kaubad ja Kaubagrupid</title>
</head>
<body>
<header class="header">
    <p>Admin on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
    <div class="container">
        <h1>Tabelid | Kaubad ja Kaubagrupid</h1>
    </div>
</header>
<?php
include('../../navigation.php');
?>
<main class="main">
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Kaubagrupp</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($group as $product_type): ?>
                <tr>
                    <td><strong><?=$product_type->id ?></strong></td>
                    <td><?=$product_type->kaubagrupp ?></td>
                    <td>
                        <a title="Kustuta kaup" class="deleteBtn" href="admin_index.php?delete=<?=$product_type->id?>"
                           onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="admin_index.php">
            <h2>Kaubagrupi lisamine:</h2>
            <dl>
                <dd><input type="text" name="kaubagrupp" placeholder="Sisesta kaubagrupi..."></dd>
                <input type="submit" name="kaubagrupi_lisamine" value="Lisa">
            </dl>
        </form>
    </div>
</main>
<h3><a href="https://github.com/longuro/kaubad" target="_blank">GitHub</a></h3>
<?php
include('../../footer.php');
?>
</body>
</html>