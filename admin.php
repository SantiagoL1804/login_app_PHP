<?php

include "partials/header.php";
include "partials/navigation.php";

if (!is_user_logged_in()) {
    redirect("login.php");
}

$result = mysqli_query($conn, "SELECT id, username, email, reg_date FROM users");
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (isset($_POST["edit_user"])) {
        $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
        $new_email = mysqli_real_escape_string($conn, $_POST["email"]);
        $new_username = mysqli_real_escape_string($conn, $_POST["username"]);

        $query_status = check_query(update_user($conn, $user_id, $new_username, $new_email));
        if ($query_status === true) {
            $_SESSION["message"] = "User {$user_id} updated successfully";
            $_SESSION["msg_type"] = "Success";
            redirect("admin.php");
        }
    } elseif (isset($_POST["delete_user"])) {
        $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);


        $sql = "DELETE FROM users WHERE id = $user_id";
        mysqli_query($conn, $sql);

        $query_status = check_query(delete_user($conn, $user_id));
        if ($query_status === true) {
            $_SESSION["message"] = "User {$user_id} deleted successfully";
            $_SESSION["msg_type"] = "Success";


            redirect("admin.php");
        }
    }
}


?>

<h2>Manage Users</h2>

<div class="container">

    <?php if (isset($_SESSION["message"])): ?>
        <div class="notification <?php echo $_SESSION["msg_type"]; ?>">
            <?php echo $_SESSION["message"];
            unset($_SESSION["message"]);
            unset($_SESSION["msg_type"]);
            ?>
        </div>
    <?php endif; ?>
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($user = mysqli_fetch_assoc($result)):
            ?>
                <tr>
                    <td><?php echo $user["id"]; ?></td>
                    <td><?php echo $user["username"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
                    <td><?php echo full_month_date($user["reg_date"]); ?></td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">
                            <input type="text" name="username" value="<?php echo $user["username"]; ?>" required>
                            <input type="email" name="email" value="<?php echo $user["email"]; ?>" required>

                            <button class="edit" type="submit" name="edit_user">Edit</button>
                        </form>
                        <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">
                            <button class="delete" type="submit" name="delete_user">Delete</button>
                        </form>
                    </td>
                </tr>


            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Include Footer -->
<?php

include "partials/footer.php";
mysqli_close($conn);
?>