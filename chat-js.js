const chatContainer = document.getElementById("chat");

// Function to check if the session is active
function checkSession(callback) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log("Session is active");
                callback(); // Proceed only if session is active
            } else if (xmlhttp.status === 401) {
                console.warn("Session expired. Redirecting to login...");
                window.location.href = "login.php"; // Redirect to login if session expired
            }
        }
    };
    xmlhttp.open("GET", "check_session.php", true); // Endpoint to validate session
    xmlhttp.send();
}

// Function to check if the chat partner is still a friend
function checkFriendship(callback) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                const friends = JSON.parse(xmlhttp.responseText);
                const isFriend = friends.some(friend => friend.username === getChatpartner());
                if (!isFriend) {
                    console.warn("Not friends anymore. Redirecting to friends list...");
                    window.location.href = "friends.php"; // Redirect to friends list if not friends
                } else {
                    callback(); // Proceed if still friends
                }
            } else {
                console.error("Failed to check friendship");
            }
        }
    };
    xmlhttp.open("GET", "friends.php?checkFriendshipWith=", true); // Endpoint to fetch friend list
    xmlhttp.setRequestHeader('Authorization', getToken());
    xmlhttp.send();
}

// Function to load messages from the server
function getMessageArray(callback) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            const data = JSON.parse(xmlhttp.responseText);
            console.log("Messages received:", data);
            callback(data); // Render messages
        }
    };
    xmlhttp.open("GET", `ajax_load_messages.php?to=${getChatpartner()}`, true); // Endpoint for loading messages
    xmlhttp.setRequestHeader('Authorization', getToken());
    xmlhttp.send();
}

// Render chat title
function renderTitle() {
    const titleContainer = document.getElementById("chat-title");
    titleContainer.innerHTML = ""; // Clear old title
    const title = document.createElement("div");
    title.classList.add("chat-title");
    title.innerHTML = `
        <img src="chatbubble.png" alt="chat" class="title-icon">
        <h1>Chat with ${getChatpartner()}</h1>
    `;
    titleContainer.appendChild(title);
}

// Render chat messages
function renderChat(data) {
    chatContainer.innerHTML = ""; // Clear old messages
    data.forEach(item => {
        const bubble = document.createElement("div");
        bubble.classList.add("chat-bubble");

        const date = new Date(item.time); // Convert timestamp to Date object

        bubble.innerHTML = `
            <span class="chat-name">${item.from}</span>
            <span class="chat-text">${item.msg}</span>
            <span class="chat-time">${date.toLocaleTimeString()}</span>
        `;
        chatContainer.appendChild(bubble);
    });
}

// Event listener for sending messages
document.getElementById("sendButton").addEventListener("click", sendMessage);

function sendMessage(e) {
    e.preventDefault();

    const inputMessage = document.querySelector("input[name='msg']");
    const msgContent = inputMessage.value;

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 204) {
                console.log("Message sent successfully");
                refreshChat(); // Reload chat after sending
            } else {
                console.error("Failed to send message");
            }
        }
    };

    xmlhttp.open("POST", "ajax_send_message.php", true); // Endpoint for sending messages
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', getToken());

    const data = JSON.stringify({
        message: msgContent,
        to: getChatpartner()
    });

    xmlhttp.send(data);
    inputMessage.value = ""; // Clear input field
}

// Helper function to get the chat partner from the URL
function getChatpartner() {
    const url = new URL(window.location.href);
    return url.searchParams.get("friend") || "Unknown";
}

// Helper function to get the user's token
function getToken() {
    return `Bearer ${sessionStorage.getItem("chat_token")}`; // Retrieve token from sessionStorage
}

// Refresh chat messages
function refreshChat() {
    getMessageArray(renderChat); // Refresh chat without redirect
}

// Initial rendering and chat load
renderTitle();
refreshChat(); // Initially load chat without checking session and friendship immediately

// Delayed session and friendship check
setTimeout(() => {
    checkSession(() => { // First, check if session is active
        checkFriendship(() => { // Then, check if still friends
            console.log("Session is valid and the user is still friends");
        });
    });
}, 1000); // Delaying session and friendship checks by 1 second after initial load

// Periodic refresh and checks
setInterval(() => {
    checkSession(() => { // First, check if session is active
        refreshChat(); // Reload chat if session is valid and still friends
        // checkFriendship(() => { // Then, check if still friends
        //     refreshChat(); // Reload chat if session is valid and still friends
        // });
    });
}, 5000); // Refresh chat every 5 seconds and check periodically
