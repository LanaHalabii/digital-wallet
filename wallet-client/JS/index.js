document.addEventListener("DOMContentLoaded", function() {
    const loginButton = document.getElementById("login");

    loginButton.addEventListener("click", function(event) {
        event.preventDefault(); 
        console.log("Login button clicked!"); // Debugging line for testing the button
        window.location.href = "../Pages/user-home.html"; 
    });
});

