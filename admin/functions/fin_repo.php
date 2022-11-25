<?php

include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}

if (isset($_POST['id'])) {
   DB::query('DELETE FROM `reports` WHERE id=:id', array(':id' => htmlspecialchars($_POST['id'])));
}

?>