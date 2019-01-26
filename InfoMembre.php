<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
        <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");

        // executer la fonction de connexion
        $con = connexion();

        // nettoyage données en entrée
        /*s'il a des donnée entrées par GET, donner variable à codeMR, exécuter la session et récupérer codeM
         * sinon, exécuter la session et récupérer codeM et codeMR
         */
        if(isset($_GET["VoirInfoMembre"])){
        $codeMR = filter_input(INPUT_GET, "VoirInfoMembre", FILTER_SANITIZE_SPECIAL_CHARS); 
        session_start();
        $_SESSION["CodeMR"] = $codeMR;
        $codeM = $_SESSION["CodeM"];
        }else
        {
           session_start();
           $codeM = $_SESSION["CodeM"];
           $codeMR = $_SESSION["CodeMR"];          
        }
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Infomation Membre</title>
    </head>
    <body>
                    <div class="head">
            <table>
            <tr>
                <td class="header"><img src="img/logo.png"></td>
                <td class="bienvenu">
                <?php
                $CodeM = $_SESSION["CodeM"];
                $monprofil = ProfilM($con, $CodeM);
                echo("Bienvenu "."$monprofil[NomM]"." "."$monprofil[PrenomM]");
                ?></td>
                <td class="header"><a href= "Home.php"><img title="Retour Home" src="img/home.png"></a></td>
                <td class="header"><a href = "MonProfile.php"><img title="Mon Profile" src="img/profile.png"></a></td>
                <td class="header"><a href = "Deconnexion.php"><img title="Deconnexion" src="img/dec.png"></a></td>
            </tr>
            </table>
        </div>
        <?php
        //afficher les données basiques de membre choisi
        $profilM = ProfilM($con, $codeMR);
        echo("<h3>"."Profil de $profilM[PseudoM]"."</h3>");
        echo("<table>");
                echo("<tr>");
                    echo("<td>"."Nom:"."</td>");
                    echo("<td>"."$profilM[NomM]"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Prénom:"."</td>");
                    echo("<td>"."$profilM[PrenomM]"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Email:"."</td>"); 
                    echo("<td>"."$profilM[EmailM]"."</td>");
                echo("</tr>");
            echo("</table>");
            
            /*check la relation suivre entre l'utilisateur et le menbre choisi
             * si l'utilisateur a déjà suivi le membre, il affiche le boutton Désabonner
             * sinon il affiche le bouton S'abonner
             */
            $checkSuivre = checkSuivre($con, $codeM, $codeMR);
            if($checkSuivre ==FALSE){
                echo("<table>");
                echo("<tr>");
                echo("<td>");            
                echo("<a href='Suivre.php'>");
                echo("<img src='img/star.png'/>");
                echo("</a>");
                echo("</td>");
                echo("<td>"."S'abonner"."</td>");
                echo("</tr>");
                echo("<table>");                
            }else{
                echo("<table>");
                echo("<tr>");
                echo("<td>");
                echo("<a href='Suivre.php'>");
                echo("<img src='img/blackstar.png'/>");
                echo("</a>");
                echo("</td>");
                echo("<td>"."Désabonner"."</td>");
                echo("</tr>");
                echo("<table>");
            }
            echo("<br>");
            
            //afficher tous les compétences du membre choisi
            echo("<h3>"."Ses Compétences"."</h3>");
            echo("<table border='1'>");
            $competences = CompetencesM($con, $codeMR);
            foreach ($competences as $CodeCompetenceM => $competencedetail) {
                echo("<tr>");
                echo("<td>".$competencedetail["NomC"]."</td>");
                echo("<td>".$competencedetail["LibN"]."</td>");
                echo("</tr>");
}
            echo("</table>");
            
            echo("<br>");
            
            //afficher tous les compétences recommandées du membre choisi
            echo("<h3>"."Ses Compétences Recommandés"."</h3>");
            $CompetencesR = CompetencesR($con, $codeMR);
            echo("<table border='1'>");
            foreach ($CompetencesR as $CodeCompetenceR => $competencedetailR){
                echo("<tr>");
                echo("<td>".$competencedetailR["NomC"]."</td>");
                echo("<td>".$competencedetailR["PseudoM"]."</td>");
                echo("</tr>");
            }
            echo("</table>");
            echo("<br>");
            
            // recommander les compétence pour le membre choisi
            echo("<h3>"."Recommander des Compétences"."</h3>");
            echo("<form method='get' action='Recommander.php'>");
            
            //récupérer la liste de compétence
            echo("<table>");
            $competence = listecomp($con);
            foreach ($competence as $CODEC => $NOMC){
                echo("<tr>");
                echo("<td>");
                echo("<input type='checkbox' name='ck_competence[]' value = $CODEC/> $NOMC");
                echo("</td>");
                echo("</tr>");
            }
            echo("</table>");
            echo("<input type='submit' name='submit_RecommanderComp' value='Recommander'/>");
            echo("</form>");
            ?>
    </body>
</html>
