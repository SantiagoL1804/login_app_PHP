<?php

include "partials/header.php";
include "partials/navigation.php";

if (!is_user_logged_in()) {
    redirect("login.php");
}

$result ? mysqli_query($conn, "SELECT id, ")
?>

<h2>Manage Users</h2>

<div class="container">
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
            <tr>
                <td>1</td>
                <td>john_doe</td>
                <td>john@example.com</td>
                <td>January 1</td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="user_id" value="1">
                        <input type="email" name="email" value="john@example.com" required>
                        <button class="edit" type="submit" name="edit_user">Edit</button>
                    </form>
                    <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="user_id" value="1">
                        <button class="delete" type="submit" name="delete_user">Delete</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>jane_doe</td>
                <td>jane@example.com</td>
                <td>February 15</td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="user_id" value="2">
                        <input type="email" name="email" value="jane@example.com" required>
                        <button class="edit" type="submit" name="edit_user">Edit</button>
                    </form>
                    <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="user_id" value="2">
                        <button class="delete" type="submit" name="delete_user">Delete</button>
                    </form>
                </td>
            </tr>
            <!-- Additional user rows can go here -->
        </tbody>
    </table>
</div>

<!-- Include Footer -->
<?php

include "partials/footer.php";
?>