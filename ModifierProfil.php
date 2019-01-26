<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
        <?php
        //charger le fichier des fonctions
        require ("fonctionsUtiles.php");
        //ex.cuter la connexion
        $con = connexion();
        
        //obtenir les infos entrée
        $nom = filter_input(INPUT_GET, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_GET, "prenom", FILTER_SANITIZE_SPECIAL_CHARS);
        $pseudo = filter_input(INPUT_GET, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
        $MDP = filter_input(INPUT_GET, "MDP", FILTER_SANITIZE_SPECIAL_CHARS);
        
        /*exécuter la session, récupérer la codeM
         * exécuter la fonction modifierProfil
         * rendre à la page MonProfile automatiquement
         */
        session_start();
        $codeM = $_SESSION["CodeM"];
        modifierProfil($con, $codeM, $nom, $prenom, $pseudo, $MDP);
        header("Location:MonProfile.php");