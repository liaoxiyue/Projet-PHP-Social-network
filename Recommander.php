<?php
// charger le fichier des fonctions
require ("fonctionsUtiles.php");

// executer la fonction de connexion
$con = connexion();

//exécuter la session, obtenir le code membre être recommandé et le code membre recommander
session_start();
$CodeMEtreR = $_SESSION["CodeMR"];
$CodeM = $_SESSION["CodeM"];

//récupérer les compétences recommandées dan array
$competenceR=array();
foreach ($_GET["ck_competence"] as $CodeCR){
    $competenceR[]=$CodeCR;
   }
   
//boucle exécuter la fonction Recommander
foreach ($competenceR as $CodeCR){
    Recommander($con, $CodeM, $CodeMEtreR, $CodeCR);
            }
//rendre à la page InfoMembre automatiquement            
header("Location: InfoMembre.php");
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->