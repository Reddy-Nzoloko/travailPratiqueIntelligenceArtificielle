<?php
// 1. INCLURE LA CONNEXION EN PREMIER
require 'db.php'; 

$message = "";
$messageType = "";

// 2. VÉRIFIER SI LE FORMULAIRE A ÉTÉ SOUMIS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password_brut = $_POST['password']; // On récupère le mot de passe du formulaire

    if (!empty($nom) && !empty($email) && !empty($password_brut)) {
        
        // 3. HACHAGE DU MOT DE PASSE
        $passwordHash = password_hash($password_brut, PASSWORD_DEFAULT);

        try {
            // Utilisation de la variable $pdo qui vient de db.php
            $stmt = $pdo->prepare("INSERT INTO users (nom, emails, passwod) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $passwordHash]);
            
            $message = "Compte créé avec succès !";
            $messageType = "success";
            header("refresh:2;url=login.php");
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "Cet email est déjà utilisé.";
                $messageType = "error";
            } else {
                $message = "Erreur : " . $e->getMessage();
                $messageType = "error";
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SEADO - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="Logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-2xl">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold italic">REJOINDRE SEADO</h2>
            <p class="text-slate-400 text-sm">Créez votre profil médical sécurisé</p>
        </div>

        <?php if($message): ?>
            <div class="mb-4 p-3 rounded-xl text-sm <?php echo $messageType == 'success' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="nom" placeholder="Nom complet" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="email" name="email" placeholder="Email" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="password" name="password" placeholder="Mot de passe" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-3 rounded-xl font-bold transition">
                S'INSCRIRE
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="login.php" class="text-blue-400 hover:underline">Déjà un compte ? Se connecter</a>
        </div>
    </div>

</body>
</html>