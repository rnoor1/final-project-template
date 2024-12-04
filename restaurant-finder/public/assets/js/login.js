document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the values of the email and password
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    var data = {
        email: email,
        password: password
    };

    // Send a POST request to the server to log in the user
    fetch("/api/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // On successful login, redirect to the dashboard or main page
            window.location.href = "/dashboard"; // Adjust according to your application
        } else {
            // Show error message if login fails
            alert(data.message || "Login failed, please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again later.");
    });
});

