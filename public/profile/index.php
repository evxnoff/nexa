
<?php
session_start();
require_once "../../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, avatar, bio, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable";
    exit;
}

$avatar = !empty($user['avatar']) ? "../../uploads/" . $user['avatar'] : "../../uploads/default.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil - Nexa</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="profile-card">

        <img src="<?php echo $avatar; ?>" class="avatar">

        <h2><?php echo htmlspecialchars($user['username']); ?></h2>

        <p class="bio">
            <?php echo !empty($user['bio']) ? htmlspecialchars($user['bio']) : "Aucune bio définie."; ?>
        </p>

        <p class="date">
            Compte créé le :
            <?php echo date("d/m/Y", strtotime($user['created_at'])); ?>
        </p>

        <div class="buttons">
            <a href="edit.php" class="btn">Modifier profil</a>
            <a href="../web/index.php" class="btn secondary">Retour</a>
        </div>

    </div>

</div>

</body>
</html>
