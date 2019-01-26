<!-- si l'adresse email a déjà existé dans BD, l'utilisateur doit refaire remplir l'adresse email et le mot de passe-->
<?php
// charger le fichier des fonctions
require ("fonctionsUtiles.php");

// executer la fonction de connexion
$con = connexion();

//exécuter la session et récupérer les données d'inscription pour remplir la formule
session_start();
$nom = $_SESSION["nomInscrire"];
$prenom = $_SESSION["prenomInscrire"];
$pseudo = $_SESSION["pseudoInscrire"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Inscrire</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="inscrir">        
        <div>
            <?php
            //la formule d'inscription remplit sauf que l'adresse email et le MDP
            echo("<form method='get' action='CheckInsert.php'>");
            echo("<table class='inscrir'>");
                echo("<tr>");
                    echo("<td>"."Nom:"."</td>");
                    echo("<td>"."<input type='text' name='nom' value='$nom' required='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Prénom:"."</td>");
                    echo("<td>"."<input type='text' name='prenom' value='$prenom' required='true'>"."</td>");
                echo("<tr>");
                    echo("<td>"."Pseudo:"."</td>"); 
                    echo("<td>"."<input type='text' name='pseudo' value='$pseudo' required='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Email:"."</td>"); 
                    echo("<td>"."<input type='email' name='email' required='true'>"."</td>");
                echo("</tr>");
                echo("<tr>");
                    echo("<td>"."Mot de passe:"."</td>");
                    echo("<td>"."<input type='password' name='MDP' required='true'>"."</td>");
                echo("</tr>");
                echo("</table>");
            
                //obtenir les infos des compétences de l'utilisateur
            echo("<table class='inscrir'>");
            
            //charger les compétences depuis BD
            $competence = listecomp($con);
            foreach ($competence as $CODEC => $NOMC){
                echo("<tr>");
                echo("<td>");
                echo("<input type='checkbox' name='ck_competence[]' value = $CODEC/> $NOMC");
                echo("</td>");
                echo("<td>");
                    echo("<select name='liste_niveau'>");
                    
                    //pour chaque compétence, chager les niveau depuis BD
                    $niveau = listeniveau($con);
                    foreach($niveau as $CodeN => $LibN){
                        echo("<option value='$CodeN'>");
                        echo("$LibN");
                        echo("</option>");
                    }
                    echo("</select>");
                    echo("</td>");
                    echo("</tr>");
            }
                ?>
            </table>
            <p align="center"><input type="submit" name="submit_inscrire" value="Inscrire maintenant!"/></p>
        </form>
        </div>
    </body>
</html>
