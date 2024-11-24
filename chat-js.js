const chatContainer = document.getElementById("chat");

// Funktion, um die Nachrichten vom Server zu laden
function getMessageArray(callback) {
    var xmlhttp = new XMLHttpRequest(); // Neue HTTP Request
    xmlhttp.onreadystatechange = function () { // Event-Handler für Statusänderungen
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // Wenn Request abgeschlossen und erfolgreich
            let data = JSON.parse(xmlhttp.responseText); // Antwort als JSON interpretieren
            
            console.log("Daten gespeichert: ", data); // Ausgabe der Antwort
            callback(data); // Callback aufrufen und die Daten übergeben
        }
    };
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/message/Jerry", true); // GET-Request an Server
    // Add token, e. g., from Tom
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyMzYzNTM1fQ._zPv9T05PVRUlkKmxCc3_tMXD5nTzN6EzO8eRDY60SE');
    xmlhttp.send();  // Request senden
}

function renderTitle() {
    const titleContainer = document.getElementById("chat-title");
    const title = document.createElement("div");
    title.classList.add("chat-title");

    title.innerHTML = `
        <img src="chatbubble.png" alt="chat" class="title-icon">
        <h1>Chat mit ${getChatpartner()}</h1>
    `;

    titleContainer.appendChild(title);
}

function renderChat(data) {
    
    const chatContainer = document.getElementById("chat");


    data.forEach(item => {

        const bubble = document.createElement("div");
        bubble.classList.add("chat-bubble");

        const date = new Date(item.time); // Konvertierung

        bubble.innerHTML = `
            <span class="chat-name">${item.from}</span>
            <span class="chat-text">${item.msg}</span>
            <span class="chat-time">${date.toISOString()}</span>
        `;

        
        chatContainer.appendChild(bubble);
    });


}

// Event Listener
document.getElementById("sendButton").addEventListener("click", sendMessage);



function sendMessage(e) {

    e.preventDefault();

    const inputMessage = document.querySelector("input[name='msg']");
    const msgContent = inputMessage.value;


    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
            console.log("Successfully sent message...");
            refreshChat();
        } else if (xmlhttp.readyState == 4) {
            console.error("Failed to send message :(");
        }
    };

    xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/message", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyMzYzNTM1fQ._zPv9T05PVRUlkKmxCc3_tMXD5nTzN6EzO8eRDY60SE');

    let data = {
        message: msgContent,
        to: getChatpartner()
    };

    let jsonString = JSON.stringify(data); // Serialize as JSON
    xmlhttp.send(jsonString); // Send JSON-data to server

    inputMessage.value = "";
}


function getChatpartner() {
    const url = new URL(window.location.href);
    // Access the query parameters using searchParams
    const queryParams = url.searchParams;
    // Retrieve the value of the "friend" parameter
    const friendValue = queryParams.get("friend");
    console.log("Friend:", friendValue);
    return friendValue;
}

function refreshChat() {
    const chatContainer = document.getElementById("chat");
    chatContainer.innerHTML = "";

    getMessageArray(renderChat);
}


renderTitle();

refreshChat();

setInterval(refreshChat, 1000); // Chat alle 1000ms aktualisieren



