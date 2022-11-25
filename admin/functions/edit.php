<?php

include '../../classes/DB.php';
$r = "i";
$msg = "";
if (isset($_POST['id'])) {

      $user_info = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $_POST['id']))[0];
} else {

      header("Location: ../../main.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="../../assets/logo.png" sizes="16x16">
      <script src="https://kit.fontawesome.com/a2e5a25eb0.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="../../css/style.css">
      <link rel="stylesheet" href="../../css/main.css">
      <link rel="stylesheet" href="../../css/profile.css">
      <link rel="stylesheet" href="../../css/settings.css">
      <link rel="stylesheet" href="../../css/admin.css">
      <link rel="stylesheet" href="../../css/responsive.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <title>Edit</title>
</head>

<body>
      <div class="navigation">
            <div class="logo">
                  <img src="../../assets/logo.png" alt="404" class="small">
            </div>
            <div class="copy sec">
                  <a href="../../messages.php">Messages</a>
                  <a href="../../logout.php">logout</a>
                  <a href="../owner.php">Back</a>
                  ~
                  <h3 class="right">Copyright © 2022</h3>
            </div>
      </div>
      <div class="j-main">
            <div class="k-main">
                  <div class="title-90"><span class="ti">Edit User</span><span class="alter"><?php echo $msg; ?></span></div>
                  <div class="g-form">
                        <form action="" method="post" class="f">
                              <input type="hidden" id="idn" name="id" value="<?php echo $user_info['id']; ?>">
                              <input type="text" name="name11" id="name" value="<?php echo $user_info['name']; ?>" required placeholder="Edit Name..." class="inputs-s">
                              <input type="email" name="email22" id="email" value="<?php echo $user_info['email']; ?>" required placeholder="Edit Email..." class="inputs-s">
                              <input type="password" name="pass33" id="pass" value="<?php echo $user_info['pass_admin']; ?>" required placeholder="Edit Password..." class="inputs-s">
                              <button type="button" name="saveing" id="save">Save</button>
                        </form>
                  </div>
            </div>
      </div>
      <?php include '../../components/footer.php'; ?>
      <script>
            $('.f').onsubmit = function(e) {
                  e.preventDefault();
            }

            $('#save').click(function() {
                  let id = $('#idn').val();
                  let name = $('#name').val();
                  let email = $('#email').val();
                  let password = $('#pass').val();

                  $.post('../../controllers/adminsetter.php', {
                        id: id,
                        name: name,
                        email: email,
                        password: password

                  }, function () {
                        window.location.href = "../owner.php";
                  })
            })
      </script>
</body>

</html>