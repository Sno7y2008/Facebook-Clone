<?php

include "../classes/DB.php";

$msg = "Hello There, Make Acconet And Share Posts With Other, Happy Day.";

if (isset($_POST['submit'])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $email = htmlspecialchars($_POST["email"]);


    if (isset($_FILES['my_image'])) {

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

                $allowed_exs = array("jpg", "jpeg", "png", "gif");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    if (!DB::query('SELECT name FROM users WHERE name=:username', array(':username' => $username))) {
                        if (strlen($username) >= 3 && strlen($username) <= 32) {
                            if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
                                if (strlen($password) >= 6 && strlen($password) <= 60) {
                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        DB::query('INSERT INTO `users` VALUES (\'\', :username, :password, :email, :image, :role, \'\');', array(':username' => $username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email, ':image' => $new_img_name, ':role' => "member"));
                                        header('Location: ../index.php');
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
        }
    } else {
        $msg = "unknown error occurred!";
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
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Sign Up</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    <div class="titles">
        <h2 class="page-title">Sign Up</h2>
        <span class="page-desc"><?php echo $msg; ?></span>
    </div>
    <div class="main">
        <div class="inputs">
            <form action="make-acconet.php" method="post" class="sign-in" enctype="multipart/form-data">
                <p class="after">username</p>
                <input type="text" required name="username" id="username">
                <p class="after ui">Email</p>
                <input type="Email" required name="email" id="email">
                <p class="after">Password</p>
                <input type="password" required name="password" id="password">
                <span class="page-desc">Upload Image For User</span>
                <input type="file" required name="my_image" id="file" placeholder="Upload Image">
                <a href="../index.php" class="make">Have Acconet Sign In -></a>
                <button type="submit" name="submit" id="btn-s">Sign Up</button>
            </form>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
    <!-- <script src="../js/main.js"></script> -->
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