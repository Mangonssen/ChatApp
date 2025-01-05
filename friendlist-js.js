async function loadFriends() {
    try {
        const response = await fetch("ajax_load_friends.php");
        if (!response.ok) throw new Error("Failed to load friends");

        const data = await response.json();
        console.log("Friends Data:", data);

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



function showFriendRequestModal(username) {
    const modal = new bootstrap.Modal(document.getElementById('friendRequestModal'));
    const friendRequestText = document.getElementById('friendRequestText');
    const acceptButton = document.getElementById('acceptButton');
    const rejectButton = document.getElementById('rejectButton');


    friendRequestText.innerHTML = `Do you want to accept the friend request from <b>${username}</b>?`;


    acceptButton.onclick = () => {
        acceptRequest(username);
        modal.hide();
    };

    rejectButton.onclick = () => {
        rejectRequest(username);
        modal.hide();
    };

 
    modal.show();
}


function updateFriendRequests(friendRequests) {
    const friendRequestParent = document.getElementById("friendRequests");
    friendRequestParent.innerHTML = "";

    friendRequests.forEach(request => {
        const requestItem = document.createElement("li");
        requestItem.innerHTML = `
            Friend request from <b>${request.username}</b>
            <button class="btn btn-primary btn-sm" onclick="acceptRequest('${request.username}')">Accept</button>
            <button class="btn btn-danger btn-sm" onclick="rejectRequest('${request.username}')">Reject</button>
        `;
        friendRequestParent.appendChild(requestItem);
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