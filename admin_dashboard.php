<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'trivia_quiz';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$sql = "SELECT id, username, status FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin_style.css"> <!-- Link to the new CSS file -->
</head>
<body>
  <div id="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <h2>Manage Users</h2>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td><?php echo $user['username']; ?></td>
          <td><?php echo $user['status']; ?></td>
          <td>
            <button class="approve" onclick="approveUser(<?php echo $user['id']; ?>)">Approve</button>
            <button class="reject" onclick="rejectUser(<?php echo $user['id']; ?>)">Reject</button>
            <button class="block" onclick="blockUser(<?php echo $user['id']; ?>)">Block</button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <h2>Feedback</h2>
<table>
  <thead>
    <tr>
      <th>Username</th>
      <th>Message</th>
      <th>Reply</th>
    </tr>
  </thead>
  <tbody id="feedback-table">
    <!-- Feedback will be populated here -->
  </tbody>
</table>
<button id='admin-dashboard-back-btn' type="button" class="btn-primary-2">Back</button>

  </div>
 <style>
.btn-primary-2 {
    width: 25%;
    padding: 12px;
    font-size: 16px;
    background-color:rgb(0, 173, 189); /* Sky blue button */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
margin-left:40%;
margin-right:100%;

    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .btn-primary-2:hover {
    background-color: #6cb4d8; /* Darker sky blue on hover */
    transform: translateY(-2px);
  }

  .btn-primary-2:active {
    transform: translateY(0);
  }

 </style>
  <script>

document.getElementById('admin-dashboard-back-btn').addEventListener('click', function() {
      window.location.href = 'admin_login.html'; // Redirect to admin login page
    });
function loadFeedback() {
    fetch('fetch_all_feedback.php')
      .then(response => response.json())
      .then(data => {
        const feedbackTable = document.getElementById('feedback-table');
        feedbackTable.innerHTML = '';
        data.forEach(feedback => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${feedback.username}</td>
            <td>${feedback.message}</td>
            <td>
              <textarea id="reply-${feedback.id}" placeholder="Enter your reply...">${feedback.admin_reply || ''}</textarea>
              <button onclick="submitReply(${feedback.id})">Submit Reply</button>
            </td>
          `;
          feedbackTable.appendChild(row);
        });
      })
      .catch(error => console.error('Error:', error));
  }

  function submitReply(feedbackId) {
    const reply = document.getElementById(`reply-${feedbackId}`).value;

    fetch('submit_reply.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `feedback_id=${feedbackId}&reply=${encodeURIComponent(reply)}`,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Reply submitted successfully!');
          loadFeedback();
        } else {
          alert('Error submitting reply.');
        }
      })
      .catch(error => console.error('Error:', error));
  }

  loadFeedback();


    function approveUser(userId) {
      updateUserStatus(userId, 'approved');
    }

    function rejectUser(userId) {
      updateUserStatus(userId, 'rejected');
    }

    function blockUser(userId) {
      updateUserStatus(userId, 'blocked');
    }

    function updateUserStatus(userId, status) {
      fetch('update_user_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user_id=${userId}&status=${status}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('User status updated successfully');
          location.reload();
        } else {
          alert('Error updating user status');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  </script>
</body>
</html>