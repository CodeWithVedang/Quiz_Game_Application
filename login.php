<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'trivia_quiz';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Verify the password using password_verify()
    if (password_verify($password, $user['password'])) {
        // Check if the user is approved
        if ($user['status'] === 'approved') {
            $_SESSION['user_id'] = $user['id']; // Set user session
            echo json_encode(["success" => true, "redirect" => "index.php"]);
        } else {
            echo json_encode(["success" => false, "message" => "Your account is not approved yet. Please contact the admin."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not found."]);
}

$stmt->close();
$conn->close();
?>