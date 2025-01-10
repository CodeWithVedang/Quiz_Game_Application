document.addEventListener('DOMContentLoaded', () => {
  const apiUrl = 'https://opentdb.com/api.php';
  const categorySelect = document.getElementById('category');
  const quizSetup = document.getElementById('quiz-setup');
  const quizContainer = document.getElementById('quiz-container');
  const resultContainer = document.getElementById('result-container');

  const questionTitle = document.getElementById('question-title');
  const questionText = document.getElementById('question-text');
  const optionsContainer = document.getElementById('options');
  const timerElement = document.getElementById('time-left');
  const finalScoreElement = document.getElementById('final-score');

  let questions = [];
  let currentQuestionIndex = 0;
  let score = 0;
  let timer;

  fetch('https://opentdb.com/api_category.php')
    .then(response => response.json())
    .then(data => {
      data.trivia_categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        categorySelect.appendChild(option);
      });
    })
    .catch(error => console.error('Error fetching categories:', error));

  document.getElementById('start-quiz').addEventListener('click', () => {
    const numQuestions = document.getElementById('questions').value;
    const category = categorySelect.value;
    const difficulty = document.getElementById('difficulty').value;
    const type = document.getElementById('type').value;

    if (!category) {
      alert('Please select a category!');
      return;
    }

    const url = `${apiUrl}?amount=${numQuestions}&category=${category}&difficulty=${difficulty}&type=${type}`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        questions = data.results;
        if (questions.length > 0) {
          score = 0;
          currentQuestionIndex = 0;
          quizSetup.classList.add('hidden');
          quizContainer.classList.remove('hidden');
          showQuestion();
        } else {
          alert('No questions available for the selected options!');
        }
      })
      .catch(error => console.error('Error fetching questions:', error));
  });

  function showQuestion() {
    if (currentQuestionIndex >= questions.length) {
      endQuiz();
      return;
    }

    const question = questions[currentQuestionIndex];
    const options = question.type === 'boolean'
      ? ['True', 'False']
      : shuffle([...question.incorrect_answers, question.correct_answer]);

    questionTitle.textContent = `Question ${currentQuestionIndex + 1}`;
    questionText.innerHTML = decodeURIComponent(question.question);

    optionsContainer.innerHTML = '';
    options.forEach(option => {
      const button = document.createElement('button');
      button.textContent = decodeURIComponent(option);
      button.className = 'option';
      button.addEventListener('click', () => {
        if (decodeURIComponent(option) === question.correct_answer) score++;
        currentQuestionIndex++;
        showQuestion();
      });
      optionsContainer.appendChild(button);
    });

    startTimer();
  }

  function shuffle(array) {
    return array.sort(() => Math.random() - 0.5);
  }

  function startTimer() {
    let timeLeft = 15;
    timerElement.textContent = timeLeft;
    clearInterval(timer);
    timer = setInterval(() => {
      timeLeft--;
      timerElement.textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(timer);
        currentQuestionIndex++;
        showQuestion();
      }
    }, 1000);
  }

  function endQuiz() {
  clearInterval(timer);
  quizContainer.classList.add('hidden');
  resultContainer.classList.remove('hidden');
  finalScoreElement.textContent = `${score} / ${questions.length}`;

  const category = document.getElementById('category').value;
  const difficulty = document.getElementById('difficulty').value;
  const type = document.getElementById('type').value;
  const dateTaken = new Date().toISOString();

  fetch('save_score.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
      score: score,
      category: category,
      difficulty: difficulty,
      type: type,
      date_taken: dateTaken,
    }),
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      console.error('Error saving score:', data.error);
    } else {
      console.log('Score saved:', data.message);
    }
  })
  .catch(error => console.error('Error saving score:', error));
}
  document.getElementById('restart-quiz').addEventListener('click', () => {
    resultContainer.classList.add('hidden');
    quizSetup.classList.remove('hidden');
  });

  document.getElementById('logout-button').addEventListener('click', function() {
    fetch('logout.php')
      .then(response => response.json())
      .then(data => {
        if (data.logged_out) {
          window.location.href = 'login.html';
        }
      })
      .catch(error => {
        console.error('Error logging out:', error);
      });
  });
});