<?php
include("../db_connection/connection.php"); 

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if email and password are set
    if (isset($_GET["email"]) && isset($_GET["password"])) {
        $email = $_GET["email"];
        $password = $_GET["password"];

        // Prepare and execute the query to find the admin by email
        $query = $mysqli->prepare("SELECT admin_id, password_hash FROM admin_users WHERE email = ?");
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
                $response["user_id"] = $user["admin_id"];
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