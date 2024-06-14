<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST["deleteItemName"];

    if (empty($itemName)) {
        die("Invalid input data");
    }

    $mysqli = require __DIR__ . "/database.php";
 
    $userEmail = $_SESSION['userEmail'];

    // Check if the item exists in the user's table
    $checkItemQuery = "SELECT name FROM `$userEmail` WHERE name = ?";
    $stmt = $mysqli->prepare($checkItemQuery);
    $stmt->bind_param("s", $itemName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Item not found in your inventory.");
    }

    // Prepare and execute the SQL DELETE statement
    $deleteItemQuery = "DELETE FROM `$userEmail` WHERE name = ?";
    $stmt = $mysqli->prepare($deleteItemQuery);
    $stmt->bind_param("s", $itemName);

    if ($stmt->execute()) {
        header("Location: inventory.php");
        //echo "Item deleted successfully.";
    } else {
        echo "Error deleting item: " . $stmt->error;
    }
} else {
    echo "Form not submitted";
}
?>
