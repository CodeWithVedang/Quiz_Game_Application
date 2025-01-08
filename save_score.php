<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in."]);
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

$user_id = $_SESSION['user_id']; // Get user_id from session
$score = $_POST['score'];
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$type = $_POST['type'];
$date_taken = date('Y-m-d H:i:s'); // Current timestamp

$sql = "INSERT INTO scores (user_id, score, category, difficulty, type, date_taken) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $user_id, $score, $category, $difficulty, $type, $date_taken);

if ($stmt->execute()) {
    echo json_encode(["message" => "Score saved successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>