var inputUsername = document.querySelector('input[name="username"]');
var inputPassword = document.querySelector('input[name="password"]');
var inputPasswordRepeat = document.querySelector('input[name="confirm-password"]');

function checkForm() {

    if (!usernameCheck(inputUsername.value)) {
        inputUsername.classList.add('error');
        return false;
    } else {
        inputUsername.classList.remove('error');
    }

    if (!passwordCheck(inputPassword.value, inputPasswordRepeat.value)) {
        inputPassword.classList.add('error');
        inputPasswordRepeat.classList.add('error');
        return false;
    } else {
        inputPassword.classList.remove('error');
        inputPasswordRepeat.classList.remove('error');
    }
    document.getElementById("registerForm").submit();
    return true;
}

function usernameCheck(username) {
    if (username.length < 3) {
        console.log("Der gewählte Nutzername soll min. drei Zeichen lang sein");
        return false;
    }
    if (usernameExists(username)) {
        console.log("Der gewählte Nutzername darf noch nicht verwendet worden sein");
        return false;
    }
    return true;
}

function passwordCheck(passwordValue, passwordRepeatValue) {
    if (passwordValue.length < 8) {
        console.log("Das Passwort muss min. 8 Zeichen haben");
        return false;
    }
    if (passwordValue !== passwordRepeatValue) {
        console.log("Die Passwörter stimmen nicht überein");
        return false;
    }
    return true;
}



function usernameExists(username) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 204) {
                console.log("Exists");
                return true;
            } else if (xmlhttp.status == 404) {
                console.log("Does not exist");
                return false;
            }
        }
    };
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/2b25b36f-1ef4-4ce3-8020-33b3665241a5/", +inputUsername, true);
    xmlhttp.send();
}