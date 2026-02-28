<?php
session_start();
require __DIR__ . '/../config.php';
if (isset($_POST['submit'])) {
    if (!empty($_POST['mail']) AND !empty($_POST['pass'])) {
        $mail = htmlspecialchars($_POST['mail']);
        $pass = sha1($_POST['pass']);

        $getUser = $db->prepare('SELECT * FROM users WHERE mail = ? AND pass = ?');
        $getUser->execute(array($mail, $pass));

        if ($getUser->rowCount() > 0) {
            $_SESSION['mail'] = $mail;
            $_SESSION['pass'] = $pass;
            $_SESSION['id'] = $getUser->fetch()['id'];
            header('Location: /web');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexa - Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1 id="title">Nexa</h1>
        <ul id="list">
            <li id="buttona"><a href="/login">Se Connecter</a></li>
            <li id="buttonb"><a href="/register">S'Inscrire</a></li>
        </ul>
    </header>
    <form action="" method="post" align="center">
        <input type="email" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>" required>
        <br/>
        <input type="password" autocomplete="off" name="pass" required>
        <br/>
        <input type="submit" name="submit" value="Connexion">
    </form>
</body>
</html>