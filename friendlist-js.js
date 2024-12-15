async function loadFriends() {
    const apiUrl = "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/friend";
    const token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDcyNTY5fQ.xrVdNNz_5cJPysY1sr6Cromp8WrMQnkmJqx5HX44esM';

    try {
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Authorization': token,
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Failed to fetch friends: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        console.log("Friends Data:", data);

        // Separate friends and requests
        const friends = data.filter(entry => entry.status === "accepted");
        const friendRequests = data.filter(entry => entry.status === "requested");

        // Update the DOM
        updateFriendList(friends);
        updateFriendRequests(friendRequests);
    } catch (error) {
        console.error("Error loading friends:", error);
    }
}

// Update Friends List
function updateFriendList(friends) {
    const friendListParent = document.getElementById("friendlist");
    friendListParent.innerHTML = ""; // Clear existing content

    friends.forEach(friend => {
        const friendItem = document.createElement('li');
        friendItem.classList.add('friend');

        const friendLink = document.createElement('a');
        friendLink.textContent = `${friend.username} (${friend.unread})`; // Display username and unread messages
        friendLink.href = `chat.html?friend=${encodeURIComponent(friend.username)}`; // Chat link

        friendItem.appendChild(friendLink);
        friendListParent.appendChild(friendItem);
    });
}

// Update Friend Requests
function updateFriendRequests(friendRequests) {
    const friendRequestParent = document.getElementById("friendRequests");
    friendRequestParent.innerHTML = ""; // Clear existing content

    friendRequests.forEach(request => {
        const requestItem = document.createElement('li');
        requestItem.innerHTML = `Friend request from <b>${request.username}</b>
            <button type="button" onclick="acceptRequest('${request.username}')">Accept</button>
            <button type="button" onclick="rejectRequest('${request.username}')">Reject</button>`;

        friendRequestParent.appendChild(requestItem);
    });
}

//rejecting function
async function rejectRequest(username) {
    console.log(`Reject request for ${username}`);

    // Locate and remove the request from the DOM
    const friendRequestParent = document.getElementById("friendRequests");
    const requestItems = friendRequestParent.getElementsByTagName("li");

    for (let item of requestItems) {
        if (item.textContent.includes(username)) {
            friendRequestParent.removeChild(item); // Remove the request from the list
            break;
        }
    }

    // Optional: Notify the backend
    const apiUrl = "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/friend";
    const token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDcyNTY5fQ.xrVdNNz_5cJPysY1sr6Cromp8WrMQnkmJqx5HX44esM';

    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: {
                'Authorization': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username })
        });

        if (response.ok) {
            console.log(`Friend request from ${username} successfully rejected.`);
        } else {
            throw new Error(`Failed to reject request: ${response.status}`);
        }
    } catch (error) {
        console.error(`Error rejecting friend request for ${username}:`, error);
    }
}

async function acceptRequest(username) {
    
    const apiUrl = "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/friend";
    const token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDcyNTY5fQ.xrVdNNz_5cJPysY1sr6Cromp8WrMQnkmJqx5HX44esM';

    const friendRequestParent = document.getElementById("friendRequests");
    const requestItems = friendRequestParent.getElementsByTagName("li");

    for (let item of requestItems) {
        if (item.textContent.includes(username)) {
            friendRequestParent.removeChild(item); // Remove the request from the list
            break;
        }
    } 


    

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Authorization': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username })
        });

        if (response.status === 204) {
            console.log(`Friend request for ${username} accepted.`);
            loadFriends(); // Refresh the friends list
        } else {
            throw new Error(`Failed to accept friend request: ${response.status}`);
        }
    } catch (error) {
        console.error(`Error accepting request for ${username}:`, error);
    }
}



async function addFriend() {
    const apiUrl = "https://online-lectures-cs.thi.de/chat/54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb/friend";
    const token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzMyNDcyNTY5fQ.xrVdNNz_5cJPysY1sr6Cromp8WrMQnkmJqx5HX44esM';

    const input = document.getElementById("addfriend");
    const username = input.value.trim();

    if (!username) {
        alert("Please enter a username.");
        return;
    }

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Authorization': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username })
        });

        if (response.status === 204) {
            console.log(`Friend request sent to ${username}`);
            input.value = ""; // Clear input field
            loadFriends(); // Refresh the friends list
        } else {
            throw new Error(`Failed to send friend request: ${response.status}`);
        }
    } catch (error) {
        console.error(`Error adding friend ${username}:`, error);
    }
}

loadFriends();
setInterval(loadFriends, 1000);