<?php
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch ($action) {
    case 'demandeConnexion':
    {
        include'views/v_menu.php';
        include("views/v_connexion.php");
        break;
    }

    case 'valideConnexion':
    {
        $login = $_REQUEST['login'];
        $mdp = $_REQUEST['mdp'];


        /** @var PdoGsb $pdo */
        $visiteur = $pdo->getInfosVisiteur($login, $mdp);
        if (!is_array($visiteur)) {
            ajouterErreur("Login ou mot de passe incorrect");
            include("views/v_erreurs.php");
            include("views/v_connexion.php");
        } else {
            $id = $visiteur['id'];
            $nom = $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            connecter($id, $nom, $prenom);

            $dateModif = date("y-m-d");;
            //echo "<br>date : " . $dateModif;

            $dateModifVrai = date_parse($dateModif);
            $jour = $dateModifVrai['day'];
            $mois = $dateModifVrai['month'];
            $annee = $dateModifVrai['year'];

            $date = $annee . "-" . $mois . "-" . $jour;
            //echo "<br>année : " . $date;
            if($mois < 10 && $jour < 10 ){

                $mois = 0 .$mois;

                $jour = 0 .$jour;
            }

            $date = $annee . "-" . $mois . "-" . $jour;

            //echo "mois : " . $mois . "<br>jour : " . $jour;

            $dateModif = $date;

            $pdo->updateDateConnexion($date, $id);

            $_SESSION['derniereDateConnexion'] = $date;



            include 'views/v_sommaire.php';
            include 'views/v_accueil.php';
        }
        break;
    }
    case 'deconnexion':
    {
        deconnecter();
        include'views/v_menu.php';
        include("views/v_connexion.php");
        break;
    }
    default :
    {
        include("views/v_connexion.php");
        break;
    }
}
