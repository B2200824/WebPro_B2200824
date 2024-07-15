document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const customerCommentsDiv = document.getElementById('customer-comments');
    const commentInput = document.getElementById('comment-input');
    const usernameInput = document.getElementById('username-input');
    const submitCommentBtn = document.getElementById('submit-comment');
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
            if (parseInt(star.getAttribute('data-value')) <= rating) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }

    // Comment functionality
    submitCommentBtn.addEventListener('click', () => {
        const commentText = commentInput.value.trim();
        const username = usernameInput.value.trim();
        const currentTime = new Date().toLocaleString();

        if (username !== '') {
            const customerComment = document.createElement('div');
            customerComment.className = 'customer-comment';
            customerComment.innerHTML = `
                <p><strong>${username}</strong> (${currentTime})</p>
                ${selectedRating > 0 ? `<p style="color: gold;">${'★'.repeat(selectedRating)}${'☆'.repeat(5 - selectedRating)}</p>` : ''}
                <p>${commentText}</p>
            `;
            customerCommentsDiv.appendChild(customerComment);

            commentInput.value = '';
            usernameInput.value = '';
            selectedRating = 0;
            updateStars(selectedRating);
        } else {
            alert('Please enter your name before submitting.');
        }
    });

    // Function to set trailer URL
    function setTrailer(videoId) {
        const trailerVideo = document.getElementById('trailer-video');
        const youtubeEmbedUrl = `https://www.youtube.com/embed/${videoId}`;
        trailerVideo.src = youtubeEmbedUrl;
    }

    // Function to set poster image
    function setPoster(imageUrl) {
        const posterImage = document.getElementById('poster-image');
        posterImage.src = imageUrl;
    }

    // Example usage
    setTrailer('Q6iK6DjV_iE'); // Updated with the provided YouTube video ID
    setPoster('movie1.jpg'); // Replace with your actual poster image URL
});