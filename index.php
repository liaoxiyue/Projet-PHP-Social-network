<?php
// charger le fichier des fonctions
require ("fonctionsUtiles.php");

// executer la fonction de connexion
$con = connexion();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Beinvenue à SIGE !</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body class="index">
        <!-- connexion de l'utilisateur-->
        <!-- obtenir l'adresse email et le mot de passe de l'utilisateur dans un form et les transférer à Home.php-->
        <div class="connexion">
            <form method="get" action="Home.php">
                <p><image name='logo' src='img/logo.png'/></p>
                <table class="log">
                <tr>
                <td>Email : 
                <input id="info_email" type="text" name="info_email" value="" placeholder="Entrez votre email"/>
                </td>
                <td>Mots de Passe : 
                <input id="info_psw" type="password" name="info_psw" placeholder="Entre votre mot de passe"/>
                </td>
                <td><input type="submit" value="Connexion"/>
                </td>
                </tr>
                </table>
            </form>
        </div>
        
        <!-- inscription de l'utilisateur--> 
        <div class="inscrire">
            <h3>Pas encore un membre de SIGE? Inscrivez vous maintenant!</h3>
        <form method="get" action="CheckInsert.php">
            <div class="inscrire1">
            <table>
                <!-- obtenir les infos personnelles de l'utilisateur-->
                <tr>
                    <td>Nom:</td>
                    <td><input type="text" name="nom" required="true"></td>
                </tr>
                <tr>
                    <td>Prénom:</td>
                    <td><input type="text" name="prenom" required="true"></td>
                </tr>
                <tr>
                    <td>Pseudo:</td> 
                    <td><input type="text" name="pseudo" required="true"></td>
                </tr>
                <tr>
                    <td>Email:</td> 
                    <td><input type="email" name="email" required="true"></td>
                </tr>
                <tr>
                    <td>Mot de passe :</td>
                    <td><input type="password" name="MDP" required="true"></td>
                </tr>
            </table>
                
                <!-- obtenir les infos des compétences de l'utilisateur-->
            </div>
            <div class="inscrire2">
            <table>
                <tr> <td colspan="2">Choisissez vos compétences : </td></tr>
                <?php
                // charger les compétences depuis BD 
                // put your code here  
                $competence = listecomp($con);
                foreach($competence as $CodeC => $NomC) 
                {
                    echo("<tr>");
                    echo("<td>");
                    echo("<input type='checkbox' name='ck_Competences[]' value = $CodeC/> $NomC");
                    echo("</td><td>");
                    
                    echo("<select name='liste_n[]'>");   
                    echo("<option>");
                    echo("choix");
                    echo("</option>");
                    
                    //pour chaque compétence, chager les niveau depuis la BD
                    $niveau = listeniveau($con);
                    foreach($niveau as $CodeN => $LibN)
                    {
                    echo("<option value=$CodeN>");
                    echo($LibN);
                    echo("</option>");
                    }
                    echo("</select></td>");
                    echo("</tr>");
                    }
                ?>
            </table>
            </div>
            <div class="inscrire3">
            <p><input type="submit" name="inscrire_submit" value="Inscrire maintenant!"/></p>
            </div>
        </form>
        </div>
    </body>
</html>
