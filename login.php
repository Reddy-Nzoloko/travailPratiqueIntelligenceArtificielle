<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE emails = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // password_verify() compare le texte clair avec le hash de la BDD
    if ($user && password_verify($password, $user['passwod'])) { 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SEADO - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="Logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-2xl">
        <div class="text-center mb-6">
            <i class="fa-solid fa-lock text-blue-500 text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold">Connexion SEADO</h2>
            <p class="text-slate-400 text-sm">Accédez à votre historique médical</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded-xl text-sm mb-4">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="password" name="password" placeholder="Mot de passe" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                Se connecter
            </button>
        </form>

        <div class="mt-6 text-center border-t border-slate-700 pt-4">
            <p class="text-slate-400 text-sm">Pas encore de compte ? 
                <a href="register.php" class="text-blue-400 font-bold hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>
</body>
</html>