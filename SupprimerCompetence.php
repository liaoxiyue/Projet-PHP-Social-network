<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");
        
        //exécuter la fonction connexion;
        $con = connexion();
        
        /*exécuter la session et récupérer codeM
         * obtenir CodeC par GET
         * exécuter la fonction SuppComp
         */
        session_start();
        $CodeM = $_SESSION["CodeM"];
        $CodeC=filter_input(INPUT_GET, "Competence", FILTER_SANITIZE_SPECIAL_CHARS);
        SuppComp($con, $CodeM, $CodeC);
        
        //rendre à la^page MonProfile automatiquement
        header("Location: MonProfile.php");