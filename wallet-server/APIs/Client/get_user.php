<?php 
include("../db_connection/connection.php"); 

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if user_id is provided
    if (isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];

        // Fetch user profile from the database
        $query = $mysqli->prepare("SELECT full_name, username, email, phone_number, address FROM Users WHERE user_id = ?");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Get wallet balance
            $balance_query = $mysqli->prepare("SELECT wallet_balance FROM Wallets WHERE user_id = ?");
            $balance_query->bind_param("i", $user_id);
            $balance_query->execute();
            $balance_result = $balance_query->get_result();
            $balance = $balance_result->fetch_assoc();

            // Prepare the response
            $response = [
                "success" => true,
                "data" => [
                    "user_id" => $user_id,
                    "full_name" => $user['full_name'],
                    "username" => $user['username'],
                    "email" => $user['email'],
                    "phone_number" => $user['phone_number'],
                    "address" => $user['address'],
                    "wallet_balance" => $balance['wallet_balance'] ?? 0,
                ]
            ];
        } else {
            $response = ["success" => false, "message" => "User not found."];
        }
    } else {
        $response = ["success" => false, "message" => "Missing user_id parameter."];
    }
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method."];
}

// Return the response as JSON
echo json_encode($response);


?>