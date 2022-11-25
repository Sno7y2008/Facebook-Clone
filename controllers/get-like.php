<?php

include '../classes/DB.php';

// if (isset($_GET['id'])) {
$r = DB::query('SELECT * FROM posts WHERE id = :id', array(":id" => htmlspecialchars($_POST['id'])))[0]['post_like'];
echo $r;

// }

?>
