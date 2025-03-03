<?php 
include("../db_connection/connection.php"); 

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $user_id = $_GET["user_id"];
    $full_name = $_GET["full_name"];
    $username = $_GET["username"];
    $email = $_GET["email"];
    $phone_number = $_GET["phone_number"];
    $address = $_GET["address"];
    $password = $_GET["password"];

    // Prepare the SQL query
    $update_query = "UPDATE Users SET ";
    $params = []; // Array to store the new parameters / data
    $set_parts = []; // Array to store the parameters we are changing
    $types = []; // Array to hold types for bind_param

    // Add the parameters based on obtained values from users
    if ($full_name !== "") {
        $set_parts[] = "full_name = ?";
        $params[] = $full_name;
        $types[] = "s"; 
    }
    if ($username !== "") {
        $set_parts[] = "username = ?";
        $params[] = $username;
        $types[] = "s"; 
    }
    if ($email !== "") {
        $set_parts[] = "email = ?";
        $params[] = $email;
        $types[] = "s"; 
    }
    if ($phone_number !== "") {
        $set_parts[] = "phone_number = ?";
        $params[] = $phone_number;
        $types[] = "s"; 
    }
    if ($address !== "") {
        $set_parts[] = "address = ?";
        $params[] = $address;
        $types[] = "s"; 
    }
    if ($password !== "") {
        $set_parts[] = "password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
        $types[] = "s"; 
    }

    
    $set_parts[] = "user_id = ?";
    $params[] = $user_id;
    $types[] = "i"; // 'i' for integer

    // Append to update_query all of the set parts
    $update_query .= implode(", ", $set_parts); 

    // Prepare and execute 
    $update_user = $mysqli->prepare($update_query);
    $update_user->bind_param(implode("", $types), ...$params); // Bind parameters using the types array

    if ($update_user->execute()) {
        echo json_encode(["success" => true, "message" => "User profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user profile."]);
    }
} else {
    echo json_encode(["success" => false, "message"]);
}

?>