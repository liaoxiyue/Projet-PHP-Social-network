<?php
// definition des constantes de connexion
define("ID_MYSQL", "21611943");
define("PASSE_MYSQL", "R01RG8");
define("HOST_MYSQL", "etu-web2.ut-capitole.fr");
define("BD_MYSQL", "db_21611943_2");

// connexion à la base de données SIGE
function connexion() {
    $con = mysqli_connect(HOST_MYSQL, ID_MYSQL, PASSE_MYSQL);

    if ($con == NULL) {
        die("Erreur connexion à MySQL DB : " . mysqli_connect_error());
    } else { // connexion réussie
        if (mysqli_select_db($con, BD_MYSQL) == FALSE) {
            die("Choix base impossible : " . mysqli_error($con));
        } else { // base est correctement - Tout OK
            return $con;
        }
    }
} 

// la liste de compétences
function listecomp($con) {
    $sqlComp = "SELECT COMPETENCES.CodeC, COMPETENCES.NomC "
    . "FROM COMPETENCES ORDER BY 1" ; 
    $curseur = mysqli_query($con,$sqlComp);
    if ($curseur == FALSE) {
        die("erreur fonction chargement compétences : " . mysqli_error($con));
    } else { //exécuter sql réussie
        $competence = array();
        while($nuplet = mysqli_fetch_array($curseur)) 
        {          
            $competence[$nuplet["CodeC"]] = $nuplet["NomC"];
        }
    }    
    return $competence;   
}
// la liste de niveau
function listeniveau($con) {
    $sqlNiveau = "SELECT CodeN, LibN FROM NIVEAU" ;
    $curseur = mysqli_query($con, $sqlNiveau);
    if ($curseur == FALSE) {
        die("erreur fonction chargement niveau : " . mysqli_error($con));
    }else{ //exécuter sql réussie
        $niveau = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {
            $niveau[$nuplet["CodeN"]] = $nuplet["LibN"];
        }
    }
    return $niveau;
}

// vérifier l'adresse email et le MDP
function CheckEmailMDP($con, $email, $MDP) {
    $sqlEmailMDP = "SELECT * FROM MEMBRES "
                    ."WHERE EMAILM = '$email' "
                    ."AND MDP='$MDP'";

    $curseur = mysqli_query($con, $sqlEmailMDP);
    if ($curseur == FALSE) {
        die("erreur fonction email ou Mot de Passe");
    } else { //exécuter sql réussie
        if (mysqli_num_rows($curseur) == 0){ //email ou MDP n'est pas bon
            return FALSE;
        } else { //email et MDP sont bon
            return TRUE;
        }
    }
}

//retrouver le CodeM par l'adresse email
function retrouverCodeM ($con, $email){
        $sqlretrouverMembre = "SELECT MEMBRES.CodeM FROM MEMBRES WHERE MEMBRES.EMAILM = '$email'";
        $curseur = mysqli_query($con, $sqlretrouverMembre);
        if ($curseur == False){
         die("erreur fonction recherche le nom de la compétence indiquée : " . my_sqli_error($con));   
        }else{ //exécuter sql réussie
        $nuplet = mysqli_fetch_array($curseur);
            $CodeM = $nuplet["CodeM"];
            return $CodeM ;
        }
}

// retrouver tous les infos basique de l'utilisateur
function ProfilM($con, $codeM){
    $sqlProfilM = "SELECT MEMBRES.NomM, MEMBRES.PrenomM, MEMBRES.PseudoM, MEMBRES.EmailM, MEMBRES.MDP FROM MEMBRES WHERE MEMBRES.CodeM='$codeM'";
    $curseur = mysqli_query($con, $sqlProfilM);
    if ($curseur == FALSE){
        die("erreur fonction recherche competence : " . mysqli_error($con));
    }else{
        $ProfilM = mysqli_fetch_array($curseur);
    }
    return $ProfilM;
}

// vérifier l'adresse email est unique dans BD
function emailcheck($con, $email){
    $sqlemail = "SELECT * "
                ."FROM MEMBRES "
                ."WHERE EMAILM = '$email'";
    $curseur = mysqli_query($con, $sqlemail);
    if ($curseur == FALSE) {
        die("erreur fonction recherche email : " . mysqli_error($con));
    } else {
        if (mysqli_num_rows($curseur) == 0){ //l'adresse email entrée n'existe pas dans BD
        return TRUE;
        }
        else{return FALSE; //l'adresse email entrée a déjà'existé dans BD
            } 
        }
}

// retrouver les détails des commentaire
function LireCommentaire($con, $codeM){
    $sqlCommentaire = "SELECT COMMENTAIRES.CODECommentaire, COMMENTAIRES.Contenu, COMMENTAIRES.DateCom, MEMBRES.PseudoM ".
                      "FROM COMMENTAIRES,MEMBRES ,VOIRCOM ".
                      "WHERE COMMENTAIRES.CODEM = MEMBRES.CODEM ".
                      "AND COMMENTAIRES.CODEM = VOIRCOM.CodeMVu ".
                      "AND VOIRCOM.CodeMVoir = '$codeM' ".
                      "ORDER BY COMMENTAIRES.CODECommentaire Desc";
    $curseur = mysqli_query($con, $sqlCommentaire);
    if ($curseur == FALSE){
        die ("erreur fonction recherche commentaire : " . mysqli_error($con));
    }else{
        $commentaire = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {
            $CODECommentaire = $nuplet["CODECommentaire"];
            $commentairedetail = array("Contenu" => $nuplet["Contenu"],
                                       "PseudoM" => $nuplet["PseudoM"],
                                       "DateCom" => $nuplet["DateCom"]);
            $commentaire[$CODECommentaire] = $commentairedetail;            
        }
    }
    return $commentaire;
}

//retrouver les détails des commentaire complémentaire
function commentaireComp($con, $CODEC){
    $sqlCommentaireComp = "SELECT MEMBRES.PseudoM, COMMENTAIRE_COMPL.DateCC, COMMENTAIRE_COMPL.CodeCC, COMMENTAIRE_COMPL.ContenuCC"
    . " FROM COMMENTAIRE_COMPL, MEMBRES"
    . " WHERE COMMENTAIRE_COMPL.CodeM = MEMBRES.CodeM"
    . " AND COMMENTAIRE_COMPL.CodeCommentaire = '$CODEC'"
    . " ORDER BY COMMENTAIRE_COMPL.DateCC DESC";
    $curseur = mysqli_query($con, $sqlCommentaireComp);
    if ($curseur == FALSE){
        die("erreur fonction recherche commentaire complémentaire : " . my_sqli_error($con));
    }else{
        $commentaireComp = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {
            $CODECC = $nuplet["CodeCC"];
            $CCdetail = array("ContenuCC" => $nuplet["ContenuCC"],
                              "PseudoM" => $nuplet["PseudoM"],
                              "DateCC" => $nuplet["DateCC"]);
            $commentaireComp[$CODECC] = $CCdetail;
        }
    }
    return $commentaireComp;
}

//retrouver les membre qui apprécie la commentaire
function apprecier($con, $CodeC){
    $sqlapprecier = " SELECT MEMBRES.PseudoM, APPRECIER.DateA"
    . " FROM APPRECIER, MEMBRES"
    . " WHERE APPRECIER.CodeM = MEMBRES.CodeM"
    . " AND APPRECIER.CodeCommentaire = '$CodeC'"
    . " ORDER BY APPRECIER.DateA";
    $curseur = mysqli_query($con, $sqlapprecier);
    if ($curseur == FALSE){
        die("erreur fonction recherche Appreécier : " . my_sqli_error($con));
    }else{
        $apprecier = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {
            $apprecier[$nuplet["DateA"]] = $nuplet["PseudoM"];
        }
    }
    return $apprecier;
}

//retrouver les membre qui apprécie la commentaire complémentaire
function apprecierCC($con, $CodeCC){
    $sqlapprecier = " SELECT MEMBRES.PseudoM, APPRECIERCC.DateAC"
    . " FROM APPRECIERCC, MEMBRES"
    . " WHERE APPRECIERCC.CodeM = MEMBRES.CodeM"
    . " AND APPRECIERCC.CodeCC = '$CodeCC'"
    . " ORDER BY APPRECIERCC.DateAC";
    $curseur = mysqli_query($con, $sqlapprecier);
    if ($curseur == FALSE){
        die("erreur fonction recherche Appreécier : " . my_sqli_error($con));
    }else{
        $apprecierCC = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {
            $apprecierCC[$nuplet["DateAC"]] = $nuplet["PseudoM"];
        }
    }
    return $apprecierCC;
}

//retrouver tous les membre qui ont la compétence choisie
function Cherche ($con, $competence){
    $sqlCherche = "SELECT distinct MEMBRES.CodeM, MEMBRES.NomM, MEMBRES.PrenomM, MEMBRES.PseudoM, MEMBRES.EmailM from MEMBRES, POSSEDER, COMPETENCES "
            ."where MEMBRES.CodeM = POSSEDER.CodeM and POSSEDER.CodeC = COMPETENCES.CodeC and COMPETENCES.CodeC = '$competence' UNION "
            ."SELECT distinct MEMBRES.CodeM, MEMBRES.NomM, MEMBRES.PrenomM, MEMBRES.PseudoM, MEMBRES.EmailM from MEMBRES, COMPETENCES, RECOMMANDER "
            ."where MEMBRES.CodeM = RECOMMANDER.CodeMEtreRecommande and RECOMMANDER.CodeC = COMPETENCES.CodeC and COMPETENCES.CodeC = '$competence'";
    $curseur = mysqli_query($con,$sqlCherche);
    if ($curseur == FALSE){
        die("erreur fonction recherche les membres ayant la compétence indiquée : " . my_sqli_error($con));
        }else{
        $Cherche = array();
        while ($nuplet = mysqli_fetch_array($curseur))
        {   $CodeCherche=$nuplet["CodeM"];
            $ChercheDetail = array("NomM" => $nuplet["NomM"],
                                "PrenomM" => $nuplet["PrenomM"],
                                "PseudoM" => $nuplet["PseudoM"],
                                "EmailM" => $nuplet["EmailM"]);
            $Cherche[$CodeCherche] = $ChercheDetail;
        }
    }
    return $Cherche;
}

//retrouver le nom d'un compétence par son code
function retreouverComp ($con, $CodeC){
    $sqlretrouverComp = "SELECT COMPETENCES.NomC FROM COMPETENCES WHERE COMPETENCES.CodeC = '$CodeC'";
    $curseur = mysqli_query($con, $sqlretrouverComp);
    if ($curseur == False){
     die("erreur fonction recherche le nom de la compétence indiquée : " . my_sqli_error($con));   
    }else{
        return mysqli_fetch_array($curseur);
        }
    }
 
//retrouver les cmpétences avec le niveau posséder par l'utilisateur  
function CompetencesM ($con, $codeM){
    $sqlcompetencesM = "SELECT COMPETENCES.CodeC, COMPETENCES.NomC, NIVEAU.LibN ".
                           "FROM POSSEDER, COMPETENCES, MEMBRES, NIVEAU ".
                           "WHERE POSSEDER.CodeM = '$codeM' ".
                           "AND POSSEDER.CodeC = COMPETENCES.CodeC ".
                           "AND POSSEDER.CodeN = NIVEAU.CodeN ";
    $curseur = mysqli_query($con, $sqlcompetencesM);
    if ($curseur ==FALSE){
        die("erreur fonction recherche mes compétences : " . my_sqli_error($con));
    }else{
        $CompetencesM = array();
    while ($nuplet = mysqli_fetch_array($curseur))
    {
        $CodeCompetenceM = $nuplet["CodeC"];
        $competencedetail = array("NomC" => $nuplet["NomC"],
                                  "LibN" => $nuplet["LibN"]);
        $CompetencesM[$CodeCompetenceM] = $competencedetail;
    }
    }
    return $CompetencesM;
}

//retrouver les compétences recommandées
function CompetencesR ($con, $codeM){
    $sqlCompetencesR = "SELECT COMPETENCES.CodeC, COMPETENCES.NomC, MEMBRES.PseudoM ".
                          "FROM MEMBRES, RECOMMANDER, COMPETENCES ".
                          "WHERE MEMBRES.CodeM = RECOMMANDER.CodeMRecommande ".
                          "AND RECOMMANDER.CodeC = COMPETENCES.CodeC ".
                          "AND RECOMMANDER.CodeMEtreRecommande = '$codeM' ";
    $curseur = mysqli_query($con, $sqlCompetencesR);
    if ($curseur ==FALSE){
        die("erreur fonction recherche mes compétences : " . my_sqli_error($con));
    }else{
        $CompetencesR = array();
    while ($nuplet = mysqli_fetch_array($curseur))
    {
        $CodeCompetenceR = $nuplet["CodeC"];
        $competencedetailR = array("NomC" => $nuplet["NomC"],
                                  "PseudoM" => $nuplet["PseudoM"]);
        $CompetencesR[$CodeCompetenceR] = $competencedetailR;
    }
    }
    return $CompetencesR;
}

//retrouver la liste des compétences possédées de l'utilisateur
function liste_CompetenceNP($con, $CodeM) {
    $sqlComp = "SELECT COMPETENCES.CodeC, COMPETENCES.NomC ".
               "FROM COMPETENCES ".
               "WHERE COMPETENCES.CodeC NOT IN ".
               "(SELECT POSSEDER.CodeC ".
               "FROM POSSEDER ".
               "WHERE POSSEDER.CodeM = '$CodeM') "; 
    $curseur = mysqli_query($con,$sqlComp);
    if ($curseur == FALSE) {
        die("erreur fonction chargement compétences en aojoutantes : " . mysqli_error($con));
    } else {
        $competenceA = array();
        while($nuplet = mysqli_fetch_array($curseur)) 
        {          
            $competenceA[$nuplet["CodeC"]] = $nuplet["NomC"];
        }
    }    
    return $competenceA;   
    
}

//insérer nouvelle compétences pour un membre dans BD
function InsertComp ($con, $CodeM, $CodeC, $CodeN){
                $insertSQL = "INSERT INTO POSSEDER (CodeM, CodeC, CodeN) "
                . "VALUES('$CodeM', '$CodeC', '$CodeN')";
            
        $ordreInsert = mysqli_query($con, $insertSQL);
}

//insérer les info d'inscription d'un membre dans BD
function InsertInscrirM ($con, $Nom, $Prenom, $pseudo, $Email, $MDP){
        $insertSQL = "INSERT INTO MEMBRES (NomM, PrenomM, PseudoM, EmailM, MDP) "
                . "VALUES('$Nom', '$Prenom', '$pseudo', '$Email', '$MDP')";    
        $ordreInsert = mysqli_query($con, $insertSQL);
        echo("<p>Vous avez bien s'inscrit</p>");
}

//insérer la commentaire dans BD
function InsertCommentaire ($con, $Contenu, $codeM){
    $insertSQL = "INSERT INTO COMMENTAIRES (Contenu, DateCom, CodeM) "
                ."VALUES ('$Contenu', now(), '$codeM')";
    $orderInsert = mysqli_query($con, $insertSQL);
}

//insérer une relation suivre dans BD
function InsertVoir ($con, $codeM, $codeMR){
    $sqlInsertVoir = "INSERT INTO VOIRCOM(VOIRCOM.CodeMVoir, VOIRCOM.CodeMVu) VALUES ('$codeM', '$codeMR')";
    $orderInsert = mysqli_query($con, $sqlInsertVoir);
}

//supprimer une relation suivre depuis BD
function SupprimerVoir ($con, $codeM, $codeMR){
    $sqlSupprimerVoir = "DELETE FROM VOIRCOM WHERE VOIRCOM.CodeMVoir = '$codeM' AND VOIRCOM.CodeMVu = '$codeMR'";
    $orderSupp = mysqli_query($con, $sqlSupprimerVoir);
}

//insert les données de recommander dans BD
function Recommander ($con, $CodeMRecommande, $CodeMEtreRecommande, $CodeC){
    $sqlInsertRecommander = "INSERT INTO RECOMMANDER (CodeMRecommande, CodeMEtreRecommande, CodeC) ".
                            "VALUES ('$CodeMRecommande', '$CodeMEtreRecommande', '$CodeC')";
    $orderInsert = mysqli_query($con, $sqlInsertRecommander);
}

//modifier les données d'un membre dans BD
function modifierProfil($con, $CodeM, $NomM, $PrenomM, $PseudoM, $MDP){
    $sqlupdate = "UPDATE MEMBRES SET NomM = '$NomM', PrenomM = '$PrenomM', PseudoM = '$PseudoM', MDP = '$MDP' WHERE CodeM='$CodeM'";
    $orderUpdate = mysqli_query($con, $sqlupdate);
}

//vérifier la relation suivre entre deux membre
function checkSuivre($con, $codeM, $codeMR){
    $sqlcheckSuivre = "SELECT * FROM VOIRCOM WHERE CodeMVoir = '$codeM' AND CodeMVu = '$codeMR'";
    $curseur = mysqli_query($con, $sqlcheckSuivre);
    if ($curseur ==FALSE){
        die("Erreur fonction recherche les Suivis : " . mysqli_connect_error());
    }else{
        if(mysqli_num_rows($curseur) == 0){ //l'utilisateur n'a pas suivi ce membre
            return FALSE;
        } else {//l'utilisateur a déjà suivi ce membre
            return TRUE;    
        }
    }
}

//supprimer une compétence depuis POSSEDER
function SuppComp ($con, $CodeM, $CodeC){
    $suppSQL = "DELETE FROM POSSEDER WHERE POSSEDER.CodeM='$CodeM' AND POSSEDER.CodeC='$CodeC' ";
    $ordreSupp = mysqli_query($con, $suppSQL);
}

//insérer les données de apprécier
function InsertA ($con, $CodeM, $CodeCommentaire){
    $insertSQL = "INSERT INTO APPRECIER (CodeM, CodeCommentaire,DateA) "
                ."VALUES ('$CodeM', '$CodeCommentaire', now())";
    $orderInsert = mysqli_query($con, $insertSQL);
}

//insérer les données de commentaire complémentaire
function InsertCC ($con, $ContenuCC, $codeM, $CodeCommentaire){
    $insertSQL = "INSERT INTO COMMENTAIRE_COMPL (ContenuCC, DateCC, CodeM, CodeCommentaire) "
                ."VALUES ('$ContenuCC', now(), '$codeM', '$CodeCommentaire')";
    $orderInsert = mysqli_query($con, $insertSQL);
    }

//insérer les données de apprécier commentaire complémentaire
    function InsertAC ($con, $CodeM, $CodeCC){
    $insertSQL = "INSERT INTO APPRECIERCC (CodeM, CodeCC, DateAC) "
                ."VALUES ('$CodeM', '$CodeCC', now())";
    $orderInsert = mysqli_query($con, $insertSQL);
}
