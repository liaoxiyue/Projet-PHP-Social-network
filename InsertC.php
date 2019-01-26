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
        
        /*Insérer la commentaire
         * exécuter la session, récupérer CodeM
         * obtenir le contenu de commentaire
         * exécuter la function InsertCommentaire
         * rendre à la page Home automatiquement
         */        
        session_start();
        $CodeM=$_SESSION["CodeM"];
        $Contenu=filter_input(INPUT_GET, "commentaire", FILTER_SANITIZE_SPECIAL_CHARS);
        InsertCommentaire($con, $Contenu, $CodeM);
        header("Location: Home.php");