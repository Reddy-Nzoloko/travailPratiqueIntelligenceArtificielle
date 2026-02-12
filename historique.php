<?php
session_start();
require 'db.php';

// Sécurité : Si l'utilisateur n'est pas connecté, on le redirige vers le login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des diagnostics de l'utilisateur (du plus récent au plus ancien)
try {
    $stmt = $pdo->prepare("SELECT * FROM diagnostic WHERE user_id = ? ORDER BY dates DESC");
    $stmt->execute([$user_id]);
    $historique = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEADO - Mon Historique</title>
    <link rel="icon" href="Logo.jpeg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-white italic">MON HISTORIQUE</h1>
                <p class="text-blue-400 text-sm uppercase tracking-widest">Analyses passées pour <?php echo $_SESSION['user_nom']; ?></p>
            </div>
            <a href="index.php" class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2 rounded-xl border border-slate-700 transition flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle Analyse
            </a>
        </div>

        <?php if (empty($historique)): ?>
            <div class="bg-slate-800 border border-dashed border-slate-700 rounded-3xl p-12 text-center">
                <i class="fa-solid fa-folder-open text-5xl text-slate-600 mb-4"></i>
                <p class="text-slate-400">Aucun diagnostic enregistré pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($historique as $diag): ?>
                    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 hover:border-blue-500/50 transition shadow-lg">
                        <div class="flex flex-wrap justify-between items-start gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-blue-600/20 rounded-xl">
                                    <i class="fa-solid fa-file-medical text-blue-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white uppercase">
                                        <?php echo str_replace('_', ' ', $diag['maladies']); ?>
                                    </h3>
                                    <p class="text-xs text-slate-500 italic">
                                        Consulté le <?php echo date('d/m/Y à H:i', strtotime($diag['dates'])); ?>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-[300px]">
                                <p class="text-xs font-bold text-blue-400 uppercase mb-1">Symptômes déclarés :</p>
                                <p class="text-sm text-slate-400 bg-slate-900/50 p-3 rounded-lg border border-slate-700">
                                    <?php echo htmlspecialchars($diag['syntomes_cite']); ?>
                                </p>
                            </div>

                            <button onclick="window.print()" class="text-slate-500 hover:text-white transition">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-12 text-center">
            <a href="logout.php" class="text-red-400 hover:text-red-300 text-sm font-bold">
                <i class="fa-solid fa-power-off mr-2"></i> Déconnexion
            </a>
        </div>
    </div>

</body>
</html>