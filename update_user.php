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
        $old_name = $row['name'];
        $old_email = $row['email'];
    } else {
        $message = "User not found with ID: $user_id";
    }

    $stmt->close();
}

if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];

    // Using prepared statements to prevent SQL injection
    $sql = "UPDATE `crud`.`user` SET `name`=?, `email`=? WHERE `id`=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "User data updated successfully.";
    } else {
        $message = "Error updating user data: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update User Data</title>
    <!-- Use your preferred Bootstrap version -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="update_user.css"> <!-- Link to your updated CSS file -->
</head>

<body>

    <div class="container">
        <h2>Update User Data:</h2>

        <!-- Form to input user ID -->
        <form action="" method="POST">
            <fieldset>
                <legend>Enter User ID to Fetch Details:</legend>
                <label for="user_id">User ID:</label>
                <input type="text" name="user_id" required>
                <input type="submit" name="fetch_details" value="Fetch Details">
            </fieldset>
        </form>

        <!-- Display existing user data for reference -->
        <?php if (!empty($old_name) && !empty($old_email)) : ?>
            <p>User ID: <?php echo $user_id; ?></p>
            <p>Old Name: <?php echo $old_name; ?></p>
            <p>Old Email: <?php echo $old_email; ?></p>

            <!-- Update form -->
            <form action="" method="POST">
                <fieldset>
                    <legend>Enter New Information:</legend>
                    <!-- Hidden input to pass user_id -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <!-- New Name -->
                    <label for="new_name">New Name:</label>
                    <input type="text" name="new_name" placeholder="Enter new name" ><br>

                    <!-- New Email -->
                    <label for="new_email">New Email:</label>
                    <input type="email" name="new_email" placeholder="Enter new email"><br>

                    <br>

                    <input type="submit" name="update" value="Update">
                </fieldset>
            </form>
        <?php endif; ?>

        <!-- Display success or error message below the form -->
        <div class="message">
            <?php echo $message; ?>
        </div>
        <p><a href="index.php">Go Back to Home Page</a></p>
    </div>

</body>

</html>
