<?php
include 'mysql.php';

// Variable to store the success message
$successMessage = "";

// CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create operation
    if (isset($_POST["adduser"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];

        $sql = "INSERT INTO users (id, name, email) VALUES ('$id', '$name', '$email')";
        
        if ($conn->query($sql)) {
            $successMessage = "User added successfully!";
        } else {
            $successMessage = "Error: " . $conn->error;
        }
    }

    // Update operation
    elseif (isset($_POST["update"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];

        $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
        
        if ($conn->query($sql)) {
            $successMessage = "User updated successfully!";
        } else {
            $successMessage = "Error: " . $conn->error;
        }
    }
}

// Delete operation
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $sql = "DELETE FROM users WHERE id=$id";
    
    if ($conn->query($sql)) {
        $successMessage = "User deleted successfully!";
    } else {
        $successMessage = "Error: " . $conn->error;
    }
}

// Read operation
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <script>
        // JavaScript function to show the success message
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
</head>

<body>

    <h2>User List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>
                    <a href='backend.php?delete={$row["id"]}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>

    <h2>Add User</h2>
    <form method="post" action="backend.php">
        <label for="id">ID:</label>
        <input type="text" name="id" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <button type="submit" name="create" onclick="showSuccessMessage('<?php echo $successMessage; ?>')">Add User</button>
    </form>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
