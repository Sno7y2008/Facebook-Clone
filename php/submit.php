<?php 

    include '../classes/DB.php';


    if (isset($_POST['content']) && isset($_POST['name'])) {
        // DB::query('INSERT INTO `reports` VALUES (\'\', :con, :name)', array(':con' => htmlspecialchars($_POST['content']), ':name' => htmlspecialchars($_POST['name'])));
        if (DB::query('SELECT * FROM users WHERE name=:n', array(':n' => htmlspecialchars($_POST['name'])))) {
            DB::query('INSERT INTO `reports` VALUES (\'\', :con, :name)', array(':con' => htmlspecialchars($_POST['content']), ':name' => htmlspecialchars($_POST['name'])));
            echo "Succeed Wait For Help...";
        } else {
            echo "Please Enter Name Correctly...";
        }
    }


?>