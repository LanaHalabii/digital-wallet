<?php

include("connection/connection.php");

// Check that the request is DELETE
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Get the user ID from the request
    parse_str(file_get_contents("php://input"), $data);
    $user_id = $data["user_id"];

    if ($user_id) { //Once the user ID is fetched
        // Query to prepare to delete the user
        $delete_query = "DELETE FROM Users WHERE user_id = ?";
        $delete_user = $mysqli->prepare($delete_query);
        // Bind the user ID 
        $delete_user->bind_param("i", $user_id);

        
        if ($delete_user->execute()) {
            if ($delete_user->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "User account deleted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "No user found with that ID."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete user account."]);
        }
        
        // Close the statement
        $delete_user->close();
    } else {
        echo json_encode(["success" => false, "message" => "User ID is required."]); // Error prevention
    }
} else {
    // If the request method is not DELETE
    echo json_encode(["success" => false, "message" => "Invalid request method. Only DELETE is allowed."]);
}

?>