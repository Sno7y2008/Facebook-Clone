<?php

include '../classes/DB.php';

$times = DB::query("SELECT ban_time FROM bans");

if (!empty($times)) {
    foreach ($times  as $time) {
        if ($time['ban_time'] > 0) {
            DB::query('UPDATE bans SET ban_time=:time', array(':time' => $time['ban_time'] - 1));
        } else {
            DB::query('DELETE FROM bans WHERE ban_time = 0');
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icon.png" sizes="16x16">
    <script src="https://kit.fontawesome.com/a2e5a25eb0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/messages.css">
    <link rel="stylesheet" href="../css/not_found.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>404</title>
</head>

<body>
    <div class="navigation">
        <div class="logo">
            <img src="../assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy sec">
            <a href="../pages/messages.php">Messages</a>
            <a href="../pages/logout.php">logout</a>
            <a href="../main.php">Back</a>
            ~
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>
    <div class="center">
        <h1>404</h1>
        <h3>Not Found</h3>
        <p>The Page You Are Looking For Not Found Please Return Back To Main Page !!!</p>
        <button type="button" id="main">Back</button>
    </div>
    <script>
        $("#main").click(function() {
            window.location.href = "../main.php";
        })
    </script>
</body>

</html>