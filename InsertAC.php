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
        
        /*Apprécier la commentaire complémentaire
         * exécuter la session, obtenir CodeM
         * obtenir le code commentaire complémentaire
         * exécuter la function InsertAC
         * rendre à la page Home automatiquement
         */
        session_start();
        $CodeM=$_SESSION["CodeM"];
        $CodeCC=filter_input(INPUT_GET, "ApprecierC", FILTER_SANITIZE_SPECIAL_CHARS);
        InsertAC($con, $CodeM, $CodeCC);
        header("Location: Home.php");