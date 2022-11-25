    <div class="navigation">
        <div class="logo">
            <img src="assets/logo.png" alt="404" class="small">
        </div>
        <div class="copy sec">
            <?php


            $userID = Login::isLoggedIn();
            $role = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $userID))[0]['role'];

            if ($role === "Owner") {
                echo '<a href="admin/Owner.php">Owner</a>';
                echo '<a href="admin/admin.php">Admin</a>';
            } else if ($role === "Admin") {
                echo '<a href="admin/admin.php">Admin</a>';
            }

            ?>
            <a href="report.php">Reports</a>
            <a href="mailto:sno7y21@gmail.com">Mail Creator</a>
            <a href="pages/logout.php">logout</a>
            <span class="ooooooo">~</span>
            <h3 class="right">Copyright © 2022</h3>
        </div>
    </div>