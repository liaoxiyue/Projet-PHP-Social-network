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
        <title>Mon Profil</title>
    </head>
    <?php
    //charger le fichier des fonctions
        require ("fonctionsUtiles.php");
        
        //exécuter la connexion
        $con = connexion();
        
        //exécuter la session et récupérer le codeM
        session_start();
        $email = $_SESSION["Email"];
        $codeM = $_SESSION["CodeM"];
        
        /*exécuter la fonction monprofil
         * entrer le codeM
         * sortir tous les infos de l'utilisateur
         * l'utilisateur peut modifier son profil
         */
        $monprofil = ProfilM($con, $codeM);
        ?>
    <body>
        <div class="head">
            <table>
            <tr>
                <td class="header"><img src="img/logo.png"></td>
                <td class="bienvenu"><?php
                $monprofil = ProfilM($con, $codeM);
                echo("Bienvenu "."$monprofil[NomM]"." "."$monprofil[PrenomM]");
                ?></td>
                <td class="header"><a href= "Home.php"><img title="Retour Home" src="img/home.png"></a></td>
                <td class="header"><a href = "MonProfile.php"><img title="Mon Profile" src="img/profile.png"></a></td>
                <td class="header"><a href = "Deconnexion.php"><img title="Deconnexion" src="img/dec.png"></a></td>
            </tr>
            </table>
        </div>
        <?php
        echo("<h3>"."Modifier Mon Profil"."</h3>");
        echo("<form method='get' action='ModifierProfil.php'>");
        echo("<table class='profil'>");
                echo("<tr>");
                    echo("<td>"."Nom:"."</td>");
                    echo("<td>"."<input type='text' name='nom' value='$monprofil[NomM]' required='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Prénom:"."</td>");
                    echo("<td>"."<input type='text' name='prenom' value='$monprofil[PrenomM]' required='true'>"."</td>");
                echo("<tr>");
                    echo("<td>"."Pseudo:"."</td>"); 
                    echo("<td>"."<input type='text' name='pseudo' value='$monprofil[PseudoM]' required='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Email:"."</td>"); 
                    echo("<td>"."<input type='email' name='email' value='$monprofil[EmailM]' required='true' disabled='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Mot de passe :"."</td>");
                    echo("<td>"."<input type='text' name='MDP' value='$monprofil[MDP]' reauired='true'>"."</td>");
                echo("</tr>");
                echo("<tr><td align='center' colspan='2'>");
                echo("<input type='submit' name='submit_modifierprofil' value='Modifier'>");
                echo("</td></tr>");
            echo("</table>");
            echo("</form>");
            echo("<br>");
            
            //afficher les infos compétences de l'utilisateur
            echo("<h3>"."Mes Compétences"."</h3>");
            echo("<p align='center'>"."Supprimez en cliquant sur button"."</p>");
            echo("<form method='get' action='SupprimerCompetence.php'>");
            echo("<table class='profil'>");
            
            //exécuter la fonction CompetencesM
            $mescompetences = CompetencesM($con, $codeM);
            
            //boucle pour afficher tous les compétences possédées par l'utilisateur
            foreach ($mescompetences as $CodeCompetenceM => $competencedetail) {
                echo("<tr>");
                echo("<td>Compétence: ".$competencedetail["NomC"]." </td>");
                echo("<td>Niveau: ".$competencedetail["LibN"]." </td>");
                echo("<td> ");
                echo(' <form methode = "get" action="SupprimerCompetence.php">');
                //supprimer la compétence en cliquant sur le bouton "-"
                echo(" <button name='Competence' value='$CodeCompetenceM'>");
                echo("-");
                echo("</button>");
                echo("</form>");
                echo("</td>");
                echo("</tr>");
}
            echo("</table>");
            echo("</form>");
            
            echo("<br>");
            
            //afficher les infos compétences recommentées de l'utilisateur
            echo("<h3>"."Mes Compétences recommandés"."</h3>");
            //exécuter la fonction CompetencesR
            $mescompetencesR = CompetencesR($con, $codeM);
            echo("<table class='profil'>");
            //boucle pour afficher tous les compétences recommandées de l'utilisateur
            foreach ($mescompetencesR as $CodeCompetenceR => $competencedetailR){
                echo("<tr>");
                echo("<td>Compétence ".$competencedetailR["NomC"]." </td>");
                echo("<td> recommandé par ".$competencedetailR["PseudoM"]."</td>");
                echo("</tr>");
            }
            echo("</table>");
            echo("<br>");
            
            //ajouter les nouvelles compétences
            echo("<h3>"."Ajouter Nouvelles Compétences"."</h3>");
            echo("<form method='get' action='AjouterCompetence.php'>");
            echo("<table class='profil'>");
            
            //exécuter la fonction liste_CompetenceNP
            $competence = liste_CompetenceNP($con, $codeM);
            //afficher tous les compétences ne sont pas possédées par l'utilisateur
            foreach ($competence as $CODEC => $NOMC){
                echo("<tr>");
                echo("<td>");
                echo("$NOMC");
                echo("</td>");
                echo("<td>");
                echo('<form methode = "get" action="AjouterCompetence.php">');
                    echo("<select name='liste_niveau'>");
                        echo("<option value=''>");
                        echo("Choix");
                        echo("</option>");
                        
                        //exécuter la fonction listeniveau
                    $niveau = listeniveau($con);
                    //boucle poyr afficher pour chaque compétences les niveaux
                    foreach($niveau as $CodeN => $LibN){
                        echo("<option value='$CodeN'>");
                        echo("$LibN");
                        echo("</option>");
                    }
                    echo("</select>");
                echo("</td>");
                echo("<td>");
                //ajouter des nouvelles compétences en cliquant boutton "+"
                echo("<button name='Competence' value='$CODEC'>");
                echo("+");
                echo("</button>");
                echo("</form>");
                echo("</td>");
                echo("</tr>");
            }
            echo("</table>");
            echo("</form>");
            ?>
    </body>
</html>
