
document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the email and password values
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Send a GET request to the login API
    axios.get('https://wallet-server/Apis/Client/user_login.php', { 
        params: {
            email: email,
            password: password
        }
    })
    .then(function (response) {
        // Handle the response from the server
        if (response.data.success) {
            alert(response.data.message);
            // Redirect to the user home page
            window.location.href = "../Pages/user-home.html";
        } else {
            alert(response.data.message);
        }
    })
    .catch(function (error) { //error handling
        console.error("There was an error!", error);
    });
});