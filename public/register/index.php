<?php
require __DIR__ . '/../config.php';

$errors = [];
$success = '';

if (isset($_POST["submit"])) {
    $mail = trim($_POST["mail"] ?? '');
    $pass = trim($_POST["pass"] ?? '');

    if (empty($mail) || empty($pass)) {
        $errors[] = 'Veuillez compléter tous les champs.';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse e-mail invalide.';
    } else {
        $stmt = $db->prepare('SELECT id FROM users WHERE mail = ?');
        $stmt->execute([$mail]);
        if ($stmt->fetch()) {
            $errors[] = 'Cette adresse e-mail est déjà utilisée.';
        } else {
            $hash = sha1($pass);
            $insertUser = $db->prepare('INSERT INTO users(mail, pass) VALUES (?, ?)');
            $insertUser->execute([$mail, $hash]);

            $getUser = $db->prepare('SELECT * FROM users WHERE mail = ? AND pass = ?');
            $getUser->execute([$mail, $hash]);
            $user = $getUser->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $_SESSION['mail'] = $user['mail'];
                $_SESSION['id'] = $user['id'];
                header('Location: /web');
                exit;
            } else {
                $errors[] = 'Erreur lors de la connexion automatique.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexa - Inscription</title>
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
        <input type="email" name="mail" autocomplete="off" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>" required>
        <br/>
        <input type="password" autocomplete="off" name="pass" required>
        <br/>
        <input type="submit" name="submit" value="Inscription">
    </form>

    <?php
    foreach ($errors as $error) {
        echo '<p style="color:red;">'.htmlspecialchars($error).'</p>';
    }
    if ($success) {
        echo '<p style="color:green;">'.htmlspecialchars($success).'</p>';
    }
    ?>
</body>
</html>