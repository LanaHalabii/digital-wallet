<?php 
include("../db_connection/connection.php"); 

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if required fields are set
    if (isset($_GET["full_name"]) && isset($_GET["username"]) && 
        isset($_GET["email"]) && isset($_GET["password"]) && 
        isset($_GET["phone_number"]) && isset($_GET["user_address"])) {
        
        $full_name = $_GET["full_name"];
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        $phone_number = $_GET["phone_number"];
        $user_address = $_GET["user_address"];

        // Check if the email or username already exists
        $query = $mysqli->prepare("SELECT user_id FROM Users WHERE email = ? OR username = ?");
        $query->bind_param("ss", $email, $username);
        $query->execute();
        $result = $query->get_result();


        // Check if user already exists or if the username is taken
        if ($result->num_rows > 0) {
            $response = [];
            $response["success"] = false;

            // Check which field is taken
            $existing_user = $result->fetch_assoc();
            if ($existing_user['email'] === $email) {
                $response["message"] = "Email already registered.";
            } else {
                $response["message"] = "Username already taken.";
            }
        } else {
            // Start user registration and hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $insert_query = $mysqli->prepare("INSERT INTO Users (full_name, username, email, password_hash, phone_number, user_address) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_query->bind_param("ssssss", $full_name, $username, $email, $password_hash, $phone_number, $user_address);
            if ($insert_query->execute()) {
                // Registration successful
                $response = [];
                $response["success"] = true;
                $response["message"] = "Registration successful!";
            } else {
                // Insertion failed
                $response = [];
                $response["success"] = false;
                $response["message"] = "Registration failed. Please try again";
            }
        }
    } else {
        // Missing fields
        $response = [];
        $response["success"] = false;
        $response["message"] = "Missing fields.";
    }
} else {
    // Invalid request method (POST not GET)
    $response = [];
    $response["success"] = false;
    $response["message"] = "Invalid request method.";
}

// Return the response as JSON
echo json_encode($response);

?>
