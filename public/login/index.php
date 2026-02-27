<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=nexa;charset=utf8;', 'root', 'Evanestbg-2013');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

$errors = [];

if (isset($_POST['submit'])) {
    $mail = trim($_POST['mail'] ?? '');

    if (empty($mail)) {
        $errors[] = "Veuillez mettre une adresse E-Mail.";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse E-Mail invalide.";
    } else {
        $stmt = $db->prepare('SELECT id, mail FROM users WHERE mail = :mail LIMIT 1');
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['id'] = $user['id'];
            header('Location: /web');
            exit;
        } else {
            $errors[] = "Adresse E-Mail incorrecte.";
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
    <form action="" method="post" align="center">
        <input type="email" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>" required>
        <br/>
        <input type="submit" name="submit" value="Connexion">
    </form>

    <?php
    if (!empty($errors)) {
        echo '<div class="errors" style="color:red;">';
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        echo '</div>';
    }
    ?>
</body>
</html>