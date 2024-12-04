document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const username = e.target.username.value;
    const email = e.target.email.value;
    const password = e.target.password.value;
    const confirmPassword = e.target.confirm_password.value;

    // Validate the form fields
    if (!username || !email || !password || !confirmPassword) {
        alert("All fields are required.");
        return;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    // If form is valid, send data to backend
    fetch('/user/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email, password }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registration successful! Please log in.');
            window.location.href = '/login'; // Redirect to login after successful registration
        } else {
            alert(data.message); // Show error message from backend
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
