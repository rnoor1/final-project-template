document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault(); 
   
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    var data = {
        email: email,
        password: password
    };

    
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
            
            window.location.href = "/dashboard"; 
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

