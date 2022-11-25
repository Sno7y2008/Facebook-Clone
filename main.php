<?php
include "classes/Login.php";
include "classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: index.php');
}

$userID = Login::isLoggedIn();

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

session_start();


$img = DB::query('SELECT images FROM users WHERE id=:id', array(':id' => $userID))[0]['images'];
$name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $userID))[0]['name'];
$users = DB::query('SELECT * FROM users ORDER BY id DESC');
$default_imgs = ["default.jpg", "default1.jpg"];
$err = "Optional, Put Post Image";
$class = "";
$count_arr = 0;

if (isset($_GET['submit'])) {
    $search = htmlentities($_GET['search']);

    if (!$search == "") {
        $users = DB::query("SELECT * FROM users WHERE name LIKE :name ORDER BY id DESC", array(':name' => "%" . $search . "%"));
    }
}

// function random_img($arr)
// {
//     return $arr[rand(0, 1)];
// }

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
                    $img_upload_path = 'upload-post/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    DB::query('INSERT INTO posts VALUES (\'\', :desc, :img, :maker, \'\', :import)', array(':desc' => $post_desc, ':img' => $new_img_name, ':maker' => $userID, ':import' => "No"));
                } else {
                    $err = "Please Upload File With Extension ( png , jpg, jpeg )";
                }
            }
        } else {
            $err = "Someting Happend Please Try Agin...";
        }
    } else {
        DB::query('INSERT INTO posts VALUES (\'\', :desc, :img, :maker, \'\', :import)', array(':desc' => $post_desc, ':img' => $default_imgs[rand(0,1)], ':maker' =>$userID, ':import' => "No"));
    }
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.png" sizes="16x16">
    <script src="https://kit.fontawesome.com/a2e5a25eb0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Pexple</title>
</head>

<body>
    <?php include 'components/main_l.php'; ?>
    <div class="main">
        <div class="sidebar">
            <div class="profile">
                <div class="conut"><img class="imgs" src="uploads/<?php echo $img; ?>" alt=""></div>
                <div class="text">
                    <span class="name"><?php echo $name; ?></span>
                    <span class="atname">@<?php echo $name; ?></span>
                </div>
            </div>
            <div class="main-side">
                <div class="links">
                    <a href="main.php"><i class="fa-solid fa-house"></i>Home</a>
                    <a href="pages/users.php"><i class="fa-solid fa-users"></i>Peoples</a>
                    <a href="pages/profile.php?profile_id=<?php echo $userID; ?>"><i class="fa-solid fa-user"></i>Profile</a>
                    <a href="pages/messages.php"><i class="fa-solid fa-message"></i>Messages</a>
                    <a href="pages/settings.php" class="last"><i class="fa-solid fa-gear"></i>Settings</a>
                </div>
            </div>
        </div>
        <div class="posts">
            <h2>Create Post</h2>
            <div class="make1">
                <form action="main.php" method="post" enctype="multipart/form-data">
                    <span class="sam"><?php echo $err; ?></span>
                    <input type="file" name="my_image" id="fell">
                    <span class="sam">Required</span>
                    <textarea name="post-desc" required id="post-desc" cols="30" rows="10" placeholder="Post Description"></textarea>
                    <button type="submit" name="post-post">Post</button>
                </form>
            </div>
            <div class="veiw"></div>
        </div>
        <div class="users">
            <div class="search">
                <form action="main.php" method="get">
                    <input type="text" name="search" id="search" placeholder="Search...">
                    <button type="submit" id='cootn' name="submit">Search</button>
                </form>
            </div>
            <div class="users-main">
                <h3>Users</h3>
                <?php foreach ($users as $user) : ?>
                    <?php if ($count_arr == 4) {
                        break;
                    } else {
                        $count_arr++;
                    ?>
                        <div class="profile rrt">
                            <div class="conut"><img class="imgs" src="<?php

                                                                        if ($user['images'] == "") {
                                                                            echo "assets/user.png";
                                                                        } else {
                                                                            echo "uploads/" . $user['images'];
                                                                        }

                                                                        ?>" alt=""></div>
                            <div class="text">
                                <span class="name"><?php echo $user['name']; ?></span>
                                <form action="pages/profile.php" method="get">
                                    <input type="hidden" name="profile_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="get-users" class="atname1">Veiw</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="up"><a href="#top">Top</a></div>
    </div>
    <?php include './components/footer.php'; ?>
    <script src="js/main.js"></script>
</body>

</html>