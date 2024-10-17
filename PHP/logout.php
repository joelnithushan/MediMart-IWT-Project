<?php

session_start();//starting the session

$_SESSION = array();

//cookie removing process
if (isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 86400, '/');
}

session_destroy();

header('location: loginForm.php');

?>