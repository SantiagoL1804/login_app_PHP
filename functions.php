<?php

function console_log($message)
{
    echo "<script>console.log('" . addslashes($message) . "');</script>";
}

function is_user_logged_in()
{
    return isset($_SESSION['logged in']) && $_SESSION['logged in'] === true;
}

function redirect($location)
{
    header("Location: $location");
    exit;
}

function setActiveClass($pageName)
{
    $current_page = basename($_SERVER["PHP_SELF"]);
    return ($current_page === $pageName) ? 'active' : '';
}


function getPageClass()
{
    return basename($_SERVER["PHP_SELF"], ".php");
}

function userExists($conn, $username)
{
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) > 0;
}
