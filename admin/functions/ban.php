<?php

include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}

if (isset($_POST['id']) && isset($_POST['time']) && isset($_POST['res'])) {
     if (!DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => htmlspecialchars($_POST['id'])))) {
        $id = Login::isLoggedIn();
        DB::query('INSERT INTO bans VALUES (\'\', :id, :bander, :time, :by, :res)', array(':id' => htmlspecialchars($_POST['id']), ':bander' => 'baned', ':time' => htmlspecialchars($_POST['time']), ':res' => htmlspecialchars($_POST['res']), ':by' => $id));
    }

}

?>