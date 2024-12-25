<?php
include "partials/header.php";
include "partials/navigation.php";

if (is_user_logged_in()) {
    redirect("admin.php");
}

$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Create variables from user input
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Check if username already exists in database
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!mysqli_num_rows($result)) {
        $error = "Invalid username";
    } else {
        $user = mysqli_fetch_assoc($result);

        if (!password_verify($password, $user["password"])) {
            $error = "Invalid password";
        } else {

            $_SESSION["logged in"] = true;
            $_SESSION["username"] = $user["username"];

            redirect("admin.php");
        }
    }
}

?>
<div class="container">


    <div class="form-container">
        <h2>Login</h2>
        <form method="POST">

            <label for="username">Username: </label>
            <input type="text" name="username" required> <br><br>

            <label for="password">Password: </label>
            <input type="password" name="password" required> <br><br>

            <?php if (!empty($error)): ?>
                <p style="color:red"><?php echo $error; ?></p>
            <?php endif; ?>
            <input type="submit" value="Login">



        </form>
    </div>
</div>
<?php
include "partials/footer.php";

?>