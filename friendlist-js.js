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
        listItem.classList.add('d-flex', 'justify-content-between', 'align-items-center');

        const friendLink = document.createElement("a");
        friendLink.textContent = `${friend.username} (${friend.status})`;
        friendLink.href = `chat.php?friend=${encodeURIComponent(friend.username)}`;
        friendLink.classList.add('text-white');

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
        requestItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        const usernameSpan = document.createElement("span");
        usernameSpan.classList.add('flex-grow-1', 'text-start', 'ms-2');
        usernameSpan.innerHTML = `<b>${request.username}</b>`;

        const reviewButton = document.createElement("button");
        reviewButton.classList.add('btn', 'btn-light', 'btn-sm');
        reviewButton.textContent = "Review";
        reviewButton.onclick = () => showFriendRequestModal(request.username);

        requestItem.appendChild(usernameSpan);
        requestItem.appendChild(reviewButton);
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
window.setInterval(loadFriends, 1000);
