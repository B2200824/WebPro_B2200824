document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const customerCommentsDiv = document.getElementById('customer-comments');
    const commentForm = document.querySelector('form'); // Use form selector directly
    const commentInput = document.getElementById('comment-input');
    const usernameInput = document.getElementById('username-input');
    let selectedRating = 0;

    // Rating functionality
    stars.forEach(star => {
        star.addEventListener('click', () => {
            selectedRating = parseInt(star.getAttribute('data-value'));
            updateStars(selectedRating);
        });

        star.addEventListener('mouseover', () => {
            const hoverValue = parseInt(star.getAttribute('data-value'));
            updateStars(hoverValue);
        });

        star.addEventListener('mouseout', () => {
            updateStars(selectedRating);
        });
    });

    function updateStars(rating) {
        stars.forEach(star => {
            star.classList.toggle('selected', parseInt(star.getAttribute('data-value')) <= rating);
        });
    }

    // Comment form submission
    commentForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const commentText = commentInput.value.trim();
        const username = usernameInput.value.trim();

        if (username && commentText && selectedRating > 0) {
            const formData = new FormData(commentForm);
            formData.append('rating', selectedRating);

            fetch('comments.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    fetchComments(); // Refresh comments
                    commentInput.value = '';
                    usernameInput.value = '';
                    selectedRating = 0;
                    updateStars(selectedRating);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            alert('Please enter your name, comment, and select a rating.');
        }
    });

    function fetchComments() {
        fetch('comments.php')
            .then(response => response.json())
            .then(data => {
                displayComments(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function displayComments(comments) {
        customerCommentsDiv.innerHTML = comments.map(comment => `
            <div class="comment-box">
                <strong>${comment.username} (${new Date(comment.timestamp).toLocaleString()})</strong>
                <div class="rating">${'★'.repeat(comment.rating)}${'☆'.repeat(5 - comment.rating)}</div>
                <p>${comment.comment}</p>
            </div>
        `).join('');
    }

    // Load existing comments on page load
    fetchComments();

    // Set trailer URL
    function setTrailer(videoId) {
        const trailerVideo = document.getElementById('trailer-video');
        trailerVideo.src = `https://www.youtube.com/embed/${videoId}`;
    }

    // Set poster image
    function setPoster(imageUrl) {
        const posterImage = document.getElementById('poster-image');
        posterImage.src = imageUrl;
    }

    // Example usage
    setTrailer('hRFY_Fesa9Q'); // Replace with your actual YouTube video ID
    setPoster('https://your_poster_image_url.jpg'); // Replace with your actual poster image URL
});
