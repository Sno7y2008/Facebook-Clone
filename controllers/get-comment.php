<?php

include '../classes/DB.php';

if (isset($_POST['id'])) {
$msgs = DB::query('SELECT * FROM comments WHERE post_id = :postid', array(":postid" => $_POST['id']));
if (!empty($msgs)) :
    foreach ($msgs as $msg) {
        $img = DB::query('SELECT images FROM users WHERE id = :name', array(':name' => $msg['maker']))[0]['images'];
?>
        <div class="call ff">
            <div class="inform">
                <img src="../uploads/<?php echo $img ?>" class="😀" alt="">
                <span class="vi"><?php echo DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $msg['maker']))[0]['name']?> : </span>
            </div>
            <div class="msgg"><span><?php echo $msg['comments_desc'] ?></span></div>
        </div>
<?php
    }
else : echo "<div class='c' id='opoopp'><span class='error'>No Comments To See Now</span></div>";
endif;
}
?>
