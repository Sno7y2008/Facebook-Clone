<?php


include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}

if (isset($_POST['id'])) {
    DB::query('UPDATE users SET role=:role WHERE id=:id', array(':id' => htmlspecialchars($_POST['id']), ':role' => "member"));
}


?>