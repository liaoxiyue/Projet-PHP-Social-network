<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Résultat de Cherche</title>
    </head>
        <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");

        // executer la fonction de connexion
        $con = connexion();

        // nettoyage données en entrée
        $CodeCCher = filter_input(INPUT_GET, "copmChercher", FILTER_SANITIZE_SPECIAL_CHARS);
        session_start();
        $CodeM=$_SESSION["CodeM"]        
        ?>
    <body>
        <div class="head">
            <table>
            <tr>
                <td class="header"><img src="img/logo.png"></td>
                <td class="bienvenu"><?php
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
            //Afficher le nom de la compétence cherchée
            $NomComp = retreouverComp($con, $CodeCCher);
            echo('<h3>Des Membres qui ayant le compétence '.$NomComp["NomC"].'</h3>');
            ?>
            <table class="cherche" border="1">
            <?php
            $ResultatCherche= Cherche($con, $CodeCCher);
            echo("<tr>");
            echo("<td>"."Nom"."</td>");
            echo("<td>"."Prénom"."</td>");
            echo("<td>"."Pseudo"."</td>");
            echo("<td>"."Email"."</td>");
            
            //boucle pour afficher tous les membre qui ont la compétence choisie
            foreach( $ResultatCherche as $CodeCherche => $ChercheDetail)
            {
                echo("<form method='get' action = 'InfoMembre.php'>");
                echo("<tr>");
                echo("<td>".$ChercheDetail["NomM"]."</td>");
                echo("<td>".$ChercheDetail["PrenomM"]."</td>");
                echo("<td>".$ChercheDetail["PseudoM"]."</td>");
                echo("<td>".$ChercheDetail["EmailM"]."</td>");
                echo("<td>");
                //conculter les infos en détail du membre choisie
                echo("<button type='submit' name='VoirInfoMembre' value='$CodeCherche'>"."Détail"."</button>");
                echo("</td>");
                echo("</form>");
                echo("</tr>");
            }
            ?>
            </table>
    </body>
</html>
