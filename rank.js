document.addEventListener('DOMContentLoaded', () => {
  const rankTableBody = document.querySelector('#rank-table tbody');

  fetch('fetch_ranks.php')
    .then(response => response.json())
    .then(data => {
      if (data.length > 0) {
        data.forEach((user, index) => {
          const row = document.createElement('tr');
          const rankCell = document.createElement('td');
          const usernameCell = document.createElement('td');
          const scoreCell = document.createElement('td');

          rankCell.textContent = index + 1; // Rank number
          usernameCell.textContent = user.username; // Username
          scoreCell.textContent = user.total_score || 0; // Total score (default to 0 if not available)

          row.appendChild(rankCell);
          row.appendChild(usernameCell);
          row.appendChild(scoreCell);
          rankTableBody.appendChild(row);
        });
      } else {
        const row = document.createElement('tr');
        const noDataCell = document.createElement('td');
        noDataCell.setAttribute('colspan', '3');
        noDataCell.textContent = 'No scores available.';
        row.appendChild(noDataCell);
        rankTableBody.appendChild(row);
      }
    })
    .catch(error => console.error('Error fetching ranks:', error));
});