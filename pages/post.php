<?php

include "../classes/Login.php";
include "../classes/DB.php";

if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}

$userID = Login::isLoggedIn();
$name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $userID))[0]['name'];
if (isset($_GET['post_id'])) {
    $posts = DB::query('SELECT * FROM posts WHERE id=:postid', array(':postid' => htmlspecialchars($_GET['post_id'])));
} else {
    header('Location: ../main.php');
}
$class = "";

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}


if ($posts[0]['post_important'] === "Yes") {
    $cl = "none";
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
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/post.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Posts</title>
</head>

<body>
    <div class="overlay lasokd">
        <i class="fa-solid fa-x" id="close"></i>
        <img src="" alt="404" class="big" id="nbig">
    </div>
    <div class="back"><a href="../main.php">Back</a></div>
    <div class="back yyyy <?php echo $cl; ?>"><a href="profile.php?profile_id=<?php echo $posts[0]['post_maker'] ?>">Back To Profile</a></div>
    <div class="center">
        <div class="container tt">
            <div class="inner ww ioio">
                <div class="image m"><img src="<?php

                                                if ($posts[0]['post_image'] == "default1.jpg" || $posts[0]['post_image'] == "default.jpg") {
                                                    $class = "default-Img-post";
                                                    echo "../assets/" . $posts[0]['post_image'];
                                                } else if ($posts[0]['post_image'] == "admin_banner.jpg") {
                                                    $class = "default-Img-post";
                                                    echo "../assets/" . $posts[0]['post_image'];
                                                } else {
                                                    echo "../upload-post/" .  $posts[0]['post_image'];
                                                }

                                                ?>" class="post-img yt <?php echo $class; ?>" id="cilckkk" onclick="myFunction(this);" alt="404"></div>
                <div class="div">
                    <p><?php echo $posts[0]['post_desc']; ?></p>
                </div>
                <div class="desc p">

                    <span>

                        <?php

                        $name_post = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $posts[0]['post_maker']))[0]['name'];
                        if ($posts[0]['post_important'] === "Yes") {
                            echo "By Admin<img src='../assets/verified.png' alt='404' id='true'>";
                        } else {
                            if (DB::query('SELECT * FROM followers WHERE current=:userid AND follower=:foll', array(':userid' => $userID, ':foll' => $posts[0]['post_maker'])) || DB::query('SELECT * FROM followers WHERE current=:userid AND follower=:foll', array(':foll' => $userID, ':userid' => $posts[0]['post_maker']))) {
                                echo "By" . $name_post . " ~ " . "Your Friend";
                            } else if ($name_post == $name) {
                                echo "By " . "You";
                            } else {
                                echo "By " . $name_post;
                            }
                        }

                        ?>

                    </span>
                </div>
            </div>
            <div class="outter2 l">
                <form action="post.php" method="get">
                    <input type="hidden" id="oio" name="post_id" value='<?php echo $posts[0]['id']; ?>'>
                    <button type="button" class="like1" name="like-post">
                        <?php

                        if (!DB::query('SELECT * FROM likes WHERE user_id = :id AND post_id = :post', array(':id' => $userID, ':post' => $posts[0]['id']))) {
                            echo "<i class='fa-solid fa-thumbs-up k' title='like'></i>";
                        } else {
                            echo "<i class='fa-solid fa-thumbs-down ko' title='unlike'></i>";
                        }

                        ?>
                    </button>
                    <span id="conutLike"></span>
                </form>

            </div>
        </div>
        <div class="cool">
            <div class="show yy">
                <div class="head">Comments</div>
                <div id="comments"></div>
            </div>
            <form action="post.php" class="flex poy" id="ioioio" method="get">
                <input type="hidden" class="oio" name="post_id" value='<?php echo $posts[0]['id']; ?>'>
                <input type="text" required class="srea rr" placeholder="Your Comment...">
                <button type="button" name='sden' class="das">Send</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        let btn = document.querySelector('.das');
        let form1 = document.getElementById('ioioio');

        form1.onsubmit = function(e) {
            e.preventDefault();
        }

        btn.addEventListener('click', () => {
            let dataY = document.querySelector('.srea').value;
            let postID = document.querySelector('.oio').value;
            if (dataY !== "") {



                $.get("../controllers/insert-comment.php", {
                    dataY: dataY,
                    postID: postID
                }, function() {
                    setTimeout(() => {
                        let veiwer = document.querySelector("#comments");
                        veiwer.scrollTop = veiwer.scrollHeight;
                    }, 300)

                });
                document.querySelector('.srea').value = "";
            } else {
                document.querySelector('.srea').value = "Type Something....";
                setTimeout(() => {
                    document.querySelector('.srea').value = "";

                }, 1500)
            }


        });

        $(document).ready(function() {
            setInterval(function() {
                let postID = document.querySelector('.oio').value;
                $("#comments").load("../controllers/get-comment.php", {
                    id: postID
                });
            }, 1000)
            setTimeout(() => {
                let veiwer = document.querySelector("#comments");
                veiwer.scrollTop = veiwer.scrollHeight;
            }, 1300)
        });
    </script>
    <script type="text/javascript">
        $(".like1 i").click(function() {
            let count = 0;
            let postID = document.querySelector('.oio').value;
            $(".like1 i").attr("iconDir", "yes");

            $.get("../controllers/insert-like.php", {
                count: count,
                id: postID
            })

            $(".like1 i").toggleClass("invert");
            // $(".like1 i").toggleClass("colo");

        });

        $(document).ready(function() {
            setInterval(function() {
                let postID = document.querySelector('.oio').value;
                $("#conutLike").load("../controllers/get-like.php", {
                    id: postID
                });
            }, 1000)
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
    <script>
        // $("#cilckkk").click(function() {
        //     $(".overlay").css("display", "flex");

        // });
        $("#close").click(function() {
            $(".overlay").css("display", "none");
        });

        function myFunction(imgs) {
            var expandImg = document.getElementById("nbig");
            expandImg.src = imgs.src;
            $(".overlay").css("display", "flex");

        }
    </script>
</body>

</html>