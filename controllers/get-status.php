<?php

if (isset($_POST['data'])) {
    if ($_POST['data'] > time()) {
        echo "<span class='ok'>online</span>";
    } else {
        echo "<span class='no'>offline</span>";
    }
}

?>