<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEADO - Expert Orthopédie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <i class="fa-solid fa-bone text-4xl mb-2"></i>
            <h1 class="text-2xl font-bold uppercase tracking-wider">Système SEADO</h1>
            <p class="text-blue-100 text-sm">Assistant intelligent de diagnostic orthopédique</p>
        </div>

        <form action="traitement.php" method="POST" class="p-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="autre_symptome" placeholder="Ex: engourdissement, froid, bleu..." class="w-full bg-slate-700 border-slate-600 rounded-lg p-2">
                    <label class="block text-sm font-medium mb-2 text-blue-400">Zone Douloureuse</label>
                    <select name="zone" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="genou">Genou</option>
                        <option value="cheville">Cheville</option>
                        <option value="bras">Bras / Coude</option>
                        <option value="dos">Dos / Colonne</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-blue-400">Intensité Douleur</label>
                    <select name="intensite" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="douleur_faible">Faible</option>
                        <option value="douleur_moderee">Modérée</option>
                        <option value="douleur_intense">Intense / Insoutenable</option>
                    </select>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-medium mb-2 text-blue-400">Signes Cliniques</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="flex items-center space-x-3 bg-slate-700 p-3 rounded-lg cursor-pointer hover:bg-slate-600 transition">
                        <input type="checkbox" name="symptomes[]" value="gonflement" class="form-checkbox h-5 w-5 text-blue-500">
                        <span>Gonflement / Œdème</span>
                    </label>
                    <label class="flex items-center space-x-3 bg-slate-700 p-3 rounded-lg cursor-pointer hover:bg-slate-600 transition">
                        <input type="checkbox" name="symptomes[]" value="traumatisme_recent" class="form-checkbox h-5 w-5 text-blue-500">
                        <span>Chute ou choc récent</span>
                    </label>
                    <label class="flex items-center space-x-3 bg-slate-700 p-3 rounded-lg cursor-pointer hover:bg-slate-600 transition">
                        <input type="checkbox" name="symptomes[]" value="deformation_osseuse" class="form-checkbox h-5 w-5 text-blue-500">
                        <span>Déformation visible</span>
                    </label>
                    <label class="flex items-center space-x-3 bg-slate-700 p-3 rounded-lg cursor-pointer hover:bg-slate-600 transition">
                        <input type="checkbox" name="symptomes[]" value="craquement" class="form-checkbox h-5 w-5 text-blue-500">
                        <span>Bruit de craquement</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-lg shadow-lg transform transition hover:scale-[1.02] active:scale-95">
                Analyser les symptômes
            </button>
        </form>
    </div>

</body>
</html>