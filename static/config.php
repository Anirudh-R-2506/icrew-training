<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'id18277168_userdb');
define('DB_USER', 'id18277168_icrewtraining');
define('DB_PASS', '9^ngjhV7)r$Wz8M{');
function check_login($id, $ip, $link){
    $sql = "SELECT * FROM users WHERE id = '$id' AND ip = '$ip'";
    $result = $link->query($sql);
    if (sizeof($result->fetch_all()) == 1) {
        return true;
    } else {
        return false;
    }
}
?>