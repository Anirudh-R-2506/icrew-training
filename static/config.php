<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'userDB');
define('DB_USER', 'root');
define('DB_PASS', '');
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