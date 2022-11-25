<?php

session_start();

include "classes/DB.php";

$msg = "Hello There, Sign In And Communicate With Other, Happy Day.";

if (isset($_POST['submit'])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (DB::query('SELECT name FROM users WHERE name=:username', array(':username' => $username))) {
        if (password_verify($password, DB::query('SELECT password FROM users WHERE name=:username', array(':username' => $username))[0]['password'])) {
            $user_id = DB::query('SELECT id FROM users WHERE name=:username', array(':username' => $username))[0]['id'];
            if (!DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $user_id))) {
                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));

                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                header("Location: /main.php");
            } else {
                $msg = "You are Baned From The Network";
            }
        } else {
            $msg = "Incorrect Password";
        }
    } else {
        $msg = 'User not registered!';
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/icon.png" sizes="16x16">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Sign In</title>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="/assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy">
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>
    <div class="titles">
        <h2 class="page-title">Sign In</h2>
        <span class="page-desc"><?php echo $msg; ?></span>
    </div>
    <div class="main">
        <div class="inputs">
            <form action="/index.php" method="post" class="sign-in">
                <p class="after">username</p>
                <input type="text" required name="username" id="username">
                <p class="after">Password</p>
                <input type="password" required name="password" id="password">
                <a href="/pages/make-acconet.php" class="make">Don't Have Acconet Make One -></a>
                <a href="/report.php" class="make">Make Report -></a>
                <button type="submit" name="submit" id="btn-s">Sign In</button>
            </form>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="/js/main.js"></script>
</body>

</html>
