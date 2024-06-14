<?php

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs (you can add more validation)
    $itemName = $_POST["addItemName"];
    $quantity = (int)$_POST["addItemQuantity"];
    $price = (float)$_POST["additemPrice"];

    if (empty($itemName) || $quantity <= 0 || $price <= 0) {
        die("Invalid input data");
    }
    $mysqli = require __DIR__ . "/database.php";
 
    // Prepare and execute the SQL INSERT statement

    $userEmail = $_SESSION['userEmail'];

    $stmt = $mysqli->prepare("INSERT INTO `$userEmail` (name, quantity, price) VALUES (?, ?, ?)");

    $stmt->bind_param("sii", $itemName, $quantity, $price);
   
    if ($stmt->execute()) {
        header("Location: inventory.php");
       //die ("Item added successfully.");
    } else {
       echo "Error: " . $stmt->error;
    }
} else {
    // Handle the case where the form is not submitted
    echo "Form not submitted";
}
?>