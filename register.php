<?php
include "partials/header.php";
include "partials/navigation.php";

if (is_user_logged_in()) {
    redirect("admin.php");
}

$error = "";
error_log("HOLIS");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Create variables from user input
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);


    // Check if password matches with confirm password from input
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if username already exists in database
        if (userExists($conn, $username)) {
            $error = "Username already exists";
        } else {
            // Hash password before inserting the data in database
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password_hash', '$email')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION["logged in"] = true;
                $_SESSION["username"] = $username;
                redirect("admin.php");
                exit;
            } else {
                $error = "SOMETHING HAPPENED AND NO DATA WAS INSERTED" . mysqli_error($conn);
            }
        }
    }
}

?>

<div class="container">


    <div class="form-container">
        <h2>Create your Account</h2>
        <form method="POST">

            <label for="username">Username: </label>
            <input value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Enter your username" type="text" name="username" required>

            <label for="email">Email: </label>
            <input value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter your email" type="email" name="email" required>

            <label for="password">Password: </label>
            <input placeholder="Enter your password" type="password" name="password" required>

            <label for="confirm_password">Confirm password: </label>
            <input placeholder="Confirm your password" type="password" name="confirm_password" required>

            <?php if (!empty($error)): ?>
                <p style="color:red"><?php echo $error; ?></p>
            <?php endif; ?>
            <input type="submit" value="Register">
        </form>
    </div>
</div>

<?php
include "partials/footer.php";
?>

<?php
mysqli_close($conn);
?>