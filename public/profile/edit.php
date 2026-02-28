<?php
session_start();
require_once "../../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT bio FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bio = trim($_POST['bio']);
    $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt->execute([$bio, $user_id]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier profil - Nexa</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="profile-card">
        <h2>Modifier profil</h2>
        <form method="POST">
            <label>Bio :</label>
            <textarea name="bio" maxlength="250"><?php echo htmlspecialchars($user['bio']); ?></textarea>
            <button type="submit" class="btn">Sauvegarder</button>
        </form>
        <a href="index.php" class="btn secondary">Annuler</a>
    </div>
</div>

</body>
</html>
