<?php

require('conf.php');

function countyData($sort_by = "kaubanimi", $search_term = "") {

    global $connection;

    $sort_list = array("kaubanimi", "hind", "kaubagrupp");

    if(!in_array($sort_by, $sort_list)) {

        return "Seda tulpa ei saa sorteerida";

    }

    $request = $connection->prepare("SELECT kaubad.id, kaubanimi, hind, kaubagrupid.kaubagrupp

    FROM kaubad, kaubagrupid 

    WHERE kaubad.kaubagrupp_id = kaubagrupid.id 

    AND (kaubanimi LIKE '%$search_term%' OR hind LIKE '%$search_term%' OR kaubagrupp LIKE '%$search_term%')

    ORDER BY $sort_by");

    $request->bind_result($id, $product_name, $price, $productGroup_name);

    $request->execute();

    $data = array();

    while($request->fetch()) {

        $product = new stdClass();

        $product->id = $id;

        $product->kaubanimi = htmlspecialchars($product_name);

        $product->hind = htmlspecialchars($price);

        $product->kaubagrupp = $productGroup_name;

        array_push($data, $product);

    }

    return $data;

}

function product_typeData() {

    global $connection;

    $request = $connection->prepare("SELECT id, kaubagrupp

    FROM kaubagrupid WHERE id>1 ORDER BY id;");

    $request->bind_result($id, $productGroup_name);

    $request->execute();

    $data = array();

    while($request->fetch()) {

        $group = new stdClass();

        $group->id = $id;
        
        $group->kaubagrupp = $productGroup_name;

        array_push($data, $group);

    }

    return $data;

}

function createSelect($query, $name) {

    global $connection;

    $query = $connection->prepare($query);

    $query->bind_result($id, $data);

    $query->execute();

    $result = "<select name='$name'>";

    while($query->fetch()) {

        $result .= "<option value='$id'>$data</option>";

    }

    $result .= "</select>";

    return $result;

}

function addProductGroup($productGroup_name) {

    global $connection;

    $query = $connection->prepare("INSERT INTO kaubagrupid (kaubagrupp)

    VALUES (?)");

    $query->bind_param("s", $productGroup_name);

    $query->execute();

}

function addProduct($product_name, $price, $productGroup_id) {

    global $connection;

    $query = $connection->prepare("INSERT INTO kaubad (kaubanimi, hind, kaubagrupp_id)

    VALUES (?, ?, ?)");

    $query->bind_param("sdi", $product_name, $price, $productGroup_id);

    $query->execute();

}

function deleteProduct($product_id) {

    global $connection;

    $query = $connection->prepare("DELETE FROM kaubad WHERE id=?");

    $query->bind_param("i", $product_id);

    $query->execute();

}

function deleteProductType($product_type_id) {

    global $connection;

    $query = $connection->prepare("DELETE FROM kaubagrupid WHERE id=?");

    $query->bind_param("i", $product_type_id);

    $query->execute();

}

function saveProduct($product_id, $product_name, $price, $productGroup_id) {

    global $connection;

    $query = $connection->prepare("UPDATE kaubad

    SET kaubanimi=?, hind=?, kaubagrupp_id=?

    WHERE kaubad.id=?");

    $query->bind_param("sdii", $product_name, $price, $productGroup_id, $product_id);

    $query->execute();

}

?>