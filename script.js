document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm-password").value;
    const usernameError = document.getElementById("usernameError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    // Clear previous error messages
    usernameError.textContent = "";
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";

    // Validate username length
    if (username.length < 3) {
        usernameError.textContent = "Der Nutzername muss mindestens 3 Zeichen lang sein.";
        return;
    }

    // Check if username is available
    fetch(`ajax_check_user.php?user=${encodeURIComponent(username)}`)
        .then(response => {
            if (response.status === 404) {
                // Username is available, proceed with other validations
                if (password.length < 8) {
                    passwordError.textContent = "Das Passwort muss mindestens 8 Zeichen lang sein.";
                    return;
                }

                if (password !== confirmPassword) {
                    confirmPasswordError.textContent = "Die Passwörter stimmen nicht überein.";
                    return;
                }

                // If all validations pass, submit the form
                this.submit();
            } else if (response.status === 204) {
                // Username is taken
                usernameError.textContent = "Der Nutzername ist bereits vergeben.";
            } else {
                // Handle other response statuses
                usernameError.textContent = "Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.";
            }
        })
        .catch(error => {
            console.error("Error checking username:", error);
            usernameError.textContent = "Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.";
        });
});