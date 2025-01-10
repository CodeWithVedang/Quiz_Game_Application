<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "trivia_quiz";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users and their total scores
$sql = "SELECT users.username, IFNULL(SUM(quiz.score), 0) as total_score 
        FROM users 
        LEFT JOIN quiz ON users.id = quiz.user_id 
        GROUP BY users.username 
        ORDER BY total_score DESC";

$result = $conn->query($sql);

$ranks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ranks[] = $row;
    } 
}

echo json_encode($ranks);

$conn->close();
?>