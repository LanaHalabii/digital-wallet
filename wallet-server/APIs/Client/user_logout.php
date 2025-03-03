<?php 
include("../db_connection/connection.php"); 

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables, by assigning an empty array to the session,
    // which is similar to using "unset" on all the data 
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Prepare response
    $response = [];
    $response["success"] = true;
    $response["message"] = "Logout successful.";
} else {
    // User is not logged in
    $response = [];
    $response["success"] = false;
    $response["message"] = "No user is logged in.";
}

// Return the response as JSON
echo json_encode($response);

?>