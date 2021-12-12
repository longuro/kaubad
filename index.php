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
$sort = "kaubanimi";
$search_term = "";

if(isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}

if(isset($_REQUEST["search_term"])) {
    $search_term = $_REQUEST["search_term"];
}

if(isset($_REQUEST["kaubagrupi_lisamine"])&&!empty($_REQUEST["kaubagrupp"])) {
    addProductGroup($_REQUEST["kaubagrupp"]);

    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/index.php';</script>";
    exit();
}

if(isset($_REQUEST["kauba_lisamine"])&&!empty($_REQUEST["kaubanimi"])&&!empty($_REQUEST["hind"])) {
    addProduct($_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
    echo "<script>self.location='https://ljah20.thkit.ee/php/content/kaubad/index.php';</script>";
    exit();
}

if(isset($_REQUEST["delete"])) {
    deleteProduct($_REQUEST["delete"]);
}

if(isset($_REQUEST["save"])) {
    saveProduct($_REQUEST["changed_id"], $_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
}
$product = countyData($sort, $search_term);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <title>Kaubad ja Kaubagrupid</title>
</head>
<body>
<header class="header">
    <p>Kasutaja on sisse logitud</p>
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
        <form action="index.php">
            <input type="text" name="search_term" placeholder="Otsi...">
        </form>
    </div>
    <?php if(isset($_REQUEST["edit"])): ?>
        <?php foreach($product as $goods): ?>
            <?php if($goods->id == intval($_REQUEST["edit"])): ?>
                <div class="container">
                    <form action="index.php">
                        <input type="hidden" name="changed_id" value="<?=$goods->id ?>"/>
                        <input type="text" name="kaubanimi" value="<?=$goods->kaubanimi?>">
                        <input type="number" name="hind" value="<?=$goods->hind?>">
                        <?php echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id"); ?>
                        <a title="Katkesta muutmine" class="cancelBtn" href="index.php" name="cancel">X</a>
                        <input type="submit" name="save" value="&#10004;">
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th><a href="index.php?sort=kaubanimi">Kaubanimi</a></th>
                <th><a href="index.php?sort=hind">Hind</a></th>
                <th><a href="index.php?sort=kaubagrupp">Kaubagrupp</a></th>>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($product as $goods): ?>
                <tr>
                    <td><strong><?=$goods->id ?></strong></td>
                    <td><?=$goods->kaubanimi ?></td>
                    <td><?=$goods->hind ?></td>
                    <td><?=$goods->kaubagrupp ?></td>
                    <td>
                        <a title="Kustuta kaup" class="deleteBtn" href="index.php?delete=<?=$goods->id?>"
                           onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                        <a title="Muuda kaupa" class="editBtn" href="index.php?edit=<?=$goods->id?>">&#9998;</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <form action="index.php">
            <h2>Kauba lisamine:</h2>
            <dl>
                <dt>Kaubanimi:</dt>
                <dd><input type="text" name="kaubanimi" placeholder="Sisesta kaubanimi..."></dd>
                <dt>Hind:</dt>
                <dd><input type="number" name="hind" placeholder="Sisesta hinda..."></dd>
                <dt>Kaubagrupp</dt>
                <dd><?php
                    echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid ORDER BY id", "kaubagrupp_id");
                    ?></dd>
                <input type="submit" name="kauba_lisamine" value="Lisa pood">
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