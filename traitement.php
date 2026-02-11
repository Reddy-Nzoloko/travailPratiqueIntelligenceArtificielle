<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intensite = $_POST['intensite'] ?? '';
    $symptomes = $_POST['symptomes'] ?? [];

    // Nettoyage et préparation des faits
    // On commence par appeler effacer_symptomes avant d'ajouter les nouveaux
    $faits = "effacer_symptomes";
    $faits .= ", assert(symptome($intensite))";
    
    foreach ($symptomes as $s) {
        // Sécurité : on nettoie la chaîne pour éviter l'injection de code Prolog
        $s = preg_replace('/[^a-z0-9_]/', '', $s);
        $faits .= ", assert(symptome($s))";
    }

    // LA COMMANDE (Note l'ordre : 1. Nettoyer, 2. Ajouter, 3. Diagnostiquer)
    // Sur Windows, si ça échoue, remplace 'swipl' par le chemin complet : 
    // "C:/Program Files/swipl/bin/swipl.exe"
    $commande = "swipl -s diagnostic.pl -g \"$faits, diagnostic(M, U), format('~w|~w', [M, U]), halt.\" 2>&1";
    
    $output = shell_exec($commande);

    if ($output && strpos($output, '|') !== false) {
        // On récupère uniquement la dernière ligne au cas où Prolog affiche des warnings
        $lines = explode("\n", trim($output));
        $lastLine = end($lines);
        list($maladie, $urgence) = explode('|', $lastLine);
    } else {
        $maladie = "Inconnu";
        $urgence = "Symptômes insuffisants ou erreur de communication avec le moteur Prolog ($output).";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat SEADO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full bg-slate-800/50 backdrop-blur-xl border border-slate-700 rounded-3xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01]">
        
        <?php 
            $isUrgent = (strpos(strtolower($maladie), 'fracture') !== false || strpos(strtolower($maladie), 'luxation') !== false);
            $headerColor = $isUrgent ? "from-red-600 to-orange-600" : "from-blue-600 to-cyan-600";
        ?>
        <div class="bg-gradient-to-r <?php echo $headerColor; ?> p-8 text-center relative">
            <div class="absolute top-4 right-4 opacity-20 text-6xl">
                <i class="fa-solid fa-stethoscope"></i>
            </div>
            <h2 class="text-sm uppercase tracking-[0.2em] font-semibold text-white/80">Analyse Terminée</h2>
            <p class="text-3xl font-black mt-2 text-white">Résultat du Diagnostic</p>
        </div>

        <div class="p-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="p-3 bg-slate-700 rounded-2xl">
                    <i class="fa-solid fa-notes-medical text-2xl <?php echo $isUrgent ? 'text-red-400' : 'text-blue-400'; ?>"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm uppercase font-bold tracking-tighter">Pathologie suspectée</p>
                    <h3 class="text-2xl font-bold text-white"><?php echo str_replace('_', ' ', ucfirst($maladie)); ?></h3>
                </div>
            </div>

            <div class="bg-slate-900/50 border border-slate-700 p-5 rounded-2xl mb-8">
                <div class="flex items-start space-x-3">
                    <i class="fa-solid fa-circle-info mt-1 text-blue-400"></i>
                    <div>
                        <p class="text-sm font-semibold text-slate-300">Recommandation :</p>
                        <p class="text-slate-400 text-sm leading-relaxed mt-1 italic">
                            "<?php echo $urgence; ?>"
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="index.php" class="flex items-center justify-center space-x-2 bg-slate-700 hover:bg-slate-600 text-white py-3 rounded-xl transition font-medium">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Retour</span>
                </a>
                <button onclick="window.print()" class="flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl transition font-medium shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span>Imprimer</span>
                </button>
            </div>
        </div>

        <div class="bg-slate-900/80 p-4 text-center border-t border-slate-700">
            <p class="text-[10px] text-slate-500 uppercase tracking-widest">
                Avertissement : Ce résultat est généré par une IA et ne remplace pas un avis médical.
            </p>
        </div>
    </div>

</body>
</html>