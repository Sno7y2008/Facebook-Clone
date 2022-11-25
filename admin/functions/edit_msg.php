<?php

include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}

if (isset($_POST['id']) && isset($_POST['msg'])) {
   DB::query('UPDATE messages SET msg=:desc WHERE id=:id', array(':id' => htmlspecialchars($_POST['id']), ':desc' => htmlspecialchars($_POST['msg'])));
}


?>