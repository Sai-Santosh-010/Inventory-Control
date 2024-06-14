<?php
    session_start();

    if (isset($_SESSION["user_id"])) {
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" type="text/css" href="/first/css/Box.css">
    <link rel="stylesheet" type="text/css" href="/first/css/Background.css">
    <link rel="stylesheet" type="text/css" href="/first/css/Button1.css">
    <link rel="stylesheet" type="text/css" href="/first/css/Input.css">
    <link rel="stylesheet" type="text/css" href="/first/css/Font1.css">
    <link rel="stylesheet" type="text/css" href="/first/css/table.css">
    <title>Inventory Control</title>
</head>
<body>
<?php if (isset($user)): ?>
    <h1 id="demotext" align="center">Inventory Control System</h1>
    <h4 align="middle" id="demotext"><a id="demotext" href="/first/logout.php">Log Out</a></h4>
    <div class="container">
        <div class="item-box">
            <!-- Form for adding new items -->
            <form id="addItemForm" method="post" action="/first/inventory/additem.php">
                <fieldset>
                    <legend id="demotext">Add Item</legend>

                    <label for="addItemName" id="demotext">Item Name:</label>
                    <input class = "input" type="text" id="addItemName" name="addItemName" required>
        
                    <label for="addItemQuantity" id="demotext">Quantity:</label>
                    <input class = "input" type="number" id="addItemQuantity" name="addItemQuantity" required>

                    <label for="additemPrice" id="demotext">Price:</label>
                    <input class = "input" type="number" id="additemPrice" name="additemPrice" require>
        
                    <button type="submit">Add Item</button>
                </fieldset>
            </form>
        </div>
        <div class="item-box">
            <!-- Form for updating an existing item -->
            <form id="updateItemForm" method="post" action="/first/inventory/updateitem.php">
                <fieldset>
                    <legend id="demotext">Update Item</legend>
        

                    <label for="updateItemName" id="demotext">Item Name:</label>
                    <input class = "input" type="text" id="updateItemName" name="updateItemName" required>
        
                    <label for="updateItemQuantity" id="demotext">New Quantity:</label>
                    <input class = "input" type="number" id="updateItemQuantity" name="updateItemQuantity" required>

                    <label for="updateItemPrice" id="demotext">New Price:</label>
                    <input class = "input" type="number" id="updateItemPrice" name="updateItemPrice" required>
        
                    <button type="submit">Update Item</button>
                </fieldset>
            </form>
        </div>
        <div class="item-box">
            <!-- Form for deleting an item -->
            <form id="deleteItemForm" method="post" action="/first/inventory/deleteitem.php">
                <fieldset>
                    <legend id="demotext">Delete Item</legend>
            
                    <label for="deleteItemName" id="demotext">Item Name:</label>
                    <input class = "input" type="text" id="deleteItemName" name="deleteItemName" required>
        
                    <button type="submit">Delete Item</button>
                </fieldset>
            </form>
        </div>    
    </div>
    <!-- Displaying the inventory -->
    <h2 id="demotext" align="center">Inventory List</h2>
    <table border="2">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <!-- Inventory items will be displayed here dynamically -->
            <?php
                // establishing a database connection
                $mysqli = require __DIR__ . "/database.php";
                // Fetch data from the user's table
                //session_start();
                $userEmail = $_SESSION['userEmail'];
                $query = "SELECT * FROM `$userEmail`"; // Replace with your actual table name
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        //echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'><center>Your Inventory is Empty.</center></td></tr>";
                }
            ?>
        </tbody>
    </table>
<?php else: header("Location: login.php"); ?>
        
    
    <p><a id="demotext" href="login.php">Log in</a> or <a id="demotext" href="signup.html">sign up</a></p>
        
<?php endif; ?>
</body>
</html>
