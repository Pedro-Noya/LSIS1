
// Get URL parameter 'email'
const params = new URLSearchParams(window.location.search);
const email = params.get('email');

// Set it as the value of the input
if (email) {
document.getElementById('emailInput').value = email;
}
