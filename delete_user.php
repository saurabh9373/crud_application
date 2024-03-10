<?php
include "mysql.php";

$message = ''; // Initialize an empty message variable

if (isset($_POST['fetch_details'])) {
    $user_id = $_POST['user_id'];

    $sql = "SELECT * FROM `crud`.`user` WHERE `id`=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_details = $row;
    } else {
        $message = "User not found with ID: $user_id";
    }

    $stmt->close();
}

if (isset($_POST['delete']) && isset($_POST['confirm'])) {
    $user_id = $_POST['user_id'];

    if ($_POST['confirm'] == 'yes') {
        // Delete user
        $sql = "DELETE FROM `crud`.`user` WHERE `id`=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "User deleted successfully.";
            $user_details = null; // Clear user details after deletion
        } else {
            $message = "Error deleting user: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // User clicked "No"
        header('Location: index.php'); // Redirect to index.php
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete User</title>
    <!-- Use your preferred Bootstrap version -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="delete_user.css"> <!-- Link to your CSS file -->
</head>

<body>

    <div class="container">
        <h2>Delete User:</h2>

        <?php if (isset($user_details)) : ?>
            <!-- Display user details -->
            <p>User ID: <?php echo $user_details['id']; ?></p>
            <p>Name: <?php echo $user_details['name']; ?></p>
            <p>Email: <?php echo $user_details['email']; ?></p>

            <!-- Confirm deletion form -->
            <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_details['id']; ?>">
                <p>Are you sure you want to delete this account permanently?</p>
                <input type="submit" name="confirm" value="Yes" class="btn btn-danger">
                <input type="submit" name="confirm" value="No" class="btn btn-default">
            </form>
        <?php else : ?>
            <!-- Form to input user ID -->
            <form action="" method="POST">
                <fieldset>
                    <legend>Enter User ID to Delete:</legend>
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" required>
                    <input type="submit" name="fetch_details" value="Fetch Details" class="btn btn-primary">
                </fieldset>
            </form>
        <?php endif; ?>

        <!-- Display success or error message below the form -->
        <div class="message">
            <?php echo $message; ?>
        </div>

        <!-- Go Back link -->
        <p><a href="index.php">Go Back to Home Page</a></p>
    </div>

</body>

</html>
