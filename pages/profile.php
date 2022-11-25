<?php

include '../classes/DB.php';
include '../classes/Login.php';

if (!Login::isLoggedIn()) {
    header('Location: index.php');
}

$userID = Login::isLoggedIn();
$name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $userID))[0]['name'];
$msgi = "";

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

if (isset($_GET['profile_id'])) {
    $profile_id = htmlspecialchars($_GET['profile_id']);
    $profile_detils = DB::query('SELECT * FROM users WHERE id = :id', array(':id' => $profile_id))[0];
} else if ($_GET['profile_id'] == "") {
    header("Location: ../main.php");
}

if (isset($_POST['mes'])) {
    $outcome = htmlentities($_POST['income_id']);

    header("Location: messages.php?income_id=$userID&outcome_id=$outcome");
} else if (isset($_POST['back'])) {
    header("Location: ../main.php");
}

$posts = DB::query('SELECT * FROM posts WHERE post_maker=:id ORDER BY id DESC', array(':id' => $profile_id));



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
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Profile</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    <div class="box">
        <div class="deit">
            <div class="logos">
                <img src="<?php

                            if ($profile_detils['images'] == "") {
                                echo "../assets/user.png";
                            } else {
                                echo "../uploads/" . $profile_detils['images'];
                            }

                            ?>" alt="" class="img-9"><span class="username">
                                Username: <span class="vi"><?php echo $profile_detils['name'] ?></span>
                                <br>
                                <span>Email: <span class="vi"><?php echo $profile_detils['email'] ?></span></span>
                                <br>
                                <span>Followers: <span class="vi"><?php echo count(DB::query('SELECT follower FROM followers WHERE follower=:for', array(':for' => $profile_id))); ?></span></span></span>
                <div class="h-buton">
                    <form action="profile.php" method="post">
                        <input type="hidden" name="income_id" id="income" value="<?php echo $profile_id; ?>">
                        <?php

                        if (!DB::query('SELECT * FROM followers WHERE current=:cid AND follower=:fid', array(':cid' => $userID, ':fid' => $profile_id))) {
                            if ($profile_id != $userID) {
                                echo '<button type="button" id="follow" class="pro">Follow</button>';
                                echo '<button type="submit" name="mes" class="pro">Message</button>';
                            } else {
                                echo "";
                            }
                        } else {
                            if ($profile_id != $userID) {
                                echo '<button type="button" id="unfollow" class="pro">Unfollow</button>';
                                echo '<button type="submit" name="mes" class="pro">Message</button>';
                            } else {
                                echo "";
                            }
                        }

                        ?>
                        <button type="submit" name="back" class="pro">Back</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="veiw">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $post) :  if ($post['post_important'] === "Yes") {
                        continue;
                    } ?>

                    <div class="container">
                        <div class="inner">
                            <div class="image"><img src="<?php

                                                                        if ($post['post_image'] == "default1.jpg" || $post['post_image'] == "default.jpg") {
                                                                            $class = "default-Img";
                                                                            echo "../assets/" . $post['post_image'];
                                                                        } else {
                                                                            $class = "";
                                                                            echo "../upload-post/" . $post['post_image'];
                                                                        }

                                                                        ?>" class="post-img <?php echo $class; ?>" alt=""></div>
                            <div class="title">
                            </div>
                            <div class="desc">
                                <p><?php

                                    $text = $post['post_desc'];

                                    if (strlen($text) > 30) {
                                        echo substr($text, strlen($text) - 30,) . ".............";
                                    } else {
                                        echo $text;
                                    }

                                    ?></p>
                                <span>
                                    <?php

                                    $name_post = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $post['post_maker']))[0]['name'];

                                    if (DB::query('SELECT * FROM followers WHERE current=:userid AND follower=:foll', array(':userid' => $userID, ':foll' => $post['post_maker']))) {
                                        echo "By" . $name_post . " ~ " . "Your Friend";
                                    } else if ($name_post == $name) {
                                        echo "By " . "You";
                                    } else {
                                        echo "By " . $name_post;
                                    }

                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="outter">
                            <form action="post.php" method="get">
                                <input type="hidden" id="oio" name="post_id" value='<?php echo $post['id']; ?>'>
                                <button type="submit" id="view-more" name="veiw_more">Veiw More</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : $msgi = "No Posts To Show"; ?>
                <div class="empty"><span class="noshoow"><?php echo $msgi ?></span></div>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript">
        $("#follow").click(function() {
            $.post('../controllers/set-follow.php', {
                profile_id: $("#income").val()
            })

            window.location.reload();
        })

        $("#unfollow").click(function() {
            $.post('../controllers/unset-follow.php', {
                profile_id: $("#income").val()
            })

            window.location.reload();
        })
    </script>
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