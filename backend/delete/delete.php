<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'your_db_username', 'your_db_password', 'your_db_name');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the record
    $sql = "DELETE FROM your_table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
