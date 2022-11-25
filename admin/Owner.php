<?php

include "../classes/Login.php";
include "../classes/DB.php";

if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}


$userID = Login::isLoggedIn();
$role = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $userID))[0]['role'];

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: ../index.php");
}


if ($role != "Owner") {
    header('Location: admin.php');
}

$users = DB::query('SELECT * FROM users ORDER BY id DESC');
$posts = DB::query('SELECT * FROM posts ORDER BY id DESC');
$comments = DB::query('SELECT * FROM comments ORDER BY id DESC');
$messages = DB::query('SELECT * FROM messages ORDER BY id DESC');
$followers = DB::query('SELECT * FROM followers ORDER BY id DESC');
$reports = DB::query('SELECT * FROM reports ORDER BY id DESC');

header('Access-Control-Allow-Origin: *');

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
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Owner</title>
</head>

<body>
    <div class="navigation">
        <!-- <div class="logo">
            <img src="../assets/logo.png" alt="404" class="small">
        </div> -->
        <div class="copy sec">

            <a href="private/admin_post.php">Admin Post</a>
            <a href="../pages/logout.php">logout</a>
            <a href="../main.php">Back</a>
            <!-- ~ -->
            <!-- <h3 class="right">Copyright © 2022</h3> -->
        </div>
    </div>
    <div class="overlay">
        <div class="container213">
            <i class="fa-solid fa-x" id="close"></i>
            <span>~~ Ban Rules ~~</span>
            <form action="owner.php" method="post" id="cococococo">
                <h3>Time Must Be Less Than 15 Min And More Than 5 Min</h3>
                <input type="text" id="ban_res" placeholder="Ban Reason...">
                <input type="number" id="ban_time" placeholder="Ban Time...">
                <button type="button" id="goTime">Ban</button>
            </form>
        </div>
    </div>
    <div class="overlay5">
        <div class="container2">
            <i class="fa-solid fa-x" id="close2"></i>
            <span>~~ Edit Comments ~~</span>
            <form action="owner.php" method="post" id="cococococo1">
                <h3>Dont Write Silly Comment Or Your Role Will Gone!!!</h3>
                <input type="text" id="comm_desc" placeholder="Comment...">
                <button type="button" id="gocomm">Save</button>
            </form>
        </div>
    </div>
    <div class="overlay4">
        <div class="container4">
            <i class="fa-solid fa-x" id="close3"></i>
            <span>~~ Edit Messages ~~</span>
            <form action="owner.php" method="post" id="cococococo12">
                <h3>Dont Write Silly Messages Or Your Role Will Gone!!!</h3>
                <input type="text" id="msg_dec" placeholder="Messages...">
                <button type="button" id="gomsg">Save</button>
            </form>
        </div>
    </div>
    <div class="texter"><span>Owner</span></div>
    <div class="tables">
        <div class="t-users">
            <table class="styled-table">
                <tr class="uv">
                    <td>Users</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td class="dele">Email</td>
                    <td>Role</td>
                    <td>Controll</td>
                </tr>

                <?php
                if (!empty($users)) :
                ?>
                    <?php
                    $i = 0;

                    foreach ($users as $user) :
                        if ($user['role'] === "Owner") {
                            continue;
                        }
                        $i++
                    ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td class="dele"><?php echo $user['email']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td class="oe">
                                <form action="functions/edit.php" method="post">
                                    <input type="hidden" name="id" class="get-user" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="edit" class="k1">Edit</button>
                                </form>
                                <form action="owner.php" method="post" class="data">
                                    <?php

                                    if (!DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $user['id']))) {
                                        echo '<button type="button" name="ban" id="ban' . $i . '" class="k1 ban">Ban<input type="hidden" name="id" class="get-user" value="' . $user["id"] . '"></button>';
                                    } else {
                                        echo '<button type="button" name="Unban" id="Unban' . $i . '" class="k1 Unban">Unban<input type="hidden" name="id" class="get-user" value="' . $user["id"] . '"></button>';
                                    }

                                    ?>
                                </form>

                                <form action="owner.php" method="get">
                                    <button type="button" name="delete" id="dele<?php echo $i; ?>" class="k1 delete">Delete<input type="hidden" name="id" class="get-user" value="<?php echo $user['id']; ?>"></button>
                                </form>

                                <?php if ($user['role'] === "Admin") {
                                    echo '<form action="owner.php" method="get">
                                    <button type="button" name="R_Admin" id="rGO' . $i . '" class="k1 r-a">R.Admin<input type="hidden" name="id" class="get-user" value="' . $user["id"] . '"></button>
                                  </form>';
                                } else {
                                    echo '<form action="owner.php" method="get">
                                    
                                    <button type="button" name="M_Admin" id="mGO' . $i . '" class="k1 m-a">M.Admin<input type="hidden" name="id" class="get-user" value="' . $user["id"] . '"></button>
                                  </form>';
                                }

                                ?>

                            </td>
                        </tr>

                    <?php
                    endforeach;

                else :
                    ?>
                    <tr>

                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                    </tr>

                <?php
                endif;
                ?>
            </table>
        </div>
        <div class="t-compos">
            <table class="styled-table">
                <tr class="uv">
                    <td>Posts</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>Img</td>
                    <td>Maker</td>
                    <td>Likes</td>
                    <td>From Admin</td>
                    <td>Controll</td>
                </tr>
                <?php if (!empty($posts)) : $p = 0; ?>
                    <?php foreach ($posts as $post) : $p++ ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><img src="<?php

                                            if ($post['post_image'] == "default1.jpg" || $post['post_image'] == "default.jpg") {
                                                echo "../assets/" . $post['post_image'];
                                            } else if ($post['post_image'] == "admin_banner.jpg") {
                                                echo "../assets/" . $post['post_image'];
                                            } else {
                                                echo "../upload-post/" . $post['post_image'];
                                            }
                                            ?>" alt="404" id="post-admin"></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $post['post_maker']))[0]['name']; ?></td>
                            <td><?php echo $post['post_like']; ?></td>
                            <td><?php echo $post['post_important']; ?></td>
                            <td class="oe">
                                <form action="owner.php" method="post">
                                    <button type="button" name="goPost" id="goPost<?php echo $p; ?>" class="k1 goPost">Go Post<input type="hidden" name="hide" id="post_id" value="<?php echo $post['id'] ?>"></button>
                                </form>
                                <form action="owner.php" method="post">
                                    <button type="button" name="delete4" id="delet<?php echo $p; ?>" class="k1 delete4">Delete<input type="hidden" name="hide" id="post_id" value="<?php echo $post['id'] ?>"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                <?php endif; ?>
            </table>
        </div>
        <div class="t-op">
            <table class="styled-table">
                <tr class="uv">
                    <td>Comments</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>Post ID</td>
                    <td>Description</td>
                    <td>Maker</td>
                    <td>Controll</td>
                </tr>
                <?php if (!empty($comments)) : $k = 0 ?>
                    <?php foreach ($comments as $comment) : $k++; ?>
                        <tr>
                            <td><?php echo $comment['id']; ?></td>
                            <td><?php echo $comment['post_id']; ?></td>
                            <td><?php echo $comment['comments_desc']; ?></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' =>  $comment['maker']))[0]['name']; ?></td>
                            <td class="oe">
                                <form action="owner.php" method="post" class="tablsssse">
                                    <button type="button" name="comm" id="editComment<?php echo $k; ?>" class="k1 comnt">Edit<input type="hidden" name="hide1" id="comm_id" value="<?php echo $comment['id'] ?>"></button>
                                    <button type="button" name="comm7" id="deleComment<?php echo $k; ?>" class="k1 comnt_d">Delete<input type="hidden" name="hide1" id="comm_id" value="<?php echo $comment['id'] ?>"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                <?php endif; ?>
            </table>
        </div>
        <div class="t-msg">
            <table class="styled-table ">
                <tr class="uv">
                    <td>Messages</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>Content</td>
                    <td>From:</td>
                    <td>To:</td>
                    <td>Controll</td>
                </tr>
                <?php if (!empty($messages)) : $s = 0 ?>
                    <?php foreach ($messages as $msg) : $s++; ?>
                        <tr>
                            <td><?php echo $msg['id']; ?></td>
                            <td><?php echo $msg['msg']; ?></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $msg['income_id']))[0]['name']; ?></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $msg['outcome_id']))[0]['name']; ?></td>
                            <td class="oe">
                                <form action="owner.php" method="post">
                                    <button type="button" name="edit_msg" id="edit_msg<?php echo $s; ?>" class="k1 editMSG">Edit<input type="hidden" name="msgID" id="msgID" value="<?php echo $msg['id'] ?>"></button>
                                </form>
                                <form action="owner.php" method="post">
                                    <button type="button" name="dele_msg" id="dele_msg<?php echo $s; ?>" class="k1 deleMSG">Delete<input type="hidden" name="msgID" id="msgID" value="<?php echo $msg['id'] ?>"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                    <td>Empty</td>
                <?php endif; ?>
            </table>
        </div>
        <div class="t-follow">
            <table class="styled-table ">
                <tr class="uv">
                    <td>Followers</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>User</td>
                    <td>Following</td>
                    <td>Controll</td>
                </tr>
                <?php if (!empty($followers)) : $w = 0; ?>
                    <?php foreach ($followers as $f) : $w++; ?>
                        <tr>
                            <td><?php echo $f['id'] ?></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $f['current']))[0]['name']; ?></td>
                            <td><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $f['follower']))[0]['name']; ?></td>
                            <td class="oe">
                                <form action="owner.php" method="post">
                                    <button type="button" id="goCurrent<?php echo $w; ?>" class="k1 goCurrent">P.User<input type="hidden" name="cid" id="cid" value="<?php echo $f['current'] ?>"></button>
                                </form>
                                <form action="owner.php" method="post">
                                    <button type="button" id="goFollow<?php echo $w; ?>" class="k1 goFollow loo1">P.Following<input type="hidden" name="cid" id="cid" value="<?php echo $f['follower'] ?>"></button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>

                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                    </tr>

                <?php endif; ?>
            </table>
        </div>
        <div class="t-report">
            <table class="styled-table ">
                <tr class="uv">
                    <td>Reports</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>Content</td>
                    <td>Name</td>
                    <td>Controll</td>
                </tr>
                <?php if (!empty($reports)) : $w = 0; ?>
                    <?php foreach ($reports as $f) : $w++; ?>
                        <tr>
                            <td><?php echo $f['id']; ?></td>
                            <td><?php echo $f['content']; ?></td>
                            <td><?php echo $f['name']; ?></td>
                            <td class="oe">
                                <form action="owner.php" method="post">
                                    <button type="button" id="ouou<?php echo $w; ?>" class="k1 ropo loo1">Finished<input type="hidden" name="cid" id="cid" value="<?php echo $f['id'] ?>"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                        <td>Empty</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <?php include "../components/footer.php"; ?>
    <script src="../js/admin.js"></script>
</body>

</html>