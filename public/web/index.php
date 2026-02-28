<?php
require __DIR__ . '/../config.php';

if (!isset($_SESSION['pass'])) {
    header('Location: /login');
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $getId = (int) $_GET['id'];

    $getUser = $db->prepare('SELECT * FROM users WHERE id = ?');
    $getUser->execute([$getId]);

    if ($getUser->rowCount() > 0) {

        if (isset($_POST['submit']) && !empty($_POST['msg'])) {

            $msg = $_POST['msg'];

            $insertMessage = $db->prepare(
                'INSERT INTO messages(auteur, destinataire, msg)
                 VALUES(?, ?, ?)'
            );

            $insertMessage->execute([
                $_SESSION['id'],
                $getId,
                $msg
            ]);
        }

    } else {
        echo 'Aucun utilisateur trouvé.';
    }

} else {
    echo 'Aucun ID trouvé.';
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="big.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <img src="big.png" alt="logo">
        <ul id="list">
            <li id="buttona"><a href="/">Home</a></li>
            <li id="buttonb"><a href="/logout">Se Déconnecter</a></li>
        </ul>
    </header>
    <div id="chat-container">
    <section id="msgs"></section>
    <form id="chat-form" action="" method="post">
        <textarea name="msg" id="msg" placeholder="Message"></textarea>
        <input type="submit" name="submit" value="Envoyer">
        <script src="app.js"></script>
    </form>
</div>
</body>
</html>