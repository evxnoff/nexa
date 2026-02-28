<?php
require __DIR__ . '/../config.php';

if (!isset($_SESSION['id'])) exit;

if (!isset($_GET['id'])) exit;
$getId = (int) $_GET['id'];

$getMessage = $db->prepare(
    'SELECT messages.*, users.pseudo
     FROM messages
     JOIN users ON users.id = messages.auteur
     WHERE (messages.auteur = ? AND messages.destinataire = ?)
        OR (messages.auteur = ? AND messages.destinataire = ?)
     ORDER BY messages.id ASC'
);

$getMessage->execute([$_SESSION['id'], $getId, $getId, $_SESSION['id']]);

while ($message = $getMessage->fetch()) {
    $auteur = ($message['auteur'] == $_SESSION['id']) ? "Moi" : htmlspecialchars($message['pseudo']);
    ?>
    <div class="message <?= ($message['auteur'] == $_SESSION['id']) ? 'moi' : '' ?>">
    <h4><?= ($message['auteur'] == $_SESSION['id']) ? 'Moi' : htmlspecialchars($message['pseudo']); ?></h4>
    <p><?= htmlspecialchars($message['msg']); ?></p>
</div>
    <?php
}
?>