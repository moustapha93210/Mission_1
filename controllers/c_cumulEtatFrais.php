<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
//echo " idVisiteur : ". $idVisiteur;
switch($action){

	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste,
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		$lesTypes = $pdo->getFraisForfait();
		include("views/v_listeMois.php");
		break;
	}

	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("views/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		
		//Gestion des dates
		@list($annee,$mois,$jour) = explode('-',$dateModif);
		$dateModif = "$jour"."/".$mois."/".$annee;

		//$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("views/v_etatFrais.php");
	}

	case 'cumulefrais':{
		$lesTypes = $pdo->getTypeDeFrais();
		$lesMois = $_REQUEST['lstMois'];
		$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $lesMois;
		include("views/v_listeTypeMois.php");
		break;
	}

	case 'voirCumulEtatFrais':{
		/*
		$typeFrais = $pdo->getTypeDeFrais();
		$leMois = $_REQUEST['lstMois'];
		$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
		include("views/v_listeTypeMois.php");

		$idFraisForfait = $_REQUEST['lstType'];
		$moisFicheFrais = $_REQUEST['lstMois'];

		$lesCumules = $pdo->getLesCumulesEtatFrais($idVisiteur, $moisFicheFrais, $idFraisForfait);

		include("views/v_cumulEtatFrais.php");
		break;
		*/

		$lesTypes = $pdo->getTypeDeFrais();
		$lesMois = $_REQUEST['lstMois'];
		$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $lesMois;
		
		include("views/v_listeTypeMois.php");
		
		
		$moisFicheFrais = $_REQUEST['lstMois'];
		$idFraisForfait = $_REQUEST['lstType'];
		/*echo "re ". $idVisiteur . $moisFicheFrais . $idFraisForfait;*/
		$lesCumules = $pdo->getLesCumulesEtatFrais($idVisiteur, $moisFicheFrais, $idFraisForfait);
		/*echo " compter ".count($lesCumules);*/


		include("views/v_cumulEtatFrais.php");
		break;
		

	}

	case 'idvisiteurType':{
		$lesTypes = $pdo->getTypeDeFrais();
		/*$lesIdv = $_REQUEST['lstIdv'];*/
		$lesIdv = $pdo->getIdvisiteur();
		//$idASelectionner = $lesIdv;

        $keys = array_keys($lesIdv);
        //echo $_GET[''];

		include("views/v_listeTypeId.php");
		break;
	}

	case 'voirIdType':{
		$lesTypes = $pdo->getTypeDeFrais();
		$lesidv = $_REQUEST['lstIdv'];
		$lesIdv = $pdo->getIdvisiteur();
		$idASelectionner = $lesIdv;
		
		include("views/v_listeTypeId.php");
		
		
		$idFraisForfait = $_REQUEST['lstType'];
		/*echo "re ". $lesIdv . $idFraisForfait;*/
		$lesCumules = $pdo->getLesCumulesTypeId($lesidv, $idFraisForfait);
		/*echo " compter ".count($lesCumules);*/


		include("views/v_cumulTypeId.php");
		break;
	}

	case 'MoisLibelle':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);

		include("views/v_listeMoisLibelle.php");
		break;

	}

	case 'voirMoisLibelle' :{
		$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);

		include("views/v_listeMoisLibelle.php");

		$idVisiteur = $_REQUEST['lstMois'];
		$moisLibelle = $_REQUEST['lstMois'];
		$lesCumules = $pdo->getLesMoisLibelle($idVisiteur, $moisLibelle);

		include("views/v_cumulMoisLibelle.php");
		break;

	}

	case 'LibelleId':{
		$lesLibelles = $pdo->getIdvisiteur();

		include("views/v_listeLibelleId.php");
		break;

	}

	case 'voirLibelleId':{
		$lesLibelles = $pdo->getIdvisiteur();
		

		include("views/v_listeLibelleId.php");


		$leslibelles = $_REQUEST['lstLibelle'];
		$lesCumules = $pdo->getLesLibelleId($leslibelles);

		include("views/v_cumulLibelleId.php");
		break;
	}

	case 'AjouterFrais':{
		$desNoms = $pdo->getLffId();

		include("views/v_ajouterFrais.php");
		break;
	}

	case 'voirFraisAjouter':{
		$desNoms = $pdo->getLffId();
	

		$idvisiteur = $_REQUEST['ajtFraisId'];

		$unmois = $_REQUEST['ajtFraisMois'];
		$uneannee = $_REQUEST['ajtFraisAnnee'];
		$mois = $uneannee . $unmois;

		$RepasMidi = $_REQUEST['repasMidi'];

		$Nuitee = $_REQUEST['nuitee'];

		$Etape = $_REQUEST['etape'];

		$Kilometre = $_REQUEST['kilometre'];


		//Condition Pour appeler la fonction d'insertion dans fraisforfait
		echo "IdVisiteur : " . $idvisiteur;
		echo "<br> Mois/Année : " . $mois;
		echo "<br> RepasMidi : " . $RepasMidi;
		echo "<br> Nuitée : " . $Nuitee;
		echo "<br> Etape : " . $Etape;
		echo "<br> Kilomètre : " . $Kilometre;


		//Tester si le couple idVisiteur Mois exitent dans la table fiche frais
		$nbLigne = $pdo->getIdvisiteurMoisFicheFrais($idvisiteur, $mois);
		//echo "Salut : ". var_dump($nbLigne);

		//Si il n'exite pas lancé insertFicheFrais
		if(empty($nbLigne))
		{
			echo "Je ne rentre pas dedans";
			$faire = $pdo->insertFicheFrais($idvisiteur, $mois);
			var_dump($faire);
			

		}
		else
		{
			echo "<br>". "Elle existe déja";
			$pdo->insertFicheFrais($idvisiteur, $mois);
		}

		//Sinon si elle a pas trouver


		//Condition Pour appeler la fonction d'insertion dans lignefraisforfait pour le type Repas-Midi
		if($RepasMidi > 0 && ($_REQUEST['repasMidi']))
		{
			$quantite = $RepasMidi;
			$idFraisForfait = 'REP';

			$pdo->insertLff($idvisiteur, $mois, $idFraisForfait, $quantite);
		}
		
		//Condition Pour appeler la fonction d'insertion dans lignefraisforfait pour le type Nuitée
		if($Nuitee > 0 && $_REQUEST['nuitee'])
		{
			$quantite = $Nuitee;
			$idFraisForfait = 'NUI';
			$pdo->insertLff($idvisiteur, $mois, $idFraisForfait, $quantite);
		}

		//Condition Pour appeler la fonction d'insertion dans lignefraisforfait pour le type Etape
		if($Etape > 0 && $_REQUEST['etape'])
		{
			$quantite = $Etape;
			$idFraisForfait = 'ETP';
			$pdo->insertLff($idvisiteur, $mois, $idFraisForfait, $Etape);
		}

		//Condition Pour appeler la fonction d'insertion dans lignefraisforfait pour le type Kilomètre
		if($Kilometre > 0 && $_REQUEST['kilometre'])
		{
			$quantite = $Kilometre;
			$idFraisForfait = 'KM';
			$pdo->insertLff($idvisiteur, $mois, $idFraisForfait, $Kilometre);
		}

		$lesid = $pdo->getIdvisiteur();
		$lesFrais = $pdo->selectionnerNouvelleDonnee($idvisiteur, $mois);

		include("views/v_voirAjouterFrais.php");
		break;
	}

}
