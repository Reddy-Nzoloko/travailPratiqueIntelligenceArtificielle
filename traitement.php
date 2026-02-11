<?php
// On initialise les variables pour l'affichage
$maladie = "";
$urgence = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupération des données du formulaire
    $intensite = $_POST['intensite'] ?? '';
    $zone = $_POST['zone'] ?? '';
    $symptomes = $_POST['symptomes'] ?? [];
    $autre = isset($_POST['autre_symptome']) ? strtolower(trim($_POST['autre_symptome'])) : "";

    // 2. Initialisation de la variable $faits (CORRECTION DE L'ERREUR)
    // On commence toujours par nettoyer la base Prolog
    $faits = "effacer_symptomes";

    // 3. Ajout de l'intensité (si non vide)
    if (!empty($intensite)) {
        $faits .= ", assert(symptome($intensite))";
    }

    // 4. Ajout de la zone (si non vide)
    if (!empty($zone)) {
        $faits .= ", assert(symptome($zone))";
    }
    
    // 5. Ajout des symptômes cochés (checkboxes)
    foreach ($symptomes as $s) {
        $s_clean = preg_replace('/[^a-z0-9_]/', '', $s);
        $faits .= ", assert(symptome($s_clean))";
    }

    // 6. Analyse du texte libre (NLP simplifié)
    if (!empty($autre)) {
        $mots_cles = ['engourdissement', 'froid', 'fievre', 'bleu', 'craquement', 'blocage_articulaire', 'raideur_matinale'];
        foreach ($mots_cles as $mot) {
            if (strpos($autre, $mot) !== false) {
                $faits .= ", assert(symptome($mot))";
            }
        }
    }

    // 7. Exécution de la commande SWI-Prolog
    $commande = "swipl -s diagnostic.pl -g \"$faits, diagnostic(M, U), format('~w|~w', [M, U]), halt.\" 2>&1";
    $output = shell_exec($commande);

    // 8. Analyse du résultat envoyé par Prolog
    if ($output && strpos($output, '|') !== false) {
        $lines = explode("\n", trim($output));
        $lastLine = trim(end($lines)); 
        
        if (strpos($lastLine, '|') !== false) {
            list($mal_raw, $urg_raw) = explode('|', $lastLine);
            $maladie = ucfirst(str_replace('_', ' ', $mal_raw));
            $urgence = $urg_raw;
        }
    } else {
        $maladie = "Indéterminée";
        $urgence = "Symptômes insuffisants pour un diagnostic automatique. Une consultation est recommandée.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat SEADO</title>
    <link rel="icon" href="Logo.jpeg" type="image/x-icon">
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