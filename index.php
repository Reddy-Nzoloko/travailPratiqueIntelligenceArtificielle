<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEADO - Expert Orthopédie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="Logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full bg-slate-800 rounded-3xl shadow-2xl border border-slate-700 overflow-hidden">
        
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-8 text-center relative">
            <div class="absolute top-4 right-6 opacity-10 text-6xl">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <i class="fa-solid fa-bone text-4xl mb-2 text-white"></i>
            <h1 class="text-3xl font-black uppercase tracking-tighter text-white">Système SEADO</h1>
            <p class="text-blue-100 text-sm font-medium opacity-80">Assistant intelligent de diagnostic orthopédique</p>
        </div>

        <form action="traitement.php" method="POST" class="p-8 space-y-8">
            
            <div class="space-y-3">
                <label class="block text-sm font-bold text-blue-400 uppercase tracking-widest">Décrivez votre douleur (Texte libre)</label>
                <div class="relative">
                    <i class="fa-solid fa-keyboard absolute left-4 top-4 text-slate-500"></i>
                    <textarea name="autre_symptome" rows="2" 
                        placeholder="Ex: J'ai des engourdissements au bras et une forte fièvre..." 
                        class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 outline-none transition placeholder:text-slate-600"></textarea>
                </div>
                <p class="text-xs text-slate-500 italic">Notre IA détectera automatiquement les mots-clés dans votre description.</p>
            </div>

            <hr class="border-slate-700/50">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold mb-2 text-blue-400 uppercase tracking-widest">Zone touchée</label>
                    <select name="zone" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none appearance-none cursor-pointer">
                        <option value="" selected>-- Non spécifié --</option>
                        <option value="genou">Genou</option>
                        <option value="cheville">Cheville</option>
                        <option value="bras">Bras / Coude</option>
                        <option value="dos">Dos / Colonne</option>
                        <option value="main">Main / Poignet</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2 text-blue-400 uppercase tracking-widest">Intensité</label>
                    <select name="intensite" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none appearance-none cursor-pointer">
                        <option value="" selected>-- Non spécifiée --</option>
                        <option value="douleur_faible">Faible (Gênant)</option>
                        <option value="douleur_moderee">Modérée (Supportable)</option>
                        <option value="douleur_intense">Intense (Insoutenable)</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-bold text-blue-400 uppercase tracking-widest">Signes Cliniques Observés</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="flex items-center space-x-3 bg-slate-900/40 border border-slate-700/50 p-4 rounded-xl cursor-pointer hover:bg-slate-700 transition group">
                        <input type="checkbox" name="symptomes[]" value="gonflement" class="w-5 h-5 rounded border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-800">
                        <span class="text-slate-300 group-hover:text-white transition">Gonflement / Œdème</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 bg-slate-900/40 border border-slate-700/50 p-4 rounded-xl cursor-pointer hover:bg-slate-700 transition group">
                        <input type="checkbox" name="symptomes[]" value="traumatisme_recent" class="w-5 h-5 rounded border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-800">
                        <span class="text-slate-300 group-hover:text-white transition">Chute ou choc récent</span>
                    </label>

                    <label class="flex items-center space-x-3 bg-slate-900/40 border border-slate-700/50 p-4 rounded-xl cursor-pointer hover:bg-slate-700 transition group">
                        <input type="checkbox" name="symptomes[]" value="deformation_osseuse" class="w-5 h-5 rounded border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-800">
                        <span class="text-slate-300 group-hover:text-white transition">Déformation visible</span>
                    </label>

                    <label class="flex items-center space-x-3 bg-slate-900/40 border border-slate-700/50 p-4 rounded-xl cursor-pointer hover:bg-slate-700 transition group">
                        <input type="checkbox" name="symptomes[]" value="craquement" class="w-5 h-5 rounded border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-800">
                        <span class="text-slate-300 group-hover:text-white transition">Bruit de craquement</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-900/20 transform transition hover:scale-[1.02] active:scale-95 flex items-center justify-center space-x-3">
                <i class="fa-solid fa-microchip"></i>
                <span>LANCER LE PRÉ-DIAGNOSTIC</span>
            </button>
        </form>

        <div class="bg-slate-900/50 p-4 text-center border-t border-slate-700">
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.2em]">Outil d'aide à la décision médicale RedDev</p>
        </div>
    </div>

</body>
</html>  