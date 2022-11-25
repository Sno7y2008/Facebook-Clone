<?php
include('../classes/DB.php');
include('../classes/Login.php');

if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}

$userID = Login::isLoggedIn();

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

if (isset($_POST['confirm'])) {

    if (isset($_POST['alldevices'])) {

        DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid' => Login::isLoggedIn()));
        header('Location: ../index.php');
    } else {
        if (isset($_COOKIE['SNID'])) {
            DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])));
            header('Location: ../index.php');
        }
        setcookie('SNID', '1', time() - 3600);
        setcookie('SNID_', '1', time() - 3600);
    }
} else if (isset($_POST['back'])) {
    header('Location: ../main.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.png" sizes="16x16">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/logout.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <title>Logout</title>
</head>

<body>
    <h1 class="sssssssssssssssss">Logout of your Account?</h1>
    <p>Are you sure you'd like to logout?</p>
    <form action="logout.php" method="post">
        <input type="checkbox" name="alldevices" id="tt" value="alldevices"> <span>Logout of all devices?</span><br />
        <input type="submit" name="confirm" id="dd" value="Confirm">
        <input type="submit" name="back" id="dd" value="Back">
    </form>
    <script>
        setInterval(() => {
            $.ajax({
                url: '../controllers/bansetter.php',
                success: function(data) {

                }
            })
        }, 60000)
    </script>
</body>

</html>