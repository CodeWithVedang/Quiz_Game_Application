<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trivia Quiz</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Progress Bar -->
  <div id="progress-bar" class="progress-bar"></div>
  <div id="quiz-setup">
    <h1>Welcome to Trivia Quiz!</h1>
    <p>Test your knowledge and climb the ranks. Choose your quiz settings below:</p>
    
    <form id="quiz-config">
      <div class="form-group">
        <label for="questions">Number of Questions:</label>
        <input type="number" id="questions" class="questions" name="questions" min="1" max="50" required>
      </div>
      
      <div class="form-group">
        <label for="category">Category:</label>
        <select id="category" name="category"></select>
      </div>
      
      <div class="form-group">
        <label for="difficulty">Difficulty:</label>
        <select id="difficulty" name="difficulty">
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type">
          <option value="multiple">Multiple Choice</option>
          <option value="boolean">True/False</option>
        </select>
      </div>
      
      <button type="button" id="start-quiz" class="btn-primary">Start Quiz</button>
      
      <div id="logout-container">
        <button id="logout-button" class="btn-secondary">Logout</button>
        <a href="rank.html" id="rank-link" class="btn-secondary">View Ranks</a>
        <a href="feedbackpage.html" id="feedback-button" class="btn-secondary">Feedback</a>
      </div>
    </form>
  </div>

  <!-- Quiz and Result Containers -->
  <div id="quiz-container" class="hidden">
    <h1 id="question-title"></h1>
    <p id="question-text"></p>
    <div id="options"></div>
    <p id="timer">Time left: <span id="time-left"></span>s</p>
  </div>

  <div id="result-container" class="hidden">
    <h1>Quiz Completed!</h1>
    <p>Your Score: <span id="final-score"></span></p>
    <button id="restart-quiz" class="btn-primary">BACK</button>
  </div>

  <style>
    /* Progress Bar Styling */
    .progress-bar {
      position: fixed;
      top: 0;
      left: 0;
      height: 10px;
      width: 0;
      background-color: #007bff;
      z-index: 1000;
      transition: width 0.3s ease;
    }
  </style>

  <script src="script.js"></script>
  <script src="progress.js"></script>
</body>
</html>