<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.png" sizes="16x16">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Reports</title>
</head>

<body>

    <div class="navbar">
        <div class="logo">
            <img src="assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy">
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>
    <div class="titles">
        <h2 class="page-title">Reports</h2>
    </div>
    <div class="main">
        <div class="inputs">
            <form action="index.php" method="post" class="sign-in">
                <p class="after">Content</p>
                <input type="text" required name="content" id="username">
                <p class="after i">Acconet Name</p>
                <input type="text" required name="name" id="password">
                <a href="pages/make-acconet.php" class="make">Don't Have Acconet Make One -></a>
                <a href="main.php" class="make">Back -></a>
                <button type="button" name="submit" id="btn-s">Send</button>
            </form>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="js/main.js"></script>
    <script>
        $(".sign-in").submit(function(e) {
            e.preventDefault();
        })

        $("#btn-s").click(function() {
            if ($("#username").val() !== "" && $("#password").val() !== "") {
                $.post("php/submit.php", {
                    content: $("#username").val(),
                    name: $("#password").val()
                }, function(data) {
                    console.log(data);
                    if (data == "Succeed Wait For Help...") {
                        $(".page-title").html(data);
                        setTimeout(() => {
                            window.location.href = "main.php";
                        }, 1500)
                    } else {
                        $(".page-title").html(data);
                    }
                });
            } else {
                $(".page-title").html("Please Fill The Inputs");

            }

        })
    </script>
</body>

</html>