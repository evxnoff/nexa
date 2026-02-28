function scrollToBottomIfAtBottom() {
    const container = document.getElementById('msgs');
    // Vérifie si on est proche du bas (10px de marge)
    const atBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 10;
    if (atBottom) {
        container.scrollTop = container.scrollHeight;
    }
}

function loadMessages() {
    const userId = new URLSearchParams(window.location.search).get('id');
    $('#msgs').load('loadMessage.php?id=' + userId, scrollToBottomIfAtBottom);
}

// Rafraîchissement toutes les 500ms
setInterval(loadMessages, 500);