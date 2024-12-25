<?php

$conn = mysqli_connect("localhost", "root", "", "login_app");

if ($conn) {
    // echo "Connected" . "<br>";
} else {
    echo "Not connected" . mysqli_error($conn);
}
