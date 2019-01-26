<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Home Page</title>
    </head>
        <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");

        // executer la fonction de connexion
        $con = connexion();

        // nettoyage données en entrée
        //vérifier il y a des données entrée par GET
        if(isset($_GET["info_email"], $_GET["info_psw"])){
        $email = filter_input(INPUT_GET, "info_email", FILTER_SANITIZE_SPECIAL_CHARS);
        $MDP = filter_input(INPUT_GET, "info_psw", FILTER_SANITIZE_SPECIAL_CHARS);
        //check l'adresse email et le MDP 
        $connexionM = CheckEmailMDP($con, $email, $MDP) ;
        if($connexionM ==FALSE)
        {
            //si l'adresse email et le MDP ne sont pas existants ou ne sont pas cohérents, l'utilisateur rendre à la page index pour reconnecter
           echo('<a href="index.php"> Retour à la page de connexion </a>');
           echo("<br>");
           die("Votre Email ou Mot de passe est faux");
        }
        else
        {    
            //si la connexion est bon, exécuter la session et enregistrer le codeM et email dans la session
            session_start();
            $_SESSION["Email"]=$email;
            $CodeM = retrouverCodeM($con, $email);
            $_SESSION["CodeM"]=$CodeM;      
        }
        }else{
            //si il n'y a pas des données entrées par GET, exécuter la session et récupérer le codeM
            session_start();    
            $CodeM=$_SESSION["CodeM"];
        }
        ?>

    <body>
        <div class="head">
            <table>
            <tr>
                <td class="header"><img src="img/logo.png"></td>
                <td class="bienvenu">
                    <?php
                    //Trouver le nom et le prenom de le membre.
                    $monprofil = ProfilM($con, $CodeM);
                    echo("Bienvenu "."$monprofil[NomM]"." "."$monprofil[PrenomM]");
                ?>
                </td>
                <!-- Retourner aux pages principales-->
                <td class="header"><a href= "Home.php"><img title="Retour Home" src="img/home.png"></a></td>
                <td class="header"><a href = "MonProfile.php"><img title="Mon Profile" src="img/profile.png"></a></td>
                <td class="header"><a href = "Deconnexion.php"><img title="Deconnexion" src="img/dec.png"></a></td>
            </tr>
            </table>
        </div>
            
        <div id="home">
        <div class="cherche">
            <form method="get" action="ResultatCherche.php">
            <p>Chercher des membres ayant la Compétence : 
                <select name="copmChercher">
                    <?php
                    // put your code here
                    $competence = listecomp($con);
                    foreach($competence as $CODEC => $NOMC) 
                    {
                              echo("<option value='$CODEC'>");
                              echo("$NOMC");
                              echo("</option>");
                    }
                    ?>
                </select>
                <input type="submit" name="chercher_submit" value="Chercher"/>
            </p>
            </form>
        </div>
        
        <div class="EcrireCommentaire">
            <form methode = "get" action="InsertC.php">
                <p>Ecrivez votre commentaire ici
                    <textarea name="commentaire" rows="4" cols="100" maxlength="140"></textarea></p>
            <input type="submit" name="submit_commentaire" value="Publier"/>
            </form>
        </div>
        
        <div class="LireCommentaire">
            <?php
             $Commentaire = LireCommentaire($con,$CodeM);
            foreach($Commentaire as $CODECommentaire => $commentairedetail)
            {   echo('<form methode = "get" action="InsertA.php">');
                $CodeC=$CODECommentaire;
                echo('<table class="Commentaire">');
                echo("<tr>");
                echo('<td colspan="2">'.$commentairedetail["PseudoM"].'</td>');
                echo('<td class="date">'.$commentairedetail["DateCom"].'</td>');
                echo("</tr>");
                echo("<tr>");
                echo('<td colspan="3"><div class="commentaire">'.$commentairedetail["Contenu"].'</div></td>');
                echo("</tr>");
                echo("<tr>");
                echo("<td class='coeur'>");
                echo("<img src='img/coeur.png'/>");
                echo("</td>");
                echo("<td>");
                $apprecier = apprecier($con, $CodeC);
                foreach($apprecier as $CodeA => $PseudoM)
                {
                    echo("  ".$PseudoM);
                }
                echo("</td>");
                echo("<td class='Apprecier'>");
                echo("<button class='Apprecier' name='Apprecier' value='$CodeC'>");
                echo("</button>");
                echo("</form>");
                echo("</td>");
                echo("</tr>");
                echo("<tr>");
                echo("<td colspan='3'>");
                echo('<form methode = "get" action="InsertCC.php">Ecrivez votre réponse ici :');
                echo("<textarea name='CC' rows='4' cols='101' maxlength='140'></textarea>");
                echo("</td>");
                echo("</tr>");
                echo("<tr>");
                echo("<td class='PubCC' colspan='3'>");
                echo("<button name='InsertCC' value='$CodeC'>publier</button>");
                echo("</td>");
                echo("</form>");
                echo("</tr>");
                $commentaireComp = commentaireComp($con, $CodeC);
                foreach ($commentaireComp as $CODECC => $commentaireComp)
                {   echo("<table class='CC'>");
                    echo("<tr>");
                    echo('<td>Répondu par '.$commentaireComp["PseudoM"].'</td>');
                    echo('<td class="date" colspan="2">'.$commentaireComp["DateCC"].'</td>');
                    echo("</tr>");
                    echo("<tr>");
                    echo('<td colspan="3"><div class="CC">'.$commentaireComp["ContenuCC"].'</div></td>');
                    echo("</tr>");
                    echo("<tr>");
                    echo("<td class='coeur'>");
                    echo("<img src='img/coeur.png'/>");
                    echo("</td>");
                    echo("<td>");
                    $apprecierCC = apprecierCC($con, $CODECC);
                    foreach($apprecierCC as $DateAC => $PseudoM)
                    {
                        echo("  ".$PseudoM);
                    }
                    echo("</td>");
                    echo("<td class='Apprecier'>");
                    echo('<form methode = "get" action="InsertAC.php">');
                    echo("<button class='Apprecier' name='ApprecierC' value='$CODECC'>");
                    echo("</button>");
                    echo("</form>");
                    echo("</td>");
                    echo("</tr>");
                    echo("</table>");
                    }
                    echo("</table>");
                    echo("<br>");
            }
            ?>
        </div>
        </div>
    </body>
</html>
