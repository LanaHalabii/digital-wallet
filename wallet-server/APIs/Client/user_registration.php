<?php 
include("../db_connection/connection.php"); 

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if required fields are set
    if (isset($_POST["full_name"]) && isset($_POST["username"]) && 
        isset($_POST["email"]) && isset($_POST["password"]) && 
        isset($_POST["phone_number"]) && isset($_POST["user_address"])) {
        
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone_number = $_POST["phone_number"];
        $user_address = $_POST["user_address"];

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
    // Invalid request method (GET not POST)
    $response = [];
    $response["success"] = false;
    $response["message"] = "Invalid request method.";
}

// Return the response as JSON
echo json_encode($response);

?>
