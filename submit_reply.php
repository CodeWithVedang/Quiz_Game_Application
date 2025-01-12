<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
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

$feedback_id = $_POST['feedback_id'];
$reply = $_POST['reply'];

$sql = "UPDATE feedback SET admin_reply = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $reply, $feedback_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>