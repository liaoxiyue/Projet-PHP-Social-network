<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");
        
        //exécuter la connexion
        $con = connexion();
        
        /*Ajouter les nouvelle compétences
         * exécuter la session, obtenir CodeM
         * obtenir le code de compétence et le code de niveau
         * exécuter la function InsertComp
         * rendre à la page MonProfile automatiquement
         */
        session_start();
        $CodeM = $_SESSION["CodeM"];
        $CodeC=filter_input(INPUT_GET, "Competence", FILTER_SANITIZE_SPECIAL_CHARS);
        $CodeN=filter_input(INPUT_GET, "liste_niveau", FILTER_SANITIZE_SPECIAL_CHARS);
        InsertComp($con, $CodeM, $CodeC, $CodeN);
        $monprofil = ProfilM($con, $CodeM); 
        header("Location: MonProfile.php");
