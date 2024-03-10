<?php
include "mysql.php";

$message = ''; // Initialize an empty message variable

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Using prepared statements to prevent SQL injection
    $sql = "INSERT INTO `crud`.`user`(`name`, `email`) VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "New record created successfully...";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup Form</title>
    <!-- Use your preferred Bootstrap version -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>

<body>

    <div class="container">
        <h2>Signup Form:</h2>
        <form action="" method="POST">
            <fieldset>
                <legend>Personal information:</legend>

                <!-- Assuming 'name' is used instead of 'firstname' -->
                Name:<br>
                <input type="text" name="name" required><br>

                Email:<br>
                <input type="email" name="email" required><br>

                <br>

                <input type="submit" name="submit" value="Submit">

            </fieldset>
        </form>

        <!-- Display success or error message below the form -->
        <div>
            <?php echo $message; ?>
        </div>
        <p><a href="index.php">Go Back to Home Page</a></p>
    </div>

</body>

</html>
