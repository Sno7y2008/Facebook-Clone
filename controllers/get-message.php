<?php

include '../classes/DB.php';
include '../classes/Login.php';

if (isset($_POST['income_id']) && isset($_POST['outcome_id'])) {
  $messages = DB::query("SELECT * FROM messages WHERE income_id=:income AND outcome_id=:outcome OR income_id=:outcome AND outcome_id=:income", array(':income' => $_POST['income_id'], ':outcome' => $_POST['outcome_id']));
  $output = "";

  if (!empty($messages)) {

    foreach ($messages as $msg) {
      if ($msg['income_id'] == $_POST['income_id']) {
        $output .= "<div class='m1'><span>" . $msg['msg'] . "</span></div>";
      } else {
        $output .= "<div class='lllllll'>
                            <div class='m2'><span>" . $msg['msg'] . "</span></div>
                        </div>";
      }
    }
  } else {
    $output = "<div class='c low'><span class='error'>No Messages To See Now</span></div>";
  }
  echo $output;
}
?>
