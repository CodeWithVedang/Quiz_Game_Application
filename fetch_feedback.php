<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "trivia_quiz";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT message, admin_reply FROM feedback WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$feedback = [];
while ($row = $result->fetch_assoc()) {
    $feedback[] = $row;
}

echo json_encode($feedback);

$stmt->close();
$conn->close();
?>