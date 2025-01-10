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
      </div>
    </form>
  </div>

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

  /* General Styling */
body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

h1 {
  text-align: center;
  color: #333;
  font-size: 2.5rem;
  margin-bottom: 20px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 2px;
}

p {
  text-align: center;
  color: #555;
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.hidden {
  display: none;
}

/* Form Styling */
#quiz-setup {
  text-align: center;
  background: #fff;
  border-radius: 15px;
  padding: 30px;
  width: 90%;
  max-width: 500px;
  margin-left:20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 20px;
  text-align: left;
    
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 8px;
  color: #333;
}

input,
select,
button {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
  transition: border-color 0.3s ease;
}

input:focus,
select:focus {
  border-color: #007bff;
  outline: none;
}

button {
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  padding: 12px 20px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-secondary {
  background-color:rgb(255, 0, 0);
  color: white;
  padding: 12px 20px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-decoration: none;
  display: inline-block;
  margin: 5px;
}

.btn-secondary:hover {
  background-color:rgb(255, 0, 136);
}

/* Quiz Container Styling */
#quiz-container,
#result-container {
  text-align: center;
  background: #fff;
  border-radius: 15px;
  padding: 30px;
  width: 90%;
  max-width: 600px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

#question-title {
  font-size: 24px;
  margin-bottom: 15px;
  color: #333;
}

#question-text {
  font-size: 18px;
  margin-bottom: 20px;
  color: #555;
}

#options {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin: 20px 0;
}

#options button {
  padding: 12px;
  font-size: 16px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

#options button:hover {
  background-color: #0056b3;
}

#timer {
  font-size: 18px;
  font-weight: bold;
  color: #333;
}

/* Result Container Styling */
#result-container h1 {
  margin-bottom: 20px;
  color: #333;
}

#result-container p {
  font-size: 20px;
  margin-bottom: 20px;
  color: #555;
}

/* Responsive Design */
@media (max-width: 768px) {
  h1 {
    font-size: 2rem;
  }

  p {
    font-size: 1rem;
  }

  #quiz-setup,
  #quiz-container,
  #result-container {
    padding: 20px;
  }
}
</style>
  <script src="script.js"></script>
  <script src="progress.js"></script>
</body>
</html>