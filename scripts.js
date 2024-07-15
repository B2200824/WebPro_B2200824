document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('discountForm');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessage('success', data.message);
                displayMessage('success', 'Successfully Registered'); // Add this line for the additional notification
            } else {
                displayMessage('error', data.message);
            }
        })
        .catch(error => {
            displayMessage('error', 'An error occurred while submitting the form.');
        });
    });
    
    function displayMessage(type, message) {
        const messageContainer = document.createElement('div');
        messageContainer.className = type === 'success' ? 'success-message' : 'error-message';
        messageContainer.textContent = message;
        
        const container = document.querySelector('.container');
        container.appendChild(messageContainer);
        
        setTimeout(() => {
            messageContainer.remove();
        }, 5000);
    }
});
