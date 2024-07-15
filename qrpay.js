document.addEventListener('DOMContentLoaded', function() {
    const proceedButton = document.getElementById('proceedButton');

    proceedButton.addEventListener('click', function() {
        alert('Proceeding to the next step.');
        // You can replace the alert with the desired action, e.g., redirecting to another page
        // window.location.href = 'next-step.html';
    });
});