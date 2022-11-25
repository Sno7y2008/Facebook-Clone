<?php
include "../classes/DB.php";
include "../classes/Login.php";

$userID = Login::isLoggedIn();
$name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $userID))[0]['name'];


$posts = DB::query('SELECT * FROM posts ORDER BY id DESC');



?>

<?php if (!empty($posts)) : ?>
    <?php foreach ($posts as $post) : ?>

        <div class="container">
            <div class="inner">
                <div class="image"><img src="<?php

                                                if ($post['post_image'] == "default1.jpg" || $post['post_image'] == "default.jpg") {
                                                    $class = "default-Img";
                                                    echo "upload-post/" . $post['post_image'];
                                                } else if ($post['post_image'] == "admin_banner.jpg") {
                                                    $class = "default-Img";
                                                    echo "assets/" . $post['post_image'];
                                                } else {
                                                    $class = "";
                                                    echo "upload-post/" .  $post['post_image'];
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
                        if ($post['post_important'] === "Yes") {
                            echo "By Admins<img src='assets/verified.png' alt='404' id='true'>";
                        } else {
                            if (DB::query('SELECT * FROM followers WHERE current=:userid AND follower=:foll', array(':userid' => $userID, ':foll' => $post['post_maker'])) || DB::query('SELECT * FROM followers WHERE current=:userid AND follower=:foll', array(':foll' => $userID, ':userid' => $post['post_maker']))) {
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
            <div class="outter">
                <form action="pages/post.php" method="get">
                    <input type="hidden" id="oio" name="post_id" value='<?php echo $post['id']; ?>'>
                    <button type="submit" id="view-more" name="veiw_more">Veiw More</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : echo "<div class='c' id='opoopp'><span class='error'>No Trending Posts To See Now</span></div>"; ?>
<?php endif; ?>

