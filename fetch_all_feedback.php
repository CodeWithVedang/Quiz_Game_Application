<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
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

$sql = "SELECT feedback.id, users.username, feedback.message, feedback.admin_reply 
        FROM feedback 
        JOIN users ON feedback.user_id = users.id 
        ORDER BY feedback.created_at DESC";
$result = $conn->query($sql);

$feedback = [];
while ($row = $result->fetch_assoc()) {
    $feedback[] = $row;
}

echo json_encode($feedback);

$conn->close();
?>