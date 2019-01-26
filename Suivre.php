        <?php
        // charger le fichier des fonctions
        require ("fonctionsUtiles.php");

        // executer la fonction de connexion
        $con = connexion();
        
        //exécuter la session et obtenir le codeM, codeMR 
        session_start();
        $codeM = $_SESSION["CodeM"];
        $codeMR = $_SESSION["CodeMR"];
        
        /*vérifier le statut de suivre
         * si l'utilisateur à déjà suivi ce membre, supprimer la relation de suivre
         * sinon ajouter la relation de suivre
         */
        $checkSuivre = checkSuivre($con, $codeM, $codeMR);
        if ($checkSuivre == FALSE){
        InsertVoir($con, $codeM, $codeMR);
        }else{
            SupprimerVoir($con, $codeM, $codeMR);
        }
        
        //rendre à la page InfoMembre automatiquement
        header("Location: InfoMembre.php");
