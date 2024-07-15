// order.js

function placeOrder() {
    // Validate form before submission
    if (validateForm()) {
        // Submit the form
        document.getElementById("orderForm").submit();
    } else {
        alert("Please fill in the required fields.");
    }
}

function validateForm() {
    // Example: Validate if at least one item quantity is greater than zero
    const popcornQuantity = document.getElementById("popcorn-quantity").value;
    const sodaQuantity = document.getElementById("soda-quantity").value;
    const nachosQuantity = document.getElementById("nachos-quantity").value;

    if (popcornQuantity === "0" && sodaQuantity === "0" && nachosQuantity === "0") {
        return false; // At least one item must be selected
    }

    return true;
}
