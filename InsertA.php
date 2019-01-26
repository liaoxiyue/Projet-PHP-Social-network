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
        
        /*Apprécier la commentaire
         * exécuter la session, obtenir CodeM
         * obtenir le code commentaire
         * exécuter la function InsertA
         * rendre à la page Home automatiquement
         */
        session_start();
        $CodeM=$_SESSION["CodeM"];
        $CodeCommentaire=filter_input(INPUT_GET, "Apprecier", FILTER_SANITIZE_SPECIAL_CHARS);
        InsertA($con, $CodeM, $CodeCommentaire);
        header("Location: Home.php");
        