% =================================================================
% SEADO PRO - Système Expert d'Aide au Diagnostic en Orthopédie
% =================================================================

:- dynamic symptome/1.

% --- LOGIQUE DE DIAGNOSTIC ---

% 1. FRACTURE (Très robuste : traumatisme + (douleur OU déformation OU craquement))
diagnostic(fracture, 'URGENT : Immobilisation immédiate. Fracture suspectée, radiographie indispensable.') :- 
    symptome(traumatisme_recent),
    (symptome(douleur_intense) ; symptome(deformation_osseuse) ; symptome(craquement)),
    (symptome(gonflement) ; symptome(douleur_intense)).

% 2. LUXATION (Spécifique au blocage)
diagnostic(luxation, 'URGENT : Déplacement de l''articulation. Ne tentez pas de remettre l''os en place.') :-
    symptome(traumatisme_recent),
    (symptome(deformation_osseuse) ; symptome(blocage_articulaire)).

% 3. ENTORSE (Si traumatisme mais pas de fracture confirmée)
diagnostic(entorse, 'MODÉRÉ : Entorse suspectée. Appliquez de la glace et du repos (RICE).') :- 
    symptome(traumatisme_recent),
    symptome(gonflement),
    \+ diagnostic(fracture, _),
    \+ diagnostic(luxation, _).

% 4. HERNIE DISCALE (Spécifique à la zone DOS)
diagnostic(hernie_discale, 'SPECIALISTE : Douleur lombaire avec possible pincement nerveux.') :-
    symptome(dos),
    (symptome(douleur_intense) ; symptome(engourdissement)),
    \+ symptome(traumatisme_recent).

% 5. ARTHROSE (Vieillissement articulaire)
diagnostic(arthrose, 'CHRONIQUE : Usure du cartilage. Prise de rendez-vous pour rhumatologie.') :-
    (symptome(raideur_matinale) ; symptome(douleur_chronique)),
    \+ symptome(traumatisme_recent).

% 6. TENDINITE (Liée au mouvement)
diagnostic(tendinite, 'REPOS : Inflammation tendineuse. Repos sportif de 10 jours recommandé.') :-
    symptome(douleur_mouvement),
    \+ symptome(gonflement),
    \+ symptome(traumatisme_recent).

% 7. GOUTTE (Inflammation spécifique)
diagnostic(crise_de_goutte, 'INFLAMMATOIRE : Douleur vive et gonflement sans choc. Possible acide urique.') :-
    symptome(gonflement),
    symptome(douleur_intense),
    \+ symptome(traumatisme_recent).

% --- GESTION DES CAS PAR DÉFAUT (Pour ne jamais avoir "Inconnu") ---

diagnostic(observation, 'STABLE : Vos symptômes semblent légers. Surveillez l''évolution pendant 48h.') :-
    symptome(douleur_faible),
    \+ symptome(traumatisme_recent).

diagnostic(medecin_generaliste, 'CONSULTATION : Tableau clinique incomplet. Consultez votre généraliste par prudence.') :-
    \+ diagnostic(fracture, _),
    \+ diagnostic(luxation, _),
    \+ diagnostic(entorse, _),
    \+ diagnostic(arthrose, _),
    \+ diagnostic(tendinite, _).

% --- UTILITAIRES ---
effacer_symptomes :- 
    retractall(symptome(_)).