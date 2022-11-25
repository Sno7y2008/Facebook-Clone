<?php

include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}

if (isset($_POST['id'])) {
//    $name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => htmlspecialchars($_POST['id'])))[0]['name'];
   DB::query('DELETE FROM users WHERE id=:id', array(':id' => htmlspecialchars($_POST['id'])));
//    DB::query('DELETE FROM posts WHERE post_maker=:id', array(':id' => htmlspecialchars($_POST['id'])));
//    DB::query('DELETE FROM comments WHERE maker=:id', array(':id' => $name));
//    DB::query('DELETE FROM messages WHERE income_id=:id OR outcome_id=:id', array(':id' => htmlspecialchars($_POST['id'])));
   DB::query('DELETE FROM followers WHERE current=:id OR follower=:id', array(':id' => htmlspecialchars($_POST['id'])));
//    DB::query('DELETE FROM admin_chat WHERE sender=:id', array(':id' => htmlspecialchars($_POST['id'])));
//    DB::query('DELETE FROM likes WHERE user_id=:id', array(':id' => htmlspecialchars($_POST['id'])));
} 


?>