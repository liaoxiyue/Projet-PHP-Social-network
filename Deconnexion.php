<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Déconnexion</title>
    </head>
    <?php
    // charger le fichier des fonctions
    require ("fonctionsUtiles.php");
    
        /*connecter à BD
         * exécuter la session
         * enlever tous les infos dans la session
         * déconnecter à BD
         */
    $con = connexion();
    session_start();
    session_destroy();
    mysqli_close($con);
    ?>
    <body class="decon">
        <p align="center">Vous avez déjà déconneté.</p>
        <h3><a href="index.php"> Rendre à la page de connxion</a></h3>
    </body>
</html>
