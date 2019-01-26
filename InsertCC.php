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
        
        /*Insérer la commentaire complémentaire
         * exécuter la session, récupérer CodeM
         * obtenir le contenu de commentaire complémentaire
         * exécuter la function InsertCC
         * rendre à la page Home automatiquement
         */
        session_start();
        $CodeM=$_SESSION["CodeM"];
        $CodeCommentaire=filter_input(INPUT_GET, "InsertCC", FILTER_SANITIZE_SPECIAL_CHARS);
        $ContenuCC=filter_input(INPUT_GET, "CC", FILTER_SANITIZE_SPECIAL_CHARS);
        InsertCC($con, $ContenuCC, $CodeM, $CodeCommentaire);
        header("Location: Home.php");