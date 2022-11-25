<?php

include "../classes/Login.php";
include "../classes/DB.php";


if (!Login::isLoggedIn()) {
    header('Location: ../index.php');
}

$userID = Login::isLoggedIn();
$name = DB::query('SELECT name FROM users WHERE id=:id', array(':id' => $userID))[0]['name'];

if (DB::query('SELECT * FROM bans WHERE user_id=:id', array(':id' => $userID))) {
    header("Location: index.php");
}

if (isset($_POST['d-serach'])) {
    $ser = htmlspecialchars($_POST['serach']);
    $users = DB::query('SELECT * FROM users WHERE name LIKE :name', array(':name' => "%" . $ser . "%"));
} else {
    $users = DB::query('SELECT * FROM users');
}

if (isset($_GET['veiw'])) {
    $profile_id = htmlspecialchars($_GET['outcome_id']);
    header("Location: profile.php?profile_id=$profile_id");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Messages</title>
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
    <div class="main2">
        <div class="ll">
            <div class="serch">
                <span class="ioioiiopii">Users</span>
                <form action="messages.php" method="post" class="kaka">
                    <input type="text" name="serach" id="new" placeholder="Search...">
                    <button type="submit" name="d-serach" id="koko">Search</button>
                </form>
            </div>
            <div class="row"></div>
            <div class="users90">
                <?php foreach ($users as $user) : ?>
                    <?php if ($user['id'] == $userID) {
                        continue;
                    } ?>
                    <div class="for-users">
                        <div class="infor">
                            <img src="../uploads/<?php

                                                    if ($user['images'] == "") {
                                                        echo "../assets/user.png";
                                                    } else {
                                                        echo "../uploads/" . $user['images'];
                                                    }

                                                    ?>" class="folder" alt="404">
                            <span class="j"><?php echo $user['name'] ?></span>
                        </div>
                        <div class="btg">
                            <form action="messages.php" method="get">
                                <input type="hidden" name="outcome_id" value="<?php echo $user['id']; ?>">
                                <input type="hidden" name="income_id" value="<?php echo $userID; ?>">
                                <button type="submit" name="veiw" class="kl i">View</button>
                                <button type="submit" name="msg" class="kl">messages</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="gg">
            <?php if (isset($_GET['outcome_id']) && isset($_GET['income_id'])) :
                $user_info_2  = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => htmlspecialchars($_GET['outcome_id'])))[0];
            ?>
                <div class="veiwer">
                    <div class="ui-user">
                        <div class="user-veiw">
                            <img src="<?php

                                        if ($user_info_2['images'] == "") {
                                            echo "../assets/user.png";
                                        } else {
                                            echo "../uploads/" . $user_info_2['images'];
                                        } ?>" class="smalllllll" alt="404">
                            <span class="vi"><?php echo $user_info_2['name']; ?> : </span>
                            <span class="role"><?php echo $user_info_2['role']; ?></span>
                        </div>
                        <div class="isFrint">
                            <form action="messages.php" method="post">
                                <input type="hidden" id="id" value="<?php echo $user_info_2['status']; ?>">
                            </form>
                            <span class="llp"></span>
                        </div>
                    </div>
                    <div class="row2"></div>
                    <div class="view-msg"></div>
                </div>
                <div class="creater">
                    <form action="messages.php" method="post" id="msgF">
                        <input type="hidden" id="income" value="<?php echo $_GET['income_id']; ?>">
                        <input type="hidden" id="outcome" value="<?php echo $_GET['outcome_id']; ?>">
                        <input type="text" id="create" placeholder="Your Message....???">
                        <button type="button" id="sender">Send</button>
                    </form>
                </div>
            <?php else : echo "<div class='c'><span class='error'>No Content Selected Now</span></div>"; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
    <script>
        setInterval(function() {
            $.ajax({
                url: "../controllers/updata_status.php",
                success: function(data) {

                }
            });

        }, 1000)
    </script>
    <script>
        let valu = document.getElementById("id").value;

        setInterval(function() {
            $.post("../controllers/get-status.php", {
                data: valu
            }, function(data) {
                $('.llp').html(data);
            })
        }, 2000)
    </script>
    <script>
        let form = document.getElementById("msgF");

        form.onsubmit = function(e) {
            e.preventDefault();
        }

        $("#sender").click(function() {
            if ($("#create").val() !== "") {
                $.post('../controllers//set-message.php', {
                    income_id: parseInt($("#income").val()),
                    outcome_id: parseInt($("#outcome").val()),
                    message: $("#create").val(),
                }, function() {
                    setTimeout(() => {
                        let veiwer = document.querySelector(".view-msg");
                        veiwer.scrollTop = veiwer.scrollHeight;
                    }, 300)
                });
                document.getElementById('create').value = "";
            } else {
                document.querySelector('#create').value = "Type Something....";
                setTimeout(() => {
                    document.querySelector('#create').value = "";

                }, 1500)
            }
        });


        $(document).ready(function() {
            setInterval(function() {
                $(".view-msg").load("../controllers//get-message.php", {
                    income_id: parseInt($("#income").val()),
                    outcome_id: parseInt($("#outcome").val()),
                })
            }, 1000)
        })
    </script>
    <script>
        setTimeout(() => {
            let veiwer = document.querySelector(".view-msg");
            veiwer.scrollTop = veiwer.scrollHeight;
        }, 1300)

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