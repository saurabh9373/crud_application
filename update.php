<?php

include "mysql.php";

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];

    $sql = "UPDATE `crud`.`user` SET `name`='$name', `email`='$email' WHERE `id`='$user_id'";

    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {

    $user_id = $_GET['id'];

    $sql = "SELECT * FROM `crud`.`user` WHERE `id`='$user_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $email = $row['email'];
            $id = $row['id'];
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Update Form</title>
    <link rel="stylesheet" href="styleupdate.css"> <!-- Link to your CSS file -->
</head>

<body>

    <div class="container">

        <h2>User Update Form</h2>

        <form action="" method="post">

            <fieldset>

                <legend>Personal information:</legend>

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="user_id" value="<?php echo $id; ?>"><br>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>"><br>

                <input type="submit" value="Update" name="update">

            </fieldset>

        </form>

    </div>

</body>

</html>

<?php
    } else {
        header('Location: view.php');
    }
}
?>
