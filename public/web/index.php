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
</head>
<body>
    <header>
        <img src="big.png" alt="logo">
        <ul id="list">
            <li id="buttona"><a href="/">Home</a></li>
            <li id="buttonb"><a href="/logout">Se Déconnecter</a></li>
        </ul>
    </header>
    <form action="" method="post">
        <textarea name="msg" id="msg" placeholder="Message"></textarea>
        <br/>
        <input type="submit" name="submit">
    </form>
    <section id="msgs">

    </section>
</body>
</html>