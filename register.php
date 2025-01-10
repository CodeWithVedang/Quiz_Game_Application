<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'trivia_quiz';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO users (username, password, status) VALUES (?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Approval request sent. Please wait for admin approval."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>