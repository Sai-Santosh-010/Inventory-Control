<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST["updateItemName"];
    $newQuantity = (int)$_POST["updateItemQuantity"];
    $newPrice = (float)$_POST["updateItemPrice"];

    if (empty($itemName) || $newQuantity <= 0 || $newPrice <= 0) {
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

    // Prepare and execute the SQL UPDATE statement
    $updateItemQuery = "UPDATE `$userEmail` SET quantity = ?, price = ? WHERE name = ?";
    $stmt = $mysqli->prepare($updateItemQuery);
    $stmt->bind_param("dss", $newQuantity, $newPrice, $itemName);

    if ($stmt->execute()) {
        header("Location: inventory.php");
        //echo "Item updated successfully.";
    } else {
        echo "Error updating item: " . $stmt->error;
    }
} else {
    echo "Form not submitted";
}
?>
