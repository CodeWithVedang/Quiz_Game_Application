// Progress Bar Logic
document.addEventListener('DOMContentLoaded', () => {
    const progressBar = document.getElementById('progress-bar');
  
    // Simulate page loading progress
    let width = 0;
    const interval = setInterval(() => {
      if (width >= 100) {
        clearInterval(interval);
      } else {
        width += 10; // Increase progress by 10%
        progressBar.style.width = width + '%';
      }
    }, 100); // Adjust the interval for smoother or faster progress
  });
  
  // Ensure the progress bar completes when the page is fully loaded
  window.addEventListener('load', () => {
    const progressBar = document.getElementById('progress-bar');
    progressBar.style.width = '100%';
    setTimeout(() => {
      progressBar.style.opacity = '0';
    }, 500); // Fade out the progress bar after completion
  });