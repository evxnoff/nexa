<?php
session_start();
$isLogged = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nexa - Home</title>

<link rel="stylesheet" href="style.css">

<link rel="shortcut icon" href="big.png">

</head>

<body>

<header>

    <img src="big.png" alt="logo">

    <ul id="list">

        <?php if ($isLogged): ?>

            <li id="buttona">
                <a href="/web/">Chat</a>
            </li>

            <li id="buttona">
                <a href="/profile/">Profil</a>
            </li>

            <li id="buttonb">
                <a href="/logout/">Logout</a>
            </li>

        <?php else: ?>

            <li id="buttona">
                <a href="/login/">Se Connecter</a>
            </li>

            <li id="buttonb">
                <a href="/register/">S'Inscrire</a>
            </li>

        <?php endif; ?>

    </ul>

</header>

</body>

</html>
