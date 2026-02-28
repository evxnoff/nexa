function loadMessages() {
    const userId = new URLSearchParams(window.location.search).get('id');
    $('#msgs').load('loadMessage.php?id=' + userId);
}

setInterval(loadMessages, 500);