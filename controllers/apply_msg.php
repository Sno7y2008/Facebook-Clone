<?php

include '../classes/DB.php';
include '../classes/Login.php';

$userID = Login::isLoggedIn();

if ($userID) {
    $messages = DB::query("SELECT * FROM admin_chat");
    $output = "";

    if (!empty($messages)) {

        foreach ($messages as $msg) {
            $output .= '<div class="msk">
                            <div class="informe">
                                <img src="../../uploads/' . DB::query('SELECT images From users WHERE id=:id', array(':id' => $msg['sender']))[0]['images'] . '" alt="404">
                                <span class="name">' . DB::query('SELECT name From users WHERE id=:id', array(':id' => $msg['sender']))[0]['name'] . '</span>
                            </div>

                            <div class="lDis">
                                <span class="msp">' . $msg['msg'] . '</span>
                            </div>
                        </div>';
        }
    } else {
        $output = "<div class='c low'><span class='error'>No Messages To See Now</span></div>";
    }
    echo $output;
}


?>