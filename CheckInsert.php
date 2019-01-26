<?php
// charger le fichier des fonctions
require ("fonctionsUtiles.php");

// executer la fonction de connexion
$con = connexion();

// nettoyage données en entrée
$nom = filter_input(INPUT_GET, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_GET, "prenom", FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_GET, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_SPECIAL_CHARS);
$MDP = filter_input(INPUT_GET, "MDP", FILTER_SANITIZE_SPECIAL_CHARS);

// récupérer les données de compétence et niveau
$competence=array();
//véfifier s'il y a des données en entrée pour les compétences avec niveau
if(isset($_GET["ck_Competences"])){
foreach ($_GET["ck_Competences"] as $CodeCp){
    $competence[]=$CodeCp;
    $niveau=array();
foreach ($_GET["liste_n"] as $CodeN){
    $niveau[] = $CodeN;
}
}
}

//exécuter la session et enregistrer les données d'inscription
session_start();
$_SESSION["nomInscrire"] = $nom;
$_SESSION["prenomInscrire"] = $prenom;
$_SESSION["pseudoInscrire"] = $pseudo;
?>
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
        <title>Bienvenue à SIGE !</title>
    </head>
    <body>
        <?php
        //vérifier l'existance de l'adresse email dans BD
        $emailcheck = emailcheck($con, $email);
        if ($emailcheck == FALSE){
            echo("<h3><a href='inscrire.php'>"." Re-s'inscrire"."</a></h3><br>");
            die("L'adreese email a déjà utilisée.");
        }else{
            //insérer les données basiques d'inscription dans BD
            InsertInscrirM($con, $nom, $prenom, $pseudo, $email, $MDP);
            
            //retrouver l'identification membre (CodeM)
            $CodeM=retrouverCodeM($con, $email);
            
            //enregistrer le codeM dans la session
            $_SESSION["CodeM"]=$CodeM;
            $_SESSION["Email"]=$email;
            
            //insérer une ligne dans le tableau VOIRCOM pour que l'utilisateur peut lire ses commentaires
            InsertVoir($con, $CodeM, $CodeM);
            
            //insérer les compétences avec les niveau correspondants de nouvelle inscription dans BD
            foreach ($competence as $Code){
                InsertComp($con, $CodeM, $Code, $niveau[$Code-1]);
            }
            
            //entrer à la page Home
            echo("<a href='Home.php'> Start SIGE </a>");
        }
        ?>
    </body>
</html>

