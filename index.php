<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/static/config.php';
function logged_in ($link) {
    if(isset($_SESSION['user_id']) && check_login($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $link)) {
        return true;
    } else {
        return false;
    }
}
session_start();
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (logged_in($link)){?>
    <script>
        window.location.href = "/profile";
    </script>
<?php    
}
else{?>
    <script>
        window.location.href = "/login";
    </script>
<?php
}
?>