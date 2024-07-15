document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.seats');
    const seats = [];
    const selectedSeatsInput = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');
    const seatPrice = 10;

    // Generate seats dynamically
    for (let i = 0; i < 64; i++) {
        const seat = document.createElement('div');
        seat.classList.add('seat');
        if (i === 5 || i === 12 || i === 25) {
            seat.classList.add('occupied');
        }
        seat.addEventListener('click', () => toggleSeatSelection(seat, i));
        container.appendChild(seat);
        seats.push(seat);
    }

    function toggleSeatSelection(seat, index) {
        if (!seat.classList.contains('occupied')) {
            seat.classList.toggle('selected');
            updateSelectedSeats();
        }
    }

    function updateSelectedSeats() {
        const selectedSeats = seats
            .map((seat, index) => (seat.classList.contains('selected') ? index : null))
            .filter((seat) => seat !== null);
        selectedSeatsInput.value = selectedSeats.join(', ');
        updateTotalPrice(selectedSeats.length);
    }

    function updateTotalPrice(selectedSeatCount) {
        const totalPrice = selectedSeatCount * seatPrice;
        totalPriceElement.textContent = totalPrice.toFixed(2);
    }

    // Function to submit the form
    document.querySelector('form').addEventListener('submit', (event) => {
        event.preventDefault();
        const selectedSeats = selectedSeatsInput.value.split(',').map(Number);

        fetch('submit_seat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `seats=${encodeURIComponent(selectedSeatsInput.value)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                selectedSeats.forEach(index => {
                    seats[index].classList.remove('selected');
                    seats[index].classList.add('occupied');
                });
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
