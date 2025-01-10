<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'trivia_quiz';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST['user_id'];
$status = $_POST['status'];

// Update the user status
$sql = "UPDATE users SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>