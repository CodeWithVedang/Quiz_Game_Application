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
$password = $_POST['password']; // Compare password as plain text

// Fetch admin details from the database
$sql = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($admin) {
    // Compare the plain text password
    if ($password === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id']; // Set admin session
        echo json_encode(["success" => true, "redirect" => "admin_dashboard.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Admin not found."]);
}

$stmt->close();
$conn->close();
?>