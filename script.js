const inputUsername = document.querySelector('input[name="username"]');
const inputPassword = document.querySelector('input[name="password"]');
const inputPasswordRepeat = document.querySelector('input[name="confirm-password"]');
const usernameError = document.querySelector('#usernameError');
const passwordError = document.querySelector('#passwordError');
const passwordRepeatError = document.querySelector('#confirmPasswordError');

inputUsername.addEventListener('input', function () {
    inputUsername.classList.remove('error');
    usernameError.innerHTML = '';
});

inputPassword.addEventListener('input', function () {
    inputPassword.classList.remove('error');
    passwordError.innerHTML = '';
});

inputPasswordRepeat.addEventListener('input', function () {
    inputPasswordRepeat.classList.remove('error');
    passwordRepeatError.innerHTML = '';
});

async function checkForm(event) {
    event.preventDefault();

    let hasError = false;

    if (!usernameCheck(inputUsername.value)) {
        inputUsername.classList.add('error');
        hasError = true;
    } else {
        const userExists = await usernameExists(inputUsername.value);
        if (userExists) {
            usernameError.innerHTML = "Username already exists";
            inputUsername.classList.add('error');
            hasError = true;
        }
    }

    if (!passwordCheck(inputPassword.value, inputPasswordRepeat.value)) {
        inputPassword.classList.add('error');
        inputPasswordRepeat.classList.add('error');
        hasError = true;
    }

    if (!hasError) {
        alert("Form submitted successfully!");
        document.getElementById("registerForm").submit();
    }
}

function usernameCheck(username) {
    if (username.length < 3) {
        usernameError.innerHTML = "Username must be at least 3 characters long";
        return false;
    }
    return true;
}

function passwordCheck(passwordValue, passwordRepeatValue) {
    if (passwordValue.length < 8) {
        passwordError.innerHTML = "Password must be at least 8 characters long";
        return false;
    }
    if (passwordValue !== passwordRepeatValue) {
        passwordRepeatError.innerHTML = "Passwords do not match";
        return false;
    }
    return true;
}

async function usernameExists(username) {
    try {
        const response = await fetch(
            `https://online-lectures-cs.thi.de/chat/2b25b36f-1ef4-4ce3-8020-33b3665241a5/${username}`
        );
        return response.status === 204;
    } catch (error) {
        console.error("Error checking username:", error);
        return false;
    }
}

document.getElementById("registerForm").addEventListener("submit", checkForm);
