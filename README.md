# Trivia Quiz Web Application

Welcome to the **Trivia Quiz Web Application**! This project is a fully functional web-based trivia quiz game where users can test their knowledge, compete with others, and interact with admins for feedback and account management. The application is built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**, and it integrates with the **Open Trivia Database API** to fetch quiz questions.

## Features

### User Features
- **User Registration & Login**: Users can register and log in to their accounts. New accounts require admin approval.
- **Quiz Customization**: Users can customize their quiz by selecting the number of questions, category, difficulty, and type (multiple choice or true/false).
- **Real-time Quiz**: Users can take quizzes with a timer and receive instant feedback on their answers.
- **Score Tracking**: Scores are saved and displayed in the leaderboard.
- **Feedback System**: Users can submit feedback to admins and view admin replies.
- **Leaderboard**: Users can view their rank and compare scores with others.

### Admin Features
- **Admin Dashboard**: Admins can manage user accounts (approve, reject, block) and view all feedback.
- **Feedback Management**: Admins can reply to user feedback directly from the dashboard.
- **User Management**: Admins can approve, reject, or block user accounts.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **API**: [Open Trivia Database API](https://opentdb.com/)
- **Version Control**: Git, GitHub

## Database Schema
The database `trivia_quiz` contains the following tables:
- **users**: Stores user information (username, password, status).
- **quiz**: Stores quiz scores and details (user_id, score, category, difficulty, type, date_taken).
- **admins**: Stores admin credentials (username, password).
- **feedback**: Stores user feedback and admin replies (user_id, message, admin_reply, created_at).

## Installation & Setup

### Prerequisites
- **Web Server**: Apache or Nginx
- **PHP**: Version 7.0 or higher
- **MySQL**: Version 5.6 or higher
- **Composer** (optional for dependency management)

### Steps to Run the Project
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/codewithvedang/trivia-quiz.git
   cd trivia-quiz
   ```

2. **Set Up the Database**:
   - Import the `trivia_quiz.sql` file into your MySQL database.
   - Update the database connection details in the PHP files (`admin_login.php`, `login.php`, etc.) with your MySQL credentials.

3. **Configure the Web Server**:
   - Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).
   - Ensure the server is running and accessible via `http://localhost/trivia-quiz`.

4. **Run the Application**:
   - Open your browser and navigate to `http://localhost/trivia-quiz`.
   - Register as a new user or log in with existing credentials.
   - Admins can log in using the default credentials (`username: admin`, `password: admin`).



## Contributing
Contributions are welcome! If you'd like to contribute to this project, please follow these steps:
1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes and push the branch.
4. Submit a pull request with a detailed description of your changes.

## License
This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for more details.

## Contact
For any questions or suggestions, feel free to reach out:
- **GitHub**: [codewithvedang](https://github.com/codewithvedang)
- **Email**: shelatkarvedang2@gmail.com

---

Enjoy the Trivia Quiz Web Application! Test your knowledge, compete with friends, and have fun! 🎉
