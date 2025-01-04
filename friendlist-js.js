async function loadFriends() {
    const apiUrl = "ajax_load_friends.php";
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error(`Failed to fetch friends: ${response.statusText}`);
        const data = await response.json();

        const friends = data.filter(friend => friend.status === "accepted");
        const friendRequests = data.filter(friend => friend.status === "requested");

        updateFriendList(friends);
        updateFriendRequests(friendRequests);
    } catch (error) {
        console.error("Error loading friends:", error);
    }
}

function updateFriendList(friends) {
    const friendListElement = document.getElementById("friendlist");
    friendListElement.innerHTML = "";

    friends.forEach(friend => {
        const listItem = document.createElement("li");
        listItem.classList.add('friend');

        const friendLink = document.createElement("a");
        friendLink.textContent = `${friend.username} (${friend.status})`;
        friendLink.href = `chat.php?friend=${encodeURIComponent(friend.username)}`;

        listItem.appendChild(friendLink);
        friendListElement.appendChild(listItem);
    });
}




function updateFriendRequests(friendRequests) {
    const requestsElement = document.getElementById("friendRequests");
    requestsElement.innerHTML = "";

    friendRequests.forEach(request => {
        const listItem = document.createElement("li");
        listItem.innerHTML = `
            Friend request from <b>${request.username}</b>
            <button onclick="acceptRequest('${request.username}')">Accept</button>
            <button onclick="rejectRequest('${request.username}')">Reject</button>
        `;
        requestsElement.appendChild(listItem);
    });
}

async function addFriend() {
    const input = document.getElementById("addfriend");
    const username = input.value.trim();
    if (!username) {
        alert("Please enter a username.");
        return;
    }

    try {
        const response = await fetch(`ajax_friend_action.php?action=add&friend=${encodeURIComponent(username)}`, {
            method: "POST"
        });
        if (response.status !== 204) throw new Error(`Failed to add friend: ${response.statusText}`);
        input.value = "";
        loadFriends();
    } catch (error) {
        console.error(`Error adding friend ${username}:`, error);
    }
}

async function acceptRequest(username) {
    try {
        const response = await fetch(`ajax_friend_action.php?action=accept&friend=${encodeURIComponent(username)}`, {
            method: "POST"
        });
        if (response.status !== 204) throw new Error(`Failed to accept friend request: ${response.statusText}`);
        loadFriends();
    } catch (error) {
        console.error(`Error accepting request for ${username}:`, error);
    }
}

async function rejectRequest(username) {
    try {
        const response = await fetch(`ajax_friend_action.php?action=dismiss&friend=${encodeURIComponent(username)}`, {
            method: "POST"
        });
        if (response.status !== 204) throw new Error(`Failed to reject friend request: ${response.statusText}`);
        loadFriends();
    } catch (error) {
        console.error(`Error rejecting friend request for ${username}:`, error);
    }
}

document.addEventListener("DOMContentLoaded", loadFriends);
window.setInterval(function() {
    loadFriends();
}, 1000);

loadFriends();