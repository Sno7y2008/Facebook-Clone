<?php

include "../classes/Login.php";
include "../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}

$userID = Login::isLoggedIn();
$user_info = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $userID))[0];
$msg = "";

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

if (isset($_POST['saver'])) {
    $username = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pass']);


    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    if ($error === 0) {
        if ($img_size > 250000) {
            $msg = "Sorry, your file is too large.";
        } else {

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                if (!DB::query('SELECT name FROM users WHERE name=:username', array(':username' => $username))) {
                    if (strlen($username) >= 3 && strlen($username) <= 32) {
                        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
                            if (strlen($password) >= 6 && strlen($password) <= 60) {
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    DB::query(
                                        'UPDATE users SET name=:name, password=:pass, email=:email, images=:img WHERE id=:id',
                                        array(':name' => $username, ':pass' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email, ':img' => $new_img_name, ':id' =>  $userID)
                                    );
                                    Header('Location: ' . $_SERVER['PHP_SELF']);
                                } else {
                                    $msg =  'Invalid email!';
                                }
                            } else {
                                $msg = 'Invalid password!';
                            }
                        } else {
                            $msg = 'Invalid username';
                        }
                    } else {
                        $msg = 'User already exists!';
                    }
                } else {
                    $msg = 'User already exists!';
                }
            }
        }
    } else {
        $msg = "An Error Has Occurred Please Try Agin...";
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
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Settings</title>
</head>

<body>
    <div class="navigation">
        <div class="logo">
            <img src="../assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy sec">
            <a href="messages.php">Messages</a>
            <a href="logout.php">logout</a>
            <a href="../main.php">Back</a>
            <span class="ooooooo">~</span>
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>
    <div class="j-main">
        <div class="k-main">
            <div class="title-90"><span class="ti">Settings</span><span class="alter"><?php echo $msg; ?></span></div>
            <div class="g-form">
                <form action="settings.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="my_image" class="input-o" required>
                    <input type="text" name="name" value="<?php echo $user_info['name']; ?>" required placeholder="Edit Name..." class="inputs-s">
                    <input type="email" name="email" value="<?php echo $user_info['email']; ?>" required placeholder="Edit Email..." class="inputs-s">
                    <input type="password" name="pass" required placeholder="Edit Password..." value="" class="inputs-s">
                    <button type="submit" name="saver" id="save">Save</button>
                </form>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
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