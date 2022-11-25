<?php

include "../classes/Login.php";
include "../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}

$userID = Login::isLoggedIn();
$users = DB::query('SELECT * FROM users ORDER BY id DESC');
$follow_btn = "<button type='submit' class='ui' name='follow'>Follow</button>";
$t4 = "Users";

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

if (isset($_GET['serc'])) {
    $search_text = htmlspecialchars($_GET['search']);
    $users = DB::query('SELECT * FROM users WHERE name LIKE :name ORDER BY id DESC', array(':name' => '%' . $search_text . '%'));
}


if (isset($_GET['follow'])) {
    if (isset($_GET['follow_id'])) {
        if ($_GET['follow_id'] == $userID) {
            $t4 = "You Can't Follow Your Self";
        } else {
            if (!DB::query('SELECT * FROM followers WHERE current = :userid AND follower = :follower', array(':userid' => $userID, ':follower' => htmlentities($_GET['follow_id'])))) {
                DB::query('INSERT INTO followers VALUES (\'\', :userid, :follower)', array(':userid' => $userID, ':follower' => htmlentities($_GET['follow_id'])));
            }
        }
    }
}


if (isset($_GET['unfollow'])) {
    if (isset($_GET['follow_id'])) {
        DB::query('DELETE FROM followers WHERE current = :userid AND follower = :follower', array(':userid' => $userID, ':follower' => htmlentities($_GET['follow_id'])));
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
    <link rel="stylesheet" href="../css/users.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <title>Users</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    <div class="back"><a href="../main.php">Back</a></div>
    <div class="main">
        <div class="users1">
            <h1>~~ <?php echo $t4; ?> ~~</h1>
            <div class="dserch">
                <form action="users.php" method="get">
                    <input type="text" name="search" id="input" placeholder="Search...">
                    <button type="submit" name="serc" id="btn-d">Search</button>
                </form>
            </div>
            <?php foreach ($users as $user) : if ($user['id'] == $userID) {
                    continue;
                } ?>
                <div class="each">
                    <div class="profile-img"><img class="img-p" src="<?php

                                                                        if ($user['images'] == "") {
                                                                            echo "../assets/user.png";
                                                                        } else {
                                                                            echo "../uploads/" . $user['images'];
                                                                        }
                                                                        ?>" alt=""></div>
                    <div class="texts">
                        <div class="name"><?php echo $user['name']; ?></div>
                        <div class="btns">
                            <form action="users.php" method="get">
                                <input type="hidden" name="follow_id" value="<?php echo $user['id']; ?>">
                                <?php

                                if (!DB::query('SELECT follower FROM followers WHERE follower = :follower', array(':follower' => $user['id'])) == []) {
                                    $follower_id = DB::query('SELECT follower FROM followers WHERE follower = :follower', array(':follower' => $user['id']))[0]['follower'];

                                    if (DB::query('SELECT * FROM followers WHERE current = :userid AND follower = :follower', array(':userid' => $userID, ':follower' => $follower_id))) {
                                        $follow_btn = "<button type='submit' class='ui' name='unfollow'>Unfollow</button>";
                                        echo $follow_btn;
                                    } else {
                                        $follow_btn = "<button type='submit' class='ui' name='follow'>Follow</button>";
                                        echo $follow_btn;
                                    }
                                } else {
                                    $follow_btn = "<button type='submit' class='ui' name='follow'>Follow</button>";
                                    echo $follow_btn;
                                }
                                ?>
                            </form>
                            <form action="profile.php" method="get">
                                <input type="hidden" name="profile_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="ui" name="follow">Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="up"><a href="#top">Top</a></div>
    <?php include '../components/footer.php'; ?>
    <script src="../js/main.js"></script>
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