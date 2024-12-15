<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = "tode123";     // Default for XAMPP
$dbname = "e_learning";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    // Prepare SQL query to get the user's data
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch the user's data
        $user = $result->fetch_assoc();
        
        // Verify the password using password_verify() function
        if (password_verify($pass, $user['password'])) {
            // Redirect to homepage after successful login
            header("Location: home.html");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
