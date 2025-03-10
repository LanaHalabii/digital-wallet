<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST"); // Allow specific request methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers
include("../db_connection/connection.php"); 

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if email and password are set
    if (isset($_GET["email"]) && isset($_GET["password"])) {
        $email = $_GET["email"];
        $password = $_GET["password"];

        // Prepare and execute the query to find the user by email
        $query = $mysqli->prepare("SELECT user_id, password_hash FROM Users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        
        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user["password_hash"])) {
                $response = [];
                $response["success"] = true;
                $response["message"] = "Login successful!";
                $response["user_id"] = $user["user_id"];
            } else {
                $response = [];
                $response["success"] = false;
                $response["message"] = "Invalid password.";
            }
        } else {
            $response = [];
            $response["success"] = false;
            $response["message"] = "User not found.";
        }
        } else {
            $response = [];
            $response["success"] = false;
            $response["message"] = "Missing email or password.";
    }
}   else {
        // Invalid request method (POST not GET)
        $response = [];
        $response["success"] = false;
        $response["message"] = "Invalid request method.";
}

// Return the response as JSON
echo json_encode($response);
?>