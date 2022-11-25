<?php

include "../../classes/Login.php";
include "../../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../../index.php');
}


$userID = Login::isLoggedIn();
$role = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $userID))[0]['role'];

$err = "Choose Image Or Let It Admin Banner";

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: ../../index.php");
}

if ($role == "member") {
    header('Location: ../../main.php');
}

if (isset($_POST['post-post'])) {
    $post_desc = htmlentities($_POST['post-desc']);

    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    if ($img_name !== "" && $img_size !== "" && $tmp_name !== "") {
        if ($error === 0) {
            if ($img_size > 250000) {
                $err = "Sorry, your file is too large.";
            } else {

                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png", "mp4", "gif");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../../upload-post/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    DB::query('INSERT INTO posts VALUES (\'\', :desc, :img, :maker, \'\', :import)', array(':desc' => $post_desc, ':img' => $new_img_name, ':maker' => $userID, ":import" => "Yes"));
                    header("Location: ../Owner.php");
                } else {
                    $err = "Please Upload File With Extension ( png , jpg, jpeg )";
                }
            }
        } else {
            $err = "Someting Happend Please Try Agin...";
        }
    } else {
        DB::query('INSERT INTO posts VALUES (\'\', :desc, :img, :maker, \'\', :import)', array(':desc' => $post_desc, ':img' => "admin_banner.jpg", ':maker' => $userID, ":import" => "Yes"));
        header("Location: ../Owner.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/icon.png" sizes="16x16">
    <script src="https://kit.fontawesome.com/a2e5a25eb0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/profile.css">
    <link rel="stylesheet" href="../../css/settings.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Admin Post</title>
</head>

<body>
    <div class="navigation">
        <div class="logo">
            <img src="../../assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy sec">
            <a href="../../pages/logout.php">logout</a>
            <a href="../Owner.php">Back</a>
            <span class="ooooooo">~</span>
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>
    <div class="makering">
        <h2 class="do">Create Admin Post</h2>
        <div class="make1">
            <form action="admin_post.php" method="post" enctype="multipart/form-data">
                <span class="sam"><?php echo $err; ?></span>
                <input type="file" name="my_image" id="fell">
                <span class="sam">Required</span>
                <textarea name="post-desc" required id="post-desc" cols="30" rows="10" placeholder="Post Description"></textarea>
                <button type="submit" name="post-post">Post</button>
            </form>
        </div>
    </div>
    <script>
        setInterval(() => {
            $.ajax({
                url: '../../controllers/bansetter.php',
                success: function(data) {

                }
            })
        }, 60000)
    </script>
</body>

</html>